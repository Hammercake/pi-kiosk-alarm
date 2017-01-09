<?php

require_once('lib/system.php');
require_once('lib/module.php');

if ( ! isset( $_GET['module_index'] ) ) {
	header('Location: settings.php');
}

$config = getConfig();

$module_index = $_GET['module_index'];

$module = initModule($module_index);

if ( ! empty($_POST) ) {
	// Save stuff!
	$data = array();
	
	foreach ($module->config as $index => $default_value) {
		$data[$index] = $_POST[$index];
	}
	saveSettings($data, $module_index);
	
	// Relocate to avoid sending again POST data when going back
	header('Location: settings.php');
}

?><!doctype html>
<html lang="<?php echo $config['lang']; ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Settings for <?php echo beautify($module->module_name); ?> | Pi Alarm</title>
		
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
		<form action="" method="POST" id="settings_form">
			
			<p><a href="#" class="button btn_save">SAVE</a> <a href="settings.php" class="button">BACK</a></p>
			
			<hr>
			
			<table border="0">
				<?php foreach ($module->config as $index => $value) { ?>
				<tr>
					<td><?php echo beautify($index); ?></td>
					<td><input type="text" name="<?php echo $index; ?>" value="<?php echo $value; ?>"></td>
				</tr>
				<?php } ?>
			</table>
			
			<hr>
			
			<p><a href="#" class="button btn_save">SAVE</a> <a href="settings.php" class="button">BACK</a></p>
			
		</form>
		
		<script src="/assets/js/jquery-3.1.1.min.js"></script>
		<script>
		$(function() {
			$('.btn_save').click(function(e) {
				e.preventDefault();
				$('#settings_form').submit();
			});
		});
		</script>
	</body>
</html>