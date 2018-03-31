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
 * Description of 006_insert_email_config
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Migration_Insert_email_config extends CI_Migration
{
	public function up()
	{
		echo "  > insert email config ... ";
		$config_set[] = [
			'config_name' => 'email_subject',
			'config_value' => "Tracer Study Bidikmisi Tahun 2018"
		];
		
		$email_body = <<<EOT
Kepada Yth. 
{NAMA}
Alumni Penerima Bantuan Pendidikan Bidikmisi
{PERGURUAN TINGGI}
Di Tempat

Direktorat Jenderal Pembelajaran dan Kemahasiswaan, Kementerian Riset, Teknologi, dan Pendidikan Tinggi (Ditjen Belmawa Kemenristekdikti) saat ini sedang melakukan pendataan Alumni Penerima Bantuan Pendidikan Bidikmisi di seluruh Indonesia terutama yang telah lulus dalam rentang tahun 2013-2015. Berkaitan dengan hal tersebut, kami meminta kerja sama Anda untuk mengisi data Alumni Penerima Bantuan Pendidikan Bidikmisi melalui laman: http://ts-bidikmisi.belmawa.ristekdikti.go.id selambat-lambatnya 7 April 2018. Data ini akan digunakan sebagai laporan Ditjen Belmawa Kemenristekdikti kepada stakeholders terkait.

Untuk mengisi pendataan tersebut, Anda dapat log-in menggunakan
Username : {USERNAME}
Password : {PASSWORD}
Pengisian pendataan ini hanya akan memakan waktu selama kurang lebih 4 menit . Untuk itu mohon berkenan untuk meluangkan waktu sebagai bentuk terima kasih atas bantuan pendidikan Bidikmisi yang telah diberikan selama 3-4 tahun. Dengan Anda mengisi pendataan Alumni Penerima Bantuan Pendidikan Bidikmisi, Anda telah membantu mempertahankan Bidikmisi untuk tetap ada dalam pemerataan pendidikan di Indonesia.

Terima Kasih

Hormat kami,

Tim Pendataan Alumni Bidikmisi 2018
EOT;
		$config_set[] = [
			'config_name' => 'email_body',
			'config_value' => $email_body
		];
		
		$config_set[] = ['config_name' => 'email_smtp_host', 'config_value' => NULL];
		$config_set[] = ['config_name' => 'email_smtp_port', 'config_value' => 465];
		$config_set[] = ['config_name' => 'email_smtp_timeout', 'config_value' => 60];
		$config_set[] = ['config_name' => 'email_smtp_keepalive', 'config_value' => 0];
		$config_set[] = ['config_name' => 'email_smtp_crypto', 'config_value' => 'ssl'];
		
		$this->db->insert_batch('config', $config_set);
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > delete email from config ... ";
		$this->db->delete('config', 'config_name like \'email_%\'');
		echo "OK\n";
	}
}
