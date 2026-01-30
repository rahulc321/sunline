@extends('layouts.admin')

@section('title', 'Appointment Setting')

@section('styles')

@endsection

@section('content')
	<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<div class="page-title mb-0">
					Please use "C" for Confirm, "R" for Reschedule and "Q" for Questions in your first SMS Text to the appointment recipient. CRM will read these letters in replies and creates tasks accordingly.
				</div>
			</div>
		</div>
	</div>
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
				<section id="Agenda">					
					<div class="col-12">
						<div class="card card-primary card-outline">
							<div class="card-header">
								<h5 class="m-0">Event Types</h5>
							</div>
							<div class="card-body">
								<div class="row">
								  <form method="post" name="addCalenEventsType" id="addCalenEventsType" action="{{ route('admin.lead-events.type-add') }}">	
								  <div class="col-12 d-flex">
									<div class="col-5 me-2">
										<label for="event_type_name">Event Type Name </label>
										<input type="text" name="event_type_name" id="event_type_name" class="form-control" data-required="true" />
										<div class="error-message text-danger" id="error_event_type_name"></div>
									</div>
									
									<div class="col-5 me-2">
										<label for="event_type_color">Event Type Color </label>
										<select name="event_type_color" id="event_type_color" class="form-control select2">
											<option value="">Select</option>
											@if($event_type_color_list)
												@foreach($event_type_color_list as $etcollist)
												<option value="{{$etcollist->id}}">{{$etcollist->title}}</option>
												@endforeach	
											@endif	
										</select>
										<div class="error-message text-danger" id="error_event_type_color"></div>
									</div>
									
									<div class="col-2 me-2">
										<label>&nbsp;</label>
										<button type="submit" class="btn btn-primary me-2">+ Add Event Type</button>
									</div>
								  </div>
								  </form>
								  <div class="col-12 my-2">
									<table class="table" id="jsGridCalendarEventTypeList">
										<thead>
											<tr>					
												<th>Event Type</th>
												<th>Color</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								  </div>
							</div>
						</div>
					</div>
					
					<div class="col-12">
						<div class="card card-primary card-outline">
							<div class="card-header">
								<div class="row">
									<div class="col-6">
										<h5 class="card-title">Manage Event Type Rules</h5>
									</div>
									<div class="col-6">
										<div class="d-flex justify-content-end align-items-center">
											<button type="button" class="btn btn-primary float-right" href="javascript:;" data-bs-toggle="modal" data-bs-target="#calenEventTypeRule" id="btnAddEventTypeRule">+ Add Rule</button>
										</div>		
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
								  <div class="col-12">
									<table class="table" id="jsGridCalendarEventTypeRuleList">
										<thead>
											<tr>					
												<th>Event Type</th>
												<th>Status Change</th>
												<th>Appointment Reminders</th>
												<th>&nbsp;</th>
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
					
					<div class="col-12">
						<div class="card card-primary card-outline">
							<div class="card-header">
								<h5 class="m-0">Appointlet Settings - Third-Party Integration</h5>
							</div>
							<div class="card-body">
								<div class="row">
								  <div class="col-4">
									<label for="appointlet_switch">Show Global Appointlet Calendar Folder </label>
								  </div>
								  <div class="col-2">
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" name="appointlet_switch" id="appointlet_switch" {{ old('appointlet_switch', $appointment_settings->appointlet_switch ?? false) ? 'checked' : '' }} />
									</div>
								  </div>
								</div>
							</div>
						</div>
					</div>
					
					<form method="post" name="saveAppointmentReminderSettingsForm" id="saveAppointmentReminderSettingsForm" action="{{ route('admin.appointment.settings.save') }}">	
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h5 class="m-0">Appointment Reminder Settings</h5>
								</div>
								<div class="card-body">
									<div class="row mb-2">
									  <div class="col-12">
										<div class="d-flex">
											<div>
												<input class="checkbox" type="checkbox" name="remind_lead_assignee" {{ old('remind_lead_assignee', $appointment_settings->remind_lead_assignee ?? false) ? 'checked' : '' }}> Lead Assignee
											</div>
											<div class="mx-2">
												<input class="checkbox" type="checkbox" name="remind_lead_owner" {{ old('remind_lead_owner', $appointment_settings->remind_lead_owner ?? false) ? 'checked' : '' }} > Lead Owner
											</div>
											<div class="mx-2">
												<input class="checkbox" type="checkbox" name="remind_lead" {{ old('remind_lead', $appointment_settings->remind_lead ?? false) ? 'checked' : '' }}> Lead
											</div>
											<div>
												<input class="checkbox" type="checkbox" name="remind_loggedin_user" {{ old('remind_loggedin_user', $appointment_settings->remind_loggedin_user ?? false) ? 'checked' : '' }} > Logged In User
											</div>
										</div>
									  </div>
									</div>
											   
									<div class="row mb-2">
									  <div class="col-12">
										<label for="reminder_other_emails" class="mb-1">Other Emails separated by commas </label>
										<input type="text" name="reminder_other_emails" id="reminder_other_emails" class="form-control" value="{{ old('reminder_other_emails', $appointment_settings->reminder_other_emails ?? '') }}" placeholder="Other Emails separated by commas" />
									  </div>
									</div>
									<div class="row">
									  <div class="col-12">
										<input class="checkbox" type="checkbox" name="remind_instant_ics" {{ old('remind_instant_ics', $appointment_settings->remind_instant_ics ?? false) ? 'checked' : '' }} > Instant ICS Email for Appointment
									  </div>
									</div>
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</div>
						</div>
					</form>
					
					<form method="post" name="saveAppointmentCancellationSettingsForm" id="saveAppointmentCancellationSettingsForm" action="{{ route('admin.appointment.settings.save') }}">	
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h5 class="m-0">Cancellation Settings</h5>
								</div>
								<div class="card-body">
									<div class="row mb-2">
									  <div class="col-2">
										<label for="cancellation_change_status">Change Status </label>
									  </div>
									  <div class="col-2">
										<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" name="cancellation_change_status" id="cancellation_change_status" {{ old('cancellation_change_status', $appointment_settings->cancellation_change_status ?? false) ? 'checked' : '' }} />
										</div>
									  </div>
									</div>
											   
									<div class="row mb-2">
									  <div class="col-12">
										<label for="cancellation_email_subject" class="mb-1">Email Subject: <span class="required text-danger">*</span> </label>
										<input type="text" name="cancellation_email_subject" id="cancellation_email_subject" class="form-control" value="{{ old('cancellation_email_subject', $appointment_settings->cancellation_email_subject ?? '') }}" placeholder="Other Emails separated by commas" />
									  </div>
									</div>
									
									<div class="row mb-2">
									  <div class="col-12">
										<label for="cancellation_email_body" class="mb-1">Email Body(Start With Line): <span class="required text-danger">*</span> </label>
										<input type="text" name="cancellation_email_body" id="cancellation_email_body" class="form-control" value="{{ old('cancellation_email_body', $appointment_settings->cancellation_email_body ?? '') }}" placeholder="Other Emails separated by commas" />
									  </div>
									</div>
									
									<div class="row mb-2">
									  <div class="col-12">
										<label for="cancellation_notification" class="mb-1">On/Off Notification: </label>
										<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" name="cancellation_notification" id="cancellation_notification" {{ old('cancellation_notification', $appointment_settings->cancellation_notification ?? false) ? 'checked' : '' }} />
										</div>
									  </div>
									</div>
									
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</div>
						</div>
					</form>
				</section>					
			  </div>
			<!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
		
		<!-- Modal with Card -->
		<div class="modal fade" id="calenEventTypeRule" tabindex="-1" role="dialog" aria-labelledby="calenEventTypeRule" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content card card-primary">
			<form name="calenEventTypeRuleForm" id="calenEventTypeRuleForm" method="post" action="{{ route('admin.lead-event-type.rule-add') }}" >
			  @csrf
			  <div class="card-header">
				<h3 class="card-title">Event Type Rule</h3>
				<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="card-body">
				<div class="row mt-2">
				  <div class="col-12">
					<label for="etr_event_type">Event Type <span class="required text-danger">*</span> </label>
					<select name="etr_event_type" id="etr_event_type" class="form-control select2" data-required="true">
						<option value="">Select</option>
						@if(isset($event_type_list) && !empty($event_type_list))
							@foreach($event_type_list as $key=>$value)
								<option value="{{$key}}" {{ (in_array($key, old('etr_event_type', []))) ? 'selected' : '' }} data-name="{{ $value }}">{{$value}}</option>
							@endforeach
						@endif
					</select>
					<div class="error-message text-danger" id="error_etr_event_type"></div>
				  </div>
				</div>
				<div class="row mt-2">
				  <div class="col-12">
					<label for="etr_lead_status">Status <span class="required text-danger">*</span> </label>
					<select name="etr_lead_status" id="etr_lead_status" class="form-control select2" data-required="true">
						<option value="">Select</option>
						@if(isset($lead_status_list) && !empty($lead_status_list))
							@foreach($lead_status_list as $key=>$value)
								<option value="{{$key}}" {{ (in_array($key, old('etr_lead_status', []))) ? 'selected' : '' }} data-name="{{ $value }}">{{$value}}</option>
							@endforeach
						@endif
					</select>
					<div class="error-message text-danger" id="error_etr_lead_status"></div>
				  </div>
				</div>
				<div class="row mb-2">
				  <div class="col-12">
					<label for="etr_appointment_reminder" class="mb-1">Appointment Reminders <span class="required text-danger">*</span> </label>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" name="etr_appointment_reminder" id="etr_appointment_reminder" {{ old('etr_appointment_reminder', $appointment_settings->etr_appointment_reminder ?? false) ? 'checked' : '' }} />
					</div>
					<div class="error-message text-danger" id="error_etr_appointment_reminder"></div>
				  </div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary" id="btnSaveEventTypeRule">Save</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Discard Changes</button>
			</div>
			</form>
			</div>
		  </div>
		</div>
		
		<div class="modal fade" id="calenEventTypeRuleEdit" tabindex="-1" role="dialog" aria-labelledby="calenEventTypeRuleEdit" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content card card-primary">
			<form name="calenEventTypeRuleFormEdit" id="calenEventTypeRuleFormEdit" method="post" action="{{ route('admin.lead-event-type.rule-add') }}" >
			  @csrf
			  <input type="hidden" name="event_type_rule_id" id="event_type_rule_id" />
			  <div class="card-header">
				<h3 class="card-title">Event Type Rule</h3>
				<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="card-body">
				<div class="row mt-2">
				  <div class="col-12">
					<label for="etre_event_type">Event Type <span class="required text-danger">*</span> </label>
					<select name="etre_event_type" id="etre_event_type" class="form-control select2" data-required="true">
						<option value="">Select</option>
						@if(isset($event_type_list) && !empty($event_type_list))
							@foreach($event_type_list as $key=>$value)
								<option value="{{$key}}" {{ (in_array($key, old('etre_event_type', []))) ? 'selected' : '' }} data-name="{{ $value }}">{{$value}}</option>
							@endforeach
						@endif
					</select>
					<div class="error-message text-danger" id="error_etre_event_type"></div>
				  </div>
				</div>
				<div class="row mt-2">
				  <div class="col-12">
					<label for="etre_lead_status">Status <span class="required text-danger">*</span> </label>
					<select name="etre_lead_status" id="etre_lead_status" class="form-control select2" data-required="true">
						<option value="">Select</option>
						@if(isset($lead_status_list) && !empty($lead_status_list))
							@foreach($lead_status_list as $key=>$value)
								<option value="{{$key}}" {{ (in_array($key, old('etre_lead_status', []))) ? 'selected' : '' }} data-name="{{ $value }}">{{$value}}</option>
							@endforeach
						@endif
					</select>
					<div class="error-message text-danger" id="error_etre_lead_status"></div>
				  </div>
				</div>
				<div class="row mb-2">
				  <div class="col-12">
					<label for="etre_appointment_reminder" class="mb-1">Appointment Reminders <span class="required text-danger">*</span> </label>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" name="etre_appointment_reminder" id="etre_appointment_reminder" {{ old('etre_appointment_reminder', $appointment_settings->etre_appointment_reminder ?? false) ? 'checked' : '' }} />
					</div>
					<div class="error-message text-danger" id="error_etre_appointment_reminder"></div>
				  </div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary" id="btnSaveEventTypeRuleEdit">Update</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Discard Changes</button>
			</div>
			</form>
			</div>
		  </div>
		</div>
		
	
@endsection

@section('scripts')
@parent	
<script>
const route = {
		admin: {
			lead_event_type_list: "{{ route('admin.lead-events.type-list') }}",
			lead_event_type_add: "{{ route('admin.lead-events.type-add') }}",
			lead_event_type_rule_add: "{{ route('admin.lead-event-type.rule-add') }}",
			lead_event_type_rule_list: "{{ route('admin.lead-event-type.rule-list') }}",
			lead_event_type_rule_details: "{{ route('admin.lead-event-type.rule-details') }}",
			lead_event_type_rule_update: "{{ route('admin.lead-event-type.rule-update') }}",
			lead_event_type_rule_delete: "{{ route('admin.lead-event-type.rule-delete') }}",
			appointment_settings_save: "{{ route('admin.appointment.settings.save') }}",
		}
	}
</script>	
<script src="{{asset('js/calendar/appointment-settings.js')}}"></script>

@endsection
