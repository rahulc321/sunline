$(document).ready(function () {
	
	$('.texts_msg_filter, #search_date_from, #search_date_to').on('change', function () {
        initDataTableOnce('#jsGridCommunicationText');
    });
	
	$('#search_communication_text').on('keyup', function() {
		initDataTableOnce('#jsGridCommunicationText');
	});
	
	$('#jsGridCommunicationText tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = initDataTableOnce('#jsGridCommunicationText').row(tr);

		if (row.child.isShown()) {
			// Close row
			row.child.hide();
			tr.removeClass('shown');
			$(this).html('<i class="fa fa-plus-circle ph-plus-circle"></i>');
		} else {
			// Open row and load data
			$(this).html('<i class="fa fa-spinner fa-spin ph-spinner ph-spin"></i>');

			let rowData = row.data();
			let id = rowData.id;

			// Call to get accordion content via AJAX
			$.ajax({
				url: route.admin.communications_text_messages_list_lead_id,
				method: 'GET',
				data: {
					lead_id:id,
					texts_msg_filter : $('input[name="texts_msg_filter[]"]:checked').map(function () {
						return $(this).val();
					}).get(),
					search_communications : $('#search_communication_text').val(),
					from_date : $('#search_date_from').val(),
					to_date : $('#search_date_to').val(),
				},
				success: function (response) {
					// show accordion with loaded HTML
					row.child(response).show();
					tr.addClass('shown');
					$(tr).find('td.details-control').html('<i class="fa fa-minus-circle ph-minus-circle"></i>');
				},
				error: function () {
					row.child('<div class="text-danger p-2">Failed to load data</div>').show();
					tr.addClass('shown');
				}
			});
		}
	});
	
});

function sendTextMessage(lead_id)
{
	$('.error-message').html('');
	let isValid=true;
	let container_id = '#texts_msg_form_'+lead_id;
	const inputs = document.querySelectorAll(container_id+' [data-required="true"]');
	let errors = [];
	console.log(inputs);
	inputs.forEach(input => {
		if(!input.value.trim()) {
			isValid=false;
			let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
			cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
			$('#error_'+input.id).html(`The ${cleanName} field is required.`);
			console.log('#error_'+input.id);
		}
	});		
	console.log('Is Valid: '+isValid);
	if(isValid) {
		let formData = {
				'lead_id':lead_id,
				'message':$('#texts_msg_'+lead_id).val(),
			};
		$.ajax({
			url: route.admin.communications_send_text_msg,
			type: 'POST',
			data: formData,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					initDataTableOnce('#jsGridCommunicationText');
					Swal.fire("Created!", response.message, "success");
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	}
}