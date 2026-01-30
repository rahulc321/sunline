<!-- Contact Related - Add Party Modal  -->
<div class="modal fade" id="popupCardParty" tabindex="-1" role="dialog" aria-labelledby="popupCardParty" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<div id="searchContactForm">
	  <div class="card-header">
		<h3 class="card-title">Search Contacts</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-12">
			<div class="row">
			  <div class="col-6">
				<h5>Choose a Contact that will be the Client on this Intake</h5>
			  </div>
			  <div class="col-6">
				<select name="pop_case_role[]" id="pop_case_role" class="form-control select2" multiple="multiple" data-required="true">
				@if(isset($intake_values['case_role']) && !empty($intake_values['case_role']))
					@foreach($intake_values['case_role'] as $key => $value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_case_role', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
				</select>
			  </div>
			</div>
			<div class="row">
			  <div class="col-6">
				<label for="pop_contact_search">Search</label>
				<input type="text" class="form-control" id="pop_contact_search" placeholder="Type to search contact" >
			  </div>
			  <div class="col-6">
				<label for="pop_contact_type">Contact Type</label>
				<select class="form-control" id="pop_contact_type">
					<option value="">Select</option>
					@if(isset($contact_type_list) && $contact_type_list)
						@foreach($contact_type_list as $key=>$value)
							<option value="{{$key}}">{{$value}}</option>
						@endforeach
					@endif	
				</select>
			  </div>
			</div>
			<div class="row mt-3">
				<table class="table" id="jsGridContactSrchAdd">
					<thead>
						<tr>					
							<th>Contact Name</th>
							<th>Contact Type</th>
							<th>E-mail</th>
							<th>Cell Phone</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<h6 class="mt-3 mb-2"><i class="far fa-user" aria-hidden="true"></i> Don't you see your contact? Create a new one!</h6>
			<a class="btn btn-primary" href="javascript:;" id="popupAddNewContactCardBTN">Add a New Contact</a>
		  </div>
		</div>
	</div>
	</div>
	</div>
  </div>
</div>

<!-- Contact Related - Change Case Role Modal  -->
<div class="modal fade" id="changeCaseRoleModal" tabindex="-1" role="dialog" aria-labelledby="changeCaseRoleModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<div id="changeCaseRoleForm">
	  <div class="card-header">
		<h3 class="card-title">Change Case Role</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-3">
			<label for="case_role_set">Case Roles to set <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-9">
			<select name="change_case_role[]" id="change_case_role" class="form-control select2" multiple="multiple" required>
				@if(isset($intake_values['case_role']) && !empty($intake_values['case_role']))
					@foreach($intake_values['case_role'] as $key => $value)
						<option value="{{$key}}" {{ (in_array($key, old('change_case_role', [])) || isset($lead_data) && $lead_data->case_roles->contains($key)) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
			<div class="my-3">
				<button type="button" class="btn btn-primary" id="submitChangeCaseRole">Submit</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
			</div>
		  </div>
		</div>
	</div>
	</div>
	</div>
  </div>
</div>