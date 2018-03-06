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
 * Description of Migrate
 *
 * @author Fathoni <m.fathoni@mail.com>
 */
class Migrate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		if ( ! $this->input->is_cli_request())
		{
			echo "Migrate harus dijalankan melalui cli";
			exit();
		}
		
		$this->load->library('migration');
	}
	
	public function index()
	{
		// Get current version
		$migration = $this->db->get('migrations')->row();
		
		echo "Current Version : {$migration->version}\n";
		
		echo "List Migration :\n";
		
		$migrations = $this->migration->find_migrations();
		
		$i = 1;
		
		foreach ($migrations as $mig_ver => $mig_file)
		{
			$mig_file = str_replace(APPPATH.'migrations/', '', $mig_file);
			echo "[{$i}] {$mig_file}\n";
			$i++;
		}
	}
	
	public function up($target_version = null)
	{
		if ($target_version == null)
			$result = $this->migration->latest();
		else
			$result = $this->migration->version($target_version);
		
		if ($result === FALSE)
		{
			show_error($this->migration->error_string());
		}
		else
		{
			echo "  > Berhasil di migrate ke versi " . $result . "\n";
		}
	}
	
	public function down($target_version = null)
	{
		// get all migration
		$migrations = $this->migration->find_migrations();
		
		// get latest version
		$latest_version = count($migrations);
		
		// rollback 1 version
		if ($target_version == null)
			$target_version = $latest_version - 1;
		
		// do rollback
		$result = $this->migration->version($target_version);
		
		if ($result == TRUE)
			echo "  > Berhasil di migrate down ke versi " . $target_version . "\n";
	}
}

