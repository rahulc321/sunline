<div class="modal fade" id="popupCardPrintCommunications" tabindex="-1" role="dialog" aria-labelledby="popupCardPrintCommunications" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="printCommunicationsData" id="printCommunicationsData" method="post" action="{{ route('admin.export-data.data') }}">
	  <div class="card-header">
		<h3 class="card-title text-center">{{ trans('communications.print_list_of_emails_to_pdf') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
			<div class="col-12">
				<h6>{{ trans('communications.print_every_email_confirm_text') }}</h6>
			</div>
		</div>
		<div class="row mt-2">
		  <div class="col-12 text-center">
			<button type="button" class="btn btn-primary" id="btnPrintCommunications">{{ trans('global.yes') }}, {{ trans('communications.print_every_emails') }}</button>
			<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.no') }}, {{ trans('communications.cancel_printing') }}</button>
		  </div>
		</div>
	</div>
	</form>
	</div>
  </div>
</div>