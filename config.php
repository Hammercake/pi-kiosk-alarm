<?php
return array(
	// Language to use. Loads language files in module according to this var.
	'lang' => 'en',
	
	/*
	Modules to be displayed on the dashboard
	Priority loading by array order
	name - Exact folder name of the module located in /modules
	active - To show or not to show
	pos_l - Offset left, percentage: "2%"
	pos_t - Offset top, percentage: "52%"
	size_w - Width, percentage: "20%"
	size_h - Height, percentage: "20%"
	use_box - Use the default wrapping box?
	*/
	'modules' => array(
		'module_0' => array(
			'name' => 'random_bg',
			'active' => true,
			'pos_l' => '0',
			'pos_t' => '0',
			'size_w' => '0',
			'size_h' => '0',
			'use_box' => false
		),
		
		'module_1' => array(
			'name' => 'datetime',
			'active' => true,
			'pos_l' => '35%',
			'pos_t' => '1%',
			'size_w' => '32%',
			'size_h' => '25%',
			'use_box' => true
		),
		
		'module_2' => array(
			'name' => 'drive_to_work',
			'active' => false,
			'pos_l' => '1%',
			'pos_t' => '1%',
			'size_w' => '33%',
			'size_h' => '51%',
			'use_box' => true
		),
		
		'module_3' => array(
			'name' => 'calendar',
			'active' => true,
			'pos_l' => '1%',
			'pos_t' => '1%',
			'size_w' => '33%',
			'size_h' => '51%',
			'use_box' => true
		),
		
		'module_4' => array(
			'name' => 'forecast',
			'active' => true,
			'pos_l' => '68%',
			'pos_t' => '1%',
			'size_w' => '31%',
			'size_h' => '25%',
			'use_box' => true,
		),
		
		'module_5' => array(
			'name' => 'news',
			'active' => true,
			'pos_l' => '1%',
			'pos_t' => '53%',
			'size_w' => '98%',
			'size_h' => '46%',
			'use_box' => true
		),
		
		'module_6' => array(
			'name' => 'quote',
			'active' => true,
			'pos_l' => '35%',
			'pos_t' => '27%',
			'size_w' => '64%',
			'size_h' => '25%',
			'use_box' => true
		),
		
		'module_7' => array(
			'name' => 'imgur',
			'active' => false,
			'pos_l' => '1%',
			'pos_t' => '50%',
			'size_w' => '33%',
			'size_h' => '49%',
			'use_box' => true
		),
		
		'module_8' => array(
			'name' => 'twitch',
			'active' => false,
			'pos_l' => '38%',
			'pos_t' => '22%',
			'size_w' => '50%',
			'size_h' => '30%',
			'use_box' => false
		),
		
		'module_9' => array(
			'name' => 'speech',
			'active' => true,
			'pos_l' => '0',
			'pos_t' => '0',
			'size_w' => '0',
			'size_h' => '0',
			'use_box' => false
		),
	)
);