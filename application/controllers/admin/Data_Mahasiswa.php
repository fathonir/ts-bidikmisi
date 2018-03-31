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
			echo json_encode(['data' => $this->mahasiswa_model->list_all()]);
		}
		else
		{
			echo json_encode(['data' => $this->mahasiswa_model->list_all_by_plot_admin($user->username)]);
		}
	}
	
	public function update_notifikasi()
	{
		if ($this->input->method() == 'post')
		{
			$this->db->insert('notifikasi_email', [
				'mahasiswa_id'	=> $this->input->post('id'),
				'notifikasi'	=> $this->input->post('jenis'),
				'waktu_kirim'	=> date('Y-m-d H:i:s')
			]);
		}
	}
	
	public function get_mahasiswa($id)
	{
		echo json_encode($this->mahasiswa_model->get_single($id));
	}
	
	public function update_mahasiswa()
	{
		$update_result = $this->db->update('mahasiswa', [
			'email' => $this->input->post('email'),
			'no_hp' => $this->input->post('no_hp')
		], ['id' => $this->input->post('id')]);
		
		echo $update_result ? '1' : '0';
	}
}
