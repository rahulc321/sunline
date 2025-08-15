$('#btnPrintForm').on('click', function(e) {
	e.preventDefault();
	$('.error-message').remove();
	let isValid=true;
	const inputs = document.querySelectorAll('#printFormData [data-required="true"]');
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
		let print_existing_data = document.querySelector('input[name="print_existing_data"]:checked').value;
		let print_format = document.querySelector('input[name="print_format"]:checked').value;
		let formData = {
			type: 'form',
			id: lead_id,
			print_existing_data: print_existing_data,
			print_format: print_format,
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
						$('#popupCardPrintForm').modal('hide');
						
						const link = document.createElement('a');
						link.href = 'data:application/pdf;base64,'+response.pdf;
						link.download = response.filename;
						link.click();
					}
				}
			}
		});
	}
});

$('#btnAddToPrintQueue').on('click', function(e) {
	e.preventDefault();
	$('.error-message').remove();
	let isValid=true;
	const inputs = document.querySelectorAll('#printFormData [data-required="true"]');
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
		let print_existing_data = document.querySelector('input[name="print_existing_data"]:checked').value;
		let print_format = document.querySelector('input[name="print_format"]:checked').value;
		let formData = {
			type: 'form',
			id: lead_id,
			print_existing_data: print_existing_data,
			print_format: print_format,
			is_queue: '1',
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
						$('#popupCardPrintForm').modal('hide');	
						const pdfWindow = window.open();
						pdfWindow.document.write(`<iframe width='100%' height='100%' src='${response.pdf}' ></iframe>`);
					}
				}
			}
		});
	}
});