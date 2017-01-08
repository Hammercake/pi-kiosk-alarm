<?php

require_once('lib/system.php');
require_once('lib/module.php');

$action = false;

if (isset($_GET['a'])) {
	$action = $_GET['a'];
}

switch ($action) {
	
	case 'alarm_on':
		alarmOn();
		break;
	
	case 'alarm_off':
		alarmOff();
		break;
	
	case 'update_app':
		updateApp();
		break;
	
	case 'alarm_set_schedule':
		$start_hour = intval($_GET['start_hour']);
		$start_minute = intval($_GET['start_minute']);
		$duration_hour = intval($_GET['duration_hour']);
		$duration_minute = intval($_GET['duration_minute']);
		
		setSchedule($start_hour, $start_minute, $duration_hour, $duration_minute);
		
		break;
	
	case 'load_module':
		if ( ! isset($_GET['module_index']) ) {
			die();
		}
		
		$module_index = $_GET['module_index'];
		
		echo renderModule($module_index);
		break;
}

?>