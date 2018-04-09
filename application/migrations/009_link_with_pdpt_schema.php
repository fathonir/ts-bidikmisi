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
 * Description of 010_link_with_pdpt_schema
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_postgre_driver $db
 */
class Migration_link_with_pdpt_schema extends CI_Migration
{
	public function up()
	{
		echo "  > repair data kode_pt di tabel mahasiswa ... ";
		$this->db->query("UPDATE mahasiswa SET kode_pt = LPAD(kode_pt, 6, '0')");
		echo "OK\n";
		
		echo "  > alter table mahasiswa ... ";
		$this->db->query("ALTER TABLE mahasiswa ADD FOREIGN KEY (kode_pt) REFERENCES pdpt.perguruan_tinggi (kode_perguruan_tinggi)");
		echo "OK\n";
		
		echo "  > alter table pdpt.program_studi ... ";
		$this->db->query("ALTER TABLE pdpt.program_studi ADD CONSTRAINT uq_kode_pt_prodi UNIQUE (kode_perguruan_tinggi, kode_program_studi)");
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > alter table mahasiswa ... ";
		$this->db->query("ALTER TABLE mahasiswa DROP CONSTRAINT mahasiswa_kode_pt_fkey");
		echo "OK\n";
		
		echo "  > alter table pdpt.program_studi ... ";
		$this->db->query("ALTER TABLE pdpt.program_studi DROP CONSTRAINT uq_kode_pt_prodi");
		echo "OK\n";
	}
}
