<p class="time"></p>
<p class="date"><?php echo $this->date; ?></p>

<script>
function updateTime()
{
	var date = new Date();
	
	var html = date.getHours() + '.' + ('0'+date.getMinutes()).slice(-2);
	
	$('.time', '#module_<?php echo $this->module_index; ?>').html(html);
	
	setTimeout(updateTime, 60000);
}
updateTime();
</script>