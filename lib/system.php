<?php

$config_cache = null;

/**
 * Get config
 * Gets the app config
 * @return	array
 */
function getConfig()
{
	global $config_cache;
	
	if ($config_cache != null) {
		return $config_cache;
	}
	
	$config = array();
	
	$config_file = getcwd() . '/config.php';
	
	if ( file_exists($config_file) ) {
		$config = include($config_file);
	}
	
	// Overwrite values with user settings
	$settings = loadSettings('app');
	
	$config = array_replace_recursive($config, $settings);
	
	$config_cache = $config;
	
	return $config;
}

/**
 * Get modules names
 * @param	active	bool	Only get active modules (default = true)
 * @return	array
 */
function getModulesNames($active_only = true)
{
	$config = getConfig();
	
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
	$config = getConfig();
	
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
 * Init module
 * @param	string	Module index
 * @return	object
 */
function initModule($module_index)
{
	$config = getConfig();
	
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
	
	include($module_file);
	
	$module_config = getModuleConfig($module_index);
	
	$module_name = $config['modules'][$module_index]['name'];
	
	$module_class = 'Module_' . $module_name;
	
	$module = new $module_class;
	
	$module->init($module_config, $module_index, $config['modules'][$module_index]['name'], $lang);
	
	return $module;
}

/**
 * Render module
 * @param	string	Module index
 * @return	string	HTML content
 */
function renderModule($module_index)
{
	$module = initModule($module_index);
	
	return $module->render();
}

/**
 * Get module dir
 * @param	string	Module index
 * @param	bool	Use a web path
 * @return	string
 */
function getModuleDir($module_index, $web_path = false)
{
	$config = getConfig();
	
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
 * Get module config
 * @param	string	Module index
 * @param	bool	Include user settings
 * @return	array
 */
function getModuleConfig($module_index)
{
	$config = getConfig();
	
	$module_config = array();
	
	$module_dir = getModuleDir($module_index);
	
	$config_file = $module_dir . '/config.php';
	
	if ( file_exists($config_file) ) {
		$module_config = include($config_file);
	}
	
	// Overwrite values with user settings
	$settings = loadSettings($module_index);
	
	$module_config = array_replace_recursive($module_config, $settings);
	
	return $module_config;
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
 * Set Schedule
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
	$lines[] = "$start_minute $start_hour * * * sh " . getcwd() . "/sh/alarm_on.sh #pialarm";
	$lines[] = "$end_minute $end_hour * * * sh " . getcwd() . "/sh/alarm_off.sh #pialarm";
	
	shell_exec('(echo "' . implode("\n", $lines) . '") | crontab -');
}

/**
 * Alarm On
 * Manually starts the alarm
 */
function alarmOn()
{
	$cmd = 'DISPLAY=":0" sh ' . getcwd() . '/sh/alarm_on.sh';
	$o = shell_exec($cmd);
}

/**
 * Alarm Off
 * Manually shuts the alarm off
 */
function alarmOff()
{
	$cmd = 'sh ' . getcwd() . '/sh/alarm_off.sh';
	$o = shell_exec($cmd);
}

/**
 * Update App
 * Fetch and rebase through Git
 */
function updateApp()
{
	$cmd = 'sh ' . getcwd() . '/sh/update_app.sh';
	$o = shell_exec($cmd);
}

/**
 * Save Settings
 * Saves given settings array in a file
 * @param	array	Associative array where keys are config index and values are the setting for that config entry
 * @param	name	Key name to retrieve settings. File will be named using that param
 */
function saveSettings($settings, $name)
{
	$settings_folder = getcwd() . '/settings';
	$file_name = $settings_folder . '/' . $name . '.json';
	
	$json_data = json_encode($settings);
	
	file_put_contents($file_name, $json_data);
}

/**
 * Load Settings
 * Retrieves saved settings
 * @param	string	Name used when saving settings, also the name of the settings file.
 * @return	array
 */
function loadSettings($name)
{
	$settings_folder = getcwd() . '/settings';
	$file_name = $settings_folder . '/' . $name . '.json';
	
	$settings = array();
	
	if ( file_exists($file_name) ) {
		$json_data = file_get_contents($file_name);
		$settings = json_decode($json_data, true);
	}
	
	return $settings;
}

/**
 * Beautify
 * Makes a string (array index mainly) prettier to read
 * @param	string	String to make pretty
 * @return	sdtring
 */
function beautify($index)
{
	$index = Ucfirst($index);
	$index = str_replace('_', ' ', $index);
	
	return $index;
}