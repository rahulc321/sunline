$(document).ready(function () {
	$(document).on('click', '.editFirmFinanceBtn', function () {
		let firm_id = $(this).data('id');
		
		$.ajax({
			url:route.admin.lead_firm_details,
			type:'POST',
			data: {
				'lead_id':lead_id,
				'firm_id':firm_id,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					$('#epop_firm_id').val(firm_id);		
					$('#epop_firm_type').val(response.data.firm_type_id);		
					$('#epop_firm_name_id').val(response.data.firm_name);		
					$('#epop_firm_percentage').val(response.data.firm_percentage);		
					$('#epop_firm_override_type').val(response.data.firm_override_type_id);		
					$('#epop_firm_override_fee_share').val(response.data.firm_override_fee_share);		
					$('#epop_firm_aggrement_in_place').val(response.data.firm_agreement_in_place);		
					$('#epop_firm_referral_status').val(response.data.firm_referral_status_id);		
					$('#popupLeadFirmEdit').modal('show');					
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});

	$('#addFirmFinance').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#addFirmFinance [data-required="true"]');
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
			formData.append('firm_type_id', $('#pop_firm_type').val());
			formData.append('firm_name', $('#pop_firm_name_id').val());
			formData.append('firm_percentage', $('#firm_percentage').val());
			formData.append('firm_override_type_id', $('#pop_firm_override_type').val());
			formData.append('firm_override_fee_share', $('#pop_firm_override_fee_share').val());
			formData.append('firm_agreement_in_place', $('#pop_firm_aggrement_in_place').val());
			formData.append('firm_referral_status_id', $('#pop_firm_referral_status').val());
			
			$.ajax({
			url:route.admin.lead_firm_add,
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
						$('#popupLeadFirmAdd').modal('hide');
						initDataTableOnce('#jsGridFirms');
						Swal.fire("Created!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);				
				}
			});
		}
	});

	$('#addExpenseFinance').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#addExpenseFinance [data-required="true"]');
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
			formData.append('cost_type_id', $('#pop_cost_type').val());
			formData.append('date_issued', $('#pop_expense_date_issued').val());
			formData.append('invoice_no', $('#pop_expense_invoice_no').val());
			formData.append('amount_billed', $('#pop_expense_amount_billed').val());
			formData.append('qty', $('#pop_expense_qty').val());
			formData.append('total', $('#pop_expense_total').val());
			formData.append('expense_category_id', $('#pop_expense_category').val());
			formData.append('billable_to_client', $('#pop_expense_client_billable').val());
			formData.append('description', $('#pop_expense_description').val());
			formData.append('document_category_id', $('#pop_expense_document_category_id').val());
			formData.append('document_description', $('#pop_expense_document_description').val());
			
			$.ajax({
			url:route.admin.lead_expense_add,
				type:'POST',
				data: formData,
				contentType: false,
				processData: false,
				cache: false,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status=='success')
					{
						$('#popupExpenseFinanceAdd').modal('hide');
						initDataTableOnce('#jsGridExpense');
						Swal.fire("Created!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);				
				}
			});
		}
	});

	$('#editFirmFinance').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').remove();
		let isValid=true;
		const inputs = document.querySelectorAll('#editFirmFinance [data-required="true"]');
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
			formData.append('firm_id', $('#epop_firm_id').val());
			formData.append('firm_type_id', $('#epop_firm_type').val());
			formData.append('firm_name', $('#epop_firm_name_id').val());
			formData.append('firm_percentage', $('#epop_firm_percentage').val());
			formData.append('firm_override_type_id', $('#epop_firm_override_type').val());
			formData.append('firm_override_fee_share', $('#epop_firm_override_fee_share').val());
			formData.append('firm_agreement_in_place', $('#epop_firm_aggrement_in_place').val());
			formData.append('firm_referral_status_id', $('#epop_firm_referral_status').val());
			
			$.ajax({
				url:route.admin.lead_firm_update,
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
						$('#popupLeadFirmEdit').modal('hide');
						initDataTableOnce('#jsGridFirms');
						Swal.fire("Updated!", response.message, "success");
					}
					else {
						Swal.fire("Opps!", response.message, "error");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);				
				}
			});
		}
	});
	
	$('#pop_firm_type, #st_firm_type').on('change', function(e) {
		let frmTypeSelector;
		if($(this).attr('id') == 'st_firm_type') {
			frmTypeSelector = 'st_firm_type';
		}
		else {
			frmTypeSelector = 'pop_firm_type';
		}
		console.log(frmTypeSelector);
		$.ajax({
		url:route.admin.firms,
			type:'POST',
			data: {
				'firm_type_id':$(this).val(),
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					let htmlOptions;
					if(frmTypeSelector == 'st_firm_type') {
						htmlOptions='<option value="all" selected >Select Firm Name</option>';
					}
					else {
						htmlOptions='<option value="">Select</option>';
					}
					
					response.data.forEach(function(item) {								
						htmlOptions=htmlOptions + '<option value="'+item.id+'">'+item.name+'</option>';
					});
					
					if(frmTypeSelector == 'st_firm_type') {
						$('#st_firm_name').html(htmlOptions);
					}
					else {
						$('#pop_firm_name_id').html(htmlOptions);
					}
					
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});
	
	$(document).on('change', '#pop_firm_name_id', function (e) {
		$('#firm_percentage').val(0);	
		$.ajax({
		url:route.admin.firmNameDetails,
			type:'POST',
			data: {
				'firm_name_id':$(this).val(),
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					$('#firm_percentage').val(response.data.firm_percentage ?? 0);
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});
	
});	