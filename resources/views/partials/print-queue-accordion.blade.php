<div class="accordion" id="mainAccordion">
	@if($printQueueDocByDate)
		@foreach($printQueueDocByDate as $date => $PQD_CountInfo)
			@php 
				$PQDocuments = $PQD_CountInfo['items'] ?? [];
				$total_count = $PQD_CountInfo['total'] ?? 0;
				$printed_count = $PQD_CountInfo['printed'] ?? 0;
				$not_printed_count = $PQD_CountInfo['not_printed'] ?? 0;
			@endphp
			<div class="accordion-item mb-2">
				<h2 class="accordion-header font-weight-bold" id="heading{{ $loop->index }}">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}">
						<span class="mx-1"><i class="more-less fa fa-plus ph-plus"></i> {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}<span> <span class="mx-1">{{ trans('documents.total_documents_generated') }}: {{$total_count}}</span><span class="mx-1">{{ trans('documents.total_documents_printed') }}: {{$printed_count}}</span><span class="mx-1">{{ trans('documents.total_documents_not_printed') }}: {{$not_printed_count}}</span>
					</button>
				</h2>
				<div id="collapse{{ $loop->index }}" class="accordion-collapse collapse">
					<div class="accordion-body">

						<div class="accordion" id="subAccordion{{ $loop->index }}">
						@if($PQDocuments && !empty($PQDocuments))
						@foreach($PQDocuments as $itemPQ)
							<div class="accordion-item DPQ-Accordion-Item">
								<h2 class="accordion-header" id="subHeading{{ $itemPQ->id }}">
									<button class="accordion-button collapsed DPQ-Accordion" type="button" data-bs-toggle="collapse"
										data-bs-target="#subCollapse{{ $itemPQ->id }}">
										<i class="more-less fa fa-plus ph-plus"></i> <span class="mx-1">{{ $itemPQ->document->document_name }}<span>
									</button>
								</h2>
								<div id="subCollapse{{ $itemPQ->id }}" class="accordion-collapse collapse">
									<div class="accordion-body">
										<table class="table table-bordered jsGridDocumentPrintQueue" id="jsGridDocumentPrintQueue_{{ $itemPQ->id }}" data-doc-id="{{ $itemPQ->document->id }}" data-doc-create-date="{{ $date }}">
											<thead>
												<tr>
													<th><input type="checkbox" class="select-all"></th>
													<th>{{ trans('documents.first_name') }}</th>
													<th>{{ trans('documents.last_name') }}</th>
													<th>{{ trans('documents.document_created') }}</th>
													<th>{{ trans('documents.mail_merge_status') }}</th>
													<th>{{ trans('documents.type_of_case') }}</th>
													<th>{{ trans('documents.mailing_address_1') }}</th>
													<th>{{ trans('documents.mailing_address_2') }}</th>
													<th>{{ trans('documents.city') }}</th>
													<th>{{ trans('documents.state') }}</th>
													<th>{{ trans('documents.zip_code') }}</th>
													<th>&nbsp;</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@endforeach
						@endif
						</div>

					</div>
				</div>
			</div>
		@endforeach
	@endif
</div>

<div class="mt-4">
	@if(isset($printQueueDocPaginate) && !empty($printQueueDocPaginate))
		{{ $printQueueDocPaginate->links('pagination::bootstrap-5') }}	
	@endif
</div>