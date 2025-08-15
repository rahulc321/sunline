$(document).ready(function () {
	let tblCalenEventType = $('#jsGridCalendarEventTypeList').DataTable({
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
	
	let tblCalenEventTypeRuleList = $('#jsGridCalendarEventTypeRuleList').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_event_type_rule_list,
			data: function (d) {
				
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'event_type', name: 'event_type' },
			{ data: 'status_change', name: 'status_change' },
			{ data: 'appointment_reminders', name: 'appointment_reminders' },
			{ data: 'action', name: 'action' },
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
	
	$('#addCalenEventsType').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		const inputs = document.querySelectorAll('#addCalenEventsType [data-required="true"]');
		let errors = [];
		
		inputs.forEach(input => {
			if(!input.value.trim()) {
				isValid=false;
				let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
				cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
				$('#error_'+input.id).html(`The ${cleanName} field is required.`);
			}
		});		
		
		if(isValid) {
			let formData = new FormData(this);
					
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
						$('#event_type_name').val('');
						$('#event_type_color').val('');
						
						let htmlOptions='<option value="">Select</option>';
						response.data.forEach(function(item) {								
							htmlOptions=htmlOptions + '<option value="'+item.id+'">'+item.title+'</option>';
						});
						$('#etr_event_type').html(htmlOptions);
						
						$('#event_type_color').trigger('change.select2');
						
						let jGCalendarEventTypeList = $('#jsGridCalendarEventTypeList').DataTable();
						jGCalendarEventTypeList.draw();
						
						Swal.fire("Created!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$('#appointlet_switch').on('change', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		if(isValid) {
			let appointlet_switch = document.querySelector('input[name="appointlet_switch"]:checked').value;
			let formData = {
				type: 'appointlet_switch',
				appointlet_switch: appointlet_switch,
				_token: $('meta[name="csrf-token"]').attr('content')
			}
					
			$.ajax({
			url:route.admin.appointment_settings_save,
				type:'POST',
				data: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status=='success')
					{
						Swal.fire("Success!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$('#saveAppointmentReminderSettingsForm').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		const inputs = document.querySelectorAll('#saveAppointmentReminderSettingsForm [data-required="true"]');
		let errors = [];
		
		inputs.forEach(input => {
			if(!input.value.trim()) {
				isValid=false;
				let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
				cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
				$('#error_'+input.id).html(`The ${cleanName} field is required.`);
			}
		});		
		
		if(isValid) {
			let formData = new FormData(this);
			formData.append('type', 'appointment_reminder');
			
			$.ajax({
			url:route.admin.appointment_settings_save,
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
						Swal.fire("Created!", response.message, "success");
					}
					else if(response.status=='error')
					{
						Swal.fire("Error!", response.message, "error");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$('#saveAppointmentCancellationSettingsForm').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		const inputs = document.querySelectorAll('#saveAppointmentCancellationSettingsForm [data-required="true"]');
		let errors = [];
		
		inputs.forEach(input => {
			if(!input.value.trim()) {
				isValid=false;
				let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
				cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
				$('#error_'+input.id).html(`The ${cleanName} field is required.`);
			}
		});		
		
		if(isValid) {
			let formData = new FormData(this);
			formData.append('type', 'appointment_cancellation');
			
			$.ajax({
			url:route.admin.appointment_settings_save,
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
						Swal.fire("Created!", response.message, "success");
					}
					else if(response.status=='error')
					{
						Swal.fire("Error!", response.message, "error");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$('#cancellation_change_status').on('change', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		if(isValid) {
			let cancellation_change_status = document.querySelector('input[name="cancellation_change_status"]:checked').value;
			let formData = {
				type: 'cancellation_change_status',
				cancellation_change_status: cancellation_change_status,
				_token: $('meta[name="csrf-token"]').attr('content')
			}
					
			$.ajax({
			url:route.admin.appointment_settings_save,
				type:'POST',
				data: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status=='success')
					{
						Swal.fire("Success!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$('#calenEventTypeRuleForm').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		const inputs = document.querySelectorAll('#calenEventTypeRuleForm [data-required="true"]');
		let errors = [];
		
		inputs.forEach(input => {
			if(!input.value.trim()) {
				isValid=false;
				let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
				cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
				$('#error_'+input.id).html(`This field is required.`);
			}
		});		
		
		if(isValid) {
			let formData = new FormData(this);
					
			$.ajax({
			url:route.admin.lead_event_type_rule_add,
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
						$('#etr_event_type').val('');
						$('#etr_lead_status').val('');
						$('#etr_appointment_reminder').prop('checked', false);
						
						let jGCalendarEventTypeRuleList = $('#jsGridCalendarEventTypeRuleList').DataTable();
						jGCalendarEventTypeRuleList.draw();
						
						$('#etr_event_type').trigger('change.select2');
					    $('#etr_lead_status').trigger('change.select2');
						
						$('#calenEventTypeRule').modal('hide');						
						
						Swal.fire("Created!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$(document).on('click', '.editEventTypeRuleBtn', function () {
		let rule_id = $(this).data('id');
		
		$.ajax({
			url:route.admin.lead_event_type_rule_details,
			type:'POST',
			data: {
				'event_type_rule_id':rule_id,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					$('#event_type_rule_id').val(response.data.id);		
					$('#etre_event_type').val(response.data.event_type_id);		
					$('#etre_lead_status').val(response.data.lead_status_id);		
					if (response.data.appointment_reminders == 1) {
						$('#etre_appointment_reminder').prop('checked', true);
					} else {
						$('#etre_appointment_reminder').prop('checked', false);
					}
					
					$('#etre_event_type').trigger('change.select2');
					$('#etre_lead_status').trigger('change.select2');
					
					$('#calenEventTypeRuleEdit').modal('show');					
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});
	
	$('#calenEventTypeRuleFormEdit').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		const inputs = document.querySelectorAll('#calenEventTypeRuleFormEdit [data-required="true"]');
		let errors = [];
		
		inputs.forEach(input => {
			if(!input.value.trim()) {
				isValid=false;
				let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
				cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
				$('#error_'+input.id).html(`This field is required.`);
			}
		});		
		
		if(isValid) {
			let formData = new FormData(this);
					
			$.ajax({
			url:route.admin.lead_event_type_rule_update,
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
						let jGCalendarEventTypeRuleList2 = $('#jsGridCalendarEventTypeRuleList').DataTable();
						jGCalendarEventTypeRuleList2.draw();
						
						$('#calenEventTypeRuleEdit').modal('hide');
						
						Swal.fire("Updated!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$(document).on('click', '.etr-delete-btn', function () {
		let dataId = $(this).data('id');
		
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, delete it!"
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: route.admin.lead_event_type_rule_delete,
					type: "DELETE",
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					data: {
						id: dataId
					},
					success: function (response) {
						Swal.fire("Deleted!", response.message, "success");
						$('#jsGridCalendarEventTypeRuleList').DataTable().ajax.reload();
					},
					error: function (xhr) {
						Swal.fire("Error!", "Something went wrong.", "error");
					}
				});
			}
		});
	});
	
});
