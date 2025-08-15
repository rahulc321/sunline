function showDocumentDetails(intake_id)
{
	$('.document-details-'+intake_id).toggle();
}	
	
function showDocsTab(tabcont)
{
	$('.document-container').hide();
	$('.print-queue-container').hide();
	if(tabcont=='print_queue') {
		$('.print-queue-container').show();
		//$('#jsGridPrintQueue').DataTable().ajax.reload();
	}
	else {
		$('.document-container').show();
	}
}	
		
$(document).ready(function () {
	let selectedLeadId = null;
	let selectedClientId = null;
	let selectedCaseId = null;
	let showEmptyFolders = 0;
	let selectedFolderId = 0;
	let isDeletedList = 0;
	let viewMode = 'list';
	const $table = $('#jsGridDocumentsMain');
	const table = $table.DataTable({
		dom: 'rtp',
		processing: true,
		serverSide: true,
		scrollY: '400px',
		scrollX: true,
		scrollCollapse: true,
		select: false,
		autoWidth: false,
		aaSorting: [],
		pageLength: 100,
		sPaginationType: 'full_numbers',
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		columns: [
			{ data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
			{ data: 'document_name', name: 'document_name' },
			{ data: 'related_lead_case', name: 'related_lead_case' },
			{ data: 'document_category', name: 'document_category' },
			{ data: 'date_modified', name: 'date_modified' },
			{ data: 'modified_by', name: 'modified_by' }
		],
		ajax: {
			url: route.admin.lead_main_document_list,
			data: function (d) {
				d.search_document = $('#search_document').val();
				d.is_deleted_list = isDeletedList;
				d.show_empty_folder = showEmptyFolders;
				d.view_mode = viewMode;
				d.lead_id = selectedLeadId;
				d.client_id = selectedClientId;
				d.case_id = selectedCaseId;
				d.folder_id = selectedFolderId;
				

				if (window.shouldFilter) {
					const fields = [
						'filter_date_range', 'filter_document_folder', 'filter_document_category', 'filter_case_type', 'filter_status', 'filter_tag', 'filter_modified_by', 'filter_marketing_source'
					];
					fields.forEach(field => {
						d[field.replace('filter_', '')] = $(`#${field}`).val();
					});
				}
			}
		},
		fnInitComplete: function () {
			$(".dataTables_length").addClass("hidden-xs");
			$table.removeClass("hidden");
		}
	});

	// Event bindings
	const redrawTable = () => table.draw();

	$('#select-all').on('click', function () {
		const checked = this.checked;
		table.rows({ search: 'applied' }).nodes().to$().find('input.user-checkbox').prop('checked', checked);
	});

	$('#showEmptyFolders').on('change', redrawTable);

	$('#search_document').on('keyup', redrawTable);

	$('#filterApplyBtn').on('click', function () {
		window.shouldFilter = true;
		table.ajax.reload();
		$('#dropdownForm').toggle();
	});
	
	// Toggle views
	const toggleView = (hideBtn, showBtn, showContainer, value = null) => {
		$(hideBtn).hide();
		$(showBtn).show();
		if (showContainer) {
			$(showContainer).toggle(value);
		}
		table.draw();
	};
	
	$('#switchDeletedBtn').on('click', function () {
		if (isDeletedList === 1) {
			isDeletedList = 0;
			$(this).html('<i class="far fa-recycle ph-recycle"></i> View Deleted Files');
		} else {
			isDeletedList = 1;
			$(this).html('<i class="far fa-recycle ph-recycle"></i> View Existing Files');
		}
		table.ajax.reload();
	});
	
	$('#showEmptyFolders').on('change', function() {
		showEmptyFolders = $('#showEmptyFolders').is(':checked') ? 1 : 0;
		table.ajax.reload();
	});	
	
	$(document).on('click', '.filter_folder', function () {
		selectedFolderId = $(this).data('folder_id');
		table.ajax.reload();
	});
	
	$(document).on('click', '.folder-btn', function () {
		if($(this).data('lead_id')>0) {
			$('#newDocumentUpload').show();
			$('#upload_lead_id').val($(this).data('lead_id'));
		}
		else {
			$('#newDocumentUpload').hide();
			$('#upload_lead_id').val(0);
		}
		selectedLeadId = $(this).data('lead_id');
		selectedClientId = $(this).data('client_id');
		selectedCaseId = $(this).data('case_id');
		selectedFolderId = $(this).data('folder-id');
		updateFolderPath(selectedFolderId);
		table.ajax.reload();
	});
	
	$('#switchViewBtn').on('click', function () {
		if (viewMode === 'folder') {
			viewMode = 'list';
			$('#contShowEmpFolder').hide();
			$(this).html('<i class="far fa-folder-open ph-folder-open"></i> Switch To Folder View');
		} else {
			viewMode = 'folder';
			$('#contShowEmpFolder').show();
			$(this).html('<i class="far fa-list-alt ph-table"></i> Switch To File View');
		}
		table.ajax.reload();
	});
	
	// Edit button
    $('#jsGridDocumentsMain').on('click', '.edit-name', function () {
        const id = $(this).data('id');
        $(`.filename[data-id="${id}"]`).addClass('d-none');
        $(`.rename-input[data-id="${id}"]`).removeClass('d-none');
        $(`.edit-name[data-id="${id}"]`).addClass('d-none');
        $(`.ok-rename-btn[data-id="${id}"], .discard-rename-btn[data-id="${id}"]`).removeClass('d-none');
    });

    // Discard button
    $('#jsGridDocumentsMain').on('click', '.discard-rename-btn', function () {
        const id = $(this).data('id');
        $(`.rename-input[data-id="${id}"]`).addClass('d-none');
        $(`.filename[data-id="${id}"]`).removeClass('d-none');
        $(`.edit-name[data-id="${id}"]`).removeClass('d-none');
        $(`.ok-rename-btn[data-id="${id}"], .discard-rename-btn[data-id="${id}"]`).addClass('d-none');
    });

    // OK button - Ajax call
    $('#jsGridDocumentsMain').on('click', '.ok-rename-btn', function () {
        const id = $(this).data('id');
        const newName = $(`.rename-input[data-id="${id}"]`).val();
		
		$.ajax({
			url:route.admin.lead_document_rename,
			type:'POST',
			data: {
                id: id,
                new_name: newName
            },
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (response) {
                if (response.success) {
                    table.ajax.reload(null, false); // reload without page reset
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
				console.error('Error: ', xhr.responseText);
			}
		});
    });
	
	function updateFolderPath(folderId) {
		const pathDisplay = document.getElementById('selected-folder-path');
		let hrefTagData = '<a class="folder-btn" href="javascript:;" data-lead_id="0" data-folder-id="0" data-case_id="0" data-client_id="0" >Documents</a>';

		if (folderId) {
			fetch(route.admin.lead_folder_path+`/${folderId}`)
				.then(response => response.json())
				.then(data => {
					if (data.path && Array.isArray(data.path)) {
						let pathHtml = '';

						data.path.forEach(function (path) {
							if (path.name === 'Documents') {
								pathHtml += `<a class="folder-btn" href="javascript:;" 
									data-lead_id="0" 
									data-folder-id="0" 
									data-case_id="0" 
									data-client_id="0" >${path.name}</a>/`;
							} else {
								pathHtml += `<a class="folder-btn" href="javascript:;" 
									data-lead_id="${selectedLeadId}" 
									data-folder-id="${path.id}" 
									data-case_id="${selectedCaseId}" 
									data-client_id="${selectedClientId}"  >${path.name}</a>/`;
							}
						});
						pathHtml = pathHtml.replace(/\/$/, '');
						pathDisplay.innerHTML = pathHtml;
					} else {
						pathDisplay.innerHTML = hrefTagData;
					}
				})
				.catch(error => {
					console.error('Error fetching folder path:', error);
					pathDisplay.innerHTML = hrefTagData;
				});
		} else {
			pathDisplay.innerHTML = hrefTagData;
		}
	}
	
	/* Start:: Print Document Queue Related JS */
	$('.DPQ-Accordion').on('click', function () {
        let tableDPQ = $(this).closest('.DPQ-Accordion-Item').find('.jsGridDocumentPrintQueue');
        let tableIdDPQ = '#' + tableDPQ.attr('id');
        let docId = tableDPQ.data('doc-id');
        let createDate = tableDPQ.data('doc-create-date');
		let documentTemplateId = null;
		let fileInformationId = null;
		let pageNum = 1;
		let pageSize = 50;

        if (docId && !$.fn.DataTable.isDataTable(tableIdDPQ)) {
            let dataTableDPQ = $(tableIdDPQ).DataTable({
				dom: 'rt', /* rtp */
                processing: true,
                serverSide: true,
                ajax: {
                    url: route.admin.doc_print_queue_info,
                    data: {
							docId: docId,
							createDate: createDate,
							documentTemplateId: documentTemplateId,
							fileInformationId: fileInformationId,
							pageNum: pageNum,
							pageSize: pageSize,
						  }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
					{ data: 'first_name', name: 'first_name' },
					{ data: 'last_name', name: 'last_name' },
					{ data: 'document_created', name: 'document_created' },
					{ data: 'mail_merge_status', name: 'mail_merge_status' },
					{ data: 'type_of_case', name: 'type_of_case' },
					{ data: 'mailing_address_1', name: 'mailing_address_1' },
					{ data: 'mailing_address_2', name: 'mailing_address_2' },
					{ data: 'city', name: 'city' },
					{ data: 'state', name: 'state' },
					{ data: 'zip_code', name: 'zip_code' },
					{ data: 'action', name: 'action' }
                ]
            });
			
			$(tableIdDPQ).on('click', '.select-all', function () {
				const checked = this.checked;
				dataTableDPQ.rows({ search: 'applied' }).nodes().to$().find('input.user-checkbox').prop('checked', checked);
			});
        }
    });
	
	$(document).on('click', '#printAllSelectedDoc', function () {
		let selectedDPQIds = [];

		$('input.user-checkbox:checked').each(function () {
			selectedDPQIds.push($(this).val());
		});

		if (selectedDPQIds.length === 0) {
			Swal.fire("No Selection", 'Please select at least one document to print.', "warning");
			return;
		}
		
		Swal.fire({
			title: "Are you sure you want to print selected documents?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#7066df",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, print them!",
			cancelButtonText: "Cancel"
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: route.admin.print_queue_document,
					type: 'POST',
					data: {
						selected_ids: selectedDPQIds
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						if(response.type == 'pdf')
						{
							const link = document.createElement('a');
							link.href = 'data:application/pdf;base64,'+response.pdf;
							link.download = response.filename;
							link.click();
						}
						Swal.fire("Success!", response.message || 'Selected Document Printed Successfully', "success");
					},
					error: function (xhr) {
						console.error(xhr);
						Swal.fire("Error!", 'Something went wrong while processing print request.', "error");
					}
				});
			}
		});
	}); 
	
	$(document).on('click', '#deleteAllSelectedDoc', function () {
		let selectedDPQIds = [];

		$('input.user-checkbox:checked').each(function () {
			selectedDPQIds.push($(this).val());
		});

		if (selectedDPQIds.length === 0) {
			Swal.fire("No Selection", 'Please select at least one document to delete.', "warning");
			return;
		}
		
		Swal.fire({
			title: "Are you sure you want to delete selected documents?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Yes, delete them!",
			cancelButtonText: "Cancel"
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: route.admin.delete_queue_document,
					type: 'POST',
					data: {
						selected_ids: selectedDPQIds
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						Swal.fire("Created!", response.message || 'Selected Documents Deleted Successfully', "success");
						location.reload();
					},
					error: function (xhr) {
						console.error(xhr);
						Swal.fire("Error!", 'Something went wrong while processing delete request.', "error");
					}
				});
			}
		});	
	});
	
	$(document).on('click', '#printDocList .pagination a', function (e) {
		e.preventDefault();
		let href = $(this).attr('href');
		let queryString = href.split('?')[1] || '';
		$.ajax({
			url: route.admin.doc_print_queue_paginate+'?'+queryString,
			type: 'GET',
			beforeSend: function() {
				$('#printDocList').html('<div class="text-center p-4">Loading...</div>');
			},
			success: function (response) {
				$('#printDocList').html(response);
			},
			error: function (xhr) {
				console.error(xhr);
				Swal.fire("Error!", 'Error Loading Data.', "error");
			}
		});
	});
	/* End:: Print Document Queue Related JS */
	
});	