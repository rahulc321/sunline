<section id="Events" class="section" style="display:none;">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h5 class="card-title">Calendar Events <i class="far fa-question-circle" title="The Event Status is for reporting purposes only. It will track calendar attendance metrics and does not edit, delete, or modify calendar events at this time. If you would like to Edit or Delete a calendar event, then please click the Edit or Delete buttons to the right of Event Status"></i><small>&nbsp;</small></h5>
			</div>
			<div class="col-6">
				<div class="d-flex justify-content-end align-items-center">
					<button type="button" class="btn btn-primary float-right" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardAddEvent" id="addEvents">Add Calender Event</button>
				</div>		
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<div class="row mb-3">
				  <div class="col-2">
					<label for="attended">Attended</label>
					<input type="text" class="form-control" name="attended" id="event_attended" value="0" />
				  </div>
				  <div class="col-2">
					<label for="event_attendance">Attendance</label>
					<input type="text" class="form-control" name="event_attendance" id="event_attendance" value="0" />
				  </div>
				  <div class="col-2">
					<label for="event_canceled">Canceled</label>
					<input type="text" class="form-control" name="event_canceled" id="event_canceled" value="0" />
				  </div>
				  <div class="col-2">
					<label for="event_rescheduled">Rescheduled</label>
					<input type="text" class="form-control" name="event_rescheduled" id="event_rescheduled" value="0" />
				  </div>
				  <div class="col-3">
					<label for="event_no_showed">No Showed</label>
					<input type="text" class="form-control" name="event_no_showed" id="event_no_showed" value="0" />
				  </div>
				</div>
				<table class="table" id="jsGridEvents">
					<thead>
						<tr>					
							<th>Date/Time</th>
							<th>Event Title</th>
							<th>Event Type</th>
							<th>Location</th>
							<th>Owner</th>
							<th>Event Status</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			  </div>
		</div>
	</div>
</section>