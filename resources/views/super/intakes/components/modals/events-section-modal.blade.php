<!-- Events Section - Add Events Modal  -->
<div class="modal fade" id="popupCardAddEvent" tabindex="-1" role="dialog" aria-labelledby="popupCardAddEvent" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="addEventsForm" id="addEventsForm" method="post" action="{{ route('admin.lead-events.store') }}" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title">Add Events</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		@if(isset($lead_data) && !empty($lead_data->id))
			<input type="hidden" name="lead_case_id" id="lead_case_id" value="{{$lead_data->id}}" />
		@else	
		<div class="row mt-2">
		  <div class="col-4">
			<label for="lead_case_id">Client Name </label>
		  </div>
		  <div class="col-8">
			<select class="form-control" name="lead_case_id" id="lead_case_id" data-required="true">
				<option value="">Select</option>	
			</select>
			<div class="error error-message text-danger" id="error_lead_case_id"></div>
		  </div>
		</div>
		@endif
		<div class="row mt-2">
		  <div class="col-4">
			<label for="events_created_by">Created By </label>
		  </div>
		  <div class="col-8">
			<select name="event_created_by" id="event_created_by" class="form-control select2">
				@if(isset($created_by_list) && !empty($created_by_list))
					@foreach($created_by_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('event_created_by', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_title">Event Title </label>
		  </div>
		  <div class="col-8">
			<input type="text" name="event_title" id="event_title" class="form-control" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_assigned_to">Assign To <span class="required text-danger"></span></label>
		  </div>
		  <div class="col-8">
			<select name="event_assigned_to" id="event_assigned_to" class="form-control select2">
				<option value="" >Select</option>
				@if(isset($event_user_list) && !empty($event_user_list))
					@foreach($event_user_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('event_assigned_to', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_date">Event Date and Time </label>
		  </div>
		  <div class="col-8 d-flex">
			<input type="date" name="event_date" class="form-control" id="event_date" value="" onchange="refreshCalendar()" />
			<input type="time" name="event_start_from" class="form-control mx-1" id="event_start_from" value="" onchange="refreshCalendar()" />
			<input type="time" name="event_start_to" class="form-control" id="event_start_to" value="" onchange="refreshCalendar()" />
		  </div>
		  <div class="col-12 mt-3">
			<div id='calendar'></div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_repeat">Repeat Event <span class="required text-danger"></span></label>
		  </div>
		  <div class="col-8">
			<select name="event_repeat" id="event_repeat" class="form-control select2">
				<option value="" >Select</option>
				@if(isset($event_repeat_list) && !empty($event_repeat_list))
					@foreach($event_repeat_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('event_repeat', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_address">Location </label>
		  </div>
		  <div class="col-8">
			<div class="search-container">
				<input type="text" name="event_address" id="event_address" class="form-control" placeholder="Start typing the location to search" />
				<div class="suggestions-container" id="suggestionsContainer"></div>
			</div>
			<div class="error" id="errorContainer" style="display: none;"></div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_description">Description </label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="event_description" class="form-control" id="event_description" placeholder="Enter Desc" >{{old('event_description')}}</textarea>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_status">Event Status <span class="required text-danger"></span></label>
		  </div>
		  <div class="col-8">
			<select name="event_status" id="event_status" class="form-control select2">
				<option value="" >Select</option>
				@if(isset($event_status_list) && !empty($event_status_list))
					@foreach($event_status_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('event_status', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_type">Event Type <span class="required text-danger"></span></label>
		  </div>
		  <div class="col-8 d-flex">
		    <div class="col-7">
				<select name="event_type" id="event_type" class="form-control select2">
					<option value="" >Select</option>
					@if(isset($event_type_list) && !empty($event_type_list))
						@foreach($event_type_list as $key=>$value)
							<option value="{{$key}}" {{ (in_array($key, old('event_type', []))) ? 'selected' : '' }}>{{$value}}</option>
						@endforeach
					@endif
				</select>
			</div>
			<div class="col-5">
				<button type="button" class="btn btn-primary" href="javascript:;" id="addEventType" style="float:right;" >Add Event Type</button>
			</div>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-primary" id="btnSaveEvents">Save</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Events Section - Edit Event Type Modal  -->
<div class="modal fade" id="popupCardEditEventType" tabindex="-1" role="dialog" aria-labelledby="popupCardEditEventType" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="editEventsType" id="editEventsType" method="post" action="{{ route('admin.lead-events.store') }}" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title">Event Types</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_type_name">Event Type Name </label>
		  </div>
		  <div class="col-8">
			<input type="text" name="event_type_name" id="event_type_name" class="form-control" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="event_type_color">Event Type Color </label>
		  </div>
		  <div class="col-8">
			<select name="event_type_color" id="event_type_color" class="form-control select2">
				<option value="">Select</option>
			</select>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-primary" id="btnSaveEventTypes">Save</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
	</div>
	<table class="table" id="jsGridEventTypeList">
		<thead>
			<tr>					
				<th>Event Type</th>
				<th>Color</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	</form>
	</div>
  </div>
</div>