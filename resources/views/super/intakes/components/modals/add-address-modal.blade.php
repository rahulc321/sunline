<!-- Start:: Create Contact Modal -->
<div class="modal fade" id="popupCardAddAddress" tabindex="-1" role="dialog" aria-labelledby="popupCardAddAddress" aria-hidden="true" style="z-index:9999;">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form id="addAddressForm" method="POST" action="{{ route('admin.contacts.addAddress') }}">
	  @csrf
	  <div class="card-header">
		<h3 class="card-title">Address</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-3">
			<label for="address_1">Address 1 <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-9">
			<input type="text" name="address_1" class="form-control" data-required="true" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="address_2">Address 2</label>
		  </div>
		  <div class="col-9">
			<input type="text" name="address_2" class="form-control" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="city">City <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-3">
			<input type="text" name="city" class="form-control" data-required="true" />
		  </div>
		  <div class="col-3">
			<label for="country">Country</label>
		  </div>
		  <div class="col-3">
			<input type="text" name="country" class="form-control" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="state_id">State</label>
			<select class="form-control" name="state_id">
				<option value="">Select</option>
			</select>
		  </div>	
		  <div class="col-4">
		    <label for="zip">Zip</label>
			<input type="text" name="zip" class="form-control" />
		  </div>
		  <div class="col-4">
			<label for="country_id">Country</label>
			<select class="form-control" name="country_id">
				<option value="">Select</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="is_primary">Is Primary?</label>
		  </div>
		  <div class="col-2">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="is_primary" id="is_primary" />
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-3">
			<label for="address_type">Address Type</label>
		  </div>
		  <div class="col-9">
			<select class="form-control" name="address_type">
				<option value="">Select</option>
				@if(isset($intake_values['address_type']) && !empty($intake_values['address_type']))
					@foreach($intake_values['address_type'] as $key=>$value)
						<option @if(old('address_type')==$key) selected @endif  value="{{$key}}">{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-secondary">Submit</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
	</div>
	</form>
	</div>
  </div>
</div>
<!-- Start:: Create Contact Modal -->