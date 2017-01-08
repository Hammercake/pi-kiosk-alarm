<?php

class Module_forecast extends Module
{
	function render()
	{
		// Forecast.io
		require_once(__DIR__ . '/forecast.io.php');

		$forecast = new ForecastIO($this->config['api_key']);

		$forecast_conditions = $forecast->getForecastToday($this->config['lat'], $this->config['lng']);
		
		include(__DIR__ . '/view.php');
	}
}
