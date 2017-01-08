
<script src="/modules/forecast/skycons.js"></script>

<script>
	var skycons = new Skycons({
		color: 'white'
	});
</script>

<?php
foreach ($forecast_conditions as $condition) {
	?>
	
	<canvas id="icon-<?php echo $this->module_index; ?>-<?php echo $condition->getTime('G'); ?>" class="weather_icon" width="64" height="64"></canvas>
	<p class="temperature"><?php echo round(floatval($condition->getTemperature())); ?>&deg;</p>
	
	<?php if ($condition->getTemperature() != $condition->getApparentTemperature()) { ?>
	<p class="temperature_apparent"><?php echo $this->lang('feels_like'); ?> <?php echo round(floatval($condition->getApparentTemperature())); ?>&deg;</p>
	<?php } ?>
	
	<?php if ($condition->getPrecipitationType()) { ?>
	<p class="precipitation"><?php
		echo $condition->getPrecipitationIntensity() .
			' (' . round(floatval($condition->getPrecipitationProbability()) * 100) . '%)';
	?></p>
	<?php } ?>
	
	<script>
		skycons.add("icon-<?php echo $this->module_index; ?>-<?php echo $condition->getTime('G'); ?>", "<?php echo $condition->getIcon(); ?>");
	</script>
	
	<?php
	break; // Only get one for now
}
?>

<script>
	// Resize to take about half of the width
	var node = document.getElementById('module_<?php echo $this->module_index; ?>');
	var w = node.clientWidth;
	var h = node.clientHeight;
	var computedSize = getComputedStyle(node);
	w -= parseFloat(computedSize.paddingLeft) + parseFloat(computedSize.paddingRight);
	h -= parseFloat(computedSize.paddingTop) + parseFloat(computedSize.paddingBottom);
	
	w /= 2;
	
	var size = Math.min(w, h);
	
	var icons = document.getElementsByClassName('weather_icon');
	
	var i;
	
	for (i = 0; i < icons.length; i++) {
		icons[i].setAttribute('width', size);
		icons[i].setAttribute('height', size);
	}
	
	skycons.play();
</script>