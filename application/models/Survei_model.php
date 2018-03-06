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
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property int $id
 * @property Pertanyaan_model[] $pertanyaan_set
 */
class Survei_model extends CI_Model
{
	/**
	 * @param int $id
	 * @return Survei_model
	 */
	public function get_single($id)
	{
		return $this->db->get_where('survei', ['id' => $id])->row();
	}
	
	public function get_single_with_relations($id)
	{
		$survei = $this->db->get_where('survei', ['id' => $id])->row();
		
		$survei->pertanyaan_set = $this->pertanyaan_model->list_by_survei($survei->id);
		
		foreach ($survei->pertanyaan_set as &$pertanyaan)
		{
			$pertanyaan->jawaban_set = $this->jawaban_model->list_by_pertanyaan($pertanyaan->id);
			
			foreach ($pertanyaan->jawaban_set as &$jawaban)
			{
				$jawaban->input_set = $this->inputjawaban_model->list_by_jawaban($jawaban->id);
			}
		}
		
		return $survei;
	}
	
	public function list_all()
	{
		return $this->db->select('survei.id, nama_survei, kode_tabel, deskripsi, count(pertanyaan.id) as jumlah_pertanyaan')
			->from('survei')
			->join('pertanyaan', 'pertanyaan.survei_id = survei.id')
			->group_by('survei.id, nama_survei, kode_tabel, deskripsi')
			->get()->result();
	}
}
