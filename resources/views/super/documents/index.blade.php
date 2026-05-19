@extends('layouts.admin')

@section('title', "{{ trans('documents.documents') }}")

@section('styles')

@endsection

@section('content')
	<!--<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					{{ trans('documents.documents') }} <span class="fw-normal">&nbsp;</span>
				</h4>
			</div>
		</div>
	</div> -->
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
			  <!-- form start -->
				  <div class="form-container">
					<input type="hidden" name="upload_lead_id" id="upload_lead_id" />
					<section id="main-documents">
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-6">
											<h5 class="m-0"><a href="javascript:;" class="" onclick="showDocsTab('document');">{{ trans('documents.documents') }}</a> | <a href="javascript:;" class="" onclick="showDocsTab('print_queue');">{{ trans('documents.print_queue') }}</a></h5>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">
													
											</div>	
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="document-container">
										<div class="row align-items-center mb-2">
											<div class="col-7">
												
											</div>
											<div class="col-5">
												<div class="d-flex flex-wrap" style="float:right;">
													<div class="mx-2">
														<button type="button" class="btn btn-primary" id="toggleFormBtn">{{ trans('documents.filters') }}</button>
													</div>
													<div class="mx-2">
														<input type="text" class="form-control" name="search_document" id="search_document" placeholder="Please enter 3 or more characters">
													</div>
											   </div>
										   </div>
										</div>
										<div class="row align-items-center mb-2">
											<div class="col-4">
												<div class="d-flex justify-content-left align-items-center">
													<div class="mx-2">
														<b>{{ trans('documents.folder_filter') }}:</b>
													</div>
													<div class="mx-2" id="selected-folder-path">
														<a class="folder-btn" href="javascript:;" data-lead_id="0" data-folder-id="0" data-case_id="0" data-client_id="0" >{{ trans('documents.documents') }}</a>
													</div>
											   </div>
										   </div>
											<div class="col-8">
												<div class="d-flex flex-wrap" style="float:right;">
													<div class="mx-2" id="newDocumentUpload" style="display: none;">
														<a id="new-document-button" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupLeadDocumentUpload" ><i class="far fa-file-upload ph-arrow-square-up"></i> {{ trans('documents.upload_files') }}</a>	
													</div>
													<div class="mx-2">
														<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#dateRangeModal" ><i class="far fa-file-excel ph-file-xls"></i> {{ trans('documents.export_document_report') }}</a>
													</div>
													<div class="mx-2" id="contShowEmpFolder" style="display: none;">
													  <label class="form-switch">
														<input class="form-check-input" id="showEmptyFolders" type="checkbox">
													  </label>
													  <label for="showEmptyFolders" style="cursor: pointer">{{ trans('documents.show_empty_folders') }}</label>
													</div>
													<div class="mx-2">
														<a href="javascript:;" class="mr-2">
															<span id="switchViewBtn"><i class="far fa-folder-open ph-folder-open"></i> {{ trans('documents.switch_to_folder_view') }}</span>
														 </a>
													</div>
													<div class="mx-2">
														<a href="javascript:;" class="mr-2">
															<span id="switchDeletedBtn"><i class="far fa-recycle ph-recycle"></i> {{ trans('documents.view_deleted_files') }}</span>
														 </a>
													</div>
													
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<div id="dropdownForm" style="display: none; position: absolute; border: 1px solid #ccc; padding: 10px; background: white; z-index:4; right:25px;">
													<form>
														<div class="card-body">
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_date_range">{{ trans('documents.date_range') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_date_range" id="filter_date_range" class="form-control select2">
																	@if(isset($date_range_options) && !empty($date_range_options))
																		@foreach($date_range_options as $key=>$value)
																		<option value="{{$key}}" >{{ $value }}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_document_folder">{{ trans('documents.default_folders') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_document_folder[]" id="filter_document_folder" class="form-control select2" multiple placeholder="Select">
																	<option value="">{{ trans('global.select') }}</option>
																	
																	@if(isset($document_folder_list) && !empty($document_folder_list))
																		@foreach($document_folder_list as $key=>$value)
																			<option value="{{$key}}" {{ (in_array($key, old('filter_document_folder', []))) ? 'selected' : '' }}>{{$value}}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_document_category">{{ trans('documents.document_category') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_document_category[]" id="filter_document_category" class="form-control select2" multiple>
																	<option value="">{{ trans('global.select') }}</option>
																	@if(isset($document_category) && !empty($document_category))
																		@foreach($document_category as $key=>$value)
																			<option value="{{$key}}" {{ (in_array($key, old('filter_document_category', []))) ? 'selected' : '' }}>{{$value}}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_case_type">{{ trans('documents.case_type') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_case_type[]" id="filter_case_type" class="form-control select2" multiple>
																	<option value="">{{ trans('global.select') }}</option>
																	@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
																		@foreach($intake_values['case_type'] as $key=>$value)
																			<option value="{{$key}}" {{ (in_array($key, old('filter_case_type', []))) ? 'selected' : '' }}>{{$value}}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_status">{{ trans('documents.status') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_status[]" id="filter_status" class="form-control select2" multiple>
																	<option value="">{{ trans('global.select') }}</option>
																	@if(isset($intake_values['status']) && !empty($intake_values['status']))
																		@foreach($intake_values['status'] as $key=>$value)
																			<option value="{{$key}}" {{ (in_array($key, old('filter_status', []))) ? 'selected' : '' }}>{{$value}}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_tag">{{ trans('documents.tags') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_tag[]" id="filter_tag" class="form-control select2" multiple placeholder="Select">
																	<option value="" >{{ trans('global.select') }}</option>
																	@if(isset($document_tag_list) && !empty($document_tag_list))
																		@foreach($document_tag_list as $key=>$value)
																			<option value="{{$key}}" {{ (in_array($key, old('filter_tag', []))) ? 'selected' : '' }}>{{$value}}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_modified_by">{{ trans('documents.last_modified_by') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_modified_by[]" id="filter_modified_by" class="form-control select2" multiple placeholder="Select">
																	<option value="" >{{ trans('global.select') }}</option>
																	@if(isset($document_modified_by_list) && !empty($document_modified_by_list))
																		@foreach($document_modified_by_list as $key=>$value)
																			<option value="{{$key}}" {{ (in_array($key, old('filter_modified_by', []))) ? 'selected' : '' }}>{{$value}}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
															  <div class="col-4">
																<label for="filter_marketing_source">{{ trans('documents.marketing_source') }} </label>
															  </div>
															  <div class="col-8">
																<select name="filter_marketing_source[]" id="filter_marketing_source" class="form-control select2" multiple placeholder="Select">
																	<option value="" >{{ trans('global.select') }}</option>
																	@if(isset($intake_values['marketing_source']) && !empty($intake_values['marketing_source']))
																		@foreach($intake_values['marketing_source'] as $key=>$value)
																			<option value="{{$value->id}}" {{ (in_array($key, old('filter_marketing_source', []))) ? 'selected' : '' }}>{{$value->value}}</option>
																		@endforeach
																	@endif
																</select>
															  </div>
															</div>
															<div class="row mt-2">
																<div class="col-4">
																	<button type="button" class="btn btn-primary" id="filterApplyBtn">{{ trans('global.apply') }}</button>
																</div>
															</div>
														</div>
													  </form>
												  </div>
											</div>
										</div>
										<div class="row">
										  <div class="col-12">
											<table class="table" id="jsGridDocumentsMain">
												<thead>
													<tr>	
														<th><input type="checkbox" id="select-all"></th>
														<th>{{ trans('documents.name') }}</th>
														<th>{{ trans('documents.releated_lead') }} / {{ trans('documents.case') }}</th>
														<th>{{ trans('documents.category') }}</th>
														<th>{{ trans('documents.date_modified') }}</th>
														<th>{{ trans('documents.last_modified_by') }}</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										  </div>
										</div>
									</div>
									<div class="print-queue-container" style="display:none;">
										<div class="row">
											<div class="col-12">
											  <div class="text-center">
											    <div class="mb-3">
													<button type="button" class="btn btn-primary" id="printAllSelectedDoc">{{ trans('documents.print_all_selected_documents') }}</button>
												</div>
												<div class="mb-3">
													<button type="button" class="btn btn-primary mb-2" id="deleteAllSelectedDoc">{{ trans('documents.delete_all_selected_documents') }}</button>
												</div>
											  </div>
											  <div class="" id="printDocList">
												@include('partials.print-queue-accordion', [
													'printQueueDocByDate' => $printQueueDocByDate,
													'printQueueDocPaginate' => $printQueueDocPaginate,
												])
											  </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>					
				  </div>
			</div>
			<!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
		
		<!-- Modal with Card -->		
		@include('admin.common.modals.date-range-modal')
		@include('admin.common.modals.upload-document-modal')
		
	
@endsection

@section('scripts')
@parent	
<script>
const route = {
		admin: {
			lead_main_document_list: "{{ route('admin.main-document.list') }}",
			lead_document_upload: "{{ route('admin.lead-document.upload') }}",
			lead_document_rename: "{{ route('admin.lead-document.rename') }}",
			lead_folder_path: "{{ route('admin.folder.path') }}",
			doc_print_queue_paginate: "{{ route('admin.documents.print-queue.paginate') }}",
			doc_print_queue_info: "{{ route('admin.documents.print-queue.info') }}",
			print_queue_document: "{{ route('admin.print-queue.document') }}",
			delete_queue_document: "{{ route('admin.delete-queue.document') }}",
		}
};
</script>
<script src="{{asset('js/common.js')}}"></script>
<script src="{{asset('js/lead/documents.js')}}"></script>
<script src="{{asset('js/lead/document-upload.js')}}"></script>	

@endsection
