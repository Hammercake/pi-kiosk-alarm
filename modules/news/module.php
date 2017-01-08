<?php

class Module_news extends Module
{
	function render()
	{
		$c = curl_init();

		curl_setopt($c, CURLOPT_URL, 'https://newsapi.org/v1/articles?source=google-news&apiKey=' . $this->config['api_key']);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

		$feed = curl_exec($c);

		curl_close($c);

		$news_feed = json_decode($feed);
		
		include(__DIR__ . '/view.php');
	}
}
