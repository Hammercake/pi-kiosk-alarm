<?php

class Module_twitch extends Module
{
	function render()
	{
		// Get the first random stream they give us
		// Gotta register a developer application on Twitch and get a client_id

		$c = curl_init();

		curl_setopt($c, CURLOPT_URL, 'https://api.twitch.tv/kraken/streams?limit=1&client_id=' . $this->config['client_id']);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

		$streams = curl_exec($c);
		curl_close($c);
		$streams = json_decode($streams);
		
		include(__DIR__ . '/view.php');
	}
}

