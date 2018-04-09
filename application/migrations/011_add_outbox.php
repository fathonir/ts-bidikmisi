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
 * Description of 011_add_outbox
 *
 * @author Fathoni <m.fathoni@mail.com>
 */
class Migration_Add_outbox extends CI_Migration
{
	public function up()
	{
		echo "  > create table email_outbox ... ";
		$this->dbforge->add_field('email VARCHAR(80) NOT NULL');
		$this->dbforge->add_field('subject TEXT NOT NULL');
		$this->dbforge->add_field('body TEXT NOT NULL');
		$this->dbforge->add_field('sent_time TIMESTAMP');
		$this->dbforge->add_field('mahasiswa_id INT NULL');
		$this->dbforge->add_field('tgl_created TIMESTAMP(6) NOT NULL');
		$this->dbforge->create_table('email_outbox', TRUE);
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > drop table email_outbox ... ";
		$this->dbforge->drop_table('email_outbox');
		echo "OK\n";
	}
}
