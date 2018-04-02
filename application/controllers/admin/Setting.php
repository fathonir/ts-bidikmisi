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
 * Description of Setting
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_Email $email
 */
class Setting extends MY_Controller
{
	public function email()
	{
		if ($this->input->method() == 'post')
		{
			$this->_email();
		}
		
		$email_subject	= $this->db->get_where('config', ['config_name' => 'email_subject'], 1)->row()->config_value;
		$email_body		= $this->db->get_where('config', ['config_name' => 'email_body'], 1)->row()->config_value;
		
		$smtp_host		= $this->db->get_where('config', ['config_name' => 'email_smtp_host'], 1)->row()->config_value;
		$smtp_port		= $this->db->get_where('config', ['config_name' => 'email_smtp_port'], 1)->row()->config_value;
		$smtp_timeout	= $this->db->get_where('config', ['config_name' => 'email_smtp_timeout'], 1)->row()->config_value;
		$smtp_crypto	= $this->db->get_where('config', ['config_name' => 'email_smtp_crypto'], 1)->row()->config_value;
		
		$this->smarty->assign('email_subject', $email_subject);
		$this->smarty->assign('email_body', $email_body);
		$this->smarty->assign('smtp_host', $smtp_host);
		$this->smarty->assign('smtp_port', $smtp_port);
		$this->smarty->assign('smtp_timeout', $smtp_timeout);
		$this->smarty->assign('smtp_crypto', $smtp_crypto);
		
		$this->smarty->display();
	}
	
	private function _email()
	{
		$this->db->trans_begin();
		
		$this->db->update('config', ['config_value' => $this->input->post('subject')],	['config_name' => 'email_subject']);
		$this->db->update('config', ['config_value' => $this->input->post('body')],		['config_name' => 'email_body']);
		
		$this->db->update('config', ['config_value' => $this->input->post('smtp_host')],	['config_name' => 'email_smtp_host']);
		$this->db->update('config', ['config_value' => $this->input->post('smtp_port')],	['config_name' => 'email_smtp_port']);
		$this->db->update('config', ['config_value' => $this->input->post('smtp_timeout')],	['config_name' => 'email_smtp_timeout']);
		$this->db->update('config', ['config_value' => $this->input->post('smtp_crypto')],	['config_name' => 'email_smtp_crypto']);
		
		if ($this->db->trans_status() === TRUE)
		{
			$this->db->trans_commit();
			
			$this->smarty->assign('success', TRUE);
		}
		
		// continue to email()
	}
	
	public function test_email()
	{
		$this->load->library('email');
		
		$email_config['protocol']		= 'smtp';
		$email_config['smtp_host']		= $this->db->get_where('config', ['config_name' => 'email_smtp_host'], 1)->row()->config_value;
		$email_config['smtp_port']		= $this->db->get_where('config', ['config_name' => 'email_smtp_port'], 1)->row()->config_value;
		$email_config['smtp_user']		= $this->input->post('email_username');
		$email_config['smtp_pass']		= $this->input->post('email_password');
		$email_config['smtp_timeout']	= $this->db->get_where('config', ['config_name' => 'email_smtp_timeout'], 1)->row()->config_value;
		$email_config['smtp_crypto']	= $this->db->get_where('config', ['config_name' => 'email_smtp_crypto'], 1)->row()->config_value;
		$email_config['smtp_keepalive']	= FALSE;
		
		$this->email->initialize($email_config);
		
		$email_subject	= '[UJICOBA] ' . $this->db->get_where('config', ['config_name' => 'email_subject'], 1)->row()->config_value;
		$email_body		= $this->db->get_where('config', ['config_name' => 'email_body'], 1)->row()->config_value;
		
		$email_from		= $this->input->post('email_username');
		
		$this->email->from($email_from, $email_from);
		$this->email->to($this->input->post('email_to'));
		
		$this->email->subject($email_subject);
		$this->email->message($email_body);
		
		$send_result = $this->email->send();
		
		echo ($send_result) ? '1' : '0';
	}
	
	public function email_login()
	{
		$user = $this->session->userdata('user');
		
		if ($this->input->method() == 'post')
		{
			$user->email_username = $this->input->post('email_username');
			$user->email_password = $this->input->post('email_password');
			
			$this->db->update('user', [
				'email_username' => $user->email_username,
				'email_password' => $user->email_password
			], ['id' => $user->id]);
			
			$this->smarty->assign('success', TRUE);
		}
		
		$this->smarty->assign('email_username', $user->email_username);
		$this->smarty->assign('email_password', $user->email_password);
		
		$this->smarty->display();
	}
}
