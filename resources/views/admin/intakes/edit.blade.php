@extends('layouts.admin')

@section('title', "{{ trans('intake.edit_intake_wizard') }}")

@section('styles')
<style>
.context-card .avtar-initials {
	width:50px; height:50px; background-color: #6c757d; color: #fff; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content:center; border-radius: 50%; text-transform: uppercase;
}
.context-card .close-btn{
	position: absolute; top:-2px; right:0px; background:none; border: none; font-size: 18px; font-weight: bold; cursor: pointer; color: #888;
}
.context-card .close-btn:hover {
	color: #ff0000;
}
.fc .fc-timegrid-now-indicator-line {
	border-width:1px;
	border-color: var(--fc-now-indicator-color, red);
}
</style>
@endsection

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
					<h3 class="card-title">{{$page_heading}} {{ trans('intake.edit_lead') }}<small>&nbsp;</small></h3>
				  </div>
				  <!-- /.card-header -->
				  <!-- form start -->
				  <form id="createIntakeForm" method="POST" action="{{ route('admin.intakes.update',$lead_data->id) }}">
					@csrf
					@method('PUT')
					<input type="hidden" name="page_section" id="page_section" value="" />
					<section id="Overview">
						<div class="card-body">
							<div class="row">
							  <div class="col-12">
								<label class="card-title" for="case_description"><h5 class="m-0">{{ trans('intake.description') }}</h5></label>
								<textarea type="text" name="case_description" class="form-control" id="case_description" placeholder="{{ trans('intake_placeholder.enter_case_description') }}">{{old('case_description',$lead_data->case_description)}}</textarea>
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
									<div id="upcoming_events">
										<h6 class="card-title">{{ trans('intake.no_upcoming_events') }}</h6>
										<p class="card-text">&nbsp;</p>
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
											<h5 class="m-0">{{ trans('intake.details') }}</h5>
										</div>
										<div class="card-body">
											<div class="row">
											  <div class="col-4">
												<label for="case_role">{{ trans('intake.primary_contact') }} - {{ trans('intake.case_role') }}</label>
												<select name="case_role" class="form-control" id="case_role" >
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
												<select name="case_type" class="form-control" id="case_type" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
														@foreach($intake_values['case_type'] as $key=>$value)
															<option @if(old('case_type',$lead_data->case_type)==$key) selected @endif  value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('case_type')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="contact_method">{{ trans('intake.contact_method') }}</label>
												<input type="text" name="contact_method" class="form-control" id="contact_method" value="{{old('contact_method',$lead_data->contact_method)}}" />
												@error('contact_method')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="estimated_case_value">{{ trans('intake.estimated_case_value') }}</label>
												<input type="text" name="estimated_case_value" class="form-control" id="estimated_case_value" value="{{old('estimated_case_value',$lead_data->estimated_case_value)}}" />
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
												<input type="hidden" name="marketing_source" value="{{$lead_data->marketing_source}}">
												<select class="form-control" id="marketing_source" readonly disabled style="cursor:pointer;">
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
												<select name="ad_campaign" class="form-control" id="ad_campaign" >
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
												<select name="rating" class="form-control" id="rating" >
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
												<select name="status" class="form-control" id="status" >
													<option value="">{{ trans('global.select') }}</option>
													@if(isset($intake_values['status']) && !empty($intake_values['status']))
														@foreach($intake_values['status'] as $key=>$value)
															<option @if(old('status',$lead_data->status)==$key) selected @endif  value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
												@error('status')
													<div class="error text-danger">{{$message}}</div>
												@enderror
											  </div>
											  <div class="col-4">
												<label for="call_outcomes">{{ trans('intake.call_outcome') }}</label>
												<select name="call_outcomes" class="form-control" id="call_outcomes" >
													<option value="">{{ trans('global.select') }}</option>
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
												<select name="office_location" class="form-control" id="office_location" >
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
												<select name="assignee" class="form-control" id="assignee" >
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
												<select name="owner" class="form-control" id="owner" >
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
												<select name="attorney" class="form-control" id="attorney" >
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
					
					@include('admin.intakes.components.sections.related-contacts')
					@include('admin.intakes.components.sections.form')
					@include('admin.intakes.components.sections.key-dates')
					@include('admin.intakes.components.sections.notes')
					@include('admin.intakes.components.sections.events')
					@include('admin.intakes.components.sections.tasks')
					@include('admin.intakes.components.sections.documents')
					@include('admin.intakes.components.sections.communications')
					@include('admin.intakes.components.sections.finance')
					@include('admin.intakes.components.sections.activity-logs')
					
					<div class="card-footer" style="background-color: #fff;">
					  <button type="submit" class="btn btn-primary">Update Lead</button>
					  <div id="success_message"></div>
					</div>
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
		
		<!-- Modal with Card -->
		@include('admin.intakes.components.modals.create-edit-contact-modal')
		@include('admin.intakes.components.modals.add-address-modal')
		@include('admin.intakes.components.modals.related-contact-modal')
		@include('admin.intakes.components.modals.key-dates-modal')
		@include('admin.intakes.components.modals.form-section-modal')
		@include('admin.intakes.components.modals.notes-section-modal')
		@include('admin.intakes.components.modals.tasks-section-modal')
		@include('admin.intakes.components.modals.events-section-modal')
		@include('admin.intakes.components.modals.finance-section-modal')
		@include('admin.intakes.components.modals.document-section-modal')
		@include('admin.intakes.components.modals.communications-section-modal')
		@include('admin.common.modals.upload-document-modal')
	
@endsection

@section('scripts')
@parent
	<script>
		const lead_id = "{{$lead_data->id}}";
		let root_document_folder_id = "{{ @$root_document_folder['id'] }}";
		const contact_name = "{{$contact_data->first_name}} {{$contact_data->last_name}}";
		const route = {
			admin: {
				lead_key_date_type_list: "{{ route('admin.lead_key_date_type.list') }}",
				lead_key_date_type_add: "{{ route('admin.lead_key_date_type.add') }}",
				lead_key_date_list: "{{ route('admin.lead_key_date.list') }}",
				contacts_store: "{{ route('admin.contacts.store') }}",
				contact_update: "{{ route('admin.contacts.contact_update') }}",
				leadRelatedContactList: "{{ route('admin.contacts.leadRelatedContactList') }}",
				contactList: "{{ route('admin.contacts.contactList') }}",
				contactDetails: "{{ route('admin.contacts.contactDetails') }}",
				addLeadContact: "{{ route('admin.contacts.addLeadContact') }}",
				changeCaseRole: "{{route('admin.intakes.changeCaseRole')}}",
				addAddress: "{{ route('admin.contacts.addAddress') }}",
				contactAddressList: "{{ route('admin.contacts.contactAddressList') }}",
				notes_update: "{{ route('admin.lead-notes.notes_update') }}",
				notesDetails: "{{ route('admin.lead-notes.notesDetails') }}",
				lead_notes_add: "{{ route('admin.lead-notes.store') }}",
				lead_notes_list: "{{ route('admin.lead-notes.list') }}",
				lead_notes_update_pinned_status: "{{ route('admin.lead-notes.update.pinned-status') }}",
				lead_tasks_add: "{{ route('admin.lead-tasks.store') }}",
				lead_tasks_list: "{{ route('admin.lead-tasks.list') }}",
				lead_events_add: "{{ route('admin.lead-events.store') }}",
				lead_events_list: "{{ route('admin.lead-events.list') }}",
				lead_events_count: "{{ route('admin.lead-events.count') }}",
				lead_event_type_color_list: "{{ route('admin.lead-events.color-type') }}",
				lead_event_type_list: "{{ route('admin.lead-events.type-list') }}",
				lead_event_type_add: "{{ route('admin.lead-events.type-add') }}",
				lead_event_calendar: "{{ route('admin.lead-events.calendar') }}",
				lead_print_data: "{{ route('admin.export-data.data') }}",
				lead_firm_add: "{{ route('admin.lead-firm.store') }}",
				lead_firm_list: "{{ route('admin.lead-firm.list') }}",
				lead_firm_update: "{{ route('admin.lead-firm.firm_update') }}",
				firms: "{{ route('admin.firm.list') }}",
				firmNameDetails: "{{ route('admin.firm.name.details') }}",
				lead_expense_add: "{{ route('admin.lead-expense.store') }}",
				lead_expense_list: "{{ route('admin.lead-expense.list') }}",
				lead_firm_details: "{{ route('admin.lead-firm.details') }}",
				lead_document_list: "{{ route('admin.lead-document.list') }}",
				lead_doc_esign_list: "{{ route('admin.lead-doc-esign.list') }}",
				lead_doc_esign_status_list: "{{ route('admin.lead-doc-esign-status.list') }}",
				lead_document_upload: "{{ route('admin.lead-document.upload') }}",
				esign: {
					GetSenders: "{{ route('admin.lead-esign.GetSenders') }}",
					GetRecipients: "{{ route('admin.lead-esign.GetRecipients') }}",
				},
				lead_communications_email_list: "{{ route('admin.lead-communications.email.list') }}",
				communications_send_text_msg: "{{ route('admin.communications.text-message.send') }}",
				communications_text_messages_list: "{{ route('admin.communications.text-message.list') }}",
				communications_text_messages_list_lead_id: "{{ route('admin.communications.text-message.list.lead-id') }}",
				activity_logs: "{{ route('admin.activity.logs') }}",
				lead_document_download: "{{ route('admin.documents.download') }}",
			}
		}
	</script>
	<script src="{{ asset('vendor/js/vendor/ui/fullcalendar/main.min.js') }}"></script>
	<script src="{{asset('js/lead/edit-lead.js')}}"></script>
	<script src="{{asset('js/lead/edit-lead-form-section.js')}}"></script>
	<script src="{{asset('js/lead/edit-lead-related-contact.js')}}"></script>
	<script src="{{asset('js/lead/create-edit-contact.js')}}"></script>
	<script src="{{asset('js/lead/edit-lead-key-dates.js')}}"></script>
	<script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
	<script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>	
	<script src="{{asset('js/lead/edit-lead-events.js')}}"></script>	
	<script src="{{asset('js/lead/event-calendar-location.js')}}"></script>	
	<script src="{{asset('js/lead/edit-lead-finance.js')}}"></script>	
	<script src="{{asset('js/lead/edit-lead-documents.js')}}"></script>	
	<script src="{{asset('js/lead/edit-lead-communications.js')}}"></script>	
	<script src="{{asset('js/lead/text-messages.js')}}"></script>	
	<script src="{{asset('js/lead/activity-log.js')}}"></script>	
	<script src="{{asset('js/lead/document-upload.js')}}"></script>	
	<script type="text/javascript">
		
	</script>
@endsection
