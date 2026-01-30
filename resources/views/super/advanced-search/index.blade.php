@extends('layouts.admin')

@section('title', "{{ trans('advanced_search.advanced_search') }}")

@section('styles')

@endsection

@section('content')
	<!--<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					{{ trans('advanced_search.advanced_search') }} <span class="fw-normal">&nbsp;</span>
				</h4>
			</div>
		</div>
	</div> -->
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
			  <!-- form start -->
				  <form id="advancedSearchForm" method="POST" action="javascript:;">
					@csrf
					<section id="advanced-search">
						<div class="col-12">
							<div class="card card-primary card-outline">
								
								<div class="card-body">
									<div class="row py-3">
										<div class="col-7">
											<div class="row">
											  <div class="col-6">
												<select name="filter_lead" id="filter_lead" class="form-control select2">
													<option value="" >{{ trans('advanced_search.all_leads') }}</option>
													<option value="open" >{{ trans('advanced_search.open_leads') }}</option>
													<option value="closed" >{{ trans('advanced_search.closed_leads') }}</option>
												</select>
											  </div>
											  <div class="col-6 d-flex align-items-center">
												<span class="mx-1">{{ trans('advanced_search.from') }}</span> <input type="date" class="form-control" name="filter_from" id="filter_from" placeholder="">
												<span class="mx-1">{{ trans('advanced_search.to') }}</span> <input type="date" class="form-control" name="filter_to" id="filter_to" placeholder="">
											  </div>
											</div>
										</div>
										<div class="col-5">
											<div class="d-flex justify-content-end align-items-center">
												<i style="color: goldenrod!important;" class="px-1 far fa-sticky-note ph-notebook"></i><a href="{{route('admin.notes-search.index')}}">{{ trans('advanced_search.go_to_notes_search') }}</a>
											</div>
										</div>
									</div>
									
									<div class="row px-4 py-2">
									  <div class="col-3">
										<select name="filter_case_type" id="filter_case_type" class="form-control select2">
											<option value="" >{{ trans('advanced_search.any_case') }}</option>
											@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
												@foreach($intake_values['case_type'] as $key=>$value)
													<option value="{{$key}}">{{$value}}</option>
												@endforeach
											@endif
										</select>
									  </div>
									  <div class="col-3">
										<select name="filter_user" id="filter_user" class="form-control select2">
											<option value="" >{{ trans('advanced_search.any_user') }}</option>
											@if(isset($users) && !empty($users))
												@foreach($users as $key=>$value)
													<option value="{{$key}}" >{{$value}}</option>
												@endforeach
											@endif
										</select>
									  </div>
									  <div class="col-3">
										<select name="filter_firm" id="filter_firm" class="form-control select2">
											<option value="" >{{ trans('advanced_search.any_firm') }}</option>
										</select>
									  </div>
									  <div class="col-3">
										<select name="filter_status" id="filter_status" class="form-control select2">
											<option value="">{{ trans('advanced_search.any_status') }}</option>
											@if(isset($intake_values['status']) && !empty($intake_values['status']))
												@foreach($intake_values['status'] as $key=>$value)
													<option value="{{$key}}">{{$value}}</option>
												@endforeach
											@endif
										</select>
									  </div>
									</div>
									
									<div class="row mt-2">
									  <div class="col-6">
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_lead_id">{{ trans('advanced_search.lead_id') }}# </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_lead_id" id="filter_lead_id" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_case_id">{{ trans('advanced_search.case_id') }}# </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_case_id" id="filter_case_id" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_case_name">{{ trans('advanced_search.case_name') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_case_name" id="filter_case_name" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_first_name">{{ trans('advanced_search.first_name') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_first_name" id="filter_first_name" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_middle_name">{{ trans('advanced_search.middle_name') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_middle_name" id="filter_middle_name" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_last_name">{{ trans('advanced_search.last_name') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_last_name" id="filter_last_name" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_suffix">{{ trans('advanced_search.suffix') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_suffix" id="filter_suffix" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_business_name">{{ trans('advanced_search.business_name') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_business_name" id="filter_business_name" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_mail_addr_1">{{ trans('advanced_search.mailing_address') }} 1 </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_mail_addr_1" id="filter_mail_addr_1" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_mail_addr_2">{{ trans('advanced_search.mailing_address') }} 2 </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_mail_addr_2" id="filter_mail_addr_2" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_city">{{ trans('advanced_search.city') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_city" id="filter_city" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_state">{{ trans('advanced_search.state') }} </label>
											</div>
											<div class="col-8">
												<select name="filter_state" id="filter_state" class="form-control select2">
													<option value="">{{ trans('advanced_search.select_state') }}</option>
													@if(isset($intake_values['state']) && !empty($intake_values['state']))
														@foreach($intake_values['state'] as $key=>$value)
															<option value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_zip">{{ trans('advanced_search.zip') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_zip" id="filter_zip" placeholder="">
											</div>
										</div>
									  </div>
									  <div class="col-6">
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_home_phone">{{ trans('advanced_search.home_phone') }} # </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_home_phone" id="filter_home_phone" placeholder="+1 (###) ###-####">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_business_phone">{{ trans('advanced_search.business_phone') }} # </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_business_phone" id="filter_business_phone" placeholder="+1 (###) ###-####">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_cell_phone">{{ trans('advanced_search.cell_phone') }} # </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_cell_phone" id="filter_cell_phone" placeholder="+1 (###) ###-####">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_primary_email">{{ trans('advanced_search.primary_email') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_primary_email" id="filter_primary_email" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_secondary_email">{{ trans('advanced_search.secondary_email') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_secondary_email" id="filter_secondary_email" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_where_to_contact">{{ trans('advanced_search.where_to_contact') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_where_to_contact" id="filter_where_to_contact" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_when_to_contact">{{ trans('advanced_search.when_to_contact') }} </label>
											</div>
											<div class="col-8">
												<input type="text" class="form-control" name="filter_when_to_contact" id="filter_when_to_contact" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_gender">{{ trans('advanced_search.gender') }} </label>
											</div>
											<div class="col-8">
												<select class="form-control" name="filter_gender" id="filter_gender">
													<option value="">{{ trans('advanced_search.select_gender') }}</option>
													<option value="F">F</option>
													<option value="M">M</option>
												</select>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_date_of_birth">{{ trans('advanced_search.date_of_birth') }} </label>
											</div>
											<div class="col-8">
												<input type="date" class="form-control" name="filter_date_of_birth" id="filter_date_of_birth" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_sol_date">{{ trans('advanced_search.sol_date') }} </label>
											</div>
											<div class="col-8">
												<input type="date" class="form-control" name="filter_sol_date" id="filter_sol_date" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_attorney">{{ trans('advanced_search.attorney') }} </label>
											</div>
											<div class="col-8">
												<select name="filter_attorney" id="filter_attorney" class="form-control select2">
													<option value="">{{ trans('advanced_search.select_attorney') }}</option>
													@if(isset($intake_values['attorney']) && !empty($intake_values['attorney']))
														@foreach($intake_values['attorney'] as $key=>$value)
															<option value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label for="filter_office_location">{{ trans('advanced_search.office_location') }} </label>
											</div>
											<div class="col-8">
												<select name="filter_office_location" id="filter_office_location" class="form-control select2">
													<option value="">{{ trans('advanced_search.select_office_location') }}</option>
													@if(isset($intake_values['office_location']) && !empty($intake_values['office_location']))
														@foreach($intake_values['office_location'] as $key=>$value)
															<option value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
									  </div>
									</div>
								</div>
								<div class="card-footer">
									<div id="formLoader" class="text-center d-none">
										<div class="spinner-border text-primary" role="status">
											<span class="visually-hidden">Loading...</span>
										</div>
									</div>

									<button type="submit" class="btn btn-secondary" id="advSrchFormSubmitBtn">{{ trans('global.submit') }}</button>
									<button type="button" class="btn btn-secondary mx-1" id="resetAdvancedSearchForm">{{ trans('global.reset') }}</button>
								</div>
							</div>
						</div>
						
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-6">
											<h5 class="m-0"><a href="javascript:;">{{ trans('advanced_search.advanced_leads_search') }}</a> </h5>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">
													
											</div>	
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
									  <div class="col-12">
										<table class="table" id="jsGridAdvancedSearch">
										<thead>
											<tr>	
												<th class="d-none"><input type="checkbox" id="select-all"></th>
												<th>{{ trans('advanced_search.first_name') }}</th>
												<th>{{ trans('advanced_search.last_name') }}</th>
												<th>{{ trans('advanced_search.created') }}</th>
												<th>{{ trans('advanced_search.source') }}</th>
												<th>{{ trans('advanced_search.status') }}</th>
												<th>{{ trans('advanced_search.type_of_case') }}</th>
												<th>{{ trans('advanced_search.lead_owner') }}</th>
												<th>{{ trans('advanced_search.current_assignee') }}</th>
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
		let table = $('#jsGridAdvancedSearch').DataTable({
			dom: 'rtp',
			processing: true,
			serverSide: true,
			"ajax": {
				url: '{{ route('admin.advanced-search.getAdvancedSearchList') }}',
				data: function (d) {
					d.filter_lead = $('#filter_lead').val();
					d.filter_from = $('#filter_from').val();
					d.filter_to = $('#filter_to').val();
					d.filter_case_type = $('#filter_case_type').val();
					d.filter_user = $('#filter_user').val();
					d.filter_firm = $('#filter_firm').val();
					d.filter_status = $('#filter_status').val();
					d.filter_lead_id = $('#filter_lead_id').val();
					d.filter_case_id = $('#filter_case_id').val();
					d.filter_case_name = $('#filter_case_name').val();
					d.filter_first_name = $('#filter_first_name').val();
					d.filter_middle_name = $('#filter_middle_name').val();
					d.filter_last_name = $('#filter_last_name').val();
					d.filter_suffix = $('#filter_suffix').val();
					d.filter_business_name = $('#filter_business_name').val();
					d.filter_mail_addr_1 = $('#filter_mail_addr_1').val();
					d.filter_mail_addr_2 = $('#filter_mail_addr_2').val();
					d.filter_city = $('#filter_city').val();
					d.filter_state = $('#filter_state').val();
					d.filter_zip = $('#filter_zip').val();
					d.filter_home_phone = $('#filter_home_phone').val();
					d.filter_business_phone = $('#filter_business_phone').val();
					d.filter_cell_phone = $('#filter_cell_phone').val();
					d.filter_primary_email = $('#filter_primary_email').val();
					d.filter_secondary_email = $('#filter_secondary_email').val();
					d.filter_where_to_contact = $('#filter_where_to_contact').val();
					d.filter_when_to_contact = $('#filter_when_to_contact').val();
					d.filter_gender = $('#filter_gender').val();
					d.filter_date_of_birth = $('#filter_date_of_birth').val();
					d.filter_sol_date = $('#filter_sol_date').val();
					d.filter_attorney = $('#filter_attorney').val();
					d.filter_office_location = $('#filter_office_location').val();
				}
			},
			"autoWidth": false,
			"aaSorting": [[7, "desc"]],
			columns: [				
				{ data: 'checkbox', name: 'checkbox', visible:false, orderable:false, searchable:false },
				{ data: 'first_name', name: 'first_name', orderable:false },
				{ data: 'last_name', name: 'last_name', orderable:false },
				{ data: 'created', name: 'created', orderable:false },
				{ data: 'source', name: 'source', orderable:false },
				{ data: 'status', name: 'status', orderable:false },
				{ data: 'case_type', name: 'case_type', orderable:false },
				{ data: 'owner', name: 'owner', orderable:false },
				{ data: 'assignee', name: 'assignee', orderable:false },
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
				'targets': [7],
				"visible": true,
				"searchable": false
			}
			],
			"fnInitComplete": function () {
				$(".dataTables_length").addClass("hidden-xs");
				$(this).removeClass("hidden");
			},
			"order": [
				[7, "DESC"]
			]
		});
		
		//Handle Select All
		$('#select-all').on('click', function() {
			var rows = table.rows({'search':'applied'}).nodes();
			$('input[type="checkbox"].user-checkbox', rows).prop('checked',this.checked);
		});
		
		$('#filter_lead, #filter_case_type, #filter_user, #filter_firm, #filter_status').on('change', function (e) {
			e.preventDefault();			
			$('#formLoader').removeClass('d-none');
			table.ajax.reload(function () {
				$('#formLoader').addClass('d-none');
			});
		});
		
		$('#advancedSearchForm').on('submit', function (e) {
			e.preventDefault();			
			$('#formLoader').removeClass('d-none');
			table.ajax.reload(function () {
				$('#formLoader').addClass('d-none');
			});
		});
		
		$('#resetAdvancedSearchForm').on('click', function () {
			$('#advancedSearchForm')[0].reset();
			$('#advancedSearchForm .select2').val(null).trigger('change');
			//$('#filter_from').datepicker('setDate', null);
			//$('#filter_to').datepicker('setDate', null);
			table.ajax.reload();
		});

		
	});
</script>

@endsection
