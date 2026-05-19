@extends('layouts.admin')

@section('title', "{{ trans('intake.new_intake_wizard') }}")

@section('content')
 <div class="page-header">
                    <div class="page-header-content d-lg-flex">
                        <div class="d-flex">
                            <h4 class="page-title mb-0">
                                {{ trans('intake.new_intake_wizard') }} - <span class="fw-normal">{{ trans('intake.create') }}</span>
                            </h4>

                            <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                            </a>
                        </div>

                      
                    </div>
                </div>
    <!-- Main content -->
		<section class="content pt-0">

			<div class="row">
			  <!-- left column -->
			  <div class="col-md-12">
				<!-- jquery validation -->
				<div class="card card-primary">
					<div class="card-body">
				  <!-- /.card-header -->
				  <!-- form start -->
				  <form id="createIntakeForm" method="POST" action="{{ route('admin.intakes.store') }}">
					@csrf
					<div class="mb-3">
						<div class="row">
						  <div class="col-4">
							<label class="form-label" for="case_role">{{ trans('intake.primary_contact') }} - {{ trans('intake.case_role') }}</label>
							<select name="case_role" class="form-control" id="case_role">
								<option value="">{{ trans('global.select') }}</option>
									@if(isset($intake_values['case_role']) && !empty($intake_values['case_role']))
										@foreach($intake_values['case_role'] as $key=>$value)
											<option @if(old('case_role')==$key) selected @endif  value="{{$key}}">{{$value}}</option>
										@endforeach
									@endif
							</select>
							@error('case_role')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						</div>
					</div>
					<div class="mb-3">
						<div class="row">
						  <div class="col-4">
							<label class="form-label" for="case_type">{{ trans('intake.select_the_case_type_for_this_intake') }} <span class="required text-danger">*</span></label>
							<select name="case_type" class="form-control" id="case_type" data-required="true">
								<option value="">{{ trans('global.select') }}</option>
								@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
									@foreach($intake_values['case_type'] as $key=>$value)
										<option @if(old('case_type')==$key) selected @endif  value="{{$key}}">{{$value}}</option>
									@endforeach
								@endif
							</select>
							@error('case_type')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						  <div class="col-4">
							<label class="form-label" for="status">{{ trans('intake.status') }} <span class="required text-danger">*</span></label>
							<select name="status" class="form-control" id="status" data-required="true">
								<option value="">{{ trans('global.select') }}</option>
								@if(isset($intake_values['status']) && !empty($intake_values['status']))
									@foreach($intake_values['status'] as $key=>$value)
										<option @if(old('status')==$key) selected @endif  value="{{$key}}">{{$value}}</option>
									@endforeach
								@endif
							</select>
							@error('status')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						  <div class="col-4">
							<label class="form-label" for="marketing_source">{{ trans('intake.marketing_source') }} <span class="required text-danger">*</span></label>
							<select name="marketing_source" class="form-control" id="marketing_source" data-required="true">
								<option value="">{{ trans('global.select') }}</option>
								@if(isset($intake_values['marketing_source']) && !empty($intake_values['marketing_source']))
									@foreach($intake_values['marketing_source'] as $options)
										<option @if(old('marketing_source')==$options->id) selected @endif value="{{$options->id}}" >{{$options->value}}</option>
									@endforeach
								@endif
							</select>
							@error('marketing_source')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						</div>
					</div>
					<div class="mb-3">
						<div class="row">
						  <div class="col-4">
							<label class="form-label" for="assignee">{{ trans('intake.assignee') }} <span class="required text-danger">*</span></label>
							<select name="assignee" class="form-control" id="assignee" data-required="true">
								<option value="">{{ trans('global.select') }}</option>
								@if($assignee_list)
									@foreach($assignee_list as $key=>$value)
										<option @if(old('assignee')==$key) selected @endif value="{{$key}}">{{$value}}</option>
									@endforeach
								@endif
							</select>
							@error('assignee')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						  <div class="col-4">
							<label class="form-label" for="owner">{{ trans('intake.owner') }}</label>
							<select name="owner" class="form-control" id="owner">
								<option value="">{{ trans('global.select') }}</option>
								@if($owner_list)
									@foreach($owner_list as $key=>$value)
										<option @if(old('owner')==$key) selected @endif value="{{$key}}">{{$value}}</option>
									@endforeach
								@endif
							</select>
							@error('owner')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						  <div class="col-4">
							<label class="form-label" for="ad_campaign">{{ trans('intake.ad_campaign') }}</label>
							<select name="ad_campaign" class="form-control" id="ad_campaign">
								<option value="">{{ trans('global.select') }}</option>
								@if(isset($intake_values['ad_campaign']) && !empty($intake_values['ad_campaign']))
									@foreach($intake_values['ad_campaign'] as $options)
										<option @if(old('ad_campaign')==$options->id) selected @endif value="{{$options->id}}" >{{$options->value}}</option>
									@endforeach
								@endif
							</select>
							@error('ad_campaign')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						</div>
					</div>
					<div class="mb-3">
						<div class="row">
						  <div class="col-12">
							<label class="form-label" for="case_description">{{ trans('intake.case_description') }}</label>
							<textarea type="text" name="case_description" class="form-control" id="case_description" placeholder="Enter Case Description">{{old('case_description')}}</textarea>
							@error('case_description')
								<div class="error text-danger">{{$message}}</div>
							@enderror
						  </div>
						</div>
					</div>
					
					<div class="mb-3">
						<div class="row">
						  <div class="col-7">
							<label class="form-label mb-2"><i class="far fa-user" aria-hidden="true"></i> {{ trans('intake.choose_a_contact_that_will_be_the_client_on_this_intake') }} <a  href="javascript:;" class="createEditContact" onclick="createEditContactModal('create');">{{ trans('intake.don_t_see_your_contact') }}? {{ trans('intake.create_a_new_contact') }}</a></label>
							<div class="row mb-2">
							  <div class="col-6">
								<label class="form-label" for="contact_search">{{ trans('intake.search') }}</label>
								<input type="text" class="form-control" id="contact_search">
							  </div>
							  <div class="col-6">
								<label class="form-label" for="contact_type">{{ trans('intake.contact_type') }}</label>
								<select class="form-control" id="contact_type">
									<option value="">{{ trans('global.select') }}</option>
									@if($contact_type_list)
										@foreach($contact_type_list as $key=>$value)
											<option value="{{$key}}">{{$value}}</option>
										@endforeach
									@endif	
								</select>
							  </div>
							</div>
							<table class="table" id="jsGridContactSrchAdd">
								<thead>
									<tr>					
										<th>{{ trans('intake.contact_name') }}</th>
										<th>{{ trans('intake.contact_type') }}</th>
										<th>{{ trans('intake.e_mail') }}</th>
										<th>{{ trans('intake.primary_phone') }}</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						  </div>
						  <div class="col-5">
							<div id="contact_err_msg" class="text-danger" style="display:none;">
								<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
								{{ trans('intake.please') }}, {{ trans('intake.add_a_contact') }}:
								<ul>
									<li>Search for an existing Contact</li>
									<li>Create a new one</li>
									
								</ul>
							</div>
							<div id="contact_details" style="display:none;">
								<div class="row">
									<div class="col-12">
										<h5 class="mt-4 mb-2">{{ trans('intake.contact') }}</h5>
										<div class="card card-info">
											<div class="card-body">
												<input type="hidden" name="contact_id" id="contact_id" value="" />	
												<div class="mb-3">
													<div class="form-group">
														<label class="form-label" for="contact_name">{{ trans('intake.name') }}</label>
														<input type="text" name="contact_name" class="form-control" id="contact_name" readonly />
													</div>
													<div class="form-group">
														<label class="form-label" for="contact_phone">{{ trans('intake.cell_phone') }}</label>
														<input type="text" name="contact_phone" class="form-control" id="contact_phone" readonly />
													</div>
													<div class="form-group">
														<label class="form-label" for="contact_lang">{{ trans('intake.language') }}</label>
														<select name="contact_lang" class="form-control" id="contact_lang" readonly disabled style="cursor: auto;" >
															<option value="">{{ trans('global.select') }}</option>
															@if(isset($languages) && !empty($languages))
																@foreach($languages as $lang_id => $lang_name)
																	<option @if(old('contact_lang')==$lang_id) selected @endif value="{{$lang_id}}" >{{$lang_name}}</option>
																@endforeach
															@endif
														</select>
													</div>
													<div class="form-group">
														<label class="form-label" for="contact_email">{{ trans('intake.primary_email') }}</label>
														<input type="text" name="contact_email" class="form-control" id="contact_email" readonly />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						  </div>
						</div>
					</div>
					
					<div class="card-footer" style="background-color: #fff;">
					  <button type="submit" class="btn btn-primary">{{ trans('intake.create_intake') }}</button>
					  <div id="success_message"></div>
					</div>
				  </form>
				</div>
				</div>
				<!-- /.card -->
				</div>
			  <!--/.col (left) -->
			  <!-- right column -->
			  <div class="col-md-6">

			  </div>
			  <!--/.col (right) -->
			</div>
		</section>
		<!-- /.content -->
		
		<!-- Modal with Card -->
		@include('admin.intakes.components.modals.create-edit-contact-modal')
		@include('admin.intakes.components.modals.add-address-modal')
	
	
@endsection

@section('scripts')
@parent
	<script>
		const route = {
			admin: {
				contacts_store: "{{ route('admin.contacts.store') }}",
				contact_update: "{{ route('admin.contacts.contact_update') }}",
				addAddress: "{{ route('admin.contacts.addAddress') }}",
				contactAddressList: "{{ route('admin.contacts.contactAddressList') }}"	
			}
		}
	</script>
	<script src="{{asset('js/lead/create-edit-contact.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			let table = $('#jsGridContactSrchAdd').DataTable({
				dom: 'rtp', //rtip Bfrtip lfrtip
				processing: true,
				serverSide: true,
				scrollY: '400px',
				scrollX: true,
				scrollCollapse: true,
				select: false,
				"ajax": {
					url: '{{ route('admin.contacts.contactList') }}',
					data: function (d) {
						d.contact_search = $('#contact_search').val();
						d.contact_type = $('#contact_type').val();
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
			
			$('#contact_search').on('keyup', function() {
				table.draw();
			});
			$('#contact_type').on('change', function() {
				table.draw();
			});			
		});
		
		$('#createIntakeForm').on('submit', function(e) {
			e.preventDefault();
			$('.error-message').remove();
			let isValid=true;
			let contact_id = $('#contact_id').val();
			const inputs = document.querySelectorAll('#createIntakeForm [data-required="true"]');
			let errors = [];
			
			inputs.forEach(input => {
				if(!input.value.trim()) {
					isValid=false;
					const cleanName = input.name.replace(/_/g,' ').toLowerCase();
					$('#'+input.id).after('<div class="error-message text-danger">'+`The ${cleanName} field is required.`+'</div>');
				}
			});
			
			if(contact_id=='') {
				$('#contact_err_msg').show();
				$('#contact_details').hide();
				isValid=false;
			}		
			
			if(isValid) {
				this.submit();
			}
		});
		
		function getContactDetails(contact_id)
		{
			
			$('#contact_err_msg').hide();
			$('#contact_details').hide();
			
			$('#contact_id').val('');
			$('#contact_name').val('');
			$('#contact_phone').val('');
			$('#contact_lang').val('');
			$('#contact_email').val('');
			$.ajax({
			url:'{{ route('admin.contacts.contactDetails') }}',
				type:'POST',
				data: {
					'id':contact_id
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status=='success')
					{
						$('#contact_id').val(response.data.id);
						$('#contact_name').val(response.data.name);
						$('#contact_phone').val(response.data.phone);
						$('#contact_lang').val(response.data.language);
						$('#contact_email').val(response.data.email);
						
						$('#contact_details').show();
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	</script>
@endsection
