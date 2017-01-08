<?php

class Module_calendar extends Module
{
	function render()
	{
		if ( ! is_callable('Google_Client') ) {
			require_once($this->getModuleDir() . '/google-api/vendor/autoload.php');
		}

		$this->client = new Google_Client();
		$this->client->setApplicationName('Pi');
		$this->client->addScope('https://www.googleapis.com/auth/calendar.readonly');
		$this->client->setAuthConfig($this->getModuleDir() . '/google-api/service_key.json');

		date_default_timezone_set($this->config['timezone']);
		
		$service = new Google_Service_Calendar($this->client);

		// Print the next 10 events on the user's calendar.
		$calendarId = $this->config['calendar_id'];
		$optParams = array(
		  'maxResults' => 10,
		  'orderBy' => 'startTime',
		  'singleEvents' => TRUE,
		  'timeMin' => date('c', strtotime('today')),
		  'timeMax' => date('c', strtotime('tomorrow')),
		);
		$results = $service->events->listEvents($calendarId, $optParams);
		
		include(__DIR__ . '/view.php');
	}
}
