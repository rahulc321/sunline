function createEditNotesModal(mod_type)
{
	if(mod_type=='edit') {
		$('#notes_form_type').val('edit');
		$('#headingNotesForm').html('Edit Note');
		$('#btnSubmitUpdateNotes').html('Update');
	}
	else {
		$('#pop_notes_id').val('');
		$('#notes_form_type').val('create');
		$('#headingNotesForm').html('Add Note');
		$('#btnSubmitUpdateNotes').html('Submit');
	}
	$('#createEditNotesModal').modal('show');
}

$(document).ready(function () {
	const $notesFormType = $('#notes_form_type');
	
	$('#search_notes').on('keyup', function() {
		initDataTableOnce('#jsGridNotes');
	});	
	
	$('#notes_category').on('change', function() {
		initDataTableOnce('#jsGridNotes');
	});

	$('#createEditNotesForm').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		
		const isValid = validateInputs('createEditNotesForm');
		if (!isValid) return;	
		
		if(isValid) {
			let page_section = $('#page_section').val();
			let category_id = $('#pop_notes_category').val();
			let notes = $('#notes').val();
			
			const form = document.getElementById('createEditNotesForm');
			const formData = new FormData(form);
			formData.append('lead_id', lead_id);
			formData.append('category_id', category_id);
			if (typeof page_section !== 'undefined' && page_section !== null && page_section !== '') {
					formData.append('page_section', page_section);
			}
			formData.append('notes_id', formData.get('pop_notes_id'));
		    formData.delete('pop_notes_id');
		
		
			
			let notesFrmAction;
			if($notesFormType.val() == 'edit') {
				notesFrmAction = route.admin.notes_update;
			}
			else {
				notesFrmAction = route.admin.lead_notes_add;
			}
			
			$.ajax({
				url: notesFrmAction ?? null,
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
						$('#createEditNotesForm')[0].reset();
						$('#createEditNotesModal').modal('hide');
						initDataTableOnce('#jsGridNotes');
						if($notesFormType.val() == 'edit') {
							Swal.fire("Updated!", response.message, "success");
						}
						else {
							Swal.fire("Created!", response.message, "success");
						}
					}
					else if(response.status=='validation_error')
					{
						errors = response.errors;
						if(errors.notes_attachment){
							$('#notes_attachment').after('<div class="error-message text-danger">'+text(errors.notes_attachment[0])+'</div>');
						}
					}
				},
				error: function(xhr) {
					if(xhr.status === 422) {
						errors = xhr.responseJSON.errors;
						if(errors.notes_attachment){
							$('#notes_attachment').after('<div class="error-message text-danger">'+text(errors.notes_attachment[0])+'</div>');
						}
					}
					else {
						console.error('Error: ', xhr.responseText);
					}				
				}
			});
		}
	});

	$('#btnPrintNotes').on('click', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#printNotesData [data-required="true"]');
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
			let formData = {
				type: 'notes',
				id: lead_id,
				print_existing_data: '1',
				print_format: 'pdf',
				_token: $('meta[name="csrf-token"]').attr('content')
			}
			
			$.ajax({
				url:route.admin.lead_print_data ?? null,
				type:'POST',
				data: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status == 'success')
					{
						if(response.type == 'pdf')
						{
							$('#popupCardPrintNotes').modal('hide');
							
							const link = document.createElement('a');
							link.href = 'data:application/pdf;base64,'+response.pdf;
							link.download = response.filename;
							link.click();
						}
					}
					else if(response.status == 'error')
					{
						$('#popupCardPrintNotes').modal('hide');
						Swal.fire("Print to PDF", response.message, "error");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
	$(document).on('click', '.editPopupNotesBtn', function () {
		$('.error-message').remove();
		let notes_id = $(this).data('id');
		$('#pop_notes_id').val(notes_id);
		
		$.ajax({
			url:route.admin.notesDetails ?? null,
			type:'POST',
			data: {
				'id':notes_id,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					$('#pop_notes_id').val(notes_id);
					$('#pop_notes_category').val(response.data.category_id);
					$('#notes').val(response.data.notes);
					
					$('#pop_notes_category').trigger('change.select2');
					
					createEditNotesModal('edit');					
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});
	
	$(document).on('click', '.addEditNotesPinBtn', function () {
		$('.error-message').remove();
		let notes_id = $(this).data('id');
		
		$.ajax({
			url:route.admin.lead_notes_update_pinned_status ?? null,
			type:'POST',
			data: {
				'notes_id':notes_id,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					Swal.fire("Updated!", response.message, "success");					
				}
				else {
					Swal.fire("Error!", response.message, "error");
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});

});