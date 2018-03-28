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
 */
class Migration_Insert_user_admin_n_plot extends CI_Migration
{
	public function up()
	{
		$this->db->trans_begin();
		
		$password_hash = sha1('tsbidikmisi2018');
		
		echo "  > insert table user (username=tsbm) ... ";
		$this->db->insert_batch('user', array(
			['username' => 'tsbm1', 'password_hash' => $password_hash, 'password_plain' => 'tsbidikmisi2018', 'email' => 'tsbidikmisi@ristekdikti.go.id', 'tipe_user' => 99],
			['username' => 'tsbm2', 'password_hash' => $password_hash, 'password_plain' => 'tsbidikmisi2018', 'email' => 'tsbidikmisi@ristekdikti.go.id', 'tipe_user' => 99],
			['username' => 'tsbm3', 'password_hash' => $password_hash, 'password_plain' => 'tsbidikmisi2018', 'email' => 'tsbidikmisi@ristekdikti.go.id', 'tipe_user' => 99],
			['username' => 'tsbm4', 'password_hash' => $password_hash, 'password_plain' => 'tsbidikmisi2018', 'email' => 'tsbidikmisi@ristekdikti.go.id', 'tipe_user' => 99],
			['username' => 'tsbm5', 'password_hash' => $password_hash, 'password_plain' => 'tsbidikmisi2018', 'email' => 'tsbidikmisi@ristekdikti.go.id', 'tipe_user' => 99],
			['username' => 'tsbm6', 'password_hash' => $password_hash, 'password_plain' => 'tsbidikmisi2018', 'email' => 'tsbidikmisi@ristekdikti.go.id', 'tipe_user' => 99],
			['username' => 'tsbm7', 'password_hash' => $password_hash, 'password_plain' => 'tsbidikmisi2018', 'email' => 'tsbidikmisi@ristekdikti.go.id', 'tipe_user' => 99],
		));
		echo "OK\n";
		
		echo "  > insert table plot_admin ... ";
		
		for ($i = 1; $i <= 7; $i++)
		{
			$username = 'tsbm' . $i;
			
			$sql = 
				"INSERT INTO plot_admin (user_id, mahasiswa_id)
				select \"user\".id as user_id, mahasiswa.id as mahasiswa_id
				from mahasiswa, \"user\"
				where \"user\".username = '{$username}' and mahasiswa.id not in (select mahasiswa_id from plot_admin)
				order by kode_pt, kode_prodi, tahun_masuk, nama_mahasiswa
				limit 3025";
				
			$this->db->query($sql);
		}
		
		echo "OK\n";
		
		$this->db->trans_commit();
	}
	
	public function down()
	{
		echo "  > delete from table plot_admin ... ";
		$this->db->query('DELETE FROM plot_admin');
		echo "OK\n";
		
		echo "  > delete from table user (username=tsbm) ... ";
		$this->db->query('DELETE FROM "user" WHERE username LIKE \'tsbm%\'');
		echo "OK\n";
	}
}
