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
	/** @var int */
	public $id;
	
	/** @var string */
	public $kode_pt;
	
	/** @var string */
	public $kode_prodi;
	
	/** @var string */
	public $nama_mahasiswa;
	
	public function list_all_for_dt($dt_params)
	{
		$result = new stdClass();
		
		// Count total
		$result->recordsTotal = $this->db->count_all('mahasiswa');
		
		// Count Filtered
		if ($dt_params['search']['value'] != '')
		{
			$search_value = strtolower($dt_params['search']['value']);
			
			// Jika angka, asumsi search by telp
			if (is_numeric($search_value))
			{
				$result->recordsFiltered = $this->db
					->like('no_hp', $search_value, null, false)
					->count_all_results('mahasiswa');
			}
			else
			{
				$result->recordsFiltered = $this->db
					->like('lower(nama_mahasiswa)', $search_value, null, false)
					->count_all_results('mahasiswa');
			}
		}
		else
		{
			$result->recordsFiltered = $result->recordsTotal;
		}
		
		$query = $this->db
			->select('row_number() over() as no, mahasiswa.id, i.nama_institusi as nama_pt, COALESCE(nama_program_studi, kode_prodi) as nama_prodi, nama_mahasiswa, tahun_masuk, tahun_lulus, mahasiswa.email, no_hp, ps.waktu_pelaksanaan', FALSE)
			->select('mahasiswa.jumlah_notif', FALSE)
			->select('mahasiswa.email_fail', FALSE)
			->from('mahasiswa')
			->join('user', 'user.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('plot_survei ps', 'ps.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('pdpt.perguruan_tinggi pt', 'pt.kode_perguruan_tinggi = mahasiswa.kode_pt', 'LEFT')
			->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi', 'LEFT')
			->join('pdpt.program_studi prodi', 'prodi.kode_perguruan_tinggi = mahasiswa.kode_pt AND prodi.kode_program_studi = mahasiswa.kode_prodi', 'LEFT')
			->limit($dt_params['length'], $dt_params['start']);
		
		if ($dt_params['search']['value'] != '')
		{
			// Jika angka, asumsi search by telp
			if (is_numeric($dt_params['search']['value']))
			{
				$query = $query->like('no_hp', strtolower($dt_params['search']['value']), null, false);	
			}
			else
			{
				$query = $query->like('lower(nama_mahasiswa)', strtolower($dt_params['search']['value']), null, false);	
			}
		}
		
		if (isset($dt_params['order']))
		{
			// dimulai kolom ke 3
			if ($dt_params['order'][0]['column'] >= 1 && $dt_params['order'][0]['column'] <= 11)
			{
				$query = $query->order_by($dt_params['order'][0]['column'] + 1, $dt_params['order'][0]['dir']);
			}
		}
		
		$result->data = $query->get()->result();
		
		return $result;
	}
	
	public function list_all_by_admin_dt($username, $dt_params)
	{
		$result = new stdClass();
				
		// Count total
		$result->recordsTotal = $this->db
			->join('plot_admin pa', 'pa.mahasiswa_id = mahasiswa.id')
			->join('user ua', 'ua.id = pa.user_id')
			->where('ua.username', $username)
			->count_all_results('mahasiswa');
		
		// Count Filtered
		if ($dt_params['search']['value'] != '')
		{
			$result->recordsFiltered = $this->db
				->join('plot_admin pa', 'pa.mahasiswa_id = mahasiswa.id')
				->join('user ua', 'ua.id = pa.user_id')
				->where('ua.username', $username)
				->where("nama_mahasiswa ilike '%{$dt_params['search']['value']}%'", NULL, FALSE)
				->count_all_results('mahasiswa');
		}
		else
		{
			$result->recordsFiltered = $result->recordsTotal;
		}
		
		$query =  $this->db
			->select('row_number() over() as no, mahasiswa.id, i.nama_institusi as nama_pt, COALESCE(nama_program_studi, kode_prodi) as nama_prodi, nama_mahasiswa, tahun_masuk, tahun_lulus, mahasiswa.email, no_hp, ps.waktu_pelaksanaan', FALSE)
			->select('mahasiswa.jumlah_notif', FALSE)
			->select('mahasiswa.email_fail', FALSE)
			->from('mahasiswa')
			->join('user um', 'um.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('pdpt.perguruan_tinggi pt', 'pt.kode_perguruan_tinggi = mahasiswa.kode_pt', 'LEFT')
			->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi', 'LEFT')
			->join('pdpt.program_studi prodi', 'prodi.kode_perguruan_tinggi = mahasiswa.kode_pt AND prodi.kode_program_studi = mahasiswa.kode_prodi', 'LEFT')
			->join('plot_survei ps', 'ps.mahasiswa_id = mahasiswa.id', 'LEFT')
			->join('plot_admin pa', 'pa.mahasiswa_id = mahasiswa.id')
			->join('user ua', 'ua.id = pa.user_id')
			->where('ua.username', $username)
			->limit($dt_params['length'], $dt_params['start']);
		
		// Searching
		if ($dt_params['search']['value'] != '')
		{
			$query = $query->where("nama_mahasiswa ilike '%{$dt_params['search']['value']}%'", NULL, FALSE);	
		}
		
		// Ordering
		if (isset($dt_params['order']))
		{
			// dimulai kolom ke 3
			if ($dt_params['order'][0]['column'] >= 1 && $dt_params['order'][0]['column'] <= 11)
			{
				$query = $query->order_by("{$dt_params['order'][0]['column']}", $dt_params['order'][0]['dir']);
			}
		}
		
		$result->data = $query->get()->result();
		
		return $result;
	}
	
	public function list_all_tanpa_login()
	{
		return $this->db
			->select('id, tahun_masuk, tahun_lulus')
			->from('mahasiswa')
			->where('id not in (select mahasiswa_id from "user" where mahasiswa_id is not null)', NULL, FALSE)
			->get()->result();
	}
	
	public function list_hasil_tracer($dt_params)
	{
		$result = new stdClass();
		
		// Count total
		$result->recordsTotal = $this->db->count_all('plot_survei');
		
		// Count Filtered
		if ($dt_params['search']['value'] != '')
		{
			$result->recordsFiltered = $this->db
				->from('plot_survei ps')
				->join('mahasiswa m', 'm.id = ps.mahasiswa_id')
				->like('lower(nama_mahasiswa)', strtolower($dt_params['search']['value']), null, false)
				->count_all_results();
		}
		else
		{
			$result->recordsFiltered = $result->recordsTotal;
		}
		
		$query =  $this->db
			->select('row_number() over(order by ps.waktu_pelaksanaan desc) as no, i.nama_institusi as nama_pt, COALESCE(nama_program_studi, kode_prodi) as nama_prodi, m.nama_mahasiswa, ps.waktu_pelaksanaan')
			->from('plot_survei ps')
			->join('mahasiswa m', 'm.id = ps.mahasiswa_id')
			->join('pdpt.perguruan_tinggi pt', 'pt.kode_perguruan_tinggi = m.kode_pt', 'LEFT')
			->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi', 'LEFT')
			->join('pdpt.program_studi prodi', 'prodi.kode_perguruan_tinggi = m.kode_pt AND prodi.kode_program_studi = m.kode_prodi', 'LEFT')
			->limit($dt_params['length'], $dt_params['start']);
		
		if ($dt_params['search']['value'] != '')
		{
			$query = $query->like('lower(nama_mahasiswa)', strtolower($dt_params['search']['value']), null, false);	
		}
		
		$result->data = $query->get()->result();
		
		return $result;
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Mahasiswa_model
	 */
	public function get_single($id)
	{
		return $this->db
			->select('m.id, pt.kode_perguruan_tinggi, i.nama_institusi as nama_pt, m.kode_prodi, nim, nama_mahasiswa, m.email, no_hp, user.username, user.password_plain')
			->from('mahasiswa m')
			->join('pdpt.perguruan_tinggi pt', 'pt.kode_perguruan_tinggi = m.kode_pt')
			->join('pdpt.institusi i', 'i.id_institusi = pt.id_institusi')
			->join('user', 'user.mahasiswa_id = m.id', 'LEFT')
			->where(['m.id' => $id])
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
	
	/**
	 * @param string $kode_pt
	 * @param string $nim
	 * @return Mahasiswa_model 
	 */
	public function get_by_nim($kode_pt, $nim)
	{
		return $this->db->from('mahasiswa')
			->where('kode_pt', $kode_pt)
			->where('nim', $nim)
			->limit(1)
			->get()->first_row();
	}
}
