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
 * Description of MY_Controller
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_Loader $load
 * @property Smarty_wrapper $smarty
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Mahasiswa_model $mahasiswa_model 
 * @property Survei_model $survei_model
 * @property Pertanyaan_model $pertanyaan_model
 * @property Jawaban_model $jawaban_model
 * @property InputJawaban_model $inputjawaban_model
 * @property PlotSurvei_model $plotsurvei_model
 */
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('mahasiswa_model');
		$this->load->model('survei_model');
		$this->load->model('pertanyaan_model');
		$this->load->model('jawaban_model');
		$this->load->model('inputjawaban_model');
		$this->load->model('plotsurvei_model');
	}
	
	public function check_credentials()
	{
		if ($this->session->userdata('user') == NULL)
		{
			redirect(site_url());
		}
	}
	
	public function check_admin_credentials()
	{
		if ($this->session->userdata('user')->tipe_user != TIPE_USER_ADMIN)
		{
			redirect(site_url('auth/logout'));
		}
	}
}
