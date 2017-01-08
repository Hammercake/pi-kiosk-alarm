<?php

require_once('lib/system.php');

$schedule = getSchedule();

?><!doctype html>
<html lang="<?php echo $config['lang']; ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Pi</title>
		
		<link rel="stylesheet" href="/assets/css/settings.css">
		
	</head>
	
	<body>
		<p><a href="#" class="button btn_alarm_on">ALARM ON</a></p>
		<p><a href="#" class="button btn_alarm_off">ALARM OFF</a></p>
		
		<hr>
		
		<p>Scheduled hour</p>
		<p><input type="number" size="2" class="schedule_hour input_hour" value="<?php echo $schedule['start_hour']; ?>">:<input type="number" size="2" class="schedule_minute input_minute" value="<?php echo str_pad($schedule['start_minute'], 2, '0'); ?>"></p>
		
		<p>Stays on for</p>
		<p><input type="number" size="2" class="duration_hour input_hour" value="<?php echo $schedule['duration_hour']; ?>">:<input type="number" size="2" class="duration_minute input_minute" value="<?php echo str_pad($schedule['duration_minute'], 2, '0', STR_PAD_LEFT); ?>"></p>
		
		<p><a href="#" class="button btn_alarm_set_schedule">SAVE</a></p>
		
		<div id="loading"><img src="/assets/img/loading.gif"></div>
		
		<script src="/assets/js/jquery-3.1.1.min.js"></script>
		<script src="/assets/js/settings.js"></script>
	</body>
</html>