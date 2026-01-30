<!-- Document Section - Upload Documents Modal  -->
<div class="modal fade" id="popupLeadDocumentUpload" tabindex="-1" role="dialog" aria-labelledby="popupLeadDocumentUpload" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="uploadDocument" id="uploadDocument" method="post" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title text-center">{{ trans('documents.upload_document') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_document_category">{{ trans('documents.category') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<select name="pop_document_category" id="pop_document_category" class="form-control">
			@if(isset($document_category) && !empty($document_category))
				<option value="">{{ trans('global.select') }}</option>
				@foreach($document_category as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="document_file">{{ trans('documents.files') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<input type="file" name="document_file" id="document_file" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_document_folder">{{ trans('documents.folder') }}</label>
		  </div>
		  <div class="col-8">
			<select name="pop_document_folder" id="pop_document_folder" class="form-control select2" placeholder="Select" readonly disabled style="cursor: auto;">
				@if(isset($document_folder_list) && !empty($document_folder_list))
					@foreach($document_folder_list as $key=>$value)
						<option value="{{$key}}" data-folder_name="{{$value}}" {{ (in_array($key, old('pop_document_folder', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_document_description">{{ trans('documents.description') }}</label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="pop_document_description" class="form-control" id="pop_document_description" placeholder="Enter Description"></textarea>
		  </div>
		</div>
	</div>
	<div class="card-footer text-center">
		<button type="submit" class="btn btn-primary" id="btnUploadDocument">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>