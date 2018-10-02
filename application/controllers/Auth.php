<?php

/*
 * The MIT License
 *
 * Copyright 2018 Fathoni <m.fathoni@mail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Description of Auth
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property Smarty_wrapper $smarty 
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_DB_mysqli_driver $db
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property Mahasiswa_model $mahasiswa_model
 * @property User_model $user_model
 */
class Auth extends CI_Controller
{
	const CAPTCHA_TIMEOUT = 7200;
	
	const SESS_MHS_RESP_FORLAP = 'SESS_MHS_RESP_FORLAP';
	
	public function login()
	{
		if ($this->input->method() == 'post')
		{
			$username	= strtolower($this->input->post('username'));
			$password	= $this->input->post('password');
			$captcha	= $this->input->post('captcha');
			
			// Ambil data user by username
			$user = $this->db->get_where('user', ['lower(username)' => $username], 1)->row();
			
			$expiration = time() - $this::CAPTCHA_TIMEOUT;
			
			// Hapus file captcha lama yang expired
			$captcha_set = $this->db->where('captcha_time < ', $expiration)->get('captcha')->result();
			foreach ($captcha_set as $captcha_row)
			{
				@unlink('./assets/captcha/'.$captcha_row->filename);
			}
			// Hapus record db
			$this->db->where('captcha_time < ', $expiration)->delete('captcha');
			
			// ambil data captcha
			$captcha_count = $this->db->query(
				"SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?",
				array($captcha, $this->input->ip_address(), $expiration))->row()->count;
			
			// Jika row ada
			if ($user != null)
			{
				// Bandingkan password
				if ($user->password_hash == sha1($password))
				{
					// jika captcha OK
					if ($captcha_count > 0)
					{
						// Assign data login ke session
						$this->session->set_userdata('user', $user);
						
						// update latest login
						$this->db->update('user', array('last_login' => date('Y-m-d H:i:s')), array('id' => $user->id));

						// redirect
						if ($user->tipe_user == TIPE_USER_NORMAL)
						{
							$mahasiswa = $this->db->get_where('mahasiswa', ['id' => $user->mahasiswa_id])->row();
							
							// Ambil data pt
							$mahasiswa->perguruan_tinggi = $this->db
								->select('i.*')->from('pdpt.perguruan_tinggi pt')
								->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi')
								->where(['pt.kode_perguruan_tinggi' => $mahasiswa->kode_pt])
								->get()->row();
							
							// Ambil data prodi
							$mahasiswa->program_studi = $this->db
								->select('ps.*')->from('pdpt.program_studi ps')
								->where([
									'ps.kode_perguruan_tinggi' => $mahasiswa->kode_pt,
									'ps.kode_program_studi' => $mahasiswa->kode_prodi
								])
								->get()->row();
							
							$this->session->set_userdata('mahasiswa', $mahasiswa);
							
							redirect(site_url('home'));
						}
						else if ($user->tipe_user == TIPE_USER_ADMIN)
						{
							redirect(site_url('admin/home'));
						}
						
						// end output after redirect
						exit();
					}
					else
					{							
						$this->session->set_flashdata('failed_login', 'Isian captcha tidak sesuai. Silahkan ulangi login');
					}
				}
				else
				{
					$this->session->set_flashdata('failed_login', 'Password tidak sesuai. Silahkan ulangi login.');
				}
			}
			else
			{
				$this->session->set_flashdata('failed_login', 'Username tidak ditemukan. Silahkan ulangi login.');
			}
		}
		
		$this->smarty->assign('img_captcha', $this->get_captcha());
		
		$this->smarty->display();
	}
	
	public function logout()
	{
		$this->session->unset_userdata('user');

		// redirect to home
		redirect(site_url());
	}
	
	public function akunku()
	{
		if ($this->input->method() == 'post')
		{
			$kode_pt	= $this->input->post('kode_perguruan_tinggi');
			$nim		= $this->input->post('nim');
			$nama		= $this->input->post('nama');
			
			$account = $this->db->query(
				"select u.username, u.password_plain as password
				from mahasiswa m
				join \"user\" u on u.mahasiswa_id = m.id
				where m.kode_pt = ? and m.nim = ? and lower(nama_mahasiswa) = lower(?)", [$kode_pt, $nim, $nama])
				->row();
			
			$this->smarty->assign('account', $account);
		}
		
		$pt_set = $this->db->query(
			"select pt.kode_perguruan_tinggi, i.nama_institusi from pdpt.perguruan_tinggi pt
			join pdpt.institusi i on i.id_institusi = pt.id_institusi
			where pt.kode_perguruan_tinggi in (select kode_pt from mahasiswa)
			order by 2")->result();
		
		$this->smarty->assign('pt_set', $pt_set);
		
		$this->smarty->display();
	}
	
	public function lapor_diri()
	{
		// Load model
		$this->load->model('mahasiswa_model');
		
		// Clear last search result
		if ($this->session->userdata($this::SESS_MHS_RESP_FORLAP))
			$this->session->unset_userdata($this::SESS_MHS_RESP_FORLAP);
		
		if ($this->input->method() == 'post')
		{
			$this->config->load('pddikti_api');
			$pddikti_api = $this->config->item('pddikti-api');
			
			$kode_pt	= $this->input->post('kode_pt');
			$kode_prodi	= $this->input->post('kode_prodi');
			$nama		= $this->input->post('nama');
			
			$id_pt		= NULL;
			$id_prodi	= NULL;
			$mahasiswa	= NULL;
			
			// Ambil id dari database
			$pt_n_prodi = $this->db
				->select('i.id_pdpt as id_pt, ps.id_pdpt as id_prodi')->from('pdpt.perguruan_tinggi pt')
				->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi')
				->join('pdpt.program_studi ps', 'ps.kode_perguruan_tinggi = pt.kode_perguruan_tinggi')
				->where('pt.kode_perguruan_tinggi', $kode_pt)
				->where('ps.kode_program_studi', $kode_prodi)
				->get()->row();
			
			if ($pt_n_prodi != NULL)
			{
				$id_pt = $pt_n_prodi->id_pt;
				$id_prodi = $pt_n_prodi->id_prodi;
			}
			
			// Building URL
			$url = sprintf('%s/pt/%s/prodi/%s/mahasiswa?nama=%s&page=0&per-page=1', $pddikti_api['endpoint'], $id_pt, $id_prodi, urlencode($nama));
			
			// Request ke pddikti api
			$response = \Httpful\Request::get($url)
				->addHeader('Authorization', 'Bearer ' . $pddikti_api['token'])
				->send();
			
			// Default pencarian tidak ditemukan
			$search_result = 'NOT_FOUND';
			
			// Jika ada, langsung proses insert ke db dan di generate loginnya
			if ($response->body != NULL)
			{
				$mahasiswa = $response->body[0];
				
				// Pastikan nama yang di input sama , hal ini untuk menghindari inputan nama yang sebagian saja
				if (strtolower(trim($nama)) == strtolower(trim($mahasiswa->nama)))
				{
					// Check existing di database
					$mahasiswa_local = $this->db
						->select('id, nama_mahasiswa, nim')->from('mahasiswa m')
						->where('kode_pt', $kode_pt)
						->where('nim', $mahasiswa->terdaftar->nim)
						->get()->row();

					// Jika belum ada, lanjut insert ke db
					if ($mahasiswa_local == NULL)
					{
						$search_result = 'FORLAP_FOUND';

						$this->smarty->assign('mahasiswa', $mahasiswa);
						
						// Simpan response asli json dari forlap untuk nanti di proses di registration-from-forlap
						$this->session->set_userdata($this::SESS_MHS_RESP_FORLAP, $response->raw_body);
					}
					else
					{
						$search_result = 'LOCAL_FOUND';
						
						$this->smarty->assign('mahasiswa_local', $mahasiswa_local);
					}
				}
			}
			
			$this->smarty->assign('search_result', $search_result);
		}
		
		$this->smarty->display();
	}
	
	public function registration_from_forlap()
	{
		if ($this->session->userdata($this::SESS_MHS_RESP_FORLAP) == NULL)
		{
			redirect(site_url());
			exit();
		}
		
		$this->load->model('user_model');
		$this->load->helper('string');
		
		// Ambil dari data session yang sudah di set setelah pencarian
		$mahasiswa_forlap = json_decode($this->session->userdata($this::SESS_MHS_RESP_FORLAP))[0];

		// ------------------------------------------------------------------------------
		// Create object mahasiswa
		// ------------------------------------------------------------------------------
		$mahasiswa					= new stdClass();
		$mahasiswa->nim				= $mahasiswa_forlap->terdaftar->nim;
		$mahasiswa->kode_prodi		= $mahasiswa_forlap->terdaftar->kode_prodi;
		$mahasiswa->kode_pt			= $mahasiswa_forlap->terdaftar->kode_pt;
		$mahasiswa->nama_mahasiswa	= $mahasiswa_forlap->nama;
		$mahasiswa->tahun_masuk		= (int) substr($mahasiswa_forlap->terdaftar->tgl_masuk, 0, 4);
		$mahasiswa->tahun_lulus		= (int) substr($mahasiswa_forlap->terdaftar->tgl_keluar, 0, 4);

		if ($mahasiswa_forlap->terdaftar->tgl_sk_yudisium != null)
			$mahasiswa->tanggal_yudisium = $mahasiswa_forlap->terdaftar->tgl_sk_yudisium;

		$mahasiswa->jenis_kelamin	= $mahasiswa_forlap->jenis_kelamin == 'L' ? 1 : 2;
		$mahasiswa->tempat_lahir	= $mahasiswa_forlap->tempat_lahir;
		$mahasiswa->no_hp			= $mahasiswa_forlap->handphone;
		$mahasiswa->email			= $mahasiswa_forlap->email;
		$mahasiswa->id_pdpt			= $mahasiswa_forlap->id;
		$mahasiswa->created_at		= date('Y-m-d H:i:s');

		// ------------------------------------------------------------------------------
		// Create object user
		// ------------------------------------------------------------------------------
		$tahun = 
				($mahasiswa->tahun_masuk != '') ? substr($mahasiswa->tahun_masuk, -2) : 
				($mahasiswa->tahun_lulus != '') ? substr($mahasiswa->tahun_lulus, -2) : '00';

		// Mengambil seri terakhir
		$seri_terakhir = $this->user_model->get_seri_terakhir();
		$seri_terakhir++;

		$new_user					= new stdClass();
		$new_user->username			= 'BM' . $tahun . str_pad($seri_terakhir, 6, '0', STR_PAD_LEFT);
		$new_user->password_plain	= random_string('numeric');
		$new_user->password_hash	= sha1($new_user->password_plain);
		$new_user->tipe_user		= TIPE_USER_NORMAL;

		$this->db->trans_begin();

		$this->db->insert('mahasiswa', $mahasiswa);

		// Ambil mahasiswa_id hasil insert
		$new_user->mahasiswa_id = $this->db->insert_id();

		$this->db->insert('user', $new_user);

		$this->db->trans_commit();

		// Assign ke session untuk ditampilkan
		$this->smarty->assign('new_user', $new_user);
		$this->smarty->assign('mahasiswa', $mahasiswa);

		// Clear session sebelumnya
		$this->session->unset_userdata($this::SESS_MHS_RESP_FORLAP);

		$this->smarty->display('auth/lapor_diri_success.tpl');
	}
	
	/**
	 * GET-AJAX /auth/search-pt
	 */
	public function search_pt()
	{
		$term = $this->input->get('term');
		
		$pt_set = $this->db
			->select('pt.kode_perguruan_tinggi as id, i.nama_institusi as value, i.nama_institusi as label')
			->from('pdpt.perguruan_tinggi pt')
			->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi')
			->where("i.nama_institusi ilike '%{$term}%'", NULL, FALSE)
			->limit(10)
			->get()->result();
		
		echo json_encode($pt_set);
	}
	
	/**
	 * GET-AJAX /auth/get-list-prodi
	 */
	public function get_list_prodi()
	{
		$kode_pt = $this->input->get('kode_pt');
		
		$prodi_set = $this->db
			->select('kode_program_studi as id, nama_program_studi as value')
			->from('pdpt.program_studi')
			->where('kode_perguruan_tinggi', $kode_pt)
			->order_by('2')
			->get()->result();
		
		echo json_encode($prodi_set);
	}
	
	public function get_captcha()
	{		
		$this->load->helper('captcha');
		
		// Captcha Parameter
		$captcha_params = array(
			'img_path'		=> './assets/captcha/',
			'img_url'		=> base_url('assets/captcha/'),
			'font_path'		=> realpath('./assets/fonts/OpenSans-Semibold.ttf'),
			'img_width'		=> 180,
			'img_height'	=> 60,
			'expiration'	=> $this::CAPTCHA_TIMEOUT,
			'word_length'	=> 4,
			'font_size'		=> 32,
			'pool'			=> '0123456789',
			'img_id'		=> time(),

			// White background and border, black text and red grid
			'colors'		=> array(
				'background'	=> array(255, 255, 255),
				'border'		=> array(0, 0, 0),
				'text'			=> array(0, 0, 0),
				'grid'			=> array(rand(0, 127), rand(0, 127), rand(0, 127))
			)
		);
		
		$captcha = create_captcha($captcha_params);
		
		if ($captcha)
		{
			$data = array(
				'captcha_time'	=> $captcha['time'],
				'ip_address'	=> $this->input->ip_address(),
				'word'			=> $captcha['word'],
				'filename'		=> $captcha['filename']
			);

			$this->db->insert('captcha', $data);

			return $captcha['image'];
		}
		else
		{
			return 'Captcha Error: GD Extension / Image Path Not Writeable';
		}
	}
}
