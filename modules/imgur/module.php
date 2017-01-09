<?php

class Module_imgur extends Module
{
	function render()
	{
		$limit = 10;
		$count = 0;

		$c = curl_init();

		curl_setopt($c, CURLOPT_URL, 'https://api.imgur.com/3/gallery/hot/viral/0/images.json');
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $this->config['client_id']));

		$feed = curl_exec($c);

		curl_close($c);

		$feed = json_decode($feed);
		
		include(__DIR__ . '/view.php');

	}
}