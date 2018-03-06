<?php

/*
 * Copyright (C) 2018 Fathoni <m.fathoni@mail.com>.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

/**
 * Description of Smarty_wrapper
 *
 * @author Fathoni <m.fathoni@mail.com>
 */
require_once FCPATH . 'vendor/smarty/smarty/libs/Smarty.class.php';

class Smarty_wrapper extends Smarty 
{ 
	/**
     * Initialize new Smarty object
     */
	function __construct()
	{
		parent::__construct();
		
		$CI =& get_instance();
		
		$views_folder			= 'views';
		$views_compiled_folder	= 'views_compiled';
		
		// Config Initialize
		$this->setTemplateDir(APPPATH.$views_folder);
		$this->setCompileDir(APPPATH.$views_compiled_folder);
		$this->assignByRef('ci', $CI);
				
		// create folder if not exist
		if ( ! file_exists(APPPATH.$views_compiled_folder))
		{
			mkdir(APPPATH.$views_compiled_folder, 0777);
		}
	}
	
	/**
     * Override fungsi 'display()' dari Smarty, dengan melakukan automatisasi pada class & method dengan cara memanggil file nama_class/nama_method.tpl
     *
     * @param string $template   the resource handle of the template file or template object
     * @param mixed  $cache_id   cache id to be used with this template
     * @param mixed  $compile_id compile id to be used with this template
     * @param object $parent     next higher level of Smarty variables
     */
	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
	{		
		// Di olah hanya ketika null
		if ($template == NULL)
		{
			$CI =& get_instance();
			
			$template = APPPATH . 'views/' . $CI->router->directory . $CI->router->class . '/' . $CI->router->method . '.tpl';
			
			if (file_exists($template))
			{
				parent::display($template, $cache_id, $compile_id, $parent);
			}
			else
			{
				show_error("Template \"{$template}\" not found.");
			}
		}
		else
		{
			parent::display($template, $cache_id, $compile_id, $parent);
		}
	}
	
	public function assignForCombo($tpl_var, $rows_object, $value_column, $display_column)
	{
		$value = array();
		
		foreach ($rows_object as $row)
		{
			$value[$row->{$value_column}] = $row->{$display_column};
		}
		
		parent::assign($tpl_var, $value);
	}
}

/* End of file Smarty_wrapper.php */
