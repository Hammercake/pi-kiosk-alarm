$(function() {
	
	// Load modules one at a time through AJAX requests
	
	if ( typeof MODULES != 'object' || MODULES.length == 0 ) {
		console.log('No module to load.');
		return;
	}
	
	loadModule();
	
	function loadModule()
	{
		var module_index;
		
		for (module_index in MODULES) {
			var module_name = MODULES[module_index];
			
			$.ajax({
				url: '/action.php?a=load_module&module_index=' + module_index,
				method: 'GET',
				success: function(html) {
					$('#module_' + module_index).html( html );
				},
				error: function() {
					console.log('Failed to load module: ' + module_name);
				},
				complete: function() {
					delete MODULES[module_index];
					loadModule();
				}
			});
		
			break; // Always only want the first iteration, next is called on ajax callback
		}
	}
	
});