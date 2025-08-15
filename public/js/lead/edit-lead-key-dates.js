$(document).ready(function () {
	$('#addKeyDateType').on('click', function(e) {
		$.ajax({
		url:route.admin.lead_key_date_type_list,
			type:'POST',
			data: {
				'lead_id':lead_id,
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
					$('#key_date_type').html(htmlOptions);
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});

	$('#submitKeyDateType').on('click', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#addKeyDateForm [data-required="true"]');
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
			let key_date_id = $('#key_date_type').val();
			$.ajax({
			url:route.admin.lead_key_date_type_add,
				type:'POST',
				data: {
					'lead_id':lead_id,
					'key_date_id':key_date_id,
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status=='success')
					{
						$('#popupCardKeyDate').modal('hide');
						initDataTableOnce('#jsGridKeyDates');
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