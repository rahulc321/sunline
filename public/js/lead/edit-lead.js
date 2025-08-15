// Store configs for each table
const dataTableConfigs = {
    '#jsGridRelatedContacts': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.leadRelatedContactList ?? null,
			data: function (d) {
				d.contact_search = $('#contact_search').val();
				d.lead_id = lead_id;
			}
		},
		"autoWidth": false,
		"aaSorting": [[0, "desc"]],
		columns: [				
			{ data: 'name', name: 'name' },
			{ data: 'case_role', name: 'case_role' }
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
	},
	'#jsGridForm': {
		
	},
    '#jsGridKeyDates': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_key_date_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
			}
		},
		"autoWidth": false,
		"aaSorting": [[0, "desc"]],
		columns: [				
			{ data: 'key_date_name', name: 'key_date_name' },
			{ data: 'key_date', name: 'key_date' }
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
	},
    '#jsGridNotes': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_notes_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
				d.notes_category = $('#notes_category').val();
				d.search_notes = $('#search_notes').val();
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'notes_date', name: 'notes_date' },
			{ data: 'user_name', name: 'user_name' },
			{ data: 'category', name: 'category' },
			{ data: 'notes', name: 'notes', orderable:false, },
			{ data: 'attachment', name: 'attachment', orderable:false, },
		],
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
		"order": [
		]
	},
	'#jsGridEvents': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_events_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'date_time', name: 'date_time' },
			{ data: 'title', name: 'title' },
			{ data: 'type', name: 'type' },
			{ data: 'location', name: 'location' },
			{ data: 'owner', name: 'owner' },
			{ data: 'status', name: 'status' },
		],
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
		"order": [
		]
	},
	'#jsGridTasks': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_tasks_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
				d.task_type = $('#task_type').val();
				d.task_category = $('#tasks_category').val();
				d.search_task = $('#search_tasks').val();
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'due_date', name: 'due_date' },
			{ data: 'subject', name: 'subject' },
			{ data: 'task_type', name: 'task_type' },
			{ data: 'task_category', name: 'task_category' },
			{ data: 'assigned_to', name: 'assigned_to' },
			{ data: 'assigned_by', name: 'assigned_by' },
			{ data: 'assigned_date', name: 'assigned_date' },
			{ data: 'status', name: 'status' },
			{ data: 'priority', name: 'priority' },
		],
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
		"order": [
		]
	},
	'#Documents': {
		
	},
	'#jsGridCommunicationEmail': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_communications_email_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
				d.search_communications = $('#search_communication_email').val();
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'communications_date', name: 'communications_date' },
			{ data: 'from_email', name: 'from_email' },
			{ data: 'to_email', name: 'to_email' },
			{ data: 'cc_email', name: 'cc_email' },
			{ data: 'subject', name: 'subject' },
			{ data: 'status', name: 'status' },
			{ data: 'campaign_type', name: 'campaign_type' },
		],
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
		"order": [
		]
	},
	'#jsGridCommunicationText': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.communications_text_messages_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
				d.texts_msg_filter = $('input[name="texts_msg_filter[]"]:checked').map(function () {
                    return $(this).val();
                }).get();
				d.search_communications = $('#search_communication_text').val();
				d.from_date = $('#search_date_from').val();
				d.to_date = $('#search_date_to').val();
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [
			{ data: 'client', name: 'client' },
			{ data: 'lead_id', name: 'lead_id' },
			{
				className: 'details-control', // used for toggling
				orderable: false,
				data: null,
				defaultContent: '<i class="fa fa-plus-circle ph-plus-circle"></i>',
			}
		],
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
		"order": [
		]
	},
	'#jsGridFirms': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_firm_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'firm_type', name: 'firm_type' },
			{ data: 'firm_agreement_in_place', name: 'firm_agreement_in_place' },
			{ data: 'firm_name', name: 'firm_name' },
			{ data: 'firm_percentage', name: 'firm_percentage' },
			{ data: 'firm_override_fee_share', name: 'firm_override_fee_share' },
			{ data: 'firm_referral_status', name: 'firm_referral_status' },
			{ data: 'firm_action', name: 'firm_action' },
		],
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
		"order": [
		]
	},
	'#jsGridExpense': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_expense_list ?? null,
			data: function (d) {
				d.lead_id = lead_id;
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'date_issued', name: 'date_issued' },
			{ data: 'vendor_name', name: 'vendor_name' },
			{ data: 'cost_type', name: 'cost_type' },
			{ data: 'expense_category', name: 'expense_category' },
			{ data: 'description', name: 'description' },
			{ data: 'amount_lien_hold', name: 'amount_lien_hold' },
			{ data: 'amount_billed', name: 'amount_billed' },
			{ data: 'billable_to_client', name: 'billable_to_client' },
			{ data: 'vendor_balance', name: 'vendor_balance' },
		],
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
		"order": [
		]
	},
	'#jsGridActivityLogs': {
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.activity_logs ?? null,
			data: function (d) {
				d.lead_id = lead_id;
				d.search_activity = $('#search_activity').val();
				d.activity_category = $('#activity_category').val();
				d.module = $('#module').val();
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'completed_on', name: 'completed_on' },
			{ data: 'user', name: 'user' },
			{ data: 'description', name: 'description' },
		],
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
		"order": [
		]
	},
};

// Function to init a table only once
function initDataTableOnce(selector) {
    if (!$.fn.DataTable.isDataTable(selector)) {
        return $(selector).DataTable(dataTableConfigs[selector]);
    } else {
        return $(selector).DataTable().ajax.reload(null, false);
    }
}


// Function to Show Lead Section according to Hash Tag Url
function showSectionFromHash()
{
	document.querySelectorAll('.section').forEach(el => el.style.display = 'none');
	const hash = window.location.hash;
	if(hash) {
		const section = document.querySelector(hash);
		if(section) {
			section.style.display = 'block';
			const sectionId = section.id;
            $('#page_section').val(sectionId);
			let tableDT;
			// Smooth scroll after lead section is visible
			setTimeout(() => {
				switch (sectionId) {
					case 'Overview':
						smoothScroll(section, 180);
						break;

					case 'RelatedContacts':
						initDataTableOnce('#jsGridRelatedContacts');
						section.scrollIntoView({ behavior: 'smooth' });
						break;
					
					case 'Form':
						//initDataTableOnce('#jsGridForm');
						section.scrollIntoView({ behavior: 'smooth' });
						break;	

					case 'KeyDates':
						initDataTableOnce('#jsGridKeyDates');
						section.scrollIntoView({ behavior: 'smooth' });
						break;

					case 'Notes':
						initDataTableOnce('#jsGridNotes');
						section.scrollIntoView({ behavior: 'smooth' });
						break;

					case 'Events':
						initDataTableOnce('#jsGridEvents');
						section.scrollIntoView({ behavior: 'smooth' });
						break;
						
					case 'Tasks':
						initDataTableOnce('#jsGridTasks');
						section.scrollIntoView({ behavior: 'smooth' });
						break;	

					case 'Documents':
						//initDataTableOnce('#jsGridDocuments');
						tableDT = $('#jsGridDocuments').DataTable();
						tableDT.draw();
						section.scrollIntoView({ behavior: 'smooth' });
						break;

					case 'Communications':
						initDataTableOnce('#jsGridCommunicationEmail');
						initDataTableOnce('#jsGridCommunicationText');
						section.scrollIntoView({ behavior: 'smooth' });
						break;

					case 'Finance':
						initDataTableOnce('#jsGridFirms');
						initDataTableOnce('#jsGridExpense');
						section.scrollIntoView({ behavior: 'smooth' });
						break;

					case 'ActivityLogs':
						initDataTableOnce('#jsGridActivityLogs');
						section.scrollIntoView({ behavior: 'smooth' });
						break;
				}	
			}, 100);
		}
	}
}

// Function For Smooth Scroll
function smoothScroll(element, offset) {
    const headerOffset = offset || 0;
    const elementPosition = element.getBoundingClientRect().top;
    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
    window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
}

// Run on Page Load
window.addEventListener('load', showSectionFromHash);

// Run on Hash Changed 
window.addEventListener('hashchange', showSectionFromHash);

getUpcommingEvents();

function getUpcommingEvents()
{
	const today = new Date();
	const dd = String(today.getDate()).padStart(2, '0');
	const mm = String(today.getMonth() + 1).padStart(2, '0');
	const yyyy = today.getFullYear();
	const date = dd + '-' + mm + '-' + yyyy;
	$.ajax({
		url: route.admin.lead_events_list ?? null,
		method: 'GET',
		data: {
			lead_id:lead_id,
			start_date:date,
		},
		success: function (response) {
			let xdata='';
			$.each(response.data, function(index, value) {
				xdata = xdata + '<h6 class="card-title">'+ value.title + '</h6>';
				xdata = xdata + '<p class="card-text">'+ value.description + '</p>';
			});
			if(xdata) 
			{
				$('#upcoming_events').html(xdata);
			}
			//$('#upcoming_events').html('<h6 class="card-title">No Upcoming Events</h6><p class="card-text">&nbsp;</p>');
		},
		error: function () {
			$('#upcoming_events').html('<h6 class="card-title">No Upcoming Events</h6><p class="card-text">&nbsp;</p>');
		}
	});
}