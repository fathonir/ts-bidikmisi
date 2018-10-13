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
 * Description of Data_Mahasiswa
 *
 * @author Fathoni <m.fathoni@mail.com>
 */
class Data_Mahasiswa extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->check_admin_credentials();
	}

	public function index()
	{
		$this->smarty->display();
	}

	public function data()
	{
		$user = $this->session->userdata('user');

		// Jika Admin utama, show all
		if ($user->username == 'admin')
		{
			echo json_encode($this->mahasiswa_model->list_all_for_dt($_POST));
		}
		else
		{
			echo json_encode($this->mahasiswa_model->list_all_by_admin_dt($user->username, $_POST));
		}
	}

	public function update_notifikasi()
	{
		if ($this->input->method() == 'post')
		{
			$mahasiswa_id	 = $this->input->post('id');
			$notifikasi		 = $this->input->post('jenis');

			if ($notifikasi == 'email')
			{
				$this->load->library('email');
				
				// Ambil data user dari db
				$user = $this->session->userdata('user');

				// Ambil data mahasiswa
				$mahasiswa = $this->mahasiswa_model->get_single_with_login($mahasiswa_id);

				// Setting SMTP
				$email_config['protocol']		 = 'smtp';
				$email_config['smtp_host']		 = $this->db->get_where('config', ['config_name' => 'email_smtp_host'], 1)->row()->config_value;
				$email_config['smtp_port']		 = $this->db->get_where('config', ['config_name' => 'email_smtp_port'], 1)->row()->config_value;
				$email_config['smtp_user']		 = $user->email_username;
				$email_config['smtp_pass']		 = $user->email_password;
				$email_config['smtp_timeout']	 = $this->db->get_where('config', ['config_name' => 'email_smtp_timeout'], 1)->row()->config_value;
				$email_config['smtp_crypto']	 = $this->db->get_where('config', ['config_name' => 'email_smtp_crypto'], 1)->row()->config_value;
				$email_config['smtp_keepalive']	 = TRUE;
				$email_config['wrapchars']		 = 120;
				$email_config['dsn']			 = TRUE;

				$this->email->initialize($email_config);
				
				$email_subject	= $this->db->get_where('config', ['config_name' => 'email_subject'], 1)->row()->config_value;
				$email_body_raw	= $this->db->get_where('config', ['config_name' => 'email_body'], 1)->row()->config_value;
				$email_from		= $user->email;
				
				// Variable collection
				$email_vars = [
					'{NIM}'				=> $mahasiswa->nim,
					'{NAMA}'			=> $mahasiswa->nama_mahasiswa,
					'{PROGRAM STUDI}'	=> $mahasiswa->kode_prodi,
					'{PERGURUAN TINGGI}'=> $mahasiswa->nama_institusi,
					'{USERNAME}'		=> $mahasiswa->username,
					'{PASSWORD}'		=> $mahasiswa->password_plain
				];
				
				// Replace variable
				$email_body = strtr($email_body_raw, $email_vars);

				$this->email->from($email_from, $email_from);
				$this->email->to($mahasiswa->email);

				$this->email->subject($email_subject);
				$this->email->message($email_body);

				$send_result = $this->email->send();

				echo ($send_result) ? '1' : '0';
			}
			
			$this->db->trans_begin();
	
			$this->db->insert('notifikasi_email', [
				'mahasiswa_id'	 => $this->input->post('id'),
				'notifikasi'	 => $this->input->post('jenis'),
				'waktu_kirim'	 => date('Y-m-d H:i:s')
			]);
			
			$this->db->set('jumlah_notif = jumlah_notif + 1', NULL, FALSE);
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('mahasiswa');
			
			$this->db->trans_commit();
		}
	}

	public function get_mahasiswa($id)
	{
		echo json_encode($this->mahasiswa_model->get_single($id));
	}

	public function update_mahasiswa()
	{
		$update_result = $this->db->update('mahasiswa', [
			'email'	 => $this->input->post('email'),
			'no_hp'	 => $this->input->post('no_hp')
		], ['id' => $this->input->post('id')]);

		echo $update_result ? '1' : '0';
	}
}
