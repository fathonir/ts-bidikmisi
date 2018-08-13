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
 * Description of Migration_Alter_table_mahasiswa
 *
 * @author Fathoni <m.fathoni@mail.com>
 */
class Migration_Alter_table_mahasiswa extends CI_Migration
{
	public function up()
	{
		echo "  > alter table mahasiswa ... ";
		$this->dbforge->add_column('mahasiswa', 'alamat VARCHAR(200) NULL');
		$this->dbforge->add_column('mahasiswa', 'no_hp2 VARCHAR(20) NULL');
		$this->dbforge->add_column('mahasiswa', 'email2 VARCHAR(80) NULL');
		$this->dbforge->add_column('mahasiswa', 'posisi_kerja VARCHAR(100) NULL');
		$this->dbforge->add_column('mahasiswa', 'tempat_kerja VARCHAR(100) NULL');
		
		$this->db->query("alter table mahasiswa alter column kode_lulusan drop not null");
		
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > rollback table mahasiswa ... ";
		$this->dbforge->drop_column('mahasiswa', 'alamat');
		$this->dbforge->drop_column('mahasiswa', 'no_hp2');
		$this->dbforge->drop_column('mahasiswa', 'email2');
		$this->dbforge->drop_column('mahasiswa', 'posisi_kerja');
		$this->dbforge->drop_column('mahasiswa', 'tempat_kerja');
		echo "OK\n";
	}
}
