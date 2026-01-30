<!-- Document Section - Create Word Document Modal  -->
<div class="modal fade" id="popupCreateWordDocument" tabindex="-1" role="dialog" aria-labelledby="popupCreateWordDocument" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="createWordDocument" id="createWordDocument" method="post" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title text-center"><img style="width: 8%; margin: auto; vertical-align: middle;" src="{{ asset('images/Word_1500x1500.png') }}"> {{ trans('documents.create_document') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_word_doc_category">{{ trans('documents.category') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<select name="pop_word_doc_category" id="pop_word_doc_category" class="form-control">
			@if(isset($document_category) && !empty($document_category))
				<option value="">Select</option>
				@foreach($document_category as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_word_doc_file_name">{{ trans('documents.file_name') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<input type="text" name="pop_word_doc_file_name" id="pop_word_doc_file_name" /> .docx
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_word_doc_description">{{ trans('documents.description') }}</label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="pop_word_doc_description" class="form-control" id="pop_word_doc_description" placeholder="Enter Description"></textarea>
		  </div>
		</div>
	</div>
	<div class="card-footer text-center">
		<button type="submit" class="btn btn-primary" id="btnCreateWordDoc">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Document Section - Create Excel Document Modal  -->
<div class="modal fade" id="popupCreateExcelDocument" tabindex="-1" role="dialog" aria-labelledby="popupCreateExcelDocument" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="createExcelDocument" id="createExcelDocument" method="post" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title text-center"><img style="width: 8%; margin: auto; vertical-align: middle;" src="{{ asset('images/Excel_1500x1500.png') }}"> {{ trans('documents.create_document') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_excel_doc_category">{{ trans('documents.category') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<select name="pop_excel_doc_category" id="pop_excel_doc_category" class="form-control">
			@if(isset($document_category) && !empty($document_category))
				<option value="">Select</option>
				@foreach($document_category as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_excel_doc_file_name">{{ trans('documents.file_name') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<input type="text" name="pop_excel_doc_file_name" id="pop_excel_doc_file_name" /> .xlsx
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_excel_doc_description">{{ trans('documents.description') }}</label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="pop_excel_doc_description" class="form-control" id="pop_excel_doc_description" placeholder="Enter Description"></textarea>
		  </div>
		</div>
	</div>
	<div class="card-footer text-center">
		<button type="submit" class="btn btn-primary" id="btnCreateExcelDoc">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Document Section - Create Power Point Document Modal  -->
<div class="modal fade" id="popupCreatePPTDocument" tabindex="-1" role="dialog" aria-labelledby="popupCreatePPTDocument" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="createPPTDocument" id="createPPTDocument" method="post" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title text-center"><img style="width: 8%; margin: auto; vertical-align: middle;" src="{{ asset('images/PowerPoint_1500x1500.png') }}"> {{ trans('documents.create_document') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_ppt_doc_category">{{ trans('documents.category') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<select name="pop_ppt_doc_category" id="pop_ppt_doc_category" class="form-control">
			@if(isset($document_category) && !empty($document_category))
				<option value="">Select</option>
				@foreach($document_category as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_ppt_doc_file_name">{{ trans('documents.file_name') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<input type="text" name="pop_ppt_doc_file_name" id="pop_ppt_doc_file_name" /> .pptx
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_ppt_doc_description">{{ trans('documents.description') }}</label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="pop_ppt_doc_description" class="form-control" id="pop_ppt_doc_description" placeholder="Enter Description"></textarea>
		  </div>
		</div>
	</div>
	<div class="card-footer text-center">
		<button type="submit" class="btn btn-primary" id="btnCreatePptDoc">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Document Section - Use Template Document Modal  -->
<div class="modal fade" id="popupUseTemplateDocument" tabindex="-1" role="dialog" aria-labelledby="popupUseTemplateDocument" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="useTemplateDocument" id="useTemplateDocument" method="post" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title text-center"><img style="width: 8%; margin: auto; vertical-align: middle;" src="{{ asset('images/Word_1500x1500.png') }}"> {{ trans('documents.create_document') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_usetemplate_template">{{ trans('documents.template') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<select name="pop_usetemplate_template" id="pop_usetemplate_template" class="form-control">
			@if(isset($document_template_list) && !empty($document_template_list))
				<option value="">Select</option>
				@foreach($document_template_list as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_usetemplate_category">{{ trans('documents.category') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<select name="pop_usetemplate_category" id="pop_usetemplate_category" class="form-control">
			@if(isset($document_category) && !empty($document_category))
				<option value="">Select</option>
				@foreach($document_category as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_usetemplate_folder">{{ trans('documents.folder') }} <i title="If you would like to change the folder for uploading, then you change the folder in the explorer and then try again. Otherwise, the file(s) will upload to the current folder and you could move them after upload." style="color: gray;font-size: 16px;" class="far fa-2x fa-question-circle"></i></label>
		  </div>
		  <div class="col-8">
			<select name="pop_usetemplate_folder" id="pop_usetemplate_folder" class="form-control select2" placeholder="Select" readonly disabled style="cursor: auto;">
				@if(isset($document_folder_list) && !empty($document_folder_list))
					@foreach($document_folder_list as $key=>$value)
						<option value="{{$key}}" data-folder_name="{{$value}}" {{ (in_array($key, old('pop_usetemplate_folder', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_usetemplate_description">{{ trans('documents.description') }}</label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="pop_usetemplate_description" class="form-control" id="pop_usetemplate_description" placeholder="Enter Description"></textarea>
		  </div>
		</div>
	</div>
	<div class="card-footer text-center">
		<button type="submit" class="btn btn-primary" id="btnUseTemplate">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Document Section - Esign Document Modal  -->
<div class="modal fade" id="popupDocEsignNow" tabindex="-1" role="dialog" aria-labelledby="popupDocEsignNow" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="docEsignNow" id="docEsignNow" method="post" action="javascript:;" enctype="multipart/form-data" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title text-center">E-Sign Recipients </h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_send_esign_from">Send E-Sign From: </label>
		  </div>
		  <div class="col-8">
			<select name="pop_send_esign_from" id="pop_send_esign_from" class="form-control">
			<option value="">Select</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-12">
			<table class="table" id="jsGridESignSend">
				<thead>
					<tr>					
						<th>&nbsp;</th>
						<th>On/Off <i class="far fa-question-circle" style="vertical-align: middle" title="Is this person part of the signature request?"></i></th>
						<th>Signing Order</th>
						<th>Place Holder</th>
						<th>Role</th>
						<th>Name</th>
						<th>Email</th>
						<th>Cell Phone#</th>
						<th>Send SMS Text?</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		</div>
	</div>
	<div class="card-footer text-center">
		<button type="submit" class="btn btn-primary" id="btnDocEsignNow"><i style="" class="far fa-paper-plane"></i>&nbsp;Send E-Sign</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >Cancel</button>
	</div>
	</form>
	</div>
  </div>
</div>