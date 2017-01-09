<script src= "http://player.twitch.tv/js/embed/v1.js"></script>

<div><!-- Wrapping div for width 100% -->
	<div id="twitch_vid"></div>
</div>

<script type="text/javascript">
	var w = $('#module_<?php echo $this->module_name; ?>').width();
	var h = $('#module_<?php echo $this->module_name; ?>').height();
	
	var options = {
		width: w,
		height: h,
		channel: "<?php echo $streams->streams[0]->channel->name; ?>"
	};
	
	
	var player = new Twitch.Player("twitch_vid", options);
	player.setVolume(0.5);
	player.play();
	
</script>