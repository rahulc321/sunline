<!-- Start:: Create Contact Modal -->
<div class="modal fade" id="createEditContactModal" tabindex="-1" role="dialog" aria-labelledby="createEditContactModal" aria-hidden="true" style="z-index:9999;">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form id="createEditContactForm" method="POST" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <input type="hidden" name="contact_form_type" id="contact_form_type" value="" />
	  <input type="hidden" name="pop_contact_id" id="pop_contact_id" />
	  <div class="card-header">
		<h3 class="card-title" id="headingContactForm">Add/Edit Contact</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_nature">Nature <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-9">
			<div>
				<input id="individual_contact" type="radio" name="contact_nature" value="individual_contact" checked="checked"><label for="individual_contact"> Individual</label>
				<input id="business_contact" type="radio" name="contact_nature" value="business_contact"><label for="business_contact"> Business</label>
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="a_contact_type">Contact Type <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-9">
			<select class="form-control" name="a_contact_type" id="a_contact_type" data-required="true">
				<option value="">Select</option>
				@if(isset($contact_type_list) && !empty($contact_type_list))
					@foreach($contact_type_list as $key=>$value)
						<option value="{{$key}}">{{$value}}</option>
					@endforeach
				@endif	
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_prefix">Prefix</label>
		  </div>
		  <div class="col-9">
			<select class="form-control" name="contact_prefix" id="contact_prefix">
				<option value="">Select</option>
				@if(isset($prefix_list))
					@foreach($prefix_list as $key=>$value)
						<option value="{{$key}}" >{{$value}}</option>
					@endforeach
				@endif	
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_first_name">First Name <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_first_name" class="form-control" id="contact_first_name" data-required="true" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_middle_name">Middle Name</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_middle_name" class="form-control" id="contact_middle_name" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_last_name">Last Name <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_last_name" class="form-control" id="contact_last_name" data-required="true" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-2">
			<label for="contact_suffix">Suffix</label>
		  </div>
		  <div class="col-4">
			<input type="text" name="contact_suffix" class="form-control" id="contact_suffix" />
		  </div>
		  <div class="col-2">
			<label for="contact_gender">Gender</label>
		  </div>
		  <div class="col-4">
			<select class="form-control" name="contact_gender" id="contact_gender">
				<option value="">-</option>
				<option value="F">F</option>
				<option value="M">M</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-2">
			<label for="contact_alias">Alias</label>
		  </div>
		  <div class="col-4">
			<input type="text" name="contact_alias" class="form-control" id="contact_alias" />
		  </div>
		  <div class="col-2">
			<label for="contact_marital_status">Marital Status</label>
		  </div>
		  <div class="col-4">
			<select class="form-control" name="contact_marital_status" id="contact_marital_status">
				<option value="">Select</option>
				@if(isset($marital_status_list))
					@foreach($marital_status_list as $key=>$value)
						<option value="{{$key}}" >{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_company_name">Company Name</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_company_name" class="form-control" id="contact_company_name" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_job_title">Job Title</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_job_title" class="form-control" id="contact_job_title" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_ssn">SSN:</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_ssn" class="form-control" id="contact_ssn" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_work_phone">Work Phone</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_work_phone" class="form-control" id="contact_work_phone" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_home_phone">Home Phone</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_home_phone" class="form-control" id="contact_home_phone" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="a_contact_phone">Primary Phone <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-3">
			<input type="text" name="a_contact_phone" class="form-control" id="a_contact_phone" data-required="true" />
		  </div>
		  <div class="col-3">
			<label for="contact_whentocontact">When to Contact</label>
		  </div>
		  <div class="col-3">
			<input type="text" name="contact_whentocontact" class="form-control" id="contact_whentocontact" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="a_contact_email">Primary Email <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<input type="text" name="a_contact_email" class="form-control" id="a_contact_email" data-required="true" />
		  </div>
		</div>  
		<div class="row mt-2">
		  <div class="col-4">
			<label for="contact_preference">Contact Preference</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="contact_preference" class="form-control" id="contact_preference" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_fax">Fax:</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_fax" class="form-control" id="contact_fax" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="contact_secondary_email">Secondary Email:</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="contact_secondary_email" class="form-control" id="contact_secondary_email" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="a_contact_addrs">Addresses</label>
		  </div>
		  <div class="col-8">
			<table class="table" id="jsGridAddrs">
				<thead>
					<tr>					
						<th>Address</th>
						<th>Type <a class="btn btn-info mx-1" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardAddAddress" >+ New Address</a></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="contact_language">Language</label>
		  </div>
		  <div class="col-8">
			<select name="contact_language" class="form-control" id="contact_language">
				<option value="">Select</option>
				@if(isset($languages) && !empty($languages))
					@foreach($languages as $lang_id => $lang_name)
						<option value="{{$lang_id}}" >{{$lang_name}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="contact_drivers_license">Drivers License #</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="contact_drivers_license" class="form-control" id="contact_drivers_license" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="contact_dob">Date of Birth</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="contact_dob" class="form-control" id="contact_dob" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="a_contact_dod">Date of Death</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="contact_dodeath" class="form-control" id="contact_dodeath" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="contact_dobankruptcy">Date of Bankruptcy</label>
		  </div>
		  <div class="col-8">
			<input type="text" name="contact_dobankruptcy" class="form-control" id="contact_dobankruptcy" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="contact_notes">Notes</label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="contact_notes" class="form-control" id="contact_notes"></textarea>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-secondary" id="btnSubmitUpdateContact">Submit</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
	</div>
	</form>
	</div>
  </div>
</div>
<!-- Start:: Create Contact Modal -->