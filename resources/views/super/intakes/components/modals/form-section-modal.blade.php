<!-- Form Section - Print Form Modal  -->
<div class="modal fade" id="popupCardPrintForm" tabindex="-1" role="dialog" aria-labelledby="popupCardPrintForm" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="printFormData" id="printFormData" method="post" action="{{ route('admin.export-data.data') }}">
	  <div class="card-header">
		<h3 class="card-title">Print Questionnaire Form</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
			<div class="col-12">
				<h6 class="text-danger">Note: Please make sure the pop ups from Law Ruler are allowed to Print these forms.</h6>
			</div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="print_existing_data">Print Existing Data </label>
		  </div>
		  <div class="col-8">
			<div class="form-check">
			  <div class="form-check-label">	
				<input class="form-check-input" type="radio" name="print_existing_data" checked value="1"> Yes
			  </div>
			  <div class="form-check-label">
				<input class="form-check-input" type="radio" name="print_existing_data" value="0"> NO
			  </div>
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="print_format">Print Format </label>
		  </div>
		  <div class="col-8">
			<div class="form-check">
			  <div class="form-check-label">	
				<input class="form-check-input" type="radio" name="print_format" checked value="pdf"> Pdf
			  </div>
			  <div class="form-check-label">
				<input class="form-check-input" type="radio" name="print_format" value="word"> Word
			  </div>
			  <div class="form-check-label">
				<input class="form-check-input" type="radio" name="print_format" value="excel"> Excel
			  </div>
			</div>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="button" class="btn btn-primary" id="btnPrintForm">Print</button>
		<button type="button" class="btn btn-primary" id="btnAddToPrintQueue">Add to Print Queue</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Form Section - Print Form Modal  -->
<div class="modal fade" id="popupCardDisplayFormLink" tabindex="-1" role="dialog" aria-labelledby="popupCardDisplayFormLink" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<div id="displayFormLinkData">
	  <div class="card-header">
		<h3 class="card-title">Public URL</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="print_existing_data">Public URL: </label>
		  </div>
		  <div class="col-8">
		  
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="print_format">QR Code: <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
		  
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Close" >Close</button>
	</div>
	</div>
	</div>
  </div>
</div>