function showCommTab(tabcont)
{
	$('.email-container').hide();
	$('.texts-container').hide();
	if(tabcont=='texts') {
		$('.texts-container').show();
		$('#jsGridCommunicationText').DataTable().ajax.reload();
	}
	else {
		$('.email-container').show();
	}
}

$(document).ready(function () {
	$('#search_communication_email').on('keyup', function() {
		initDataTableOnce('#jsGridCommunicationEmail');
	});	
	
	$('#refreshCommunucations').on('click', function() {
		initDataTableOnce('#jsGridCommunicationEmail');
		Swal.fire("Success", "Email Communications Refreshed", "success");
	});
	
	$('#btnPrintCommunications').on('click', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#printCommunicationsData [data-required="true"]');
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
				type: 'communications',
				id: lead_id,
				print_existing_data: '1',
				print_format: 'pdf',
				_token: $('meta[name="csrf-token"]').attr('content')
			}
			
			$.ajax({
			url:route.admin.lead_print_data,
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
							$('#popupCardPrintCommunications').modal('hide');
							
							const link = document.createElement('a');
							link.href = 'data:application/pdf;base64,'+response.pdf;
							link.download = response.filename;
							link.click();
						}
					}
					else if(response.status == 'error')
					{
						$('#popupCardPrintCommunications').modal('hide');
						Swal.fire("Print to PDF", response.message, "error");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
	
});