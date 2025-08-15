function createEditTaskModal(mod_type)
{
	if(mod_type=='edit') {
		$('#task_form_type').val('edit');
		$('#headingTaskForm').html('Edit Task');
		$('#btnSubmitUpdateTask').html('Update');
	}
	else {
		$('#pop_task_id').val('');
		$('#task_form_type').val('create');
		$('#headingTaskForm').html('Add Task');
		$('#btnSubmitUpdateTask').html('Submit');
	}
	$('#createEditTaskModal').modal('show');
}

$(document).ready(function () {
	const $tasksFormType = $('#task_form_type');
	
	$('#search_tasks').on('keyup', function() {
		initDataTableOnce('#jsGridTasks');
	});	
	
	$('#tasks_category').on('change', function() {
		initDataTableOnce('#jsGridTasks');
	});
    
    $('#task_type').on('change', function() {
		initDataTableOnce('#jsGridTasks');
	});

	$('#createEditTaskForm').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		
		const isValid = validateInputs('createEditTaskForm');
		if (!isValid) return;	
		
		if(isValid) {
			let page_section = $('#page_section').val();
			
			const form = document.getElementById('createEditTaskForm');
			const formData = new FormData(form);
			formData.append('lead_id', lead_id);
			if (typeof page_section !== 'undefined' && page_section !== null && page_section !== '') {
					formData.append('page_section', page_section);
			}
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
			
			let tasksFrmAction;
			if($tasksFormType.val() == 'edit') {
				tasksFrmAction = null;
			}
			else {
				tasksFrmAction = route.admin.lead_tasks_add;
			}
			
			$.ajax({
				url: tasksFrmAction ?? null,
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
						$('#createEditTaskForm')[0].reset();
						$('#createEditTaskModal').modal('hide');
						initDataTableOnce('#jsGridTasks');
						if($tasksFormType.val() == 'edit') {
							Swal.fire("Updated!", response.message, "success");
						}
						else {
							Swal.fire("Created!", response.message, "success");
						}
					}
					else if(response.status=='validation_error')
					{
						errors = response.errors;
						
					}
				},
				error: function(xhr) {
					if(xhr.status === 422) {
						errors = xhr.responseJSON.errors;
						
					}
					else {
						console.error('Error: ', xhr.responseText);
					}				
				}
			});
		}
	});
});