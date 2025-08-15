$(document).ready(function () {
	$('#contact_search').on('keyup', function() {
		initDataTableOnce('#jsGridRelatedContacts');
	});	

	$(document).on('click', '.delete-contact-btn', function () {
		let dataId = $(this).data('id');
		
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, delete it!"
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: "/admin/contacts/" + dataId,
					type: "DELETE",
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					success: function (response) {
						Swal.fire("Deleted!", response.message, "success");
						initDataTableOnce('#jsGridRelatedContacts');
					},
					error: function (xhr) {
						Swal.fire("Error!", "Something went wrong.", "error");
					}
				});
			}
		});
	});	
	
	$(document).on('click', '#popupAddNewContactCardBTN', function () {
		$('.error-message').remove();
		let isValid=true;
		const selected = document.querySelector('select[name="pop_case_role[]"]').selectedOptions;
		let errors = [];
		if (selected.length > 0) {
		  
		} else {
			isValid=false;
			let cleanName = 'Case Role';					
			$('#pop_case_role').after('<div class="error-message text-danger">'+`The ${cleanName} field is required.`+'</div>');
		}	
		
		if(isValid) {
			$('#createEditContactModal').modal('show');
		}		
	});
	
	let tablesa = $('#jsGridContactSrchAdd').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.contactList,
			data: function (d) {
				d.lead_id = lead_id;
				d.contact_search = $('#pop_contact_search').val();
				d.contact_type = $('#pop_contact_type').val();
			}
		},
		"autoWidth": false,
		"aaSorting": [[0, "desc"]],
		columns: [				
			{ data: 'name', name: 'name' },
			{ data: 'contact_type', name: 'contact_type' },
			{ data: 'email', name: 'email' },
			{ data: 'phone', name: 'phone' },
		],
		"lengthMenu": [
			[10, 25, 50, 100, -1],
			[10, 25, 50, 100, "All"] // change per page values here
		],
		// set the initial value
		"pageLength": 100,
		"sPaginationType": "full_numbers",
		"columnDefs": [{  // set default column settings
			'orderable': true,
			'targets': [0]
		}, {  // set default column settings
			'targets': [0],
			"visible": true,
			"searchable": false
		}
		],
		"fnInitComplete": function () {
			$(".dataTables_length").addClass("hidden-xs");
			$(this).removeClass("hidden");
		},
		"order": [
			[0, "DESC"]
		]
	});
	
	$('#pop_contact_search').on('keyup', function() {
		tablesa.draw();
	});
	$('#pop_contact_type').on('change', function() {
		tablesa.draw();
	});
});

$('#submitChangeCaseRole').on('click', function(e) {
	e.preventDefault();
	$('.error-message').remove();
	let isValid=true;
	const inputs = document.querySelectorAll('#changeCaseRoleModal [data-required="true"]');
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
		const container = document.getElementById('changeCaseRoleModal');
		const select = container.querySelector('select[name="change_case_role[]"]');
		const selectedValues = Array.from(select.selectedOptions).map(option => option.value);
		$.ajax({
			url:route.admin.changeCaseRole,
			type:'POST',
			data: {
				'lead_id':lead_id,
				'case_role':selectedValues,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{	
					$('#changeCaseRoleModal').modal('hide');
					initDataTableOnce('#jsGridRelatedContacts');
					Swal.fire("Created!", response.message, "success");
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	}
});

/* Start:: Contex Related JS */
$(document).ready(function () {
	// Hide any open menu on click outside
	$(document).on('click', function(e) {
		if (!$(e.target).closest('.context-card').length && !$(e.target).hasClass('context-icon')) {
			$('.context-card').remove();
		}
	});

	// Handle icon click
	$('#jsGridRelatedContacts').on('click', '.context-icon', function(e) {
		e.stopPropagation();
		$('.context-card').remove(); // remove any existing cards

		const id = $(this).data('id');
		const contact_id = $(this).data('contact_id');
		const iconOffset = $(this).offset();
		
		$.ajax({
			url:route.admin.contactDetails,
			type:'POST',
			data: {
				'id':contact_id,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{
					const cardHtml = renderContactContexCardHtml(response.data,iconOffset,{id:id});
					console.log(cardHtml);
					$('body').append(cardHtml);
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});
});

function setContactDetails(contact_id)
{
	getContactDetails(contact_id);
}

function getContactDetails(contact_id)
{
	$('.error-message').remove();
	let isValid=true;
	const selected = document.querySelector('select[name="pop_case_role[]"]').selectedOptions;
	let errors = [];
	if (selected.length > 0) {
	  
	} else {
		isValid=false;
		let cleanName = 'Case Role';					
		$('#pop_case_role').after('<div class="error-message text-danger">'+`The ${cleanName} field is required.`+'</div>');
	}	
	
	if(isValid) {
		Swal.fire({
			title: "Add Party With Role",
			text: "Are you sure that you want to add contact 'Alice Jackson ()' with role 'Administrator'?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, Add",
			cancelButtonText: "No, Cancel"
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url:route.admin.addLeadContact,
					type:'POST',
					data: {
						'lead_id':lead_id,
						'contact_id':contact_id,
					},
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					success: function (response) {
						Swal.fire("Success", response.message, "success");
						initDataTableOnce('#jsGridRelatedContacts');
						$('#popupCardAddAddress').modal('hide');
					},
					error: function (xhr) {
						Swal.fire("Error!", "Something went wrong.", "error");
					}
				});
			}
		});
	}
}

function renderContactContexCardHtml(data,iconOffset,other)
{
	let id = other.id;
	let fullName = data.display_name;
	if(fullName=="") {
		fullName = data.first_name+" "+data.last_name;
	}
	const nameParts = fullName.trim().split(" ");
	let initials = "";
	if(nameParts.length>=2)
	{
		initials = nameParts[0][0] + nameParts[1][0];
	}
	else if(nameParts.length==1)
	{
		initials = nameParts[0][0];
	}
	
	const cardHtml = `
			<div class="context-card" style="
				position: absolute;
				top: ${iconOffset.top + 20}px;
				left: ${iconOffset.left + 25}px;
				background: white;
				border: 1px solid #ccc;
				padding: 5px;
				width: 400px;
				box-shadow: 0 2px 5px rgba(0,0,0,0.2);
				z-index: 9999;
			">
				<button type="button" class="close-btn" onclick="dismissContext(this)">x</button>
				<div>
				  <div class="card-body">
					<div class="row">
					  <div class="col-2">
						<div class="avtar-initials">
							${initials}
						</div>
					  </div>
					  <div class="col-6">
						<div><h5>${data.display_name}<h5></div>
						<div>${data.phone} <span>(mobile)</span></div>
						<div>${data.email} <span>(email)</span></div>
						<div>No post address presented</div>
						<div>ID ${lead_id}</div>
					  </div>
					  <div class="col-4 context-actions" style="display:block;background:#ccc;">
						<div><a href="javascript:;">Compose Email</a></div>
						<div><a href="javascript:;">Opt-Out Emails</a></div>
						<div><a href="javascript:;" data-bs-toggle="modal" data-bs-target="#changeCaseRoleModal" >Change Case Role</a></div>
						<div><a href="javascript:;" class="createEditContact" onclick="createEditContactModal('create');">Change Contact</a></div>
						<div><a href="javascript:;" data-id="${id}" class="delete-contact-btn" >Delete Contact</a></div>
					  </div>
					</div>
				 </div>
				</div>
			</div>
		`;
	return cardHtml;
}

function dismissContext(btn)
{
	const contextBox = btn.parentElement;
	contextBox.remove();
	
}

/* End:: Contex Related JS */

/* Start:: Add Contact Address */
$('#addAddressForm').on('submit', function(e) {
	e.preventDefault();
	$('.error-message').remove();
	let isValid=true;
	const inputs = document.querySelectorAll('#popupCardAddAddress [data-required="true"]');
	let errors = [];
	console.log(inputs);
	inputs.forEach(input => {
		if(!input.value.trim()) {
			isValid=false;
			let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
			cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
			$('#'+input.id).after('<div class="error-message text-danger">'+`The ${cleanName} field is required.`+'</div>');
		}
	});		
	
	if(isValid) {
		$.ajax({
		url:route.admin.addAddress,
			type:'POST',
			data: $(this).serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				if(response.status=='success')
				{	
					$('#popupCardAddAddress').modal('hide');
					$('#popupCardParty').modal('hide');
					$('#createEditContactModal').modal('show');
					let tbljsgAddrs = $('#jsGridAddrs').DataTable();
					tbljsgAddrs.draw();
					Swal.fire("Created!", response.message, "success");
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	}
});
/* End:: Add Contact Address */