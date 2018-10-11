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
 * Description of 014_add_username_seq
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_result $result
 */
class Migration_Add_username_seq extends CI_Migration
{
	public function up()
	{
		echo "  > create sequence username_seq ... ";
		$this->db->query("create sequence username_seq");
		$this->result = $this->db->query("select max(substring(username, 6))::int + 1 as seri from \"user\"");
		$seri = $this->result->first_row()->seri;
		$this->db->query("alter sequence username_seq restart with {$seri}");
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > drop sequence username_seq ... ";
		$this->db->query("drop sequence username_seq");
		echo "OK\n";
	}
}
