$(function() {
	
	$('.btn_action').click(click_action);
	$('.btn_alarm_set_schedule').click(click_alarm_set_schedule);
	
	function click_action(e)
	{
		var action;
		
		e.preventDefault();
		
		action = $(this).attr('href');
		
		action = action.substring(1);
		
		post_action(action);
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