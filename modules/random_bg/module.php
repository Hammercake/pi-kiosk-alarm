<?php

class Module_random_bg extends Module
{
	function render()
	{
		$dir = __DIR__ . '/backgrounds';
		
		$files = scandir($dir);

		$max = count($files) - 1;

		$rand = rand(2, $max); // Skip "." and ".."

		$background = $files[$rand];

		$background = '/modules/random_bg/backgrounds/' . $background;
		
		echo "<script>" .
			"	$('body').css('background-image', 'url(\"$background\")');" .
			"</script>";
	}
}
