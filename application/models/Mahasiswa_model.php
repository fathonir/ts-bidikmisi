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
 * Description of Mahasiswa_model
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Mahasiswa_model extends CI_Model
{
	public function list_all()
	{
		return $this->db
			->select('mahasiswa.id, kode_pt, nama_mahasiswa, tahun_masuk, tahun_lulus, mahasiswa.email, no_hp, username, password_plain, ps.waktu_pelaksanaan')
			->from('mahasiswa')
			->join('user', 'user.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('plot_survei ps', 'ps.mahasiswa_id = mahasiswa.id', 'LEFT')
			->get()->result();
	}
	
	public function list_all_tanpa_login()
	{
		return $this->db
			->select('id, tahun_masuk')
			->from('mahasiswa')
			->where_not_in('select mahasiswa_id from user', NULL, FALSE)
			->get()->result();
	}
	
	public function list_hasil_tracer()
	{
		return $this->db
			->select('m.kode_pt, m.nim, m.nama_mahasiswa, ps.waktu_pelaksanaan')
			->from('plot_survei ps')
			->join('mahasiswa m', 'm.id = ps.mahasiswa_id')
			->get()->result();
	}
}
