<!-- Key Dates Section - Add Key Date Modal  -->
<div class="modal fade" id="popupCardKeyDate" tabindex="-1" role="dialog" aria-labelledby="popupCardKeyDate" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<div id="addKeyDateForm">
	  <div class="card-header">
		<h3 class="card-title">Add Key Date</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-3">
			<label for="key_date">Key Date <span class="required text-danger">*</span> <i class="far fa-question-circle" title="If you do not see your Key Date listed here, then add the Key Date or ask your IT or firm administrator to add it for your firm if you do not have permission to add it."></i></label>
		  </div>
		  <div class="col-9">
			<select class="form-control" name="key_date_type" id="key_date_type" data-required="true">
				<option value="">Select</option>	
			</select>
			<div class="my-3">
				<button type="button" class="btn btn-primary" id="submitKeyDateType">Submit</button>
				<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
			</div>
		  </div>
		</div>
	</div>
	</div>
	</div>
  </div>
</div>