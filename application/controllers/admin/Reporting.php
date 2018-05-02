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
					) tabel
					group by nama_pt
				) tabel";
		}
		
		$data_set = $this->db->query($sql)->result();

		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}
