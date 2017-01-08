<?php

// TODO - PORT TO NEW CLASS STRUCTURE

$client_id = '41dd97d382bc598';
$limit = 10;
$count = 0;

$c = curl_init();

curl_setopt($c, CURLOPT_URL, 'https://api.imgur.com/3/gallery/hot/viral/0/images.json');
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));

$feed = curl_exec($c);

curl_close($c);

$feed = json_decode($feed);

/*
	Client ID: 41dd97d382bc598
	Client secret: 7aafdfdbafd3b50e088e953ad35c476b403150aa
	https://api.imgur.com/3/gallery/hot/viral/0.json
		title
		description
		link
*/

?>

<?php
foreach ($feed->data as $entry) {
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