$(document).ready(function () {	
	let tableJGActivity = $('#jsGridActivity').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_activity_list,
			data: function (d) {
				d.search_activity = $('#search_activity').val();
				if(window.shouldFilter) {
					d.type = $('#filter_type').val();
					d.case_type = $('#filter_case_type').val();
					d.status = $('#filter_status').val();
					d.date_range = $('#filter_date_range').val();
					var filter_activity_type = [];
					$('.filter_activity_type:checked').each(function() {
						filter_activity_type.push($(this).val());
					});
					d.activity_type = filter_activity_type;
				}
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'completed_on', name: 'completed_on' },
			{ data: 'lead_id', name: 'lead_id' },
			{ data: 'case_type', name: 'case_type' },
			{ data: 'client', name: 'client' },
			{ data: 'user_name', name: 'user_name' },
			{ data: 'description', name: 'description' },
		],
		"lengthMenu": [
			[10, 25, 50, 100, -1],
			[10, 25, 50, 100, "All"] // change per page values here
		],
		// set the initial value
		"pageLength": 100,
		"sPaginationType": "full_numbers",
		"columnDefs": [
		],
		"fnInitComplete": function () {
			$(".dataTables_length").addClass("hidden-xs");
			$(this).removeClass("hidden");
		},
		"order": [
		]
	});
	
	$('#search_activity').on('keyup', function() {
		tableJGActivity.draw();
	});

	$('#filterApplyBtn').on('click', function() {
		window.shouldFilter = true;
		tableJGActivity.ajax.reload();
	});
	
});	