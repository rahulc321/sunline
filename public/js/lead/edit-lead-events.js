$(document).ready(function () {
	$('#jsGridEvents').on('xhr.dt', function (e, settings, json, xhr) {
		$.ajax({
			url: route.admin.lead_events_count,
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				'lead_id':lead_id,
			},
			success: function (response) {
				if(response.status=='success')
				{
					$('#event_attended').val(response.data.attended);
					$('#event_attendance').val(response.data.attendance);
					$('#event_canceled').val(response.data.canceled);
					$('#event_rescheduled').val(response.data.rescheduled);
					$('#event_no_showed').val(response.data.no_showed);
				}
			}
		});
	});
	
	let tblEventType = $('#jsGridEventTypeList').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_event_type_list,
			data: function (d) {
				
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'event_type', name: 'event_type' },
			{ data: 'color', name: 'color' },
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
	
	$('#addEventType').on('click', function(e) {
		$.ajax({
		url:route.admin.lead_event_type_color_list,
			type:'POST',
			data: {
				
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					let htmlOptions='<option value="">Select</option>';
					response.data.forEach(function(item) {								
						htmlOptions=htmlOptions + '<option value="'+item.id+'">'+item.title+'</option>';
					});
					$('#event_type_color').html(htmlOptions);
					$('#popupCardEditEventType').modal('show');
					let tablejsevnttbl = $('#jsGridEventTypeList').DataTable();
					tablejsevnttbl.draw();
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});
});

$('#addEventsForm').on('submit', function(e) {
	e.preventDefault();
	$('.error-message').remove();
	let isValid=true;
	const inputs = document.querySelectorAll('#addEventsForm [data-required="true"]');
	let errors = [];
	
	inputs.forEach(input => {
		if(!input.value.trim()) {
			isValid=false;
			let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
			cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
			$('#'+input.id).after('<div class="error-message text-danger">'+`The ${cleanName} field is required.`+'</div>');
		}
	});		
	
	if(isValid) {
		let formData = new FormData(this);
		formData.append('lead_id', lead_id);
		formData.append('owner_id', $('#event_created_by').val());
		formData.append('assigned_to', $('#event_assigned_to').val());
		formData.append('address', $('#event_address').val());
		formData.append('description', $('#event_description').val());
		formData.append('event_status_id', $('#event_status').val());
		formData.append('event_type_id', $('#event_type').val());
				
		$.ajax({
		url:route.admin.lead_events_add,
			type:'POST',
			data: formData,
			contentType: false,
			processData: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					$('#popupCardAddEvent').modal('hide');
					initDataTableOnce('#jsGridEvents');
					Swal.fire("Created!", response.message, "success");
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	}
});

$('#editEventsType').on('submit', function(e) {
	e.preventDefault();
	$('.error-message').remove();
	let isValid=true;
	const inputs = document.querySelectorAll('#editEventsType [data-required="true"]');
	let errors = [];
	
	inputs.forEach(input => {
		if(!input.value.trim()) {
			isValid=false;
			let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
			cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
			$('#'+input.id).after('<div class="error-message text-danger">'+`The ${cleanName} field is required.`+'</div>');
		}
	});		
	
	if(isValid) {
		let formData = new FormData(this);
		//formData.append('event_type_name', $('#event_type_name').val());
		formData.append('event_type_color', $('#event_type_color').val());
				
		$.ajax({
		url:route.admin.lead_event_type_add,
			type:'POST',
			data: formData,
			contentType: false,
			processData: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					$('#popupCardEditEventType').modal('hide');
					
					let htmlOptions='<option value="">Select</option>';
					response.data.forEach(function(item) {								
						htmlOptions=htmlOptions + '<option value="'+item.id+'">'+item.title+'</option>';
					});
					$('#event_type').html(htmlOptions);
					
					let tablejsevnttbl2 = $('#jsGridEventTypeList').DataTable();
					tablejsevnttbl2.draw();
					Swal.fire("Created!", response.message, "success");
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	}
});