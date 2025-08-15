$(document).ready(function () {
	$('#uploadDocument').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#uploadDocument [data-required="true"]');
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
			let page_section = $('#page_section').val();
			let docFolderSelectVal = $('#pop_document_folder').val();
			let docFolderSelectedOption = $('#pop_document_folder').find('option[value="'+docFolderSelectVal+'"]');
			let formData = new FormData(this);
			if (typeof page_section !== 'undefined' && page_section !== null && page_section !== '') {
				formData.append('page_section', page_section);
			}
			if (typeof lead_id !== 'undefined' && lead_id !== null && lead_id !== '') {
				formData.append('lead_id', lead_id);
			}
			else {
				formData.append('lead_id', $('#upload_lead_id').val());
			}
			formData.append('document_category_id', $('#pop_document_category').val());
			if(docFolderSelectVal==="0") { 
				//formData.append('document_folder', docFolderSelectedOption.data('folder_name'));
				formData.append('document_folder', $('#pop_document_folder').val());
			} else {
				formData.append('document_folder', $('#pop_document_folder').val());
			}
			formData.append('document_description', $('#pop_document_description').val());
			$.ajax({
			url:route.admin.lead_document_upload,
				type:'POST',
				data: formData,
				contentType: false,  // Important!
				processData: false,  // Important!
				cache: false,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status=='success')
					{
						$('#popupLeadDocumentUpload').modal('hide');
						let tableJSDocUPL = $('#jsGridDocuments').DataTable();
						tableJSDocUPL.draw();
						Swal.fire("Created!", response.message, "success");
					}
					else if(response.status=='validation_error')
					{
						errors = response.errors;
						if(errors.document_file){
							$('#document_file').after('<div class="error-message text-danger">' + errors.document_file[0] + '</div>');
						}
						if(errors.document_category_id){
							$('#pop_document_category').after('<div class="error-message text-danger">' + errors.document_category_id[0] + '</div>');
						}
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
});