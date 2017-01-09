<?php

require_once('lib/system.php');

$config = getConfig();

if ( ! empty($_POST) ) {
	// Save stuff!
	$data = array(
		'lang' => $_POST['lang'],
		'modules' => array(),
	);
	
	foreach ($config['modules'] as $module_index => $module) {
		$data['modules'][$module_index] = array(
			'active' => isset($_POST['active'][$module_index]) ? 1 : 0,
			'use_box' => isset($_POST['use_box'][$module_index]) ? 1 : 0,
			'pos_l' => $_POST['pos_l'][$module_index],
			'pos_t' => $_POST['pos_t'][$module_index],
			'size_w' => $_POST['size_w'][$module_index],
			'size_h' => $_POST['size_h'][$module_index],
		);
	}
	
	saveSettings($data, 'app');
	
	// Relocate to avoid sending again POST data when going back
	header('Location: settings.php');
}

?><!doctype html>
<html lang="<?php echo $config['lang']; ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Settings | Pi Alarm</title>
		
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
		<form action="settings.php" method="POST" id="settings_form">
			
			<p><a href="#" class="button btn_save">SAVE</a> <a href="index.php" class="button">BACK</a></p>
			
			<hr>
			
			<p>
				<label>Language
					<input type="text" name="lang" value="<?php echo $config['lang']; ?>">
				</label>
			</p>
			
			<?php foreach ($config['modules'] as $module_index => $module) { ?>
			<hr>
			<h3><?php echo beautify($config['modules'][$module_index]['name']); ?></h3>
			<p>
				<label>Active
					<input type="checkbox" name="active[<?php echo $module_index; ?>]" value="1" <?php if ($config['modules'][$module_index]['active']) echo 'checked'; ?>>
				</label>
			</p>
			<p>
				<label>Use bounding box
					<input type="checkbox" name="use_box[<?php echo $module_index; ?>]" value="1" <?php if ($config['modules'][$module_index]['use_box']) echo 'checked'; ?>>
				</label>
			</p>
			<p>
				<label>Position Left
					<input type="text" name="pos_l[<?php echo $module_index; ?>]" value="<?php echo $config['modules'][$module_index]['pos_l']; ?>">
				</label>
			</p>
			<p>
				<label>Position Top
					<input type="text" name="pos_t[<?php echo $module_index; ?>]" value="<?php echo $config['modules'][$module_index]['pos_t']; ?>">
				</label>
			</p>
			<p>
				<label>Size Width
					<input type="text" name="size_w[<?php echo $module_index; ?>]" value="<?php echo $config['modules'][$module_index]['size_w']; ?>">
				</label>
			</p>
			<p>
				<label>Size Height
					<input type="text" name="size_h[<?php echo $module_index; ?>]" value="<?php echo $config['modules'][$module_index]['size_h']; ?>">
				</label>
			</p>
			
			<p><a href="module_settings.php?module_index=<?php echo $module_index; ?>" class="button">MODULE SETTINGS</a></p>
			<?php } ?>
			
			<hr>
			
			<p><a href="#" class="button btn_save">SAVE</a> <a href="index.php" class="button">BACK</a></p>
			
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