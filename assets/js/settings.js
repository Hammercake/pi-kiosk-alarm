$(function() {
	
	$('.btn_alarm_on').click(click_alarm_on);
	$('.btn_alarm_off').click(click_alarm_off);
	$('.btn_alarm_set_schedule').click(click_alarm_set_schedule);
	
	function click_alarm_on(e)
	{
		console.log('h');
		
		e.preventDefault();
		
		post_action('alarm_on');
	}
	
	function click_alarm_off(e)
	{
		e.preventDefault();
		
		post_action('alarm_off');
	}
	
	function click_alarm_off(e)
	{
		e.preventDefault();
		
		post_action('alarm_off');
	}
	
	function click_alarm_set_schedule(e)
	{
		e.preventDefault();
		
		var data = {
			'start_hour': $('input.schedule_hour').val(),
			'start_minute': $('input.schedule_minute').val(),
			'duration_hour': $('input.duration_hour').val(),
			'duration_minute': $('input.duration_minute').val()
		}
		
		post_action('alarm_set_schedule', data);
	}
	
	function post_action(action, data)
	{
		// Show loading
		$('#loading').show();
		
		if (typeof data == 'undefined') {
			data = {};
		}
		
		data['a'] = action;
		
		$.ajax({
			data: data,
			method: 'GET',
			url: '/action.php',
			complete: function(a) {
				// Hide loading
				$('#loading').hide();
			}
		});
	}
	
});