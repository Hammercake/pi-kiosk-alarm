<?php

require_once('lib/system.php');

$modules = getModulesNames();
$module_styles = getModulesStyles();

?><!doctype html>
<html lang="<?php echo $config['lang']; ?>">
	<head>
		<meta charset="utf-8">
		
		<title>Pi</title>
		
		<link rel="stylesheet" href="/assets/css/style.css">
		
		<?php foreach ($module_styles as $href) { ?>
		<link rel="stylesheet" href="<?php echo $href; ?>">
		<?php } ?>
		
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
		<div id="wrapper">
			<?php
			foreach ($modules as $module_index => $module_name) {
				
				echo '<div id="module_' . $module_index. '" class="module_' . $module_name . ' ';
				echo ($config['modules'][$module_index]['use_box']) ? 'box' : 'no_box';
				echo '" ';
				
				echo 'style="';
				echo 'left:' . $config['modules'][$module_index]['pos_l'] . '; ';
				echo 'top:' . $config['modules'][$module_index]['pos_t'] . '; ';
				echo 'width:' . $config['modules'][$module_index]['size_w'] . '; ';
				echo 'height:' . $config['modules'][$module_index]['size_h'] . '; ';
				echo '"><p class="box_loading"><img src="/assets/img/loading.gif"></p></div>';
				
			}
			?>
		</div>
		
		<script>
		MODULES = <?php echo json_encode($modules); ?>;
		</script>
		
		<script src="/assets/js/jquery-3.1.1.min.js"></script>
		<script src="/assets/js/module_loader.js"></script>
	</body>
</html>