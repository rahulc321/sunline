$(document).ready(function () {
	$('#createEditTaskModal').on('shown.bs.modal', function () {
		$('#client_id').select2({
			dropdownParent: $('#createEditTaskModal'),
			placeholder: 'Select',
			ajax: {
				url: route.admin.intakes_select2,
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return { q: params.term };
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			},
			minimumInputLength: 1
		});
	});
	
	$('#createEditTaskForm').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#createEditTaskForm [data-required="true"]');
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
			formData.append('lead_id', $('#client_id').val());
			formData.append('category_id', $('#pop_tasks_category').val());
			formData.append('type_id', $('#pop_tasks_type').val());
			formData.append('subject', $('#pop_tasks_subject').val());
			formData.append('assigned_to', $('#pop_tasks_assignto').val());
			formData.append('due_date', $('#pop_tasks_duedate').val());
			formData.append('priority', $('#pop_tasks_priority').val());
			formData.append('activity', $('#pop_tasks_act_utbms').val());
			formData.append('billable_to_client', $('#pop_tasks_bill_client').val());
			formData.append('notify_assignee', $('#pop_tasks_notify').val());
			formData.append('add_calander_event', $('#pop_tasks_add_cal_event').val());
			formData.append('appointment_reminder', $('#pop_tasks_ap_remind').val());
			formData.append('description', $('#pop_tasks_description').val());
			
			$.ajax({
			url:route.admin.lead_tasks_add,
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
						$('#createEditTaskModal').modal('hide');
						let tablejst = $('#jsGridTasksAgenda').DataTable();
						tablejst.draw();
						Swal.fire("Created!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	let tablejgtsAgenda = $('#jsGridTasksAgenda').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_tasks_list,
			data: function (d) {
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'due_date', name: 'due_date' },
			{ data: 'subject', name: 'subject' },
			{ data: 'task_type', name: 'task_type' },
			{ data: 'task_category', name: 'task_category' },
			{ data: 'assigned_to', name: 'assigned_to' },
			{ data: 'assigned_by', name: 'assigned_by' },
			{ data: 'assigned_date', name: 'assigned_date' },
			{ data: 'status', name: 'status' },
			{ data: 'priority', name: 'priority' },
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
	
	let tablejgesAgenda = $('#jsGridEventsAgenda').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_events_list,
			data: function (d) {
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'date_time', name: 'date_time' },
			{ data: 'title', name: 'title' },
			{ data: 'type', name: 'type' },
			{ data: 'location', name: 'location' },
			{ data: 'owner', name: 'owner' },
			{ data: 'status', name: 'status' },
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
	
	$('#popupCardAddEvent').on('shown.bs.modal', function () {
		$('#lead_case_id').select2({
			dropdownParent: $('#popupCardAddEvent'),
			placeholder: 'Select',
			ajax: {
				url: route.admin.intakes_select2,
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return { q: params.term };
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			},
			minimumInputLength: 1
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
			formData.append('lead_id', $('#lead_case_id').val());
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
						let tablejst = $('#jsGridEvents').DataTable();
						tablejst.draw();
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
});	