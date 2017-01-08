<?php

class Module_quote extends Module
{
	function render()
	{
		$c = curl_init();

		curl_setopt($c, CURLOPT_URL, 'http://api.forismatic.com/api/1.0/?method=getQuote&format=json&lang=en');
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

		$quote = curl_exec($c);

		curl_close($c);

		$quote = json_decode($quote);

		if ( $quote ) {
			include(__DIR__ . '/view.php');
		}
	}
}
