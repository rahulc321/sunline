function createEditContactModal(mod_type)
{
	if(mod_type=='edit') {
		$('#contact_form_type').val('edit');
		$('#headingContactForm').html('Edit Contact');
		$('#btnSubmitUpdateContact').html('Update');
	}
	else {
		$('#pop_contact_id').val('');
		$('#contact_form_type').val('create');
		$('#headingContactForm').html('Add a New Contact');
		$('#btnSubmitUpdateContact').html('Submit');
	}
	$('#createEditContactModal').modal('show');
}

$(document).ready(function () {
	const $contactInput = $('#pop_contact_id');
	const $contactFormType = $('#contact_form_type');
	
	/* Start:: List Contact Address */
	const $tableAddress = $('#jsGridAddrs');
	const tableAddr = $tableAddress.DataTable({
		dom: '', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		orderable: false,
		searchable: false,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.contactAddressList,
			data: function (d) {
				d.contact_id = ($contactInput.length && $contactInput.val()) ? $contactInput.val() : null;
			}
		},
		"autoWidth": false,
		columns: [				
			{ data: 'address', name: 'address' },
			{ data: 'type', name: 'type' },
		],
		language: {
			emptyTable: "There are no addreses added at this time. Please press + New Address above."
		},
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
	});		
	const redrawAddressTable = () => tableAddr.draw();
	$('.createEditContact').on('click', redrawAddressTable);
	$(document).on('click', '.editPopupContactBtn', redrawAddressTable);
	/* End:: List Contact Address */

	/* Start:: Add Contacts */
	$('#createEditContactForm').on('submit', function (e) {
		e.preventDefault();
		$('.error-message').remove();

		const isValid = validateInputs('createEditContactForm');
		if (!isValid) return;

		const form = document.getElementById('createEditContactForm');
		const formData = new FormData(form);
		formData.append('contact_id', formData.get('pop_contact_id'));
		formData.append('contact_phone', formData.get('a_contact_phone'));
		formData.append('contact_email', formData.get('a_contact_email'));
		formData.append('contact_type', formData.get('a_contact_type'));

		formData.delete('pop_contact_id');
		formData.delete('a_contact_phone');
		formData.delete('a_contact_email');
		formData.delete('a_contact_type');
		
		let cntFrmAction;
		if($contactFormType.val() == 'edit') {
			cntFrmAction = route.admin.contact_update;
		}
		else {
			cntFrmAction = route.admin.contacts_store;
		}

		$.ajax({
			url: cntFrmAction,
			type: 'POST',
			data: formData,
			processData: false,
		    contentType: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (response) {
				if (response.status === 'success') {
					$('#createEditContactForm')[0].reset();
					$('#createEditContactModal').modal('hide');
					if($contactFormType.val() == 'edit') {
						let tablecont = $('#jsGridContactsMain').DataTable();
						tablecont.draw();
						Swal.fire("Updated!", response.message, "success");
					}
					else {
						let table = $('#jsGridContactSrchAdd').DataTable();
						table.draw();
						Swal.fire("Created!", response.message, "success");
					}
				}
			},
			error: function (xhr) {
				console.error('Error:', xhr.responseText);
			}
		});
	});
	/* End:: Add Contacts */

	/* Start:: Add Contact Address */
	$('#addAddressForm').on('submit', function (e) {
		e.preventDefault();
		$('.error-message').remove();

		const isValid = validateInputs('popupCardAddAddress');
		if (!isValid) return;

		let data = $(this).serialize();
		let contact_id = $contactInput.val() || null;
		if (contact_id) {
			data += '&contact_id=' + encodeURIComponent(contact_id);
		}

		$.ajax({
			url: route.admin.addAddress,
			type: 'POST',
			data: data,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (response) {
				if (response.status === 'success') {
					$('#popupCardAddAddress').modal('hide');
					$('#createEditContactModal').modal('show');
					tableAddr.draw();
					Swal.fire("Created!", response.message, "success");
				}
			},
			error: function (xhr) {
				console.error('Error:', xhr.responseText);
			}
		});
	});
	/* End:: Add Contact Address */
});