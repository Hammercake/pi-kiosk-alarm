<?php

/**
 * Twitch
 */
// Get the first random stream they give us
// Gotta register a developer application on Twitch and get a client_id
$client_id = 'ka34z3maju19pmnkpki7g51kpx27df';

$c = curl_init();

curl_setopt($c, CURLOPT_URL, 'https://api.twitch.tv/kraken/streams?limit=1&client_id=' . $client_id);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

$streams = curl_exec($c);
curl_close($c);
$streams = json_decode($streams);

?>

<script src= "http://player.twitch.tv/js/embed/v1.js"></script>

<div><!-- Wrapping div for width 100% -->
	<div id="twitch_vid"></div>
</div>

<script type="text/javascript">
	var w = $('#module_<?php echo $module_name; ?>').width();
	var h = $('#module_<?php echo $module_name; ?>').height();
	
	var options = {
		width: w,
		height: h,
		channel: "<?php echo $streams->streams[0]->channel->name; ?>"
	};
	
	
	var player = new Twitch.Player("twitch_vid", options);
	player.setVolume(0.5);
	player.play();
	
</script>