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
 * Description of Migration_Init_database
 * 
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_postgre_forge $dbforge
 * @property CI_DB_postgre_driver $db
 * @property CI_DB_query_builder $db
 */
class Migration_Init_database extends CI_Migration
{
	public function up()
	{
		echo "  > create table captcha ... ";
		$this->dbforge->add_field('captcha_id SERIAL PRIMARY KEY');
		$this->dbforge->add_field('captcha_time INTEGER NOT NULL');
		$this->dbforge->add_field('ip_address VARCHAR(45) NOT NULL');
		$this->dbforge->add_field('word VARCHAR(20) NOT NULL');
		$this->dbforge->add_field('filename VARCHAR(20) NULL');
		$this->dbforge->create_table('captcha', TRUE);
		echo "OK\n";
		
		echo "  > create table mahasiswa ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY');
		$this->dbforge->add_field('kode_lulusan TEXT NOT NULL');
		$this->dbforge->add_field('nim VARCHAR(20) NOT NULL');
		$this->dbforge->add_field('kode_prodi VARCHAR(6) NOT NULL');
		$this->dbforge->add_field('kode_pt VARCHAR(6) NOT NULL');
		$this->dbforge->add_field('nama_mahasiswa VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('tahun_masuk INTEGER NULL');
		$this->dbforge->add_field('tahun_lulus INTEGER NULL');
		$this->dbforge->add_field('tanggal_yudisium DATE NULL');
		$this->dbforge->add_field('ipk NUMERIC(3,2) NULL');
		$this->dbforge->add_field('jenis_kelamin VARCHAR(1) NULL');
		$this->dbforge->add_field('tempat_lahir VARCHAR(50) NULL');
		$this->dbforge->add_field('tanggal_lahir DATE NULL');
		$this->dbforge->add_field('no_hp VARCHAR(20) NULL');
		$this->dbforge->add_field('email VARCHAR(80) NULL');
		$this->dbforge->add_field('tanggal_input TIMESTAMP WITHOUT TIME ZONE NULL');
		$this->dbforge->add_field('status INTEGER NULL');
		$this->dbforge->add_field('source INTEGER NULL');
		$this->dbforge->add_field('lanjutan INTEGER NULL');
		$this->dbforge->add_field('keterangan_lanjutan TEXT NULL');
		$this->dbforge->add_field('created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at TIMESTAMP NULL');
		$this->dbforge->create_table('mahasiswa', TRUE);
		echo "OK\n";
		
		
		echo "  > create table user ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY'); // primary key
		$this->dbforge->add_field('username VARCHAR(10) NOT NULL');  // Format : BMXXYYYYYY, XX: Tahun Masuk, YYYYYY: Seri
		$this->dbforge->add_field('password_hash VARCHAR(60) NOT NULL');  // sha1(password)
		$this->dbforge->add_field('password_reset_token VARCHAR(100) NULL');
		$this->dbforge->add_field('password_plain VARCHAR(20) NULL');
		$this->dbforge->add_field('email VARCHAR(250) NULL');
		$this->dbforge->add_field('tipe_user INTEGER NOT NULL DEFAULT 1'); // 99-Admin; 1-Mahasiswa
		$this->dbforge->add_field('last_login TIMESTAMP WITHOUT TIME ZONE NULL');
		$this->dbforge->add_field('mahasiswa_id INTEGER NULL REFERENCES mahasiswa (id)');
		$this->dbforge->add_field('created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at TIMESTAMP NULL');
		$this->dbforge->create_table('user', TRUE);
		echo "OK\n";
		
		echo "  > insert table user (admin) ... ";
		$this->db->insert('user', ['username' => 'admin', 'password_hash' => sha1('password'), 'tipe_user' => 99]);
		echo "OK\n";
		
		
		echo "  > create table notifikasi_email ... ";
		$this->dbforge->add_field('id SERIAL'); // primary key
		$this->dbforge->add_field('mahasiswa_id INTEGER NOT NULL REFERENCES mahasiswa (id)');
		$this->dbforge->add_field('notifikasi VARCHAR(50) NOT NULL');
		$this->dbforge->add_field('waktu_kirim TIMESTAMP WITHOUT TIME ZONE NULL');
		$this->dbforge->create_table('notifikasi_email', TRUE);
		echo "OK\n";
		
		
		echo "  > create table survei ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY'); // Primary Key
		$this->dbforge->add_field('nama_survei VARCHAR(100) NOT NULL');
		$this->dbforge->add_field('deskripsi TEXT NULL');
		$this->dbforge->add_field('kode_tabel VARCHAR(10) NOT NULL'); // Prefix TS_
		$this->dbforge->add_field('created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at TIMESTAMP NULL');
		$this->dbforge->create_table('survei', TRUE);
		echo "OK\n";
		
		echo "  > create type jumlah_jawaban_enum ... ";
		$this->db->query("CREATE TYPE jumlah_jawaban_enum AS ENUM ('ONE', 'MANY')");
		echo "OK\n";
		
		echo "  > create table pertanyaan ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY');
		$this->dbforge->add_field('survei_id INTEGER NOT NULL REFERENCES survei (id)');
		$this->dbforge->add_field('no INT NOT NULL');
		$this->dbforge->add_field('no_view VARCHAR(10) NULL');
		$this->dbforge->add_field('pertanyaan TEXT NOT NULL');
		$this->dbforge->add_field('jumlah_jawaban jumlah_jawaban_enum NOT NULL');
		$this->dbforge->add_field('created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at TIMESTAMP NULL');
		$this->dbforge->create_table('pertanyaan', TRUE);
		$this->db->query("COMMENT ON COLUMN pertanyaan.no IS 'Urutan nomer'");
		$this->db->query("COMMENT ON COLUMN pertanyaan.no_view IS 'Jika ada isinya yg tayang adalah ini'");
		$this->db->query("COMMENT ON COLUMN pertanyaan.jumlah_jawaban IS 'ONE; MANY;'");
		echo "OK\n";
		
		echo "  > create type jenis_jawaban_enum ... ";
		$this->db->query("CREATE TYPE jenis_jawaban_enum AS ENUM ('SINGLE', 'MULTI_CHOICE', 'MULTI_ENTRY', 'MULTI_SELECT', 'MULTI_CHOICE_LR')");
		echo "OK\n";
		
		echo "  > create table jawaban ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY');
		$this->dbforge->add_field('pertanyaan_id INTEGER NOT NULL REFERENCES pertanyaan (id)');
		$this->dbforge->add_field('urutan INT NOT NULL DEFAULT 1');
		$this->dbforge->add_field('keterangan VARCHAR(100) NULL');
		$this->dbforge->add_field('keterangan_html TEXT NULL');
		$this->dbforge->add_field('jenis_jawaban jenis_jawaban_enum NOT NULL');
		$this->dbforge->add_field('created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at TIMESTAMP NULL');
		$this->dbforge->create_table('jawaban', TRUE);
		$this->db->query("COMMENT ON COLUMN jawaban.jenis_jawaban IS 'SINGLE; MULTI_CHOICE; MULTI_ENTRY; MULTI_SELECT; MULTI_CHOICE_LR'");
		echo "OK\n";
		
		echo "  > create type jenis_input_enum ... ";
		$this->db->query("CREATE TYPE jenis_input_enum AS ENUM ('TEXT','TEXT_TEXT','RADIO','CHECKBOX','CHECKBOX_TEXT','RADIO_TEXT','RADIO_5_LR')");
		echo "OK\n";
		
		echo "  > create table input_jawaban ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY');
		$this->dbforge->add_field('jawaban_id INTEGER NOT NULL REFERENCES jawaban (id)');
		$this->dbforge->add_field('urutan INT NOT NULL DEFAULT 1');
		$this->dbforge->add_field('jenis_input jenis_input_enum NOT NULL');
		$this->dbforge->add_field('name1 VARCHAR(10) NOT NULL');
		$this->dbforge->add_field('name2 VARCHAR(10) NULL');
		$this->dbforge->add_field('keterangan TEXT NULL');
		$this->dbforge->add_field('value1 VARCHAR(30) NULL');
		$this->dbforge->add_field('value2 VARCHAR(30) NULL');
		$this->dbforge->add_field('class1 VARCHAR(50) NULL');
		$this->dbforge->add_field('class2 VARCHAR(50) NULL');
		$this->dbforge->add_field('rules1 VARCHAR(50) NULL');
		$this->dbforge->add_field('rules2 VARCHAR(50) NULL');
		$this->dbforge->create_table('input_jawaban', TRUE);
		$this->db->query("COMMENT ON COLUMN input_jawaban.jenis_input IS 'TEXT; TEXT_TEXT; RADIO; CHECKBOX; CHECKBOX_TEXT; RADIO_TEXT; RADIO5_LR'");
		$this->db->query("COMMENT ON COLUMN input_jawaban.name1 IS 'Name input untuk input ke satu'");
		$this->db->query("COMMENT ON COLUMN input_jawaban.name2 IS 'Name input untuk input ke dua'");
		$this->db->query("COMMENT ON COLUMN input_jawaban.value1 IS 'Value untuk RADIO/CHECKBOX atau nilai 5 radio comma-separated'");
		$this->db->query("COMMENT ON COLUMN input_jawaban.value2 IS 'nilai 5 radio comma-separated'");
		echo "OK\n";
		
		
		echo "  > create table plot_survei ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY');
		$this->dbforge->add_field('mahasiswa_id INTEGER NOT NULL REFERENCES mahasiswa (id)');
		$this->dbforge->add_field('survei_id INTEGER NOT NULL REFERENCES survei (id)');
		$this->dbforge->add_field('waktu_pelaksanaan TIMESTAMP NULL');
		$this->dbforge->add_field('created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->create_table('plot_survei', TRUE);
		echo "OK\n";
		
		
		echo "  > create table hasil_survei ... ";
		$this->dbforge->add_field('id SERIAL PRIMARY KEY');
		$this->dbforge->add_field('mahasiswa_id INTEGER NOT NULL REFERENCES mahasiswa (id)');
		$this->dbforge->add_field('survei_id INTEGER NOT NULL REFERENCES survei (id)');
		$this->dbforge->add_field('pertanyaan_id INTEGER NOT NULL REFERENCES pertanyaan (id)');
		$this->dbforge->add_field('jawaban_id INTEGER NOT NULL REFERENCES jawaban (id)');
		$this->dbforge->add_field('input_jawaban_id INTEGER NOT NULL REFERENCES input_jawaban (id)');
		$this->dbforge->add_field('name1 TEXT NULL');
		$this->dbforge->add_field('name2 TEXT NULL');
		$this->dbforge->add_field('value1 TEXT NULL');
		$this->dbforge->add_field('value2 TEXT NULL');
		$this->dbforge->add_field('created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
		$this->dbforge->add_field('updated_at TIMESTAMP NULL');
		$this->dbforge->create_table('hasil_survei', TRUE);
		echo "OK\n";
    }

    public function down()
    {
		$tables_to_del = array(
			'hasil_survei',
			'plot_survei',
			'input_jawaban',
			'jawaban',
			'pertanyaan',
			'survei',
			'notifikasi_email',
			'user',
			'mahasiswa',
			'captcha'
		);
		
		foreach ($tables_to_del as $table)
		{
			echo "  > drop table {$table} ... ";
			$this->dbforge->drop_table($table, TRUE);
			echo "OK\n";
		}
		
		$types_to_del = array(
			'jumlah_jawaban_enum',
			'jenis_jawaban_enum',
			'jenis_input_enum'
		);
		
		foreach ($types_to_del as $type)
		{
			echo "  > drop type {$type} ... ";
			$this->db->query("DROP TYPE IF EXISTS {$type}");
			echo "OK\n";
		}
    }
}