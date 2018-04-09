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
 * Description of Email_Fail
 *
 * @author Fathoni <m.fathoni@mail.com>
 */
class Email_Fail extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->check_admin_credentials();
	}

	public function index()
	{
		$data_set = $this->db->get('email_fail')->result();
		
		$this->smarty->assign('data_set', $data_set);
		$this->smarty->display();
	}
	
	public function add()
	{
		if ($this->input->method() == 'post')
		{
			$this->db->insert('email_fail', [
				'email' => trim($this->input->post('email'))
			]);
			
			$this->smarty->display('admin/email_fail/add_success.tpl');
			exit();
		}
		
		$this->smarty->display();
	}
	
	public function delete($email)
	{
		$this->db->delete('email_fail', ['email' => urldecode($email)], 1);
		
		redirect(site_url('admin/email-fail/index'));
	}
}
