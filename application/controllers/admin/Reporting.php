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
 */
class Reporting extends MY_Controller
{
	public function per_program_studi()
	{
		$sql =
			"select kode_program_studi, nama_program_studi, sudah, belum, total, ceil(total * 0.3) as t30, ceil(total * 0.3) - sudah as target
			from (
				select kode_program_studi, nama_program_studi, sum(tracer) as sudah, sum(case when tracer = 0 then 1 else 0 end) as belum, count(*) as total
				from (
					select 
						ps.kode_program_studi, ps.nama_program_studi,
						(case when plot.\"id\" is not null then 1 else 0 end) as tracer
					from mahasiswa m
					left join plot_survei plot on plot.mahasiswa_id = m.\"id\"
					join pdpt.program_studi ps on ps.kode_perguruan_tinggi = m.kode_pt and ps.kode_program_studi = m.kode_prodi
					where m.tahun_lulus <= 2016
				) tabel
				group by kode_program_studi, nama_program_studi
			) tabel
			order by total desc";
		
		$data_set = $this->db->query($sql)->result();
		
		$this->smarty->assign('data_set', $data_set);
		$this->smarty->display();
	}
	
	public function per_perguruan_tinggi()
	{
		if ( ! empty($this->input->get('kode_ps')))
		{
			$kode_ps = $this->input->get('kode_ps');
			
			$sql = 
				"select nama_pt, sudah, belum, total, ceil(total * 0.3) as t30, ceil(total * 0.3) - sudah as target
				from (
					select nama_pt, sum(tracer) as sudah, sum(case when tracer = 0 then 1 else 0 end) as belum, count(*) as total
					from (
						select 
							i.nama_institusi as nama_pt,
							(case when plot.\"id\" is not null then 1 else 0 end) as tracer
						from mahasiswa m
						left join plot_survei plot on plot.mahasiswa_id = m.\"id\"
						join pdpt.perguruan_tinggi pt on pt.kode_perguruan_tinggi = m.kode_pt
						join pdpt.institusi i on i.id_institusi = pt.id_institusi
						where m.kode_prodi = '{$kode_ps}'
					) tabel
					group by nama_pt
				) tabel";
						
			$program_studi = $this->db->get_where('pdpt.program_studi', ['kode_program_studi' => $kode_ps], 1)->row();
			
			$this->smarty->assign('program_studi', $program_studi);
		}
		else
		{
			$sql = 
				"select nama_pt, sudah, belum, total, ceil(total * 0.3) as t30, ceil(total * 0.3) - sudah as target
				from (
					select nama_pt, sum(tracer) as sudah, sum(case when tracer = 0 then 1 else 0 end) as belum, count(*) as total
					from (
						select 
							i.nama_institusi as nama_pt,
							(case when plot.\"id\" is not null then 1 else 0 end) as tracer
						from mahasiswa m
						left join plot_survei plot on plot.mahasiswa_id = m.\"id\"
						join pdpt.perguruan_tinggi pt on pt.kode_perguruan_tinggi = m.kode_pt
						join pdpt.institusi i on i.id_institusi = pt.id_institusi
						where m.tahun_lulus <= 2016 or m.tahun_lulus is null
					) tabel
					group by nama_pt
				) tabel";
		}
		
		$data_set = $this->db->query($sql)->result();

		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function per_tahun_lulus()
	{
		$data_set = $this->db->query(
			"with 
			t1 as (
				select tahun_lulus, count(*) as mahasiswa from mahasiswa
				group by tahun_lulus),
			t2 as (
				select tahun_lulus, count(*) as tracer from mahasiswa
				where id in (select mahasiswa_id from plot_survei)
				group by tahun_lulus)
			select t1.*, t2.tracer from t1
			left join t2 on t2.tahun_lulus = t1.tahun_lulus
			order by 1")->result();
		
		// labels name
		$labels = array();
		// dataset
		$dataset_1 = array();
		$dataset_2 = array();
		
		foreach ($data_set as $data)
		{
			array_push($labels, $data->tahun_lulus != '' ? "{$data->tahun_lulus}" : 'X');
			array_push($dataset_1, $data->mahasiswa);
			array_push($dataset_2, $data->tracer);
		}
		
		$this->smarty->assign('labels', json_encode($labels));
		$this->smarty->assign('dataset_1', json_encode($dataset_1));
		$this->smarty->assign('dataset_2', json_encode($dataset_2));
		
		$this->smarty->display();
	}
	
	public function isian_tracer()
	{
		$data_set = $this->db->query(
			"select to_char(waktu_pelaksanaan, 'YYYY-MM-DD') tanggal, count(*) tracer from plot_survei
			group by to_char(waktu_pelaksanaan, 'YYYY-MM-DD')
			order by 1 desc
			limit 30")->result();
		
		// labels name
		$labels = array();
		// dataset
		$dataset_1 = array();
		
		foreach ($data_set as $data)
		{
			array_push($labels, date('d/m', strtotime($data->tanggal)));
			array_push($dataset_1, $data->tracer);
		}
		
		$labels = array_reverse($labels);
		$dataset_1 = array_reverse($dataset_1);
		
		$this->smarty->assign('labels', json_encode($labels));
		$this->smarty->assign('dataset_1', json_encode($dataset_1));
		
		$this->smarty->display();
	}
	
	public function data_csv($format = 1)
	{
		header('Pragma: public');
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename=data-mahasiswa-per-'.date('d-m-Y').'.csv');
		
		if ($format == 1)
		{
			$sql = 
				"select 
					i.nama_institusi as perguruan_tinggi, ps.nama_program_studi, m.nama_mahasiswa, m.email, 
					(case when left(m.no_hp, 2) = '08' then '+62'||right(m.no_hp, -1) else m.no_hp end) as no_hp,
					(case when plot.\"id\" is not null then 'sudah' else 'belum' end) as tracer
				from mahasiswa m
				join \"user\" u on u.mahasiswa_id = m.id
				join pdpt.perguruan_tinggi pt on pt.kode_perguruan_tinggi = m.kode_pt
				join pdpt.institusi i on i.id_institusi = pt.id_institusi
				left join pdpt.program_studi ps on ps.kode_perguruan_tinggi = m.kode_pt and ps.kode_program_studi = m.kode_prodi
				left join plot_survei plot on plot.mahasiswa_id = m.\"id\"";
		}
		
		if ($format == 2)
		{
			$sql = 
				"select 
					u.username||' '||u.password_plain as \"login\", 
					(case when left(m.no_hp, 2) = '08' then '+62'||right(m.no_hp, -1) else m.no_hp end) as no_hp
				from mahasiswa m
				join \"user\" u on u.mahasiswa_id = m.id
				where 
					m.id not in (select mahasiswa_id from plot_survei) 
					and m.tahun_lulus <= 2016
					and m.no_hp not in (
						select no_hp from mahasiswa where no_hp is not null
						group by no_hp having count(*) > 2)";
		}
		
		$this->load->dbutil();

		$query = $this->db->query($sql);

		echo $this->dbutil->csv_from_result($query);
	}
}