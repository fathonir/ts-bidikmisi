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
 * @property CI_DB_postgre_driver $db
 */
class Migration_Seed_initial_data extends CI_Migration
{
	public function up()
	{
		echo "  > seed initial data ...\n";
		
		echo "  > insert table survei ... ";
		$this->db->insert('survei', ['nama_survei' => 'Tracer Study Bidikmisi 2018', 'kode_tabel' => 'BM2018']);
		$survei_id = $this->db->insert_id();
		echo "OK\n";
		
		echo "  > insert table pertanyaan ... ";
		$this->db->insert_batch('pertanyaan', array(
			[
				'survei_id' => $survei_id, 
				'no' => 1, 'no_view' => 'F2',
				'pertanyaan' => 'Menurut anda seberapa besar penekanan pada metode pembelajaran di bawah ini dilaksanakan di program studi anda ?',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 2, 'no_view' => 'F3',
				'pertanyaan' => 'Kapan anda mulai mencari pekerjaan? <i>Mohon pekerjaan sambilan tidak dimasukkan</i>',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 3, 'no_view' => 'F18',
				'pertanyaan' => 'Kira-kira berapa jam/minggu Anda gunakan untuk kegiatan berikut selama Anda kuliah? (jam/minggu)',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 4, 'no_view' => 'F20',
				'pertanyaan' => 'Sebutkan prestasi Anda selama kuliah dalam bidang di bawah ini:',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 5, 'no_view' => 'F21',
				'pertanyaan' => 'Sebutkan prestasi Anda setelah lulus kuliah dalam bidang di bawah ini:',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 6, 'no_view' => 'F22',
				'pertanyaan' => 'Apakah Anda aktif di organisasi (organisasi sosial/kepemudaan/agama/politik, dll.)?',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 7, 'no_view' => 'F4',
				'pertanyaan' => 'Bagaimana anda mencari pekerjaan tersebut? <i>Jawaban bisa lebih dari satu</i>',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 8, 'no_view' => 'F5',
				'pertanyaan' => 'Berapa bulan waktu yang dihabiskan (sebelum dan sesudah kelulusan) untuk memeroleh pekerjaan pertama?',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 9, 'no_view' => 'F6',
				'pertanyaan' => 'Berapa perusahaan/instansi/institusi yang sudah anda lamar (lewat surat atau e-mail) sebelum anda memeroleh pekerjaan pertama?',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 10, 'no_view' => 'F7',
				'pertanyaan' => 'Berapa banyak perusahaan/instansi/institusi yang merespons lamaran anda?',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 11, 'no_view' => 'F7a',
				'pertanyaan' => 'Berapa banyak perusahaan/instansi/institusi yang mengundang anda untuk wawancara?',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 12, 'no_view' => 'F8',
				'pertanyaan' => 'Apakah anda bekerja saat ini (termasuk kerja sambilan dan wirausaha)?',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 13, 'no_view' => 'F9',
				'pertanyaan' => 'Bagaimana anda menggambarkan situasi anda saat ini? <i>Jawaban bisa lebih dari satu</i>',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 14, 'no_view' => 'F10',
				'pertanyaan' => 'Apakah anda aktif mencari pekerjaan dalam 4 minggu terakhir? <i>Pilihlah Satu Jawaban. KEMUDIAN LANJUT KE f17</i>',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 14, 'no_view' => 'F11',
				'pertanyaan' => 'Apa jenis perusahaan/instansi/institusi tempat anda bekerja sekarang?',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 15, 'no_view' => 'F13',
				'pertanyaan' => 'Kira-kira berapa pendapatan anda setiap bulannya?',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 16, 'no_view' => 'F14',
				'pertanyaan' => 'Seberapa erat hubungan antara bidang studi dengan pekerjaan anda?',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 17, 'no_view' => 'F15',
				'pertanyaan' => 'Tingkat pendidikan apa yang paling tepat/sesuai untuk pekerjaan anda saat ini?',
				'jumlah_jawaban' => 'ONE'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 18, 'no_view' => 'F16',
				'pertanyaan' => 'Jika menurut anda pekerjaan anda saat ini tidak sesuai dengan pendidikan anda, mengapa anda mengambilnya? <i>Jawaban bisa lebih dari satu</i>',
				'jumlah_jawaban' => 'MANY'
			],
			[
				'survei_id' => $survei_id, 
				'no' => 19, 'no_view' => 'F17',
				'pertanyaan' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini anda kuasai? (A) Pada saat ini, pada tingkat mana kompetensi di bawah ini diperlukan dalam pekerjaan? (B)',
				'jumlah_jawaban' => 'MANY'
			],
		));
		echo "OK\n";
		
		echo "  > insert table jawaban + input_jawaban F2 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F2'])->row()->id;
		
		$jawaban_f2_set = [
			['urutan' => 1, 'keterangan' => 'Perkuliahan', 'name1' => 'F21'],
			['urutan' => 2, 'keterangan' => 'Demonstrasi', 'name1' => 'F22'],
			['urutan' => 3, 'keterangan' => 'Partisipasi dalam proyek riset', 'name1' => 'F23'],
			['urutan' => 4, 'keterangan' => 'Magang', 'name1' => 'F24'],
			['urutan' => 5, 'keterangan' => 'Praktikum', 'name1' => 'F25'],
			['urutan' => 6, 'keterangan' => 'Kerja Lapangan', 'name1' => 'F26'],
			['urutan' => 7, 'keterangan' => 'Diskusi', 'name1' => 'F27'],
		];
		
		foreach ($jawaban_f2_set as $jawaban_f2)
		{
			$this->db->insert('jawaban', [
				'pertanyaan_id' => $pertanyaan_id, 'urutan' => $jawaban_f2['urutan'], 
				'keterangan' => $jawaban_f2['keterangan'],
				'jenis_jawaban' => 'MULTI_CHOICE'
			]);
			
			$jawaban_id = $this->db->insert_id();
			
			$input_jawaban_f2_set = [
				['urutan' => 1, 'keterangan' => 'Sangat Besar', 'value1' => 1],
				['urutan' => 2, 'keterangan' => 'Besar', 'value1' => 2],
				['urutan' => 3, 'keterangan' => 'Cukup Besar', 'value1' => 3],
				['urutan' => 4, 'keterangan' => 'Kurang', 'value1' => 4],
				['urutan' => 5, 'keterangan' => 'Tidak sama sekali', 'value1' => 5],
			];
			
			foreach ($input_jawaban_f2_set as $input_jawaban_f2)
			{
				$this->db->insert('input_jawaban', [
					'jawaban_id' => $jawaban_id, 'urutan' => $input_jawaban_f2['urutan'], 
					'jenis_input' => 'RADIO', 
					'name1' => $jawaban_f2['name1'], 
					'keterangan' => $input_jawaban_f2['keterangan'],
					'value1' => $input_jawaban_f2['value1']
				]);
			}
		}
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F3 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F3'])->row()->id;
		
		$this->db->insert('jawaban', [
			'pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 
			'keterangan' => NULL,
			'jenis_jawaban' => 'MULTI_CHOICE'
		]);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO_TEXT', 'name1' => 'F301', 'name2' => 'F302', 'keterangan' => '%1$s Kira - kira %2$s bulan sebelum lulus', 'value1' => 1]);
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO_TEXT', 'name1' => 'F301', 'name2' => 'F303', 'keterangan' => '%1$s Kira - kira %2$s bulan setelah lulus', 'value1' => 2]);
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'RADIO', 'name1' => 'F301', 'keterangan' => 'Saya tidak mencari kerja <i>(Langsung ke pertanyaan f8)</i>', 'value1' => 3]);
			
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F18 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F18'])->row()->id;
		
		$this->db->insert('jawaban', [
			'pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 
			'keterangan' => 'Reguler',
			'jenis_jawaban' => 'MULTI_ENTRY'
		]);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F181', 'class1' => 'width-50', 'keterangan' => 'Kuliah %s (jam/minggu)']);
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'TEXT', 'name1' => 'F182', 'class1' => 'width-50', 'keterangan' => 'Belajar mandiri/membuat PR/paper/tugas kuliah lain %s (jam/minggu)']);
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'TEXT_TEXT', 'name1' => 'F183', 'class1' => 'width-50', 'name2' => 'F183b', 'keterangan' => 'Lainnya %1$s (jam/minggu), Sebutkan: %2$s']);
		
		$this->db->insert('jawaban', [
			'pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 
			'keterangan' => 'Diluar kuliah reguler',
			'jenis_jawaban' => 'MULTI_ENTRY'
		]);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F184', 'class1' => 'width-50', 'keterangan' => 'Pelajaran tambahan/kelas di Semester Pendek /antara (SP) : %s (jam/minggu)']);
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'TEXT', 'name1' => 'F185', 'class1' => 'width-50', 'keterangan' => 'Belajar/kursus-kursus di kampus mapun di luar kampus : %s (jam/minggu)']);
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'TEXT', 'name1' => 'F186', 'class1' => 'width-50', 'keterangan' => 'Kegiatan Ekstrakurikuler (olah raga, seni, dll) : %s (jam/minggu)']);
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'TEXT_TEXT', 'name1' => 'F187', 'class1' => 'width-50', 'name2' => 'F187b', 'keterangan' => 'Lainnya %1$s (jam/minggu), Sebutkan: %2$s']);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F20 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F20'])->row()->id;
		
		$jawaban_f20_set = [
			['urutan' => 1, 'keterangan' => 'Olah Raga (jumlah kegiatan)'],
			['urutan' => 2, 'keterangan' => 'Seni'],
			['urutan' => 3, 'keterangan' => 'Penalaran / Sains'],
		];
		
		$n = 0;
		
		foreach ($jawaban_f20_set as $jawaban_f20)
		{
			$this->db->insert('jawaban', [
				'pertanyaan_id' => $pertanyaan_id, 'urutan' => $jawaban_f20['urutan'], 
				'keterangan' => $jawaban_f20['keterangan'],
				'jenis_jawaban' => 'MULTI_ENTRY'
			]);
			
			$jawaban_id = $this->db->insert_id();
			
			$this->db->insert_batch('input_jawaban', [
				['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F20'. ($n + 1), 'class1' => 'width-50', 'keterangan' => 'Tingkat Regional %s (Kali)'],
				['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'TEXT', 'name1' => 'F20'. ($n + 2), 'class1' => 'width-50', 'keterangan' => 'Tingkat Nasional %s (Kali)'],
				['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'TEXT', 'name1' => 'F20'. ($n + 3), 'class1' => 'width-50', 'keterangan' => 'Tingkat Internasional %s (Kali)'],
			]);
			
			$n += 3;
		}
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F21 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F21'])->row()->id;
		
		$this->db->insert('jawaban', [
			'pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 
			'keterangan' => 'Olah Raga',
			'jenis_jawaban' => 'MULTI_ENTRY'
		]);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F211', 'class1' => 'width-50', 'keterangan' => 'Tingkat Regional %s (Kali)'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'TEXT', 'name1' => 'F212', 'class1' => 'width-50', 'keterangan' => 'Tingkat Nasional %s (Kali)'],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'TEXT', 'name1' => 'F213', 'class1' => 'width-50', 'keterangan' => 'Tingkat Internasional %s (Kali)'],
		]);
		
		$this->db->insert('jawaban', [
			'pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 
			'keterangan' => 'Seni',
			'jenis_jawaban' => 'MULTI_ENTRY'
		]);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F214', 'class1' => 'width-50', 'keterangan' => 'Tingkat Regional %s (Kali)'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'TEXT', 'name1' => 'F215', 'class1' => 'width-50', 'keterangan' => 'Tingkat Nasional %s (Kali)'],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'TEXT', 'name1' => 'F216', 'class1' => 'width-50', 'keterangan' => 'Tingkat Internasional %s (Kali)'],
		]);
		
		$this->db->insert('jawaban', [
			'pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 
			'keterangan' => 'Penalaran',
			'jenis_jawaban' => 'MULTI_ENTRY'
		]);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F217', 'class1' => 'width-50', 'keterangan' => 'Penalaran %s'],
		]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F22 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F22'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => 'Sebelum Lulus', 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO', 'name1' => 'F221', 'keterangan' => 'Ya' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO', 'name1' => 'F221', 'keterangan' => 'Tidak' , 'value1' => '0'],
		]);
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 2, 'keterangan' => 'Setelah Lulus', 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO', 'name1' => 'F222', 'keterangan' => 'Ya' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO', 'name1' => 'F222', 'keterangan' => 'Tidak' , 'value1' => '0'],
		]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F4 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F4'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_SELECT']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'CHECKBOX', 'name1' => 'F401', 'keterangan' => 'Melalui iklan di koran/majalah, brosur' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'CHECKBOX', 'name1' => 'F402', 'keterangan' => 'Melamar ke perusahaan tanpa mengetahui lowongan yang ada' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'CHECKBOX', 'name1' => 'F403', 'keterangan' => 'Pergi ke bursa/pameran kerja' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'CHECKBOX', 'name1' => 'F404', 'keterangan' => 'Mencari lewat internet/iklan online/milis' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 5, 'jenis_input' => 'CHECKBOX', 'name1' => 'F405', 'keterangan' => 'Dihubungi oleh perusahaan' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 6, 'jenis_input' => 'CHECKBOX', 'name1' => 'F406', 'keterangan' => 'Menghubungi Kemenakertrans' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 7, 'jenis_input' => 'CHECKBOX', 'name1' => 'F407', 'keterangan' => 'Menghubungi agen tenaga kerja komersial/swasta' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 8, 'jenis_input' => 'CHECKBOX', 'name1' => 'F408', 'keterangan' => 'Memeroleh informasi dari pusat/kantor pengembangan karir fakultas/universitas' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 9, 'jenis_input' => 'CHECKBOX', 'name1' => 'F409', 'keterangan' => 'Menghubungi kantor kemahasiswaan/hubungan alumni' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 10, 'jenis_input' => 'CHECKBOX', 'name1' => 'F410', 'keterangan' => 'Membangun jejaring (network) sejak masih kuliah' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 11, 'jenis_input' => 'CHECKBOX', 'name1' => 'F411', 'keterangan' => 'Melalui relasi (misalnya dosen, orang tua, saudara, teman, dll.)' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 12, 'jenis_input' => 'CHECKBOX', 'name1' => 'F412', 'keterangan' => 'Membangun bisnis sendiri' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 13, 'jenis_input' => 'CHECKBOX', 'name1' => 'F413', 'keterangan' => 'Melalui penempatan kerja atau magang' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 14, 'jenis_input' => 'CHECKBOX', 'name1' => 'F414', 'keterangan' => 'Bekerja di tempat yang sama dengan tempat kerja semasa kuliah' , 'value1' => '1'],
		]);
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 15, 'jenis_input' => 'CHECKBOX_TEXT', 'name1' => 'F415', 'name2' => 'F416', 'keterangan' => '%1$s Lainnya : %2$s' , 'value1' => '1']);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F5 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F5'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO_TEXT', 'name1' => 'F501', 'name2' => 'F502', 'class2' => 'width-50', 'keterangan' => '%1$s Kira - kira %2$s bulan sebelum lulus ujian', 'value1' => 1],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO_TEXT', 'name1' => 'F501', 'name2' => 'F503', 'class2' => 'width-50', 'keterangan' => '%1$s Kira - kira %2$s bulan setelah lulus ujian', 'value1' => 2],
		]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F6 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F6'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'SINGLE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F6', 'class1' => 'width-50', 'keterangan' => '%s perusahaan/instansi/institusi']);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F7 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F7'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'SINGLE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F7', 'class1' => 'width-50', 'keterangan' => '%s perusahaan/instansi/institusi']);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F7a ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F7a'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'SINGLE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F7a', 'class1' => 'width-50', 'keterangan' => '%s perusahaan/instansi/institusi']);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F8 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F8'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO', 'name1' => 'F8', 'keterangan' => 'Ya <i>(Jika ya, lanjutkan ke f11)</i>', 'value1' => 1],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO', 'name1' => 'F8', 'keterangan' => 'Tidak', 'value1' => 2],
		]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F9 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F9'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_SELECT']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'CHECKBOX', 'name1' => 'F901', 'keterangan' => 'Saya masih belajar/melanjutkan kuliah profesi atau pascasarjana' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'CHECKBOX', 'name1' => 'F902', 'keterangan' => 'Saya menikah' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'CHECKBOX', 'name1' => 'F903', 'keterangan' => 'Saya sibuk dengan keluarga dan anak-anak' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'CHECKBOX', 'name1' => 'F904', 'keterangan' => 'Saya sekarang sedang mencari pekerjaan' , 'value1' => '1'],
		]);
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 5, 'jenis_input' => 'CHECKBOX_TEXT', 'name1' => 'F905', 'name2' => 'F906', 'class2' => 'width-350', 'keterangan' => '%1$s Lainnya: %2$s' , 'value1' => '1']);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F10 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F10'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO', 'name1' => 'F1001', 'keterangan' => 'Tidak' , 'value1' => 1],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO', 'name1' => 'F1001', 'keterangan' => 'Tidak, tapi saya sedang menunggu hasil lamaran kerja' , 'value1' => 2],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'RADIO', 'name1' => 'F1001', 'keterangan' => 'Ya, saya akan mulai bekerja dalam 2 minggu ke depan' , 'value1' => 3],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'RADIO', 'name1' => 'F1001', 'keterangan' => 'Ya, tapi saya belum pasti akan bekerja dalam 2 minggu ke depan' , 'value1' => 4],
		]);
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 5, 'jenis_input' => 'RADIO_TEXT', 'name1' => 'F1001', 'name2' => 'F1002', 'class2' => 'width-350', 'keterangan' => '%1$s Lainnya: %2$s' , 'value1' => 5]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F11 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F11'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO', 'name1' => 'F1101', 'keterangan' => 'Instansi pemerintah (termasuk BUMN)' , 'value1' => 1],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO', 'name1' => 'F1101', 'keterangan' => 'Organisasi non-profit/Lembaga Swadaya Masyarakat' , 'value1' => 2],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'RADIO', 'name1' => 'F1101', 'keterangan' => 'Perusahaan swasta' , 'value1' => 3],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'RADIO', 'name1' => 'F1101', 'keterangan' => 'Wiraswasta/perusahaan sendiri' , 'value1' => 4],
		]);
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 5, 'jenis_input' => 'RADIO_TEXT', 'name1' => 'F1101', 'name2' => 'F1102', 'class2' => 'width-350', 'keterangan' => '%1$s Lainnya, tuliskan: %2$s' , 'value1' => 5]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F13 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F13'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_ENTRY']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'TEXT', 'name1' => 'F1301', 'keterangan' => 'Dari Pekerjaan Utama Rp. %s (Isilah dengan ANGKA saja, tanpa tanda Titik atau Koma)'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'TEXT', 'name1' => 'F1302', 'keterangan' => 'Dari Lembur dan Tips Rp. %s (Isilah dengan ANGKA saja, tanpa tanda Titik atau Koma)'],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'TEXT', 'name1' => 'F1303', 'keterangan' => 'Dari Pekerjaan lainnya Rp. %s (Isilah dengan ANGKA saja, tanpa tanda Titik atau Koma)'],
		]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F14 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F14'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO', 'name1' => 'F14', 'keterangan' => 'Sangat Erat' , 'value1' => 1],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO', 'name1' => 'F14', 'keterangan' => 'Erat' , 'value1' => 2],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'RADIO', 'name1' => 'F14', 'keterangan' => 'Cukup Erat' , 'value1' => 3],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'RADIO', 'name1' => 'F14', 'keterangan' => 'Kurang Erat' , 'value1' => 4],
			['jawaban_id' => $jawaban_id, 'urutan' => 5, 'jenis_input' => 'RADIO', 'name1' => 'F14', 'keterangan' => 'Tidak Sama Sekali ' , 'value1' => 5],
		]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F15 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F15'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_CHOICE']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO', 'name1' => 'F15', 'keterangan' => 'Setingkat Lebih Tinggi' , 'value1' => 1],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO', 'name1' => 'F15', 'keterangan' => 'Tingkat yang Sama' , 'value1' => 2],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'RADIO', 'name1' => 'F15', 'keterangan' => 'Setingkat Lebih Rendah' , 'value1' => 3],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'RADIO', 'name1' => 'F15', 'keterangan' => 'Tidak Perlu Pendidikan Tinggi' , 'value1' => 4],
		]);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F16 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F16'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => NULL, 'jenis_jawaban' => 'MULTI_SELECT']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1601', 'keterangan' => 'Pertanyaan tidak sesuai; pekerjaan saya sekarang sudah sesuai dengan pendidikan saya.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1602', 'keterangan' => 'Saya belum mendapatkan pekerjaan yang lebih sesuai.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1603', 'keterangan' => 'Di pekerjaan ini saya memeroleh prospek karir yang baik.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1604', 'keterangan' => 'Saya lebih suka bekerja di area pekerjaan yang tidak ada hubungannya dengan pendidikan saya.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 5, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1605', 'keterangan' => 'Saya dipromosikan ke posisi yang kurang berhubungan dengan pendidikan saya dibanding posisi sebelumnya.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 6, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1606', 'keterangan' => 'Saya dapat memeroleh pendapatan yang lebih tinggi di pekerjaan ini.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 7, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1607', 'keterangan' => 'Pekerjaan saya saat ini lebih aman/terjamin/secure' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 8, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1608', 'keterangan' => 'Pekerjaan saya saat ini lebih menarik' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 9, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1609', 'keterangan' => 'Pekerjaan saya saat ini lebih memungkinkan saya mengambil pekerjaan tambahan/jadwal yang fleksibel, dll.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 10, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1610', 'keterangan' => 'Pekerjaan saya saat ini lokasinya lebih dekat dari rumah saya.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 11, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1611', 'keterangan' => 'Pekerjaan saya saat ini dapat lebih menjamin kebutuhan keluarga saya.' , 'value1' => '1'],
			['jawaban_id' => $jawaban_id, 'urutan' => 12, 'jenis_input' => 'CHECKBOX', 'name1' => 'F1612', 'keterangan' => 'Pada awal meniti karir ini, saya harus menerima pekerjaan yang tidak berhubungan dengan pendidikan saya.' , 'value1' => '1'],
		]);
		
		$this->db->insert('input_jawaban', ['jawaban_id' => $jawaban_id, 'urutan' => 13, 'jenis_input' => 'CHECKBOX_TEXT', 'name1' => 'F1613', 'name2' => 'F1614', 'class2' => 'width-350', 'keterangan' => '%1$s Lainnya: %2$s' , 'value1' => '1']);
		
		echo "OK\n";
		
		
		echo "  > insert table jawaban + input_jawaban F17 ... ";
		
		$pertanyaan_id = $this->db->get_where('pertanyaan', ['survei_id' => $survei_id, 'no_view' => 'F17'])->row()->id;
		
		$this->db->insert('jawaban', ['pertanyaan_id' => $pertanyaan_id, 'urutan' => 1, 'keterangan' => '', 'jenis_jawaban' => 'MULTI_CHOICE_LR']);
		
		$jawaban_id = $this->db->insert_id();
		
		$this->db->insert_batch('input_jawaban', [
			['jawaban_id' => $jawaban_id, 'urutan' => 1, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F171', 'value1' => '1,2,3,4,5', 'name2' => 'F172b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Pengetahuan di bidang atau disiplin ilmu anda'],
			['jawaban_id' => $jawaban_id, 'urutan' => 2, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F173', 'value1' => '1,2,3,4,5', 'name2' => 'F174b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Pengetahuan di luar bidang atau disiplin ilmu anda'],
			['jawaban_id' => $jawaban_id, 'urutan' => 3, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F175', 'value1' => '1,2,3,4,5', 'name2' => 'F176b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Pengetahuan umum'],
			['jawaban_id' => $jawaban_id, 'urutan' => 4, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F175a', 'value1' => '1,2,3,4,5', 'name2' => 'F176ba', 'value2' => '1,2,3,4,5', 'keterangan' => 'Bahasa inggris'],
			['jawaban_id' => $jawaban_id, 'urutan' => 5, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F177', 'value1' => '1,2,3,4,5', 'name2' => 'F178b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Ketrampilan internet'],
			['jawaban_id' => $jawaban_id, 'urutan' => 6, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F179', 'value1' => '1,2,3,4,5', 'name2' => 'F1710b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Berpikir kritis'],
			['jawaban_id' => $jawaban_id, 'urutan' => 7, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1711', 'value1' => '1,2,3,4,5', 'name2' => 'F1712b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Ketrampilan riset'],
			['jawaban_id' => $jawaban_id, 'urutan' => 8, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1713', 'value1' => '1,2,3,4,5', 'name2' => 'F1714b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan belajar'],
			['jawaban_id' => $jawaban_id, 'urutan' => 9, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1715', 'value1' => '1,2,3,4,5', 'name2' => 'F1716b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan berkomunikasi'],
			['jawaban_id' => $jawaban_id, 'urutan' => 10, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1717', 'value1' => '1,2,3,4,5', 'name2' => 'F1718b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Bekerja di bawah'],
			['jawaban_id' => $jawaban_id, 'urutan' => 11, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1719', 'value1' => '1,2,3,4,5', 'name2' => 'F1720b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Manajemen waktu'],
			['jawaban_id' => $jawaban_id, 'urutan' => 12, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1721', 'value1' => '1,2,3,4,5', 'name2' => 'F1722b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Bekerja secara mandiri'],
			['jawaban_id' => $jawaban_id, 'urutan' => 13, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1723', 'value1' => '1,2,3,4,5', 'name2' => 'F1724b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Bekerja dalam tim / bekerjasama dengan orang lain'],
			['jawaban_id' => $jawaban_id, 'urutan' => 14, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1725', 'value1' => '1,2,3,4,5', 'name2' => 'F1726b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Negoisasi'],
			['jawaban_id' => $jawaban_id, 'urutan' => 15, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1727', 'value1' => '1,2,3,4,5', 'name2' => 'F1728b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan analisis'],
			['jawaban_id' => $jawaban_id, 'urutan' => 16, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1729', 'value1' => '1,2,3,4,5', 'name2' => 'F1730b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Toleransi'],
			['jawaban_id' => $jawaban_id, 'urutan' => 17, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1731', 'value1' => '1,2,3,4,5', 'name2' => 'F1732b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan adaptasi'],
			['jawaban_id' => $jawaban_id, 'urutan' => 18, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1733', 'value1' => '1,2,3,4,5', 'name2' => 'F1734b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Loyalitas'],
			['jawaban_id' => $jawaban_id, 'urutan' => 19, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1735', 'value1' => '1,2,3,4,5', 'name2' => 'F1736b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Integritas'],
			['jawaban_id' => $jawaban_id, 'urutan' => 20, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1737', 'value1' => '1,2,3,4,5', 'name2' => 'F1738b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Bekerja dengan orang yang berbeda budaya maupun latar belakang'],
			['jawaban_id' => $jawaban_id, 'urutan' => 21, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1737a', 'value1' => '1,2,3,4,5', 'name2' => 'F1738ba', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kepemimpinan'],
			['jawaban_id' => $jawaban_id, 'urutan' => 22, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1739', 'value1' => '1,2,3,4,5', 'name2' => 'F1740b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan dalam memegang tanggung jawab'],
			['jawaban_id' => $jawaban_id, 'urutan' => 23, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1741', 'value1' => '1,2,3,4,5', 'name2' => 'F1742b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Inisiatif'],
			['jawaban_id' => $jawaban_id, 'urutan' => 24, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1743', 'value1' => '1,2,3,4,5', 'name2' => 'F1744b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Manajemen proyek / program'],
			['jawaban_id' => $jawaban_id, 'urutan' => 25, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1745', 'value1' => '1,2,3,4,5', 'name2' => 'F1746b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan untuk memresentasikan ide/produk/laporan'],
			['jawaban_id' => $jawaban_id, 'urutan' => 26, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1747', 'value1' => '1,2,3,4,5', 'name2' => 'F1748b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan dalam menulis laporan, memo dan dokumen'],
			['jawaban_id' => $jawaban_id, 'urutan' => 27, 'jenis_input' => 'RADIO_5_LR', 'name1' => 'F1749', 'value1' => '1,2,3,4,5', 'name2' => 'F1750b', 'value2' => '1,2,3,4,5', 'keterangan' => 'Kemampuan untuk terus belajar sepanjang hayat'],
		]);
		
		echo "OK\n";
		
		echo "  > seed complete !\n";
	}
	
	public function down()
	{
		echo "  > clear initial data ...\n";
		
		echo "  > delete from table input_jawaban ... ";
		$this->db->query("DELETE FROM input_jawaban");
		echo "OK\n";
		
		echo "  > delete from table jawaban ... ";
		$this->db->query("DELETE FROM jawaban");
		echo "OK\n";
		
		echo "  > delete from table pertanyaan ... ";
		$this->db->query("DELETE FROM pertanyaan");
		echo "OK\n";
		
		echo "  > delete from table survei ... ";
		$this->db->query("DELETE FROM survei");
		echo "OK\n";
		
		echo "  > clear complete !\n";
	}
}
