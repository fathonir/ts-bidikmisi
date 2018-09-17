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
 * Description of Migration_Alter_table_mahasiswa_1
 *
 * @author Fathoni <m.fathoni@mail.com>
 */
class Migration_Alter_table_mahasiswa_1 extends CI_Migration
{
	public function up()
	{	
		echo "  > create index idx_notif_mhs, idx_efail_email, idx_mhs_nama ... ";
		$this->db->query("create index idx_notif_mhs on notifikasi_email (mahasiswa_id)");
		$this->db->query("create index idx_efail_email on email_fail using hash (email)");
		$this->db->query("create index idx_mhs_nama on mahasiswa using gin (nama_mahasiswa gin_trgm_ops)");
		echo "OK\n";
		
		echo "  > alter table mahasiswa ... ";
		$this->dbforge->add_column('mahasiswa', 'jumlah_notif INT NOT NULL DEFAULT 0');
		$this->dbforge->add_column('mahasiswa', 'email_fail INT NOT NULL DEFAULT 0');
		$this->db->query("update mahasiswa set jumlah_notif = (select count(*) from notifikasi_email n where n.mahasiswa_id = mahasiswa.id)");
		$this->db->query("update mahasiswa set email_fail = (select count(*) from email_fail e where e.email = mahasiswa.email)");
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > rollback table mahasiswa ... ";
		$this->dbforge->drop_column('mahasiswa', 'jumlah_notif');
		$this->dbforge->drop_column('mahasiswa', 'email_fail');
		echo "OK\n";
		
		echo "  > drop index idx_notif_mhs, idx_efail_email, idx_mhs_nama ... ";
		$this->db->query("drop index idx_notif_mhs");
		$this->db->query("drop index idx_efail_email");
		$this->db->query("drop index idx_mhs_nama");
		echo "OK\n";
	}
}
