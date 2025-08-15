function showDocsTab(tabcont)
{
	$('#documents_tab').removeClass('show active');
	$('#doc_esign_tab').removeClass('show active');
	if(tabcont=='e_sign') {
		$('#doc_esign_tab').addClass('show active');
	}
	else {
		$('#documents_tab').addClass('show active');
	}
}

function showHideEsignTab(tabcont)
{
	$('#esign_tab_contnr').hide();
	$('#esign_status_tab_contnr').hide();
	if(tabcont=='e_sign_status') {
		$('#esign_status_tab_contnr').show();
	}
	else {
		$('#esign_tab_contnr').show();
	}
}

$(document).ready(function () {
	let showEmptyFolders = 1;
	let selectedFolderId = root_document_folder_id;
	let selectedDFolderId = 0;
	let viewMode = 'folder'; // 'folder' or 'list'
    let tableDoc;
	tableDoc = $('#jsGridDocuments').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_document_list,
			data: function (d) {
				d.lead_id = lead_id;
				d.show_empty_folder = showEmptyFolders;
				d.folder_id = selectedFolderId;
				d.d_folder_id = selectedDFolderId;
				d.view_mode = viewMode;
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'document_name', name: 'document_name' },
			{ data: 'document_category', name: 'document_category' },
			{ data: 'document_modified', name: 'document_modified' },
			{ data: 'description', name: 'description' },
			{ data: 'document_size', name: 'document_size' },
			{ data: 'document_type', name: 'document_type' },
			{ data: 'contact_name', name: 'contact_name' },
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
	});
	
	$('#showEmptyFolders').on('change', function() {
		showEmptyFolders = $('#showEmptyFolders').is(':checked') ? 1 : 0;
		tableDoc.ajax.reload();
	});	
	
	$(document).on('click', '.filter_folder', function () {
		selectedFolderId = $(this).data('folder_id');
		selectedDFolderId = $(this).data('d_folder_id');
		tableDoc.ajax.reload();
	});
	
	$(document).on('click', '.folder-btn', function () {
		selectedFolderId = $(this).data('folder-id');
		tableDoc.ajax.reload();
	});
	
	$('#switchViewBtn').on('click', function () {
		if (viewMode === 'folder') {
			viewMode = 'list';
			$('#id-show-empty-folders').hide();
			$(this).html('<i class="far fa-folder-open ph-folder-open"></i> Switch To Folder View');
		} else {
			viewMode = 'folder';
			$('#id-show-empty-folders').show();
			$(this).html('<i class="far fa-list-alt ph-table"></i> Switch To File View');
		}
		tableDoc.ajax.reload();
	});
	
	$('#jsGridDocuments tbody').on('dblclick', 'tr', function () {
		let data = tableDoc.row(this).data();
		if(data && data.id) {
			window.location.href = route.admin.lead_document_download+`/${data.id}`;
		}
	});
	
	let tableDocEsign = $('#jsGridDocEsign').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_doc_esign_list,
			data: function (d) {
				d.lead_id = lead_id;
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'document_name', name: 'document_name' },
			{ data: 'case_type', name: 'case_type' },
			{ data: 'uploaded_at', name: 'uploaded_at' },
			{ data: 'updated_at', name: 'updated_at' },
			{ data: 'created_by_name', name: 'created_by_name' },
			{ data: 'document_action', name: 'document_action' },
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
	});	
	
	$(document).on('click', '.doc_esign_tab', function () {
		tableDocEsign.draw();
	});
	
	let tableDocEsignStatus = $('#jsGridDocEsignStatus').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.lead_doc_esign_status_list,
			data: function (d) {
				d.lead_id = lead_id;
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'signers', name: 'signers' },
			{ data: 'envelope_id', name: 'envelope_id' },
			{ data: 'sent_time', name: 'sent_time' },
			{ data: 'template_name', name: 'template_name' },
			{ data: 'envelope_status', name: 'envelope_status' },
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
	});	
	
	$(document).on('click', '.doc_esign_status_tab', function () {
		tableDocEsignStatus.draw();
	});
	
	let tbljs_esignsend = $('#jsGridESignSend').DataTable({
		dom: 'rtp', //rtip Bfrtip lfrtip
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		"ajax": {
			url: route.admin.esign.GetRecipients,
			data: function (d) {
				d.lead_id = lead_id;
				d.show_empty_folder = ($('#showEmptyFolders').is(':checked')=='on')?1:0;
			}
		},
		"autoWidth": false,
		"aaSorting": [],
		columns: [				
			{ data: 'esign_index', name: 'esign_index' },
			{ data: 'OnOff', name: 'OnOff' },
			{ data: 'SigningOrder', name: 'SigningOrder' },
			{ data: 'Placeholder', name: 'Placeholder' },
			{ data: 'Role', name: 'Role' },
			{ data: 'Name', name: 'Name' },
			{ data: 'Email', name: 'Email' },
			{ data: 'Phone', name: 'Phone' },
			{ data: 'SMS', name: 'SMS' },
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
	});
	
	$(document).on('click', '.btn-send-lead-contract, .btn-sign-now', function () {
		$.ajax({
			url:route.admin.esign.GetSenders,
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
					$('#pop_send_esign_from').html(htmlOptions);
					
					$('#popupDocEsignNow').modal('show');
					tbljs_esignsend.draw();
				}
			},
			error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
	});
	
});