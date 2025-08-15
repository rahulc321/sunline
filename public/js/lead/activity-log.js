$(document).ready(function () {
	$('#search_activity').on('keyup', function() {
		initDataTableOnce('#jsGridActivityLogs');
	});	
	
	$('#activity_category').on('change', function() {
		initDataTableOnce('#jsGridActivityLogs');
	});
	
	$('#module').on('change', function() {
		initDataTableOnce('#jsGridActivityLogs');
	});	
});