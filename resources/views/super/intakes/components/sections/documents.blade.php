<style>
/* Show dropdown on hover */
.nav-item.dropdown:hover .dropdown-menu {
	display: block;
	margin-top: 0; /* Optional: removes small spacing */
}
</style>
<section id="Documents" class="section" style="display:none;">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h5 class="m-0"><a href="javascript:;" class="doc_tab" onclick="showDocsTab('document');">{{ trans('documents.documents') }}</a> | <a href="javascript:;" class="doc_esign_tab" onclick="showDocsTab('e_sign');">{{ trans('documents.e-sign') }}</a></h5>
			</div>
			<div class="col-6">
				<div class="d-flex justify-content-end align-items-center">
						
				</div>	
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="tab-content">
			<div style="padding:0px;" class="tab-pane fade show active" id="documents_tab" role="tabpanel">
				<div class="row">
					<div class="col-12">
						<div class="card-body">
							<div class="row">
								<div class="col-6">
								  <div class="d-flex justify-content-left align-items-center mb-2">
									<div class="me-2">
									  <a href="javascript:;" class="mr-2">
										<span id="switchViewBtn"><i class="far fa-list-alt ph-table"></i> {{ trans('documents.switch_to_file_view') }}</span>
									 </a>
									</div>
									<div id="id-show-empty-folders" class="me-2">
									  <label class="form-switch">
										<input class="form-check-input" id="showEmptyFolders" type="checkbox" checked="checked">
									  </label>
									  <label for="showEmptyFolders" style="cursor: pointer">{{ trans('documents.show_empty_folders') }}</label>
									</div>
								  </div>
								</div>
								<div class="col-6">
									<div class="d-flex justify-content-end align-items-center mb-2">
										<ul class="navbar-nav">
											<li class="nav-item dropdown">
												<a class="dropdown-toggle btn btn-primary float-right mr-1" 
												   href="javascript:;" 
												   role="button"
												   aria-expanded="false">
													{{ trans('documents.document_options') }}
												</a>
												<ul class="dropdown-menu" style="position: absolute; border: 1px solid #ccc; padding: 10px; background: white; z-index:4; right:0px;">
													<li><a class="dropdown-item" id="new-document-button" href="javascript:;" role="button" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#popupLeadDocumentUpload" >{{ trans('documents.upload_files') }}</a></li>
													<li><a class="dropdown-item" id="new-word-document-button" href="javascript:;" role="button" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#popupCreateWordDocument">{{ trans('documents.new_word_document') }}</a></li>
													<li><a class="dropdown-item" id="new-excel-document-button" href="javascript:;" role="button" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#popupCreateExcelDocument">{{ trans('documents.new_excel_spreadsheet') }}</a></li>
													<li><a class="dropdown-item" id="new-powerpoint-document-button" href="javascript:;" role="button" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#popupCreatePPTDocument">{{ trans('documents.new_powerpoint_presentation') }}</a></li>
													<li><a class="dropdown-item" id="use-template-button" href="javascript:;" role="button" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#popupUseTemplateDocument">{{ trans('documents.use_a_document_template') }}</a></li>
												</ul>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-4">
									<div id="folderList" class="list-group">
										@if($document_default_folder)
											<a href="javascript:;" class="filter_folder list-group-item list-group-item-action active " data-d_folder_id="0" data-folder_id="{{ @$root_document_folder['id'] }}" ><i class="far fa-folder-open ph-folder-open"></i> {{ @$root_document_folder['name'] }}</a>
											@foreach ($document_default_folder as $deffolder)
												  <a href="javascript:;" class="filter_folder list-group-item list-group-item-action @if(@$deffolder['id_a']==0) active @endif " data-d_folder_id="{{ @$deffolder['id_a'] }}" data-folder_id="{{ @$deffolder['id_b'] }}" ><i class="far fa-folder-open ph-folder-open"></i> {{ @$deffolder['name'] }}</a>
											@endforeach
										@endif
									</div>
								</div>
								<div class="col-8">
									<table class="table" id="jsGridDocuments">
										<thead>
											<tr>					
												<th>{{ trans('documents.name') }}</th>
												<th>{{ trans('documents.category') }}</th>
												<th>{{ trans('documents.modified') }}</th>
												<th>{{ trans('documents.description') }}</th>
												<th>{{ trans('documents.size') }}</th>
												<th>{{ trans('documents.type') }}</th>
												<th>{{ trans('documents.contact_name') }}</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="padding:0px;" class="tab-pane fade" id="doc_esign_tab" role="tabpanel">
				<div class="row">
					<div class="col-12">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="d-flex justify-content-left align-items-center mb-2">
										<button type="button" class="btn btn-primary me-2" id="tabESignDocuments" onclick="showHideEsignTab('e_sign_doc');">{{ trans('documents.e_sign_documents') }}</button>
										<button type="button" class="btn btn-primary me-2 doc_esign_status_tab" id="tabESignStatus" onclick="showHideEsignTab('e_sign_status');" >{{ trans('documents.e_sign_status') }}</button>
									</div>
								</div>
							</div>
							<div class="row esign_tab_contnr" id="esign_tab_contnr">
								<div class="col-12">
									<table class="table" id="jsGridDocEsign">
										<thead>
											<tr>					
												<th>{{ trans('documents.name') }}</th>
												<th>{{ trans('documents.case_type') }}</th>
												<th>{{ trans('documents.uploaded') }}</th>
												<th>{{ trans('documents.last_edited') }}</th>
												<th>{{ trans('documents.created_by') }}</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row esign_tab_contnr" id="esign_status_tab_contnr" style="display:none;">
								<div class="col-12">
									<table class="table" id="jsGridDocEsignStatus">
										<thead>
											<tr>					
												<th>{{ trans('documents.signers') }}</th>
												<th>{{ trans('documents.envelope_id') }}</th>
												<th>{{ trans('documents.sent_time') }}</th>
												<th>{{ trans('documents.template_name') }}</th>
												<th>{{ trans('documents.envelope_status') }}</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>