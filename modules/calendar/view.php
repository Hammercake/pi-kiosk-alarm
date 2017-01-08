<h2><?php echo $this->lang('today'); ?></h2>
<?php 
if (count($results->getItems()) == 0) {
	echo '<p>' . $this->lang('no_event') . '</p>';
} else {
?>
<table border="0">
<?php
	foreach ($results->getItems() as $event) {
?>
		<tr class="event">
			<td class="time">
				<?php
				// Some events don't have a time, only a date (all-day events)
				if (isset($event['modelData']['start']['dateTime'])) {
					echo date('G:i', strtotime($event['modelData']['start']['dateTime']));
				}
				?>
			</td>
			<td><?php echo $event['summary']; ?></td>
		</tr>
		
		<?php if ($event['location']) { ?>
		<tr>
			<td colspan="2"><?php echo $event['location']; ?></td>
		</tr>
		<?php } ?>
		
		<?php if ($event['description']) { ?>
		<tr>
			<td colspan="2"><?php echo $event['description']; ?></td>
		</tr>
		<?php } ?>
		
<?php
		/* 
		public 'colorId' => null
		public 'summary' => string 'Possible GBTN' (length=13)
		public 'description' => null
		public 'kind' => string 'calendar#event' (length=14)
		public 'location' => null
		modelData -> start ->'dateTime'
		modelData -> end ->'dateTime'
		*/
	}
}
?>
</table>