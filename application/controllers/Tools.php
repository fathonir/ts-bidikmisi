<?php
require FCPATH . 'vendor/autoload.php';

use Curl\Curl;

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
 * Description of Tools
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load 
 */
class Tools extends CI_Controller
{
	
	public function generate_outbox_email()
	{
		$this->load->helper('email');

		echo "  > Start generate all outbox email \n";

		echo "  > Ambil data mahasiswa yang akan dikirimi email ... ";
		
		$data_set = $this->db
				->select('m.id, m.email, m.nim, m.nama_mahasiswa, i.nama_institusi, ps.nama_program_studi, u.username, u.password_plain')
				->from('mahasiswa m')
				->join('user u', 'u.mahasiswa_id = m.id', 'LEFT')
				->join('pdpt.perguruan_tinggi pt', 'pt.kode_perguruan_tinggi = m.kode_pt', 'LEFT')
				->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi', 'LEFT')
				->join('pdpt.program_studi ps', 'ps.kode_perguruan_tinggi = m.kode_pt AND ps.kode_program_studi = m.kode_prodi', 'LEFT')
				->where('m.tahun_lulus <=', 2016)	// Filter hingga lulusan 2016 saja
				->where('m.id not in (select mahasiswa_id from plot_survei where survei_id = 1)', NULL, FALSE)	// Survei_id = 1 untuk kuesioner tahun 2018
				->where('m.email not in (select email from mahasiswa where email is not null group by email having count(*) > 1)', NULL, FALSE) // pilih yang emailnya tidak dobel
				->get()->result();
		
		echo "OK\n";

		echo "  > Ambil template email ... ";

		$email_subject	 = $this->db->get_where('config', ['config_name' => 'email_subject'], 1)->row()->config_value;
		$email_body_raw	 = $this->db->get_where('config', ['config_name' => 'email_body'], 1)->row()->config_value;
		
		echo "OK\n";
		
		echo "  > Insert to outbox ... ";
		
		$this->db->trans_begin();

		foreach ($data_set as $data)
		{
			// Jika email valid baru di proses
			if (filter_var($data->email, FILTER_VALIDATE_EMAIL))
			{
				// Variable collection
				$email_vars = [
					'{NIM}'				 => $data->nim,
					'{NAMA}'			 => $data->nama_mahasiswa,
					'{PROGRAM STUDI}'	 => $data->nama_program_studi,
					'{PERGURUAN TINGGI}' => $data->nama_institusi,
					'{USERNAME}'		 => $data->username,
					'{PASSWORD}'		 => $data->password_plain
				];

				// Replace variable
				$email_body = strtr($email_body_raw, $email_vars);

				// Insert to Outbox
				$this->db->insert('email_outbox', [
					'email'			 => $data->email,
					'subject'		 => $email_subject,
					'body'			 => $email_body,
					'mahasiswa_id'	 => $data->id,
					'tgl_created'	 => date('Y-m-d H:i:s')
				]);
			}
		}

		if ($this->db->trans_status() === TRUE)
		{
			$this->db->trans_commit();
			
			echo "OK\n";
		}
		else
		{
			$this->db->trans_rollback();
			
			echo "Failed\n";
		}

		exit(0);
	}

	public function fix_missing_tahun_masuk()
	{
		// Ambil mahasiswa yang tahun_masuk nya bermasalah
		echo 'Ambil mahasiswa yang tahun_masuk bermasalah ... ';
		$mahasiswa_set = $this->db
			->select('id, kode_pt, kode_prodi, nim, nama_mahasiswa, tahun_masuk, tahun_lulus, id_pdpt')
			->from('mahasiswa')
			->where('tahun_masuk IS NULL', NULL, FALSE)
			->or_where('tahun_masuk >=', 2018)
			->or_where('tahun_masuk <', 2009)
			->get()->result();
		echo "OK\n";
		
		$count_updated = 0;
		
		foreach ($mahasiswa_set as $mahasiswa)
		{
			echo "Proses {$mahasiswa->kode_pt} {$mahasiswa->kode_prodi} {$mahasiswa->nim} {$mahasiswa->nama_mahasiswa} ... ";
			echo "cek data pddikti ... ";
			
			$respone = $this->pddikti_mahasiswa($mahasiswa->kode_pt, $mahasiswa->kode_prodi, $mahasiswa->nim);
			
			if ($respone != NULL)
			{
				echo "update db ... ";
				
				$pddikti_mahasiswa = $respone[0];
				
				$this->db->update('mahasiswa', [
					'tahun_masuk' => substr($pddikti_mahasiswa->terdaftar->tgl_masuk, 0, 4),
					'id_pdpt' => $pddikti_mahasiswa->id,
					'updated_at' => date('Y-m-d H:i:s')
				], ['id' => $mahasiswa->id]);
				
				echo "OK\n";
				
				$count_updated++;
			}
			else
			{
				echo "tidak ditemukan.\n";
			}
		}
		
		echo "Jumlah data diperbarui = {$count_updated}";
	}
	
	public function fix_missing_tahun_lulus()
	{
		echo 'Ambil mahasiswa yang tahun_masuk bermasalah ... ';
		$mahasiswa_set = $this->db
			->select('id, kode_pt, kode_prodi, nim, nama_mahasiswa, tahun_masuk, tahun_lulus, id_pdpt')
			->from('mahasiswa')
			->where('tahun_lulus IS NULL', NULL, FALSE)
			->or_where('tahun_lulus >', 2018)
			->or_where('tahun_lulus <', 2013)
			->get()->result();
		echo "OK\n";
		
		$count_updated = 0;
		
		foreach ($mahasiswa_set as $mahasiswa)
		{
			echo "Proses {$mahasiswa->kode_pt} {$mahasiswa->kode_prodi} {$mahasiswa->nim} {$mahasiswa->nama_mahasiswa} ... ";
			echo "cek data pddikti ... ";
			
			$respone = $this->pddikti_mahasiswa($mahasiswa->kode_pt, $mahasiswa->kode_prodi, $mahasiswa->nim);
			
			if ($respone != NULL)
			{
				echo "update db ... ";
				
				$pddikti_mahasiswa = $respone[0];
				
				if ($pddikti_mahasiswa->terdaftar->tgl_keluar != NULL)
				{
					$this->db->update('mahasiswa', [
						'tahun_lulus' => substr($pddikti_mahasiswa->terdaftar->tgl_keluar, 0, 4),
						'id_pdpt' => $pddikti_mahasiswa->id,
						'updated_at' => date('Y-m-d H:i:s')
					], ['id' => $mahasiswa->id]);

					echo "OK\n";
				}
				else
				{
					echo "tanggal lulus belum ada.\n";
				}
				
				$count_updated++;
			}
			else
			{
				echo "tidak ditemukan.\n";
			}
		}
		
		echo "Jumlah data diperbarui = {$count_updated}";
	}
	
	private function pddikti_mahasiswa($kode_pt, $kode_prodi, $nim)
	{
		$endpoint = 'https://api.ristekdikti.go.id:8243/pddikti/1.0';
		$access_token = 'd3f25dda-36dd-345c-89da-1473d5045f17';
		
		$curl = new Curl();
		$curl->setHeader('Accept', 'application/json');
		$curl->setHeader('Authorization', "Bearer {$access_token}");		
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
		$curl->get("{$endpoint}/pt/{$kode_pt}/prodi/{$kode_prodi}/mahasiswa/" . urlencode($nim));
		
		if ($curl->error)
		{
			return NULL;
		}
		else
		{
			return $curl->response;
		}
	}
}
