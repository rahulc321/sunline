@extends('layouts.admin')

@section('title', "{{ trans('intake.edit_intake_wizard') }}")

@section('content')
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
			  <!-- left column -->
			  <div class="col-md-12">
				<!-- jquery validation -->
				<div class="card card-primary">
				  @php
				  $page_heading = '';
				  if(isset($contact_data) && !empty($contact_data))
				  {
					  $page_heading = $page_heading.$contact_data->display_name;
				  }
				  @endphp	
				  <div class="card-header">
					<h3 class="card-title">{{$page_heading}} {{ trans('intake.lead') }}<small>&nbsp;</small></h3>
				  </div>
				  <!-- /.card-header -->
				  <!-- form start -->
				  <form id="createIntakeForm">
					@csrf
					@method('PUT')
					<section id="Overview">
						<div class="card-body">
							<div class="row">
							  <div class="col-12">
								<label class="card-title" for="case_description"><h5 class="m-0">{{ trans('intake.description') }}</h5></label>
								<textarea type="text" name="case_description" class="form-control" id="case_description" readonly>{{old('case_description',$lead_data->case_description)}}</textarea>
								@error('case_description')
									<div class="error text-danger">{{$message}}</div>
								@enderror
							  </div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
							  <div class="col-6">
								<div class="card card-primary card-outline">
								  <div class="card-header">
									<h5 class="m-0">{{ trans('intake.contact_information') }}</h5>
								  </div>
								  <div class="card-body">
									@if(isset($contact_data) && !empty($contact_data))
									<div class="form-group">
										<h6 class="card-title">{{ trans('intake.contact_name') }}</h6>
										<p class="card-text">{{$contact_data->display_name}}</p>
									</div>
									<div class="form-group">
										<h6 class="card-title">{{ trans('intake.primary_phone') }}</h6>
										<p class="card-text">{{$contact_data->phone}}</p>
									</div>
									<div class="form-group">
										<h6 class="card-title">{{ trans('intake.primary_email') }}</h6>
										<p class="card-text">{{$contact_data->email}}</p>
									</div>
									<div class="form-group">
										<h6 class="card-title">{{ trans('intake.address') }}</h6>
										<p class="card-text">&nbsp;</p>
									</div>
									<div class="row">
									  <div class="col-6">
										<div class="form-group">
											@php 
											$language_value = '';
											if($contact_data->language_value) {
												$language_value = $contact_data->language_value->name ? $contact_data->language_value->name : '';
											}
											@endphp
											<h6 class="card-title">{{ trans('intake.language') }}</h6>
											<p class="card-text">{{$language_value}}</p>
										</div>
									  </div>
									  <div class="col-6">
										<div class="form-group">
											<h6 class="card-title">{{ trans('intake.local_time') }}</h6>
											<p class="card-text">&nbsp;</p>
										</div>
									  </div>
									</div>
									<div class="row">
									  <div class="col-6">
										<div class="form-group">
											<h6 class="card-title">{{ trans('intake.contact_preference') }}</h6>
											<p class="card-text">{{$contact_data->contact_preference}}</p>
										</div>
									  </div>
									  <div class="col-6">
										<div class="form-group">
											<h6 class="card-title">{{ trans('intake.when_to_contact') }}</h6>
											<p class="card-text">{{$contact_data->whentocontact}}</p>
										</div>
									  </div>
									</div>
									@endif
								  </div>
								</div>
							  </div>
							  <div class="col-6">
								<div class="card card-primary card-outline">
								  <div class="card-header">
									<h5 class="m-0">{{ trans('intake.upcoming_events') }}</h5>
								  </div>
								  <div class="card-body">
									<h6 class="card-title">{{ trans('intake.no_upcoming_events') }}</h6>
									<p class="card-text">&nbsp;</p>
								  </div>
								</div>
							  </div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="card card-primary card-outline">
										<div class="card-header">
											<h5 class="m-0">{{ trans('intake.details') }}</h5>
										</div>
										<div class="card-body">
											<div class="row">
											  <div class="col-4">
												<label for="case_role">{{ trans('intake.primary_contact') }} - {{ trans('intake.case_role') }}</label>
												<select name="case_role" class="form-control" id="case_role" readonly disabled style="cursor: auto;" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['case_role']) && !empty($intake_values['case_role']))
														@foreach($intake_values['case_role'] as $key=>$value)
															<option @if(old('case_role',$lead_data->case_role)==$key) selected @endif  value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('case_role')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
											  <div class="col-4">
												<label for="case_type">{{ trans('intake.select_the_case_type_for_this_intake') }} <span class="required text-danger">*</span></label>
												<select name="case_type" class="form-control" id="case_type" readonly disabled style="cursor: auto;" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
															@foreach($intake_values['case_type'] as $key=>$value)
															<option @if(old('case_type',$lead_data->case_type)==$key) selected @endif  value="{{$key}}" >{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('case_type')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="contact_method">{{ trans('intake.contact_method') }}</label>
												<input type="text" name="contact_method" class="form-control" id="contact_method" value="{{old('contact_method',$lead_data->contact_method)}}" readonly />
												@error('contact_method')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="estimated_case_value">{{ trans('intake.estimated_case_value') }}</label>
												<input type="text" name="estimated_case_value" class="form-control" id="estimated_case_value" value="{{old('estimated_case_value',$lead_data->estimated_case_value)}}" readonly />
												@error('estimated_case_value')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
											  <div class="col-4">
												<label for="marketing_source">{{ trans('intake.marketing_source') }} <span class="required text-danger">*</span></label>
												<select name="marketing_source"  class="form-control" id="marketing_source" readonly disabled style="cursor:pointer;">
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['marketing_source']) && !empty($intake_values['marketing_source']))
														@foreach($intake_values['marketing_source'] as $options)
															<option @if(old('marketing_source',$lead_data->marketing_source)==$options->id) selected @endif value="{{$options->id}}" >{{$options->value}}</option>
														@endforeach
													@endif
												</select>
												@error('marketing_source')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="ad_campaign">{{ trans('intake.ad_campaign') }}</label>
												<select name="ad_campaign" class="form-control" id="ad_campaign" readonly disabled style="cursor: auto;" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['ad_campaign']) && !empty($intake_values['ad_campaign']))
														@foreach($intake_values['ad_campaign'] as $options)
															<option @if(old('ad_campaign',$lead_data->ad_campaign)==$options->id) selected @endif value="{{$options->id}}" >{{$options->value}}</option>
														@endforeach
													@endif
												</select>
												@error('ad_campaign')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="rating">{{ trans('intake.rating') }}</label>
												<select name="rating" class="form-control" id="rating" readonly disabled style="cursor:pointer;" >
													<option value="">{{ trans('global.select') }}</option>
													<option value="1" @if(old('rating',$lead_data->rating)==1) selected @endif >1</option>
													<option value="2" @if(old('rating',$lead_data->rating)==2) selected @endif >2</option>
													<option value="3" @if(old('rating',$lead_data->rating)==3) selected @endif >3</option>
													<option value="4" @if(old('rating',$lead_data->rating)==4) selected @endif >4</option>
												</select>
												@error('rating')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
											  <div class="col-4">
												<label for="status">{{ trans('intake.status') }}</label>
												<select name="status" class="form-control" id="status" readonly disabled style="cursor:pointer;" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['status']) && !empty($intake_values['status']))
														@foreach($intake_values['status'] as $key=>$value)
															<option @if(old('status',$lead_data->status)==$key) selected @endif  value="{{$key}}" >{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('status')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="call_outcomes">{{ trans('intake.call_outcome') }}</label>
												<select name="call_outcomes" class="form-control" id="call_outcomes" readonly disabled style="cursor:pointer;" >
													<option value="">Select</option>
													@if(isset($intake_values['lead_call_outcome']) && !empty($intake_values['lead_call_outcome']))
														@foreach($intake_values['lead_call_outcome'] as $key=>$value)
															<option @if(old('call_outcomes',$lead_data->call_outcomes)==$key) selected @endif  value="{{$key}}" >{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('call_outcomes')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="office_location">{{ trans('intake.office_location') }}</label>
												<select name="office_location" class="form-control" id="office_location" readonly disabled style="cursor:pointer;" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['office_location']) && !empty($intake_values['office_location']))
														@foreach($intake_values['office_location'] as $options)
															<option @if(old('office_location',$lead_data->office_location)==$options->id) selected @endif value="{{$options->id}}" >{{$options->value}}</option>
														@endforeach
													@endif
												</select>
												@error('office_location')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="card card-primary card-outline">
										<div class="card-header">
											<h5 class="m-0">{{ trans('intake.staff') }}</h5>
										</div>
										<div class="card-body">
											<div class="row">
											  <div class="col-4">
												<label for="assignee">{{ trans('intake.assignee') }} <span class="required text-danger">*</span></label>
												<select name="assignee" class="form-control" id="assignee"  readonly disabled style="cursor:pointer;" >
													<option value="">{{ trans('global.select') }}</option>
													@if($assignee_list)
														@foreach($assignee_list as $key=>$value)
															<option @if(old('assignee',$lead_data->assignee)==$key) selected @endif value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('assignee')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="owner">{{ trans('intake.owner') }}</label>
												<select name="owner" class="form-control" id="owner" readonly disabled style="cursor:pointer;" >
													<option value="">{{ trans('global.select') }}</option>
													@if($owner_list)
														@foreach($owner_list as $key=>$value)
															<option @if(old('owner',$lead_data->owner)==$key) selected @endif value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('owner')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="attorney">{{ trans('intake.attorney') }}</label>
												<select name="attorney" class="form-control" id="attorney"  readonly disabled style="cursor:pointer;" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['attorney']) && !empty($intake_values['attorney']))
														@foreach($intake_values['attorney'] as $options)
															<option @if(old('attorney',$lead_data->attorney)==$options->id) selected @endif  value="{{$options->id}}" >{{$options->value}}</option>
														@endforeach
													@endif
												</select>
												@error('attorney')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				  </form>
				</div>
				<!-- /.card -->
				</div>
			  <!--/.col (left) -->
			  <!-- right column -->
			  <div class="col-md-6">

			  </div>
			  <!--/.col (right) -->
			</div>
			<!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	
	
@endsection

@section('scripts')
@parent
	
@endsection
