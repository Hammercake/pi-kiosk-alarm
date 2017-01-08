<?php

abstract class Module
{
	protected $module_index;
	protected $module_name;
	protected $config;
	protected $lang;
	
	function init($config, $module_index, $module_name, $lang)
	{
		$this->config = $config;
		$this->module_index = $module_index;
		$this->module_name = $module_name;
		$this->lang = $lang;
	}
	
	function render()
	{
		include($this->getModuleDir() . '/view.php');
	}
	
	function getModuleDir($web_path = false)
	{
		global $config;
		
		$modules_web_dir = '/modules';
		$modules_dir = __DIR__ . '/..' . $modules_web_dir;
		
		if ( ! $web_path ) {
			$dir = $modules_dir . '/' . $this->module_name;
		}
		else {
			$dir = $modules_web_dir . '/' . $this->module_name;
		}
		
		return $dir;
	}
	
	function lang($index)
	{
		if ( isset($this->lang[$index]) ) {
			$string = $this->lang[$index];
		}
		else {
			$string = $index;
		}
		
		return $string;
	}

}