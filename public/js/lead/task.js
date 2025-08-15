$('#toggleFormBtn').on('click', function () {
    $('#dropdownForm').toggle();
});
  
function checkExportForm()
{
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	
	if(from_date!='' && to_date !='' ){
		$('#dateRangeModal').modal('hide');
	}
}  

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
	
	let tableJGTaskMain = $('#jsGridTasksMain').DataTable({
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
				d.search_task = $('#search_tasks').val();
				if(window.shouldFilter) {
					d.task_type = $('#filter_tasks_type').val();
					d.task_category = $('#filter_tasks_category').val();
					d.task_assigned_to = $('#filter_tasks_assignto').val();
					d.task_assigned_by = $('#filter_assigned_by').val();
					//d.task_status = $('#filter_status').val();
					var filter_status = [];
					$('.filter_status:checked').each(function() {
						filter_status.push($(this).val());
					});
					d.task_status = filter_status;
					d.task_date_range = $('#filter_date_range').val();
				}
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'due_date', name: 'due_date' },
			{ data: 'subject', name: 'subject' },
			{ data: 'task_type', name: 'task_type' },
			{ data: 'task_category', name: 'task_category' },
			{ data: 'assigned_by', name: 'assigned_by' },
			{ data: 'assigned_to', name: 'assigned_to' },
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
	
	$('#search_tasks').on('keyup', function() {
		tableJGTaskMain.draw();
	});

	$('#filterApplyBtn').on('click', function() {
		window.shouldFilter = true;
		tableJGTaskMain.ajax.reload();
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
						let tablejst = $('#jsGridTasksMain').DataTable();
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
	
});	