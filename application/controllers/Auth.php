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
 */
class Auth extends CI_Controller
{
	const CAPTCHA_TIMEOUT = 7200;
	
	public function login()
	{
		if ($this->input->method() == 'post')
		{
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			$captcha	= $this->input->post('captcha');
			
			// Ambil data user by username
			$user = $this->db->get_where('user', ['username' => $username], 1)->row();
			
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
