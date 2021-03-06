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
 * Description of 007_alter_table_user
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_table_user extends CI_Migration
{
	public function up()
	{
		echo "  > alter table user ... ";
		$this->dbforge->add_column('user', 'email_username VARCHAR(100) NULL');
		$this->dbforge->add_column('user', 'email_password VARCHAR(100) NULL');
		echo "OK\n";
	}
	
	public function down()
	{
		echo "  > rollback table user ... ";
		$this->dbforge->drop_column('user', 'email_username');
		$this->dbforge->drop_column('user', 'email_password');
		echo "OK\n";
	}
}
