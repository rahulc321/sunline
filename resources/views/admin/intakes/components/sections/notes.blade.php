<section id="Notes" class="section" style="display:none;">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h5 class="card-title">{{ trans('notes.notes') }}/{{ trans('notes.voice_memos') }}<small>&nbsp;</small></h5>
			</div>
			<div class="col-6">
				<div class="d-flex justify-content-end align-items-center">
					<button type="button" class="btn btn-primary me-2" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardPrintNotes" id="printToPDF">{{ trans('notes.print_to_pdf') }}</button>
					<button type="button" class="btn btn-primary me-2" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupRecordVoiceMemo" id="recordVoiceMemo">{{ trans('notes.record_a_voice_memo') }}</button>
					<a class="btn btn-primary me-2" href="javascript:;" onclick="createEditNotesModal('create');" id="addNote">{{ trans('notes.add_note') }}</a>
				</div>				
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<div class="row mb-3">
				  <div class="col-4">
					<label for="notes_category">{{ trans('notes.category') }}</label>
					<select name="notes_category[]" id="notes_category" class="form-control select2" multiple="multiple" data-required="true">
					<option value="all" selected >{{ trans('global.all') }}</option>
					@if(isset($notes_category_list) && !empty($notes_category_list))
						@foreach($notes_category_list as $key=>$value)
							<option value="{{$key}}" {{ (in_array($key, old('notes_category', []))) ? 'selected' : '' }}>{{$value}}</option>
						@endforeach
					@endif
					</select>
				  </div>
				  <div class="col-4">
					<label for="search_notes">{{ trans('notes.search') }}</label>
					<input type="text" class="form-control" name="search_notes" id="search_notes">
				  </div>
				</div>
				<table class="table" id="jsGridNotes">
					<thead>
						<tr>					
							<th>{{ trans('notes.date') }}</th>
							<th>{{ trans('notes.user_name') }}</th>
							<th>{{ trans('notes.category') }}</th>
							<th>{{ trans('notes.notes') }}</th>
							<th><i class="fa fa-paperclip ph-paperclip"></i></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			  </div>
		</div>
	</div>
</section>