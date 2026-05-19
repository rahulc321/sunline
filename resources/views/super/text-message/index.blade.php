@extends('layouts.admin')

@section('title', 'Text Messages')

@section('content')
	<div class="page-header">
		<div class="page-header-content d-lg-flex" style="display:none;">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					&nbsp; <span class="fw-normal">&nbsp;</span>
				</h4>
			</div>
		</div>
	</div>
    <!-- Main content -->
	<section class="content pt-0">
	  <div class="card">
		  <div class="card-header">
			  <h3 class="card-title"><i class="far fa-comment-dots ph-chats"></i> Text Messages</h3>
		  </div>
		  <!-- /.card-header -->
          <div class="card-body">			
			  <div class="texts-container">
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
		</div>
	</section>
	<!-- /.content -->
	
	<!-- Modal -->
		
@endsection

@section('styles')

@endsection

@section('scripts')
@parent
<script>
let contact_name = '';
let lead_id = "{{$lead_id}}";
const route = {
			admin: {
				communications_send_text_msg: "{{ route('admin.communications.text-message.send') }}",
				communications_text_messages_list: "{{ route('admin.communications.text-message.list') }}",
				communications_text_messages_list_lead_id: "{{ route('admin.communications.text-message.list.lead-id') }}",
			}
		}
</script>
<script src="{{asset('js/lead/text-messages.js')}}"></script>
@endsection
