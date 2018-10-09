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
 * Description of Tools
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property User_model $user_model
 */
class Utility extends MY_Controller
{
	/**
	 * Menggenerate user dari data mahasiswa yang masih belum punya login
	 */
	public function generate_user_login()
	{
		$this->load->helper('string');
		$this->load->model('user_model');
		
		// Mendapatkan seri user tertinggi terakhir
		$seri_terakhir = $this->user_model->get_seri_terakhir();
			
		foreach ($this->mahasiswa_model->list_all_tanpa_login() as $mahasiswa)
		{
			$seri_terakhir++;
			
			// Baca tahun masuk bila ada dan jika tidak ada baca tahun lulus, jika tidak diketahui set 00
			$tahun						= 
				($mahasiswa->tahun_masuk != '') ? substr($mahasiswa->tahun_masuk, -2) : 
				($mahasiswa->tahun_lulus != '') ? substr($mahasiswa->tahun_lulus, -2) : '00';
			
			$new_user					= new stdClass();
			$new_user->username			= 'BM' . $tahun . str_pad($seri_terakhir, 6, '0', STR_PAD_LEFT);
			$new_user->password_plain	= random_string('numeric');
			$new_user->password_hash	= sha1($new_user->password_plain);
			$new_user->tipe_user		= TIPE_USER_NORMAL;
			$new_user->mahasiswa_id		= $mahasiswa->id;
			
			$new_user_set[] = $new_user;
		}
		
		echo "Start<br/>";
		
		// Start insert
		$this->db->trans_begin();
		
		foreach ($new_user_set as $new_user)
		{
			echo "Insert {$new_user->username} ... ";
			$this->db->insert('user', $new_user);
			echo "OK<br/>";
		}
		
		if ($this->db->trans_status() !== FALSE)
		{
			$this->db->trans_commit();
			
			echo "Berhasil";
		}
		else
		{
			$this->db->trans_rollback();
			
			echo "Gagal";
		}
	}
	
	public function clear_isian()
	{
		$this->db->query("DELETE FROM \"TS_BM2018\"");
		$this->db->query("DELETE FROM plot_survei");
		$this->db->query("DELETE FROM hasil_survei");
		echo "OK";
	}
}
