<?php

// Load config
require_once('config.php');

/**
 * Get modules names
 * @param	active	bool	Only get active modules (default = true)
 * @return	array
 */
function getModulesNames($active_only = true)
{
	global $config;
	
	$modules = array();
	
	foreach ($config['modules'] as $module_index => $module) {
		// Skip if inactive
		if ( $active_only && ! $module['active'] ) {
			continue;
		}
		
		$modules[$module_index] = $module['name'];
	}
	
	return $modules;
}

/**
 * Get modules styles
 * Returns all CSS files for modules
 * @param	active	bool	Only get active modules (default = true)
 * @return	array
 */
function getModulesStyles($active_only = true)
{
	global $config;
	
	$css_files = array();
	
	foreach ($config['modules'] as $module_index => $module) {
		// Skip if inactive
		if ( $active_only && ! $module['active'] ) {
			continue;
		}
		
		// Is there a style.css file to include?
		$css_file = getModuleDir($module_index) . '/style.css';
		
		if ( file_exists($css_file) ) {
			// Need a web path instead of system path
			$css_files[$module['name']] = '/modules/' . $module['name'] . '/style.css';
		}
	}
	
	return $css_files;
}

/**
 * Render module
 * @param	string	Module name
 * @return	string	HTML content
 */
function renderModule($module_index)
{
	global $config;
	global $module_lang;
	
	$module_dir = getModuleDir($module_index);
	
	$module_file = $module_dir . '/module.php';
	
	// Skip if folder is not found or no module.php file
	if ( ! is_dir($module_dir) ||
		! file_exists($module_file) )
	{
		return false;
	}
	
	// Load lang file
	$lang = array();
	$lang_dir = $module_dir . '/lang';
	
	if ( is_dir($lang_dir) ) {
		// Based on config lang
		$lang_file = $lang_dir . '/' . $config['lang'] . '.php';
		
		if ( ! file_exists($lang_file) ) {
			// No lang file for congif lang, default to "en"
			$lang_file = $lang_dir . '/en.php';
		}
		
		if ( ! file_exists($lang_file) ) {
			// No lang file for "en" either. Fine, get whatever is in that folder.
			$lang_file = false;
			$scanned_lang_files = scandir($lang_dir);
			
			foreach ($scanned_lang_files as $scanned_lang_file) {
				$lang_file_parts = explode('.', $scanned_lang_file);
				
				// Just making sure the extension is ".php"
				if (end($lang_file_parts) == 'php') {
					$lang_file = $lang_dir . '/' . $scanned_lang_file;
					break;
				}
			}
		}
		
		if ($lang_file) {
			$lang = include($lang_file);
		}
	}
	
	return _renderModule($module_index, $module_file, $module_dir, $lang);
}

/**
 * _Render Module
 * Seperate function to contain variable scope
 */
function _renderModule($module_index, $module_file, $module_dir, $lang)
{
	global $config;
	
	include($module_file);
	
	$module_name = $config['modules'][$module_index]['name'];
	
	$module_config = array();
	
	// Load config file
	$config_dir = $module_dir . '/config';
	
	if ( is_dir($config_dir) ) {
		if ( isset($config['modules'][$module_index]['config']) ) {
			$config_file = $config_dir . '/' . $config['modules'][$module_index]['config'] . '.php';
		}
		
		
		if ( ! isset($config_file) || ! file_exists($config_file) ) {
			$config_file = $config_dir . '/default.php';
		}
		
		if ( file_exists($config_file) ) {
			$module_config = include($config_file);
		}
	}
	
	$module_class = 'Module_' . $module_name;
	
	$module = new $module_class;
	
	$module->init($module_config, $module_index, $config['modules'][$module_index]['name'], $lang);
	
	$module->render();
}

/**
 * Get module dir
 * @param	string	Module name
 * @param	bool	Use a web path
 * @return	string
 */
function getModuleDir($module_index, $web_path = false)
{
	global $config;
	
	$modules_web_dir = '/modules';
	$modules_dir = __DIR__ . '/../' . $modules_web_dir;
	
	if ( ! $web_path ) {
		$dir = $modules_dir . '/' . $config['modules'][$module_index]['name'];
	}
	else {
		$dir = $modules_web_dir . '/' . $config['modules'][$module_index]['name'];
	}
	
	return $dir;
}

/**
 * 
 * @param	
 * @param	
 * @return	
 */
function getSchedule()
{
	$cmd = 'crontab -l -u pi';
	$crontab = shell_exec($cmd);
	
	$schedule = array(
		'start_hour' => '0',
		'start_minute' => '0',
		'duration_hour' => '0',
		'duration_minute' => '0',
	);
	
	// A special tag is used to identify crontab lines for the pi alarm
	// Seperate into lines and find those with the special tag
	$lines = explode("\n", $crontab);
	
	foreach ($lines as $i => $line) {
		if ( strpos($line, '#pialarm') >= 0 ) {
			if (strpos($line, 'alarm_on') > 0) {
				$parts = explode(" ", $line);
				
				$schedule['start_minute'] = (int)$parts[0];
				$schedule['start_hour'] = (int)$parts[1];
				
				break;
			}
		}
	}
	
	// Seperate loops because we need to have start_hour to calculate duration_hour
	foreach ($lines as $i => $line) {
		if ( strpos($line, '#pialarm') >= 0 ) {
			if (strpos($line, 'alarm_off') > 0) {
				$parts = explode(" ", $line);
				
				// TODO
				// Duration is End minus Start, but need to consider negative minutes
				
				$end_minute = (int)$parts[0];
				$end_hour = (int)$parts[1];
				
				$duration_minute = $end_minute - $schedule['start_minute'];
				
				$hour_difference = 0;
				
				if ($duration_minute < 0) {
					$hour_difference = -1;
					$duration_minute += 60;
				}
				
				$duration_hour = $end_hour - $schedule['start_hour'] + $hour_difference;
				
				$schedule['duration_minute'] = $duration_minute;
				$schedule['duration_hour'] = $duration_hour;
				
				break;
			}
		}
	}
	
	return $schedule;
}

/**
 * 
 * @param	
 * @param	
 * @return	
 */
function setSchedule($start_hour = 8, $start_minute = 0, $duration_hour = 1, $duration_minute = 0)
{
	$cmd = 'crontab -l';
	$crontab = shell_exec($cmd);
	
	$end_minute = (int)$start_minute + (int)$duration_minute;
	$extra_hours = floor($end_minute / 60);
	$end_minute = $end_minute % 60;
	
	
	$end_hour = (int)$start_hour + (int)$duration_hour + $extra_hours;
	$extra_days = floor($end_hour / 24);
	$end_hour = $end_hour % 24;
	
	// A special tag is used to identify crontab lines for the pi alarm
	// Seperate into lines and find those with the special tag
	$lines = explode("\n", $crontab);
	
	// Remove previous crontab lines for the pi alarm
	foreach ($lines as $i => $line) {
		if ( strpos($line, '#pialarm') !== false ) {
			unset($lines[$i]);
		}
		
		// Remove empty lines
		if ( empty($line) ) {
			unset($lines[$i]);
		}
	}
	
	// Add new lines in the crontab with new settings
	$lines[] = "$start_minute $start_hour * * * sh /home/pi/alarm_on.sh #pialarm";
	$lines[] = "$end_minute $end_hour * * * sh /home/pi/alarm_off.sh #pialarm";
	
	shell_exec('(echo "' . implode("\n", $lines) . '") | crontab -');
}

/**
 * Alarm On
 * Manually starts the alarm
 */
function alarmOn()
{
	$cmd = 'DISPLAY=":0" sh /home/pi/alarm_on.sh';
	$o = shell_exec($cmd);
}

/**
 * Alarm Off
 * Manually shuts the alarm off
 */
function alarmOff()
{
	$cmd = 'sh /home/pi/alarm_off.sh';
	$o = shell_exec($cmd);
}

/**
 * Update App
 * Fetch and rebase through Git
 */
function updateApp()
{
	$cmd = 'sh /home/pi/update.sh';
	$o = shell_exec($cmd);
}