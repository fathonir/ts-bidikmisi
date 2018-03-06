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
 * Description of Survei
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_postgre_forge $dbforge
 */
class Master_Survei extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_admin_credentials();
	}
	
	public function index()
	{
		$data_set = $this->survei_model->list_all();
		
		foreach ($data_set as &$data)
		{
			// Cek tabel eksis / tidak
			$data->tabel_exists = $this->db->query("SELECT EXISTS (
				SELECT 1
				FROM   information_schema.tables 
				WHERE    table_name = ?
			 )", array('TS_'.$data->kode_tabel))->result()[0]->exists;
		}
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function generate_table_ts()
	{
		$this->load->dbforge();
		
		$survei_id = $this->input->get('id');
		
		$survei = $this->survei_model->get_single($survei_id);
		
		// Mendapatkan nama-nama kolom
		$this->db->query(
			"select distinct p.no, j.urutan, ij.name1, ij.name2
			from survei s
			join pertanyaan p on p.survei_id = s.id
			join jawaban j on j.pertanyaan_id = p.id
			join input_jawaban ij on ij.jawaban_id = j.id
			where s.id = 1
			order by p.no, j.urutan");
		
		$input_set = $this->db->select('distinct p.no, j.urutan, ij.name1, ij.name2', false)
			->from('survei s')
			->join('pertanyaan p', 'p.survei_id = s.id')
			->join('jawaban j', 'j.pertanyaan_id = p.id')
			->join('input_jawaban ij', 'ij.jawaban_id = j.id')
			->where('s.id', $survei_id)
			->order_by('p.no, j.urutan')
			->get()->result();
		
		$column_set = array();
		
		foreach ($input_set as $input)
		{
			// Name1
			if ( ! in_array($input->name1, $column_set))
			{
				array_push($column_set, $input->name1);
			}
			
			if ($input->name2 !== NULL)
			{
				// Name2
				if ( ! in_array($input->name2, $column_set))
				{
					array_push($column_set, $input->name2);
				}
			}
		}
		
		// Default Column untuk kebutuhan sistem
		$this->dbforge->add_field("id SERIAL");
		$this->dbforge->add_field("kdptimsmh TEXT NULL");
		$this->dbforge->add_field("kdpstmsmh TEXT NULL");
		$this->dbforge->add_field("nimhsmsmh TEXT NULL");
		$this->dbforge->add_field("nmmhsmsmh TEXT NULL");
		$this->dbforge->add_field("telpomsmh TEXT NULL");
		$this->dbforge->add_field("emailmsmh TEXT NULL");
		$this->dbforge->add_field('tahun_lulus INTEGER NULL');
		
		// variabel kolum
		foreach ($column_set as $column)
		{
			$this->dbforge->add_field($column . ' TEXT NULL');
		}
		
		$this->dbforge->create_table('TS_'.$survei->kode_tabel);
		
		redirect(site_url('admin/master-survei'));
	}
}
