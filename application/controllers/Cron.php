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
 * Description of Cron
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property CI_Email $email
 */
class Cron extends CI_Controller
{
	public function send_email()
	{
		$this->load->library('email');
		
		// Ambil login email user admin
		$user = $this->db->get_where('user', ['username' => 'admin'])->row();
		
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
		
		// Ambil 30 email yang belum dikirim
		$data_set = $this->db->get_where('email_outbox', ['sent_time IS NULL' => NULL], 30)->result();
		
		foreach ($data_set as $data)
		{			
			echo "  > Kirim {$data->email} ... ";
			
			$this->email->from($user->email_username, 'Tracer Study Bidikmisi');
			$this->email->to($data->email);
			$this->email->subject($data->subject);
			$this->email->message($data->body);
			
			$send_result = $this->email->send();
			
			if ($send_result)
			{
				$this->db->trans_begin();
				
				$this->db->update('email_outbox', ['sent_time' => date('Y-m-d H:i:s')], ['mahasiswa_id' => $data->mahasiswa_id]);
				
				$this->db->insert('notifikasi_email', [
					'mahasiswa_id'	=> $data->mahasiswa_id,
					'notifikasi'	=> 'email',
					'waktu_kirim'	=> date('Y-m-d H:i:s')
				]);
				
				$this->db->query("update mahasiswa set jumlah_notif = jumlah_notif + 1 where id = " . $data->mahasiswa_id);
				//$this->db->set('jumlah_notif = jumlah_notif + 1', NULL, FALSE);
				//$this->db->where('id', $data->mahasiswa_id);
				//$this->db->update('mahasiswa');
				
				$this->db->trans_commit();
				
				echo "OK\n";
			}
			else
			{
				echo "Fail\n";
			}
		}
	}
}
