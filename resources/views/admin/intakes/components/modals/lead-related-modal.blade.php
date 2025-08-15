<!-- Change Case Type Modal  -->
<div class="modal fade" id="changeCaseTypeModal" tabindex="-1" role="dialog" aria-labelledby="changeCaseTypeModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form id="changeCaseTypeForm" name="changeCaseTypeForm" method="post" action="javascript:;">
	  <div class="card-header">
		<h3 class="card-title">Change Case Type</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-12">
			<select name="change_case_type" id="change_case_type" class="form-control select2" required>
				<option value="">Select</option>
				@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
					@foreach($intake_values['case_type'] as $key => $value)
						<option value="{{$key}}">{{$value}}</option>
					@endforeach
				@endif
			</select>
			<div class="my-3">
				<button type="button" class="btn btn-primary" id="changeCaseType">Apply</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
			</div>
		  </div>
		</div>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Change Lead Status Modal  -->
<div class="modal fade" id="changeLeadStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeLeadStatusModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form id="changeLeadStatusForm" name="changeLeadStatusForm" method="post" action="javascript:;">
	  <div class="card-header">
		<h3 class="card-title">Change Status</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-12">
			<select name="change_lead_status" id="change_lead_status" class="form-control select2" required>
				<option value="">Select</option>
				@if(isset($intake_values['status']) && !empty($intake_values['status']))
					@foreach($intake_values['status'] as $key => $value)
						<option value="{{$key}}">{{$value}}</option>
					@endforeach
				@endif
			</select>
			<div class="my-3">
				<button type="button" class="btn btn-primary" id="changeLeadStatus">Apply</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
			</div>
		  </div>
		</div>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Change Lead Rating Modal  -->
<div class="modal fade" id="changeLeadRatingModal" tabindex="-1" role="dialog" aria-labelledby="changeLeadRatingModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form id="changeLeadRatingForm" name="changeLeadRatingForm" method="post" action="javascript:;">
	  <div class="card-header">
		<h3 class="card-title">Change Rating</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-12">
			<select name="change_lead_rating" id="change_lead_rating" class="form-control select2" required>
				<option value="">{{ trans('global.select') }}</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
			<div class="my-3">
				<button type="button" class="btn btn-primary" id="changeLeadRating">Apply</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
			</div>
		  </div>
		</div>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Change Lead Owner Modal  -->
<div class="modal fade" id="changeLeadOwnerModal" tabindex="-1" role="dialog" aria-labelledby="changeLeadOwnerModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form id="changeLeadOwnerForm" name="changeLeadOwnerForm" method="post" action="javascript:;">
	  <div class="card-header">
		<h3 class="card-title">Change Owner</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-12">
			<select name="change_lead_owner" id="change_lead_owner" class="form-control select2" required>
				@if(isset($owner_list) && !empty($owner_list))
					@foreach($owner_list as $key => $value)
						<option value="{{$key}}">{{$value}}</option>
					@endforeach
				@endif
			</select>
			<div class="my-3">
				<button type="button" class="btn btn-primary" id="changeLeadOwner">Apply</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
			</div>
		  </div>
		</div>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Change Lead Assignee Modal  -->
<div class="modal fade" id="changeLeadAssigneeModal" tabindex="-1" role="dialog" aria-labelledby="changeLeadAssigneeModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form id="changeLeadAssigneeForm" name="changeLeadAssigneeForm" method="post" action="javascript:;">
	  <div class="card-header">
		<h3 class="card-title">Change Assignee</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-12">
			<select name="change_lead_assignee" id="change_lead_assignee" class="form-control select2" required>
				@if(isset($assignee_list) && !empty($assignee_list))
					@foreach($assignee_list as $key => $value)
						<option value="{{$key}}">{{$value}}</option>
					@endforeach
				@endif
			</select>
			<div class="my-3">
				<button type="button" class="btn btn-primary" id="changeLeadAssignee">Apply</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
			</div>
		  </div>
		</div>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Transfer Record Modal  -->
<div class="modal fade" id="transferRecordModal" tabindex="-1" aria-labelledby="transferRecordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content  card card-primary">
      <form id="transferRecordForm" name="transferRecordForm" method="post" action="javascript:;">
		  <!-- Modal Header -->
		  <div class="modal-header">
			<h5 class="modal-title" id="transferRecordLabel">Transfer Record</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>

		  <!-- Modal Body -->
		  <div class="modal-body">
			<!-- Tabs -->
			<ul class="nav nav-tabs" id="transferTabs" role="tablist">
			  <li class="nav-item">
				<button class="nav-link active" id="record-task-tab" data-bs-toggle="tab" data-bs-target="#record-task" type="button" role="tab">Transfer record and task</button>
			  </li>
			  <li class="nav-item">
				<button class="nav-link" id="record-only-tab" data-bs-toggle="tab" data-bs-target="#record-only" type="button" role="tab">Transfer record only</button>
			  </li>
			</ul>

			<!-- Tab Content -->
			<div class="tab-content mt-3">
			  <!-- Tab 1 -->
			  <div class="tab-pane fade show active" id="record-task" role="tabpanel">
				<form>
				  <div class="mb-3">
					<label class="form-label">Transfer To <span class="required text-danger">*</span></label>
					<select name="transfer_to" id="transfer_to" class="form-select select2" required>
						@if(isset($assignee_list) && !empty($assignee_list))
							@foreach($assignee_list as $key => $value)
								<option value="{{$key}}">{{$value}}</option>
							@endforeach
						@endif
					</select>
				  </div>

				  <div class="mb-3">
					<label class="form-label">Record Owner <span class="required text-danger">*</span></label>
					<select name="record_owner" id="record_owner" class="form-select select2" required>
						@if(isset($owner_list) && !empty($owner_list))
							@foreach($owner_list as $key => $value)
								<option value="{{$key}}">{{$value}}</option>
							@endforeach
						@endif
					</select>
				  </div>

				  <div class="row">
					<div class="col-md-6 mb-3">
					  <label class="form-label">Assigned Date <span class="required text-danger">*</span></label>
					  <input type="date" class="form-control" value="2025-08-11">
					</div>
					<div class="col-md-6 mb-3">
					  <label class="form-label">Assigned Time <span class="required text-danger">*</span></label>
					  <select class="form-select">
						<option>9:00 PM</option>
						<option>9:15 PM</option>
						<option>...</option>
					  </select>
					</div>
				  </div>

				  <div class="row">
					<div class="col-md-6 mb-3">
					  <label class="form-label">Due Date <span class="required text-danger">*</span></label>
					  <input type="date" class="form-control" value="2025-08-11">
					</div>
					<div class="col-md-6 mb-3">
					  <label class="form-label">Due Time <span class="required text-danger">*</span></label>
					  <select class="form-select">
						<option>9:00 PM</option>
						<option>9:15 PM</option>
						<option>...</option>
					  </select>
					</div>
				  </div>

				  <div class="mb-3">
					<label class="form-label">Task <span class="required text-danger">*</span></label>
					<input type="text" class="form-control" placeholder="Enter task">
				  </div>

				  <div class="mb-3">
					<label class="form-label">Notes</label>
					<textarea class="form-control" rows="3"></textarea>
				  </div>

				  <div class="mb-3">
					<label class="form-label">Priority:</label>
					<select class="form-select">
					  <option>Low</option>
					  <option>Standard</option>
					  <option>High</option>
					</select>
				  </div>

				  <div class="form-check">
					<input class="form-check-input" type="checkbox" id="sms">
					<label class="form-check-label" for="sms">
					  Send SMS Text Reminders with this Task
					</label>
				  </div>

				  <div class="form-check mb-3">
					<input class="form-check-input" type="checkbox" id="email">
					<label class="form-check-label" for="email">
					  Send e-mail notifications on this record
					</label>
				  </div>
				</form>
			  </div>

			  <!-- Tab 2 -->
			  <div class="tab-pane fade" id="record-only" role="tabpanel">
				<form>
				  <div class="mb-3">
					<label class="form-label">Transfer To <span class="required text-danger">*</span></label>
					<select name="transfer_to2" id="transfer_to2" class="form-select select2" required>
						@if(isset($assignee_list) && !empty($assignee_list))
							@foreach($assignee_list as $key => $value)
								<option value="{{$key}}">{{$value}}</option>
							@endforeach
						@endif
					</select>
				  </div>

				  <div class="mb-3">
					<label class="form-label">Record Owner <span class="required text-danger">*</span></label>
					<select name="change_lead_owner2" id="change_lead_owner2" class="form-control select2" required>
						@if(isset($owner_list) && !empty($owner_list))
							@foreach($owner_list as $key => $value)
								<option value="{{$key}}">{{$value}}</option>
							@endforeach
						@endif
					</select>
				  </div>
				</form>
			  </div>
			</div>
		  </div>

		  <!-- Modal Footer -->
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary">Apply</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
		  </div>
	  </form>
    </div>
  </div>
</div>