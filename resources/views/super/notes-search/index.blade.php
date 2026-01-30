@extends('layouts.admin')

@section('title', "{{ trans('notes_search.search_notes') }}")

@section('styles')

@endsection

@section('content')
	<!-- <div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					{{ trans('notes_search.search_notes') }} <span class="fw-normal">&nbsp;</span>
				</h4>
			</div>
		</div>
	</div> -->
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
			  <!-- form start -->
				  <form id="notesSearchForm" method="POST" action="javascript:;">
					@csrf
					<section id="notes-search">
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-6">
											<h5 class="m-0"><a href="javascript:;">{{ trans('notes_search.search_notes') }}</a> </h5>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">
													
											</div>	
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row py-3">
										<div class="col-10">
											<div class="row">
											  <div class="d-flex align-items-center">
												<span class="mx-1">{{ trans('notes_search.date') }}</span> <input type="date" class="form-control" name="filter_from" id="filter_from" placeholder="">
												<span class="mx-1">{{ trans('notes_search.to') }}</span> <input type="date" class="form-control" name="filter_to" id="filter_to" placeholder="">
												<span class="mx-1">{{ trans('notes_search.search') }}</span> <input type="text" class="form-control" name="filter_search" id="filter_search" placeholder="">
												<button type="submit" class="mx-1 btn btn-secondary" id="notesSrchFormSubmitBtn" style="font-size: 15px;"><i class="fa fa-search ph-magnifying-glass"></i></button>
												<button type="button" class="mx-1 btn btn-secondary" id="resetnotesSearchForm" style="font-size: 15px;" title="{{ trans('notes_search.reset') }}"><i class="fa fa-trash ph-trash"></i></button>
											  </div>
											</div>
										</div>
										<div class="col-2">
											<div class="d-flex justify-content-end align-items-center">
												<a href="javascript:;" id="exportNotes">{{ trans('notes_search.export_to_excel') }}<i style="color: goldenrod!important;" class="px-1 far fa-file-excel ph-file-xls"></i></a>
											</div>
										</div>
									</div>
									
									<div class="row py-2">
									  <div class="col-4">
									    <label for="filter_case_type">{{ trans('notes_search.case_type') }}:</label>
										<select name="filter_case_type[]" id="filter_case_type" class="form-control select2" multiple >
											@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
												@foreach($intake_values['case_type'] as $key=>$value)
													<option value="{{$key}}">{{$value}}</option>
												@endforeach
											@endif
										</select>
									  </div>
									  <div class="col-4">
										<label for="filter_notes_category">{{ trans('notes_search.notes_category') }}:</label>
										<select name="filter_notes_category[]" id="filter_notes_category" class="form-control select2" multiple>
											@if(isset($notes_category_list) && !empty($notes_category_list))
												@foreach($notes_category_list as $key=>$value)
													<option value="{{$key}}">{{$value}}</option>
												@endforeach
											@endif
										</select>
									  </div>
									  <div class="col-4">
									    <label for="filter_user">{{ trans('notes_search.user') }}:</label>
										<select name="filter_user[]" id="filter_user" class="form-control select2" multiple>
											@if(isset($users) && !empty($users))
												@foreach($users as $key=>$value)
													<option value="{{$key}}" >{{$value}}</option>
												@endforeach
											@endif
										</select>
									  </div>
									</div>
									
								</div>
							</div>
						</div>
						
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-body">
									<div class="row">
									  <div class="col-12">
										<table class="table" id="jsGridNotesSearch">
										<thead>
											<tr>	
												<th class="d-none"><input type="checkbox" id="select-all"></th>
												<th>{{ trans('notes_search.date') }}/{{ trans('notes_search.time') }}</th>
												<th>{{ trans('notes_search.user_name') }}</th>
												<th>{{ trans('notes_search.client') }}</th>
												<th>{{ trans('notes_search.note_type') }}</th>
												<th>{{ trans('notes_search.notes') }}</th></th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									  </div>
									</div>
								</div>
							</div>
						</div>
					</section>					
				  </form>
			</div>
			<!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
		
		<!-- Modal with Card -->
		
	
@endsection

@section('scripts')
@parent	
<script type="text/javascript">	
	$(document).ready(function () {
		let table = $('#jsGridNotesSearch').DataTable({
			dom: 'rtp',
			processing: true,
			serverSide: true,
			"ajax": {
				url: '{{ route('admin.notes-search.getNotesSearchList') }}',
				data: function (d) {
					d.filter_from = $('#filter_from').val();
					d.filter_to = $('#filter_to').val();
					d.filter_search = $('#filter_search').val();
					d.filter_case_type = $('#filter_case_type').val();
					d.filter_notes_category = $('#filter_notes_category').val();
					d.filter_user = $('#filter_user').val();
				}
			},
			"autoWidth": false,
			"aaSorting": [[2, "desc"]],
			columns: [				
				{ data: 'checkbox', name: 'checkbox', visible:false, orderable:false, searchable:false },
				{ data: 'created', name: 'created', orderable:false, },
				{ data: 'user_name', name: 'user_name', orderable:false, },
				{ data: 'client', name: 'client', orderable:false, },
				{ data: 'note_type', name: 'note_type', orderable:false, },
				{ data: 'notes', name: 'notes', orderable:false, },
			],
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "All"] // change per page values here
			],
			// set the initial value
			"pageLength": 10,
			"sPaginationType": "full_numbers",
			"columnDefs": [{  // set default column settings
				'orderable': true,
				'targets': [0]
			}, {  // set default column settings
				'targets': [2],
				"visible": true,
				"searchable": false
			}
			],
			"fnInitComplete": function () {
				$(".dataTables_length").addClass("hidden-xs");
				$(this).removeClass("hidden");
			},
			"order": [
				[2, "DESC"]
			]
		});
		
		//Handle Select All
		$('#select-all').on('click', function() {
			var rows = table.rows({'search':'applied'}).nodes();
			$('input[type="checkbox"].user-checkbox', rows).prop('checked',this.checked);
		});
		
		$('#notesSearchForm').on('submit', function (e) {
			e.preventDefault();			
			$('#formLoader').removeClass('d-none');
			table.ajax.reload(function () {
				$('#formLoader').addClass('d-none');
			});
		});
		
		$('#resetnotesSearchForm').on('click', function () {
			$('#notesSearchForm')[0].reset();
			$('#notesSearchForm .select2').val(null).trigger('change');
			//$('#filter_from').datepicker('setDate', null);
			//$('#filter_to').datepicker('setDate', null);
			table.ajax.reload();
		});
		
		$('#resetnotesSearchForm').on('click', function () {
			$('#notesSearchForm')[0].reset();
			$('#notesSearchForm .select2').val(null).trigger('change');
			//$('#filter_from').datepicker('setDate', null);
			//$('#filter_to').datepicker('setDate', null);
			table.ajax.reload();
		});
		
		$('#exportNotes').on('click', function (e) {
			e.preventDefault();

			const isValid = validateInputs('notesSearchForm');
			if (!isValid) return;

			const form = document.getElementById('notesSearchForm');
			const formData = new FormData(form);

			fetch('{{ route('admin.notes-search.exportSearchedNotes') }}', {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				body: formData
			})
			.then(response => {
				if (!response.ok) {
					throw new Error('Network response was not ok');
				}
				const disposition = response.headers.get('Content-Disposition');
				let filename = 'notes_export.csv'; // fallback

				if (disposition && disposition.indexOf('filename=') !== -1) {
					const match = disposition.match(/filename="(.+)"/);
					if (match.length > 1) filename = match[1];
				}

				return response.blob().then(blob => ({ blob, filename }));
			})
			.then(({ blob, filename }) => {
				const url = window.URL.createObjectURL(blob);
				const a = document.createElement('a');
				a.href = url;
				a.download = filename;
				document.body.appendChild(a);
				a.click();
				a.remove();
			})
			.catch(error => {
				console.error('Export failed:', error);
			});
		});


		
	});
</script>

@endsection
