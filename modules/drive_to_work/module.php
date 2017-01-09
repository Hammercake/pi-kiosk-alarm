<?php

class Module_drive_to_work extends Module
{
	function render()
	{
		$origin = $this->config['origin'];
		$destination = $this->config['destination'];
		
		$url = "http://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&sensor=false";
		
		$json = json_decode(file_get_contents($url));
		
		$routes = $json->routes;
		
		foreach ($routes as $route) {
			echo '<p>' . $this->lang('road_to') . $route->legs[0]->end_address . '</p>';
			
			echo '<p>' . $route->legs[0]->duration->text . '</p>';
			// echo '<p>' . $route->legs[0]->duration->value . '</p>'; // VALUE IS INT, use for later i18n
			
			// This is always empty?
			foreach ($route->legs[0]->traffic_speed_entry as $traffic) {
				echo '<p>' . $traffic . '</p>';
			}
		}

	}
}
