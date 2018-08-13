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
			->select('row_number() over(order by kode_pt, kode_prodi, tahun_masuk) as no, mahasiswa.id, i.nama_institusi as kode_pt, COALESCE(nama_program_studi, kode_prodi) as kode_prodi, nama_mahasiswa, tahun_masuk, tahun_lulus, mahasiswa.email, no_hp, ps.waktu_pelaksanaan', FALSE)
			->select('(select count(*) from notifikasi_email n where n.mahasiswa_id = mahasiswa.id) as jumlah_notif', FALSE)
			->select('(select count(*) from email_fail e where e.email = mahasiswa.email) as email_fail', FALSE)
			->from('mahasiswa')
			->join('user', 'user.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('plot_survei ps', 'ps.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('pdpt.perguruan_tinggi pt', 'pt.kode_perguruan_tinggi = mahasiswa.kode_pt', 'LEFT')
			->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi', 'LEFT')
			->join('pdpt.program_studi prodi', 'prodi.kode_perguruan_tinggi = mahasiswa.kode_pt AND prodi.kode_program_studi = mahasiswa.kode_prodi', 'LEFT')
			->get()->result();
	}
	
	public function list_all_by_plot_admin($username)
	{
		return $this->db
			->select('row_number() over(order by kode_pt, kode_prodi, tahun_masuk) as no, mahasiswa.id, kode_pt, kode_prodi, nama_mahasiswa, tahun_masuk, tahun_lulus, mahasiswa.email, no_hp, ps.waktu_pelaksanaan', FALSE)
			->select('(select count(*) from notifikasi_email n where n.mahasiswa_id = mahasiswa.id) as jumlah_notif', FALSE)
			->select('(select count(*) from email_fail e where e.email = mahasiswa.email) as email_fail', FALSE)
			->from('mahasiswa')
			->join('user um', 'um.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('plot_survei ps', 'ps.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('plot_admin pa', 'pa.mahasiswa_id = mahasiswa.id')
			->join('user ua', 'ua.id = pa.user_id')
			->where('ua.username', $username)
			->get()->result();
	}
	
	public function list_all_tanpa_login()
	{
		return $this->db
			->select('id, tahun_masuk, tahun_lulus')
			->from('mahasiswa')
			->where('id not in (select mahasiswa_id from "user" where mahasiswa_id is not null)', NULL, FALSE)
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
	
	/**
	 * 
	 * @param int $id
	 * @return Mahasiswa_model
	 */
	public function get_single($id)
	{
		return $this->db
			->select('mahasiswa.*, user.username, user.password_plain')
			->from('mahasiswa')
			->join('user', 'user.mahasiswa_id = mahasiswa.id', 'LEFT')
			->where(['mahasiswa.id' => $id])
			->get()->row();
	}

	/**
	 * @param int $id
	 * @return Mahasiswa_model
	 */
	public function get_single_with_login($id)
	{
		return $this->db->select('mahasiswa.*, i.nama_institusi, user.username, user.password_plain')
			->from('mahasiswa')
			->join('user', 'user.mahasiswa_id = mahasiswa.id')
			->join('pdpt.perguruan_tinggi pt', 'pt.kode_perguruan_tinggi = mahasiswa.kode_pt', 'LEFT')
			->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi', 'LEFT')
			->where(['mahasiswa.id' => $id])
			->limit(1)
			->get()->row();
	}
}
