@extends('layouts.admin')

@section('title', 'Contacts')

@section('content')

	<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					Calendar <span class="fw-normal">&nbsp;</span>
				</h4>
			</div>
		</div>
	</div>
	
    <!-- Main content -->
	<section class="content">
	  <div class="card">
		<!-- /.card-header -->
		<div class="card-body">
		  <div class="row">
			  <div class="col-4">
				<div id='calendar'></div>
				<div id='calendar-accordion' class="mt-3">
					<div class="accordion" id="accordionExample">
					  <div class="accordion-item">
						<h2 class="accordion-header d-flex" id="headingSharedCalendar">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sharedCalendar" aria-expanded="false" aria-controls="sharedCalendar">
							<i class="far fa-bars ph-list"></i> Shared Calendar
						  </button>
						  <div style="padding: var(--accordion-btn-padding-y) var(--accordion-btn-padding-x);">
							<i class="ph-calendar "></i>
						  </div>
						</h2>
						<div id="sharedCalendar" class="accordion-collapse collapse" aria-labelledby="headingSharedCalendar" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<span class="notfound"> No Folders Found</span>
						  </div>
						</div>
					  </div>
					  <div class="accordion-item">
						<h2 class="accordion-header d-flex" id="headingMyCalendar">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#myCalendar" aria-expanded="false" aria-controls="myCalendar">
							<i class="far fa-bars ph-list"></i> My Calendar
						  </button>
						  <div style="padding: var(--accordion-btn-padding-y) var(--accordion-btn-padding-x);">
							<i class="ph-calendar "></i>
						  </div>
						</h2>
						<div id="myCalendar" class="accordion-collapse collapse" aria-labelledby="headingMyCalendar" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<div class="d-flex">
								<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#calenSharPermiss" class="d-flex">
								<input class="checkbox" type="checkbox" checked name="mycalenuser" data-uid="{{auth()->user()->id}}">
								<div class="mx-1" >{{auth()->user()->name}}</div><i class="far fa-user-edit calendar-folder-permission"></i></a>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="accordion-item">
						<h2 class="accordion-header d-flex" id="headingOtherUsersCalendars">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#otherUsersCalendars" aria-expanded="false" aria-controls="otherUsersCalendars">
							<i class="far fa-bars ph-list"></i> Other User's Calendars
						  </button>
						  <div style="padding: var(--accordion-btn-padding-y) var(--accordion-btn-padding-x);">
							<i class="ph-calendar "></i>
						  </div>
						</h2>
						<div id="otherUsersCalendars" class="accordion-collapse collapse" aria-labelledby="headingOtherUsersCalendars" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<span class="notfound"> No Folders Found</span>
						  </div>
						</div>
					  </div>
					  <div class="accordion-item">
						<h2 class="accordion-header d-flex" id="headingGroupCalendars">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#groupCalendars" aria-expanded="false" aria-controls="groupCalendars">
							<i class="far fa-bars ph-list"></i> Group Calendars
						  </button>
						  <div style="padding: var(--accordion-btn-padding-y) var(--accordion-btn-padding-x);">
							<i class="ph-calendar "></i>
						  </div>
						</h2>
						<div id="groupCalendars" class="accordion-collapse collapse" aria-labelledby="headingGroupCalendars" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<span class="notfound"> No Folders Found</span>
						  </div>
						</div>
					  </div>
					</div>
				</div>
			  </div>	
			  <div class="col-8">
				<!-- Refresh Button and Loader -->
				<div class="d-flex justify-content-end align-items-center mb-2">
					<button id="refreshCalendarBtn" class="btn btn-primary me-2">
						<i class="ph-arrows-clockwise"></i>
					</button>
					<a href="{{ route('admin.appointment.settings') }}" id="appointmentSettingBtn" class="btn btn-primary me-2">
						<i class="ph-gear"></i>
					</a>
					<div id="calendarLoader" style="display: none;">
						<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
						<span>Loading...</span>
					</div>
				</div>
				<div id='calendar-events'></div>
			  </div>
			</div>
		</div>
		<!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</section>
	<!-- /.content -->
	
	<!-- Modal -->
	<div class="modal fade" id="calenSharPermiss" tabindex="-1" role="dialog" aria-labelledby="calenSharPermiss" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content card card-primary">
		<form name="calenSharPermissForm" id="calenSharPermissForm" method="post" action="{{ route('admin.calendar.selected.users') }}" >
		  @csrf
		  <div class="card-header">
			<h3 class="card-title">Calendar Sharing and Permissions</h3>
			<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="card-body">
			<div class="row mt-2">
			  <div class="col-12">
				<input type="text" name="calen_folder_name" id="calen_folder_name" class="form-control" value="{{auth()->user()->name}}" disabled />
			  </div>
			</div>
			<div class="row mt-2">
			  <div class="col-10">
				<label for="calen_crm_sys">Share the calendar with any user in the CRM System </label>
				<select name="calen_crm_sys[]" id="calen_crm_sys" class="form-control calen_crm_sys select2" multiple placeholder="No Shared Users Found">
					@if(isset($users) && !empty($users))
						@foreach($users as $key=>$value)
							<option value="{{$key}}" {{ (in_array($key, old('calen_crm_sys', []))) ? 'selected' : '' }} data-name="{{ $value }}">{{$value}}</option>
						@endforeach
					@endif
				</select>
			  </div>	
			  <div class="col-2 d-flex justify-content-end align-items-center">
				<button type="button" class="form-control btn btn-info mt-3" id="share_calen_crm_sys">Share</button>
			  </div>
			</div>
			<div class="row mt-2">
			  <div class="col-12">
				<label for="calen_shared_user">Currently shared users </label>
				<table class="table" id="selectedUsersTable">
					<tbody>
						<!-- Selected users will be appended here -->
					</tbody>
				</table>
				<!-- Hidden input to store selected user IDs -->
				<input type="hidden" name="selected_users" id="selectedUsersInput">
			  </div>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary" id="btnSaveCalenSharPermiss">Save</button>
			<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Discard Changes</button>
		</div>
		</form>
		</div>
	  </div>
	</div>
		
@endsection

@section('styles')
<style>
	.fc .fc-timegrid-now-indicator-line {
		border-width:1px;
		border-color: var(--fc-now-indicator-color, red);
	}
	#calendarLoader {
		font-size: 14px;
		align-items: center;
	}

</style>
@endsection

@section('scripts')
@parent
	<script src="{{ asset('vendor/js/vendor/ui/fullcalendar/main.min.js') }}"></script>
	<script>
		const route = {
			admin: {
				lead_event_calendar: "{{ route('admin.lead-events.calendar') }}",
				save_selected_user_calendar: "{{ route('admin.calendar.selected.users') }}",
			}
		}
	</script>	
	<script src="{{asset('js/calendar/events.js')}}"></script>
	
@endsection
