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
 * 
 * @property Mahasiswa_model $mahasiswa
 * @property Survei_model $survei
 */
class Survei extends MY_Controller
{
	/**
	 * GET /survei/isi
	 */
	public function isi()
	{
		$mahasiswa = $this->session->userdata('mahasiswa');
		
		$survei_id = 1; // Tracer Study Bidikmisi 2018
		$survei = $this->survei_model->get_single_with_relations($survei_id);
		
		// Cek apakah sudah pernah mengisi
		if ($this->plotsurvei_model->get_single($mahasiswa->id, $survei_id) != NULL)
		{
			$this->smarty->display('survei/isi_finished.tpl');
			exit();
		}
		
		// Proses POST di fungsi _isi()
		if ($this->input->method() == 'post')
		{					
			// Simpan variabel agar bisa di akses di fungsi _isi()
			$this->mahasiswa = $mahasiswa;
			$this->survei = $survei;

			$this->_isi();
		}
		
		foreach ($survei->pertanyaan_set as $pertanyaan)
		{
			foreach ($pertanyaan->jawaban_set as $jawaban)
			{
				foreach ($jawaban->input_set as &$input)
				{
					$name1 = "f[{$pertanyaan->id}][{$jawaban->id}][{$input->name1}]";
					$name2 = "f[{$pertanyaan->id}][{$jawaban->id}][{$input->name2}]";
					
					$input->name1_render = $name1;
					$input->name2_render = $name2;
					
					if ($input->jenis_input == 'RADIO')
					{
						$input->html = sprintf('%s %s', 
							form_radio(['name' => $name1, 'value' => $input->value1, 'data-id-jawaban' => $jawaban->id]), 
							$input->keterangan);
					}
					
					if ($input->jenis_input == 'RADIO_TEXT')
					{
						$input->html = sprintf($input->keterangan, 
							form_radio(['name' => $name1, 'value' => $input->value1, 'data-id-jawaban' => $jawaban->id]), 
							form_input(['name' => $name2, 'class' => $input->class2, 'data-jenis' => $input->jenis_input]));
					}
					
					if ($input->jenis_input == 'TEXT')
					{
						$input->html = sprintf($input->keterangan, 
							form_input(['name' => $name1, 'class' => $input->class1, 'data-jenis' => $input->jenis_input]));
					}
					
					if ($input->jenis_input == 'TEXT_TEXT')
					{
						$input->html = sprintf($input->keterangan, 
							form_input(['name' => $name1, 'class' => $input->class1, 'data-jenis' => $input->jenis_input]), 
							form_input(['name' => $name2, 'class' => $input->class2, 'data-jenis' => $input->jenis_input]));
					}
					
					if ($input->jenis_input == 'CHECKBOX')
					{
						$input->html = sprintf('%s %s', 
							form_checkbox(['name' => $name1, 'value' => $input->value1]), 
							$input->keterangan);
					}
					
					if ($input->jenis_input == 'CHECKBOX_TEXT')
					{
						$input->html = sprintf($input->keterangan, 
							form_checkbox(['name' => $name1, 'value' => $input->value1]), 
							form_input(['name' => $name2, 'class' => $input->class2, 'data-jenis' => $input->jenis_input]));
					}
					
					// Khusus untuk RADIO5, format penulisan langsung didalam <tr>
					if ($input->jenis_input == 'RADIO_5_LR')
					{
						$left_values	= explode(',', $input->value1);
						$right_values	= explode(',', $input->value2);
						
						foreach ($left_values as $value)
						{
							$input->left_html_set[] = form_radio(['name' => $name1, 'value' => $value, 'data-jenis' => $input->jenis_input, 'data-name' => $input->name1]);
						}
						
						foreach ($right_values as $value)
						{
							$input->right_html_set[] = form_radio(['name' => $name2, 'value' => $value, 'data-jenis' => $input->jenis_input, 'data-name' => $input->name2]);
						}
					}
				}
			}
		}
		
		$this->smarty->assignByRef('mahasiswa', $mahasiswa);
		$this->smarty->assignByRef('survei', $survei);
		
		$this->smarty->display();
	}
	
	/**
	 * POST /survei/
	 */
	private function _isi()
	{
		// Ambil object dari this
		$mahasiswa = $this->mahasiswa;
		$survei = $this->survei;
		
		$post = $this->input->post();

		$hasil_survei_set = array();

		foreach ($survei->pertanyaan_set as $pertanyaan)
		{
			foreach ($pertanyaan->jawaban_set as $jawaban)
			{						
				foreach ($jawaban->input_set as $input)
				{
					// Input Radio
					if ($input->jenis_input == 'RADIO')
					{
						// Cek apakah di entri & value match
						if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]))
						{
							// Jika value-nya match, simpan input_jawaban.id
							if ($post['f'][$pertanyaan->id][$jawaban->id][$input->name1] == $input->value1)
							{									
								$hasil_survei = new stdClass();	
								$hasil_survei->mahasiswa_id		= $mahasiswa->id;
								$hasil_survei->survei_id		= $survei->id;
								$hasil_survei->pertanyaan_id	= $pertanyaan->id;
								$hasil_survei->jawaban_id		= $jawaban->id;
								$hasil_survei->input_jawaban_id	= $input->id;
								$hasil_survei->name1			= $input->name1;
								$hasil_survei->value1			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name1];
								$hasil_survei->name2			= NULL;
								$hasil_survei->value2			= NULL;

								array_push($hasil_survei_set, $hasil_survei);

								break;
							}
						}
					}

					// Input Radio + Text
					if ($input->jenis_input == 'RADIO_TEXT')
					{
						// Cek apakah di entri & value match
						if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]))
						{
							// Jika value-nya match, simpan input_jawaban.id
							if ($post['f'][$pertanyaan->id][$jawaban->id][$input->name1] == $input->value1)
							{
								$hasil_survei = new stdClass();	
								$hasil_survei->mahasiswa_id		= $mahasiswa->id;
								$hasil_survei->survei_id		= $survei->id;
								$hasil_survei->pertanyaan_id	= $pertanyaan->id;
								$hasil_survei->jawaban_id		= $jawaban->id;
								$hasil_survei->input_jawaban_id	= $input->id;
								$hasil_survei->name1			= $input->name1;
								$hasil_survei->value1			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name1];
								$hasil_survei->name2			= $input->name2;
								$hasil_survei->value2			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name2];

								array_push($hasil_survei_set, $hasil_survei);

								break;
							}
						}
					}

					// Input Checkbox
					if ($input->jenis_input == 'CHECKBOX')
					{
						// Cek apakah di entri & value match
						if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]))
						{
							// Jika value-nya match, simpan input_jawaban.id
							if ($post['f'][$pertanyaan->id][$jawaban->id][$input->name1] == $input->value1)
							{
								$hasil_survei = new stdClass();	
								$hasil_survei->mahasiswa_id		= $mahasiswa->id;
								$hasil_survei->survei_id		= $survei->id;
								$hasil_survei->pertanyaan_id	= $pertanyaan->id;
								$hasil_survei->jawaban_id		= $jawaban->id;
								$hasil_survei->input_jawaban_id	= $input->id;
								$hasil_survei->name1			= $input->name1;
								$hasil_survei->value1			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name1];
								$hasil_survei->name2			= NULL;
								$hasil_survei->value2			= NULL;

								array_push($hasil_survei_set, $hasil_survei);
							}
						}
					}

					// Input Checkbox
					if ($input->jenis_input == 'CHECKBOX_TEXT')
					{
						// Cek apakah di entri & value match
						if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]))
						{
							// Jika value-nya match, simpan input_jawaban.id
							if ($post['f'][$pertanyaan->id][$jawaban->id][$input->name1] == $input->value1)
							{
								$hasil_survei = new stdClass();	
								$hasil_survei->mahasiswa_id		= $mahasiswa->id;
								$hasil_survei->survei_id		= $survei->id;
								$hasil_survei->pertanyaan_id	= $pertanyaan->id;
								$hasil_survei->jawaban_id		= $jawaban->id;
								$hasil_survei->input_jawaban_id	= $input->id;
								$hasil_survei->name1			= $input->name1;
								$hasil_survei->value1			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name1];
								$hasil_survei->name2			= $input->name2;
								$hasil_survei->value2			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name2];

								array_push($hasil_survei_set, $hasil_survei);
							}
						}
					}

					// Input Text
					if ($input->jenis_input == 'TEXT')
					{
						// Cek apakah di entri
						if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]))
						{
							$hasil_survei = new stdClass();	
							$hasil_survei->mahasiswa_id		= $mahasiswa->id;
							$hasil_survei->survei_id		= $survei->id;
							$hasil_survei->pertanyaan_id	= $pertanyaan->id;
							$hasil_survei->jawaban_id		= $jawaban->id;
							$hasil_survei->input_jawaban_id	= $input->id;
							$hasil_survei->name1			= $input->name1;
							$hasil_survei->value1			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name1];
							$hasil_survei->name2			= NULL;
							$hasil_survei->value2			= NULL;

							array_push($hasil_survei_set, $hasil_survei);
						}
					}

					// Input Text + Text
					if ($input->jenis_input == 'TEXT_TEXT')
					{
						// Cek apakah di entri
						if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]))
						{
							$hasil_survei = new stdClass();	
							$hasil_survei->mahasiswa_id		= $mahasiswa->id;
							$hasil_survei->survei_id		= $survei->id;
							$hasil_survei->pertanyaan_id	= $pertanyaan->id;
							$hasil_survei->jawaban_id		= $jawaban->id;
							$hasil_survei->input_jawaban_id	= $input->id;
							$hasil_survei->name1			= $input->name1;
							$hasil_survei->value1			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name1];
							$hasil_survei->name2			= $input->name2;
							$hasil_survei->value2			= $post['f'][$pertanyaan->id][$jawaban->id][$input->name2];

							array_push($hasil_survei_set, $hasil_survei);
						}
					}

					// Input Text + Text
					if ($input->jenis_input == 'RADIO_5_LR')
					{
						// Cek apakah radio di entri pada salah satu sisi kiri / kanan
						if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]) ||
							isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name2]))
						{
							$hasil_survei = new stdClass();	
							$hasil_survei->mahasiswa_id		= $mahasiswa->id;
							$hasil_survei->survei_id		= $survei->id;
							$hasil_survei->pertanyaan_id	= $pertanyaan->id;
							$hasil_survei->jawaban_id		= $jawaban->id;
							$hasil_survei->input_jawaban_id	= $input->id;
							$hasil_survei->name1			= $input->name1;

							if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name1]))
							{
								$hasil_survei->value1		= $post['f'][$pertanyaan->id][$jawaban->id][$input->name1];
							}
							else
							{
								$hasil_survei->value1		= NULL;
							}

							$hasil_survei->name2			= $input->name2;

							if (isset($post['f'][$pertanyaan->id][$jawaban->id][$input->name2]))
							{
								$hasil_survei->value2		= $post['f'][$pertanyaan->id][$jawaban->id][$input->name2];
							}
							else
							{
								$hasil_survei->value2		= NULL;
							}

							array_push($hasil_survei_set, $hasil_survei);
						}
					}
				}					
			}
		}

		$this->db->trans_begin();

		$this->db->insert_batch('hasil_survei', $hasil_survei_set);

		$this->db->insert('plot_survei', [
			'mahasiswa_id'		=> $mahasiswa->id,
			'survei_id'			=> $survei->id,
			'waktu_pelaksanaan'	=> date('Y-m-d H:i:s')
		]);

		// Cek tabel TS_ eksis / tidak
		$table_ts_exists = $this->db->query("SELECT EXISTS (
			SELECT 1
			FROM   information_schema.tables 
			WHERE    table_name = ?
		 )", array('TS_'.$survei->kode_tabel))->result()[0]->exists;

		// Jika eksis langsung insert data kesana
		if ($table_ts_exists == 't')
		{
			// Informasi biodata mahasiswa
			$data_ts = [
				'kdptimsmh'		=> $mahasiswa->kode_pt,
				'kdpstmsmh'		=> $mahasiswa->kode_prodi,
				'nimhsmsmh'		=> $mahasiswa->nim,
				'nmmhsmsmh'		=> $mahasiswa->nama_mahasiswa,
				'telpomsmh'		=> $mahasiswa->no_hp,
				'emailmsmh'		=> $mahasiswa->email,
				'tahun_lulus'	=> $mahasiswa->tahun_lulus
			];

			/// Informasi isian tracer dibuat menjadi per kolom
			foreach ($hasil_survei_set as $hasil_survei)
			{
				if ($hasil_survei->value1 != NULL)
				{
					$data_ts[strtolower($hasil_survei->name1)] = $hasil_survei->value1;
				}

				if ($hasil_survei->value2 != NULL)
				{
					$data_ts[strtolower($hasil_survei->name2)] = $hasil_survei->value2;
				}
			}

			// Insert data ke db
			$this->db->insert('TS_'.$survei->kode_tabel, $data_ts);
		}

		if ($this->db->trans_status() !== FALSE)
		{
			$this->db->trans_commit();

			$this->session->set_flashdata('result', array(
				'is_success' => TRUE,
				'page_title' => "Form {$survei->nama_survei}",
				'message' => 'Berhasil isi tracer',
				'link_1' => anchor('home', 'Kembali ke halaman depan') 
			));
		}
		else
		{
			$this->db->trans_rollback();

			$this->session->set_flashdata('result', array(
				'is_success' => FALSE,
				'page_title' => "Form {$survei->nama_survei}",
				'message' => 'Gagal isi tracer',
				'link_1' => anchor('survei/isi', 'Kembali ke halaman isi tracer'),
				'link_2' => anchor('home', 'Kembali ke halaman depan')
			));
		}

		redirect(site_url('survei/isi-result'));

		exit();
	}
	
	public function isi_result()
	{
		$this->smarty->display();
	}
}
