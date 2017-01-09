<?php

require_once('lib/system.php');

$config = getConfig();

$schedule = getSchedule();

?><!doctype html>
<html lang="<?php echo $config['lang']; ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Dashboard | Pi Alarm</title>
		
		<link rel="stylesheet" href="/assets/css/settings.css">
		
		<link href="/assets/img/app_icons/favicon.png" rel="shortcut icon" />
		<link href="/assets/img/app_icons/icon-57.png" rel="apple-touch-icon" />
		<link href="/assets/img/app_icons/icon-76.png" rel="apple-touch-icon" sizes="76x76" />
		<link href="/assets/img/app_icons/icon-120.png" rel="apple-touch-icon" sizes="120x120" />
		<link href="/assets/img/app_icons/icon-152.png" rel="apple-touch-icon" sizes="152x152" />
		<link href="/assets/img/app_icons/icon-180.png" rel="apple-touch-icon" sizes="180x180" />
		<link href="/assets/img/app_icons/icon-192.png" rel="icon" sizes="192x192" />
		<link href="/assets/img/app_icons/icon-128.png" rel="icon" sizes="128x128" />
	</head>
	
	<body>
		<p><a href="#alarm_on" class="button btn_action">ALARM ON</a></p>
		<p><a href="#alarm_off" class="button btn_action">ALARM OFF</a></p>
		
		<hr>
		
		<p>Scheduled hour</p>
		<p><input type="number" size="2" class="schedule_hour input_hour" value="<?php echo $schedule['start_hour']; ?>">:<input type="number" size="2" class="schedule_minute input_minute" value="<?php echo str_pad($schedule['start_minute'], 2, '0'); ?>"></p>
		
		<p>Stays on for</p>
		<p><input type="number" size="2" class="duration_hour input_hour" value="<?php echo $schedule['duration_hour']; ?>">:<input type="number" size="2" class="duration_minute input_minute" value="<?php echo str_pad($schedule['duration_minute'], 2, '0', STR_PAD_LEFT); ?>"></p>
		
		<p><a href="#" class="button btn_alarm_set_schedule">SAVE</a></p>
		
		<hr>
		
		<p><a href="settings.php" class="button">SETTINGS</a></p>
		<p><a href="#update_app" class="button btn_action">UPDATE</a></p>
		
		<div id="loading"><img src="/assets/img/loading.gif"></div>
		
		<script src="/assets/js/jquery-3.1.1.min.js"></script>
		<script src="/assets/js/settings.js"></script>
	</body>
</html>