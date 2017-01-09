<?php foreach ($feed->data as $entry) {
	if ($entry->is_album) {
		// Gotta work a hack, since when querying a gallery, Imgur doesn't
		// give us an image if it's an album.
		$src = 'http://i.imgur.com/' . $entry->cover . '.jpg';
	}
	else {
		$src = $entry->link;
	}
?>

<div class="imgur_entry">
	<h3><?php echo htmlspecialchars($entry->title); ?></h3>
	<img src="<?php echo $src; ?>">
	<!--<p><?php echo htmlspecialchars($entry->description); ?></p>-->
</div>

<?php
	
	$count++;
	
	if ($count >= $limit) {
		break;
	}
	
}
?>

<script>

// Show only one entry at a time!
$(function() {
	
	var delay = 20 * 1000;
	
	$('.imgur_entry', '#module_imgur').first().addClass('active');
	
	setTimeout(nextEntry, delay);
	
	function nextEntry()
	{
		var next = $('.imgur_entry.active', '#module_imgur').next('.imgur_entry');
		
		// Loop around
		if (next.length <= 0) {
			next = $('.imgur_entry', '#module_imgur').first();
		}
		
		$('.imgur_entry.active', '#module_imgur').removeClass('active');
		next.addClass('active');
		
		setTimeout(nextEntry, delay);
	}
	
});


</script>