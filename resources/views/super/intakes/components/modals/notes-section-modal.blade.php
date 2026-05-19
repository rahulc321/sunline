<!-- Notes Section - Create/Edit Notes Form Modal  -->
<div class="modal fade" id="createEditNotesModal" tabindex="-1" role="dialog" aria-labelledby="createEditNotesModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="createEditNotesForm" id="createEditNotesForm" method="post" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <input type="hidden" name="notes_form_type" id="notes_form_type" value="" />
	  <input type="hidden" name="pop_notes_id" id="pop_notes_id" />
	  <div class="card-header">
		<h3 class="card-title" id="headingNotesForm">{{ trans('notes.add_note') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_notes_category">{{ trans('notes.notes_category') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_notes_category[]" id="pop_notes_category" class="form-control select2">
				<option value="" >{{ trans('notes.choose_a_notes_category') }}</option>
				@if(isset($notes_category_list) && !empty($notes_category_list))
					@foreach($notes_category_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('notes_category', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="notes_attachment">&nbsp;</label>
		  </div>
		  <div class="col-8">
			<input type="file" name="notes_attachment" id="notes_attachment" />
			<div class="notes_attachment_count">0 {{ trans('notes.attachments') }}</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-12">
			<textarea type="text" name="notes" class="form-control" id="notes" placeholder="Enter Notes">{{old('notes')}}</textarea>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-primary" id="btnSubmitUpdateNotes">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Notes Section - Print Notes Modal  -->
<div class="modal fade" id="popupCardPrintNotes" tabindex="-1" role="dialog" aria-labelledby="popupCardPrintNotes" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="printNotesData" id="printNotesData" method="post" action="{{ route('admin.export-data.data') }}">
	  <div class="card-header">
		<h3 class="card-title text-center">Print List of Notes to PDF</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
			<div class="col-12">
				<h6>Are you sure that you want to print every note and not print a particular one?</h6>
			</div>
		</div>
		<div class="row mt-2">
		  <div class="col-12 text-center">
			<button type="button" class="btn btn-primary" id="btnPrintNotes">Yes, Print every Note</button>
			<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >No, Cancel Printing</button>
		  </div>
		</div>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Notes Section - Record a Voice Memo Modal  -->
<div class="modal fade" id="popupRecordVoiceMemo" tabindex="-1" role="dialog" aria-labelledby="popupRecordVoiceMemo" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="recordVioceMemoData" id="recordVioceMemoData" method="post" action="{{ route('admin.export-data.data') }}">
	  <div class="card-header">
		<h3 class="card-title text-center">Record a Voice Memo</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
			<div class="col-12">
				<h6>Click on the "Record" button to start recording your voice memo. Press "Stop" when finished. You may listen to a playback before you save it.</h6>
			</div>
		</div>
		<div class="row mt-2">
		  <div class="col-12 text-center">
			<button type="button" class="btn btn-primary" id="btnRecordNotesAudioClip">Record</button>
			<button type="button" class="btn btn-primary" id="btnStopNotesAudioClip" >Stop</button>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-12 text-center">
			<h6>Time elapsed:</h6>
		  </div>
		</div>		
	</div>
	<div class="card-footer text-center">
		<button type="button" class="btn btn-primary" id="btnSaveNotesAudioClip">Save Audio Clip</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
	</div>
	</form>
	</div>
  </div>
</div>