<section id="Communications" class="section" style="display:none;">
	<div class="card-header">
		<h5 class="card-title"><a href="javascript:;" onclick="showCommTab('email');" >{{ trans('communications.emails') }}</a> | <a href="javascript:;" onclick="showCommTab('texts');" >{{ trans('communications.texts') }}</a><small>&nbsp;</small></h5>
	</div>
	<div class="card-body">
		<div class="email-container">
			<div class="row">
				<div class="col-12">
					<div class="d-flex justify-content-end align-items-center mb-2">
						<button type="button" class="btn btn-primary me-2" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardPrintCommunications" id="printToPDF"><i class="ph-printer"></i>&nbsp;{{ trans('communications.print_to_pdf') }}</button>
						<button type="button" id="refreshCommunucations" class="btn btn-primary me-2">
							<i class="ph-arrows-clockwise"></i>
						</button>
						<a class="btn btn-primary" href="{{route('admin.email.compose',['lead'=>$lead_data->id])}}" target="_blank" >{{ trans('communications.compose_email') }}</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="row mb-3">
					  <div class="col-8">
						<div>{{ trans('communications.copy_auto_import_text') }} </div>
					  </div>
					  <div class="col-4">
						<label for="search_tasks">{{ trans('global.search') }}</label>
						<input type="text" class="form-control" name="search_communication_email" id="search_communication_email">
					  </div>
					</div>
					<table class="table" id="jsGridCommunicationEmail">
						<thead>
							<tr>					
								<th>{{ trans('communications.date') }}</th>
								<th>{{ trans('communications.from') }}</th>
								<th>{{ trans('communications.to') }}</th>
								<th>{{ trans('communications.cc') }}</th>
								<th>{{ trans('communications.subject') }}</th>
								<th>{{ trans('communications.status') }}</th>
								<th>{{ trans('communications.campaign_type') }}</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				  </div>
			</div>
		</div>
		<div class="texts-container" style="display:none;">
			<div class="row align-items-center mb-2">
				<div class="col-2">
					<h6>{{ trans('communications.filters') }}</h6>
				</div>
				<div class="col-10">
					<div class="d-flex flex-wrap">
						<div class="mx-2">
							<input class="checkbox texts_msg_filter" type="checkbox" name="texts_msg_filter[]" value="direct" {{ (in_array('direct', old('texts_msg_filter', []))) ? 'checked' : '' }} > {{ trans('communications.direct_messages') }}
						</div>
						<div class="mx-2">
							<input class="checkbox texts_msg_filter" type="checkbox" name="texts_msg_filter[]" value="unread" {{ (in_array('unread', old('texts_msg_filter', []))) ? 'checked' : '' }} > {{ trans('communications.unread_messages_only') }}
						</div>
						<div class="mx-2">
							<input class="checkbox texts_msg_filter" type="checkbox" name="texts_msg_filter[]" value="enter" {{ (in_array('enter', old('texts_msg_filter', []))) ? 'checked' : '' }} > Use <Enter> to Send Texts
						</div>
						<div class="mx-2">
							<input class="checkbox texts_msg_filter" type="checkbox" name="texts_msg_filter[]" value="automated" {{ (in_array('automated', old('texts_msg_filter', []))) ? 'checked' : '' }} > {{ trans('communications.automated_messages') }}
						</div>
						<div class="mx-2">
							<input class="checkbox texts_msg_filter" type="checkbox" name="texts_msg_filter[]" value="read" {{ (in_array('read', old('texts_msg_filter', []))) ? 'checked' : '' }} > {{ trans('communications.read_messages_only') }}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="row mb-3">
					  <div class="col-8">
						<div class="d-flex flex-wrap">
							<div class="mx-2">
								<label for="search_date_from">{{ trans('communications.from') }}</label>
							</div>
							<div class="mx-2">
								<input type="date" class="form-control" name="search_date_from" id="search_date_from" value="" >
							</div>
							<div class="mx-2">
								<label for="search_date_to">{{ trans('communications.to') }}</label>
							</div>
							<div class="mx-2">
								<input type="date" class="form-control" name="search_date_to" id="search_date_to" value="" >
							</div>
						</div>
					  </div>
					  <div class="col-4">
						<div class="d-flex flex-wrap">
							<div class="mx-2">
								<label for="search_communication_text">{{ trans('global.search') }}</label>
							</div>
							<div class="mx-2">
								<input type="text" class="form-control" name="search_communication_text" id="search_communication_text">
							</div>
						</div>
					  </div>
					</div>
					<table class="table" id="jsGridCommunicationText">
						<thead>
							<tr>
								<th>{{ trans('communications.client') }}</th>
								<th>{{ trans('intake.lead_id') }}</th>
								<th>{{ trans('global.message') }}</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				  </div>
			</div>
		</div>
	</div>
</section>