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
 * Description of 008_add_pdpt
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_postgre_forge $dbforge
 */
class Migration_Add_pdpt extends CI_Migration
{
	public function up()
	{
		echo "  > enable extension uuid-ossp ... ";
		$this->db->query("CREATE EXTENSION IF NOT EXISTS \"uuid-ossp\"");
		echo "OK\n";
		
		echo "  > create schema pdpt ... ";
		$this->db->query("CREATE SCHEMA pdpt");
		echo "OK\n";
		
		echo "  > create table pdpt.provinsi ... ";
		$this->dbforge->add_field('kode_provinsi CHAR(2) NOT NULL PRIMARY KEY');
		$this->dbforge->add_field('nama_provinsi VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.provinsi', TRUE);
		echo "OK\n";
		
		echo "  > create table pdpt.kota ... ";
		$this->dbforge->add_field('kode_kota CHAR(5) NOT NULL PRIMARY KEY');
		$this->dbforge->add_field('nama_kota VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('kode_provinsi CHAR(2) NOT NULL REFERENCES pdpt.provinsi (kode_provinsi)');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.kota', TRUE);
		echo "OK\n";
		
		echo "  > create table pdpt.jenis_institusi ... ";
		$this->dbforge->add_field('kd_jenis_institusi CHAR(1) NOT NULL PRIMARY KEY');
		$this->dbforge->add_field('jenis_institusi VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.jenis_institusi', TRUE);
		echo "OK\n";
		
		echo "  > create table pdpt.institusi ... ";
		$this->dbforge->add_field('id_institusi UUID NOT NULL PRIMARY KEY DEFAULT uuid_generate_v4()');
		$this->dbforge->add_field('kd_jenis_institusi CHAR(1) NOT NULL REFERENCES pdpt.jenis_institusi (kd_jenis_institusi)');
		$this->dbforge->add_field('nama_institusi VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('kd_sts_data CHAR(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_field('id_pdpt UUID');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.institusi', TRUE);
		echo "OK\n";
		
		echo "  > create table pdpt.jenis_perguruan_tinggi ... ";
		$this->dbforge->add_field('kode_jenis_perguruan_tinggi CHAR(1) NOT NULL PRIMARY KEY');
		$this->dbforge->add_field('jenis_perguruan_tinggi VARCHAR(30) NOT NULL');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.jenis_perguruan_tinggi', TRUE);
		echo "OK\n";
		
		echo "  > create table pdpt.kategori_perguruan_tinggi ... ";
		$this->dbforge->add_field('kode_kategori_perguruan_tinggi NUMERIC(1) NOT NULL PRIMARY KEY');
		$this->dbforge->add_field('kategori_perguruan_tinggi VARCHAR(10) NOT NULL');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.kategori_perguruan_tinggi', TRUE);
		echo "OK\n";
		
		echo "  > create table pdpt.perguruan_tinggi ... ";
		$this->dbforge->add_field('kode_perguruan_tinggi CHAR(6) NOT NULL PRIMARY KEY');
		$this->dbforge->add_field('kode_jenis_perguruan_tinggi CHAR(1) NULL REFERENCES pdpt.jenis_perguruan_tinggi (kode_jenis_perguruan_tinggi)');
		$this->dbforge->add_field('kode_kategori_perguruan_tinggi NUMERIC(1) NULL REFERENCES pdpt.kategori_perguruan_tinggi (kode_kategori_perguruan_tinggi)');
		$this->dbforge->add_field('id_institusi UUID NULL');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.perguruan_tinggi', TRUE);
		echo "OK\n";
		
		echo "  > create table pdpt.program_studi ... ";
		$this->dbforge->add_field('id_program_studi UUID NOT NULL PRIMARY KEY DEFAULT uuid_generate_v4()');
		$this->dbforge->add_field('kode_program_studi CHAR(6) NOT NULL');
		$this->dbforge->add_field('kode_perguruan_tinggi CHAR(6) NOT NULL REFERENCES pdpt.perguruan_tinggi (kode_perguruan_tinggi)');
		$this->dbforge->add_field('nama_program_studi VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('kode_status_aktif CHAR(1) NOT NULL DEFAULT 1');
		$this->dbforge->add_field('id_pdpt UUID');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('tgl_updated TIMESTAMP(6) NULL');
		$this->dbforge->create_table('pdpt.program_studi', TRUE);
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > drop table pdpt.program_studi ... ";
		$this->dbforge->drop_table('pdpt.program_studi');
		echo "OK\n";
		
		echo "  > drop table pdpt.perguruan_tinggi ... ";
		$this->dbforge->drop_table('pdpt.perguruan_tinggi');
		echo "OK\n";
		
		echo "  > drop table pdpt.kategori_perguruan_tinggi ... ";
		$this->dbforge->drop_table('pdpt.kategori_perguruan_tinggi');
		echo "OK\n";
		
		echo "  > drop table pdpt.jenis_perguruan_tinggi ... ";
		$this->dbforge->drop_table('pdpt.jenis_perguruan_tinggi');
		echo "OK\n";
		
		echo "  > drop table pdpt.institusi ... ";
		$this->dbforge->drop_table('pdpt.institusi');
		echo "OK\n";
		
		echo "  > drop table pdpt.jenis_institusi ... ";
		$this->dbforge->drop_table('pdpt.jenis_institusi');
		echo "OK\n";
		
		echo "  > drop table pdpt.kota ... ";
		$this->dbforge->drop_table('pdpt.kota');
		echo "OK\n";
		
		echo "  > drop table pdpt.provinsi ... ";
		$this->dbforge->drop_table('pdpt.provinsi');
		echo "OK\n";
		
		echo "  > drop schema pdpt ... ";
		$this->db->query("DROP SCHEMA pdpt");
		echo "OK\n";
	}
}
