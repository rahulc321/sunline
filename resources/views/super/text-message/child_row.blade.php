@php
$contact_name = @$lead_data->contact->display_name;
$lead_id = @$lead_data->id;
@endphp
<div class="p-2">
	<div id="texts_msg_form_{{$lead_id}}">
		<div class="row mb-2">
			<!-- <div class="col-12">{{$contact_name}}</div>
			<div class="col-12">{{$lead_id}}</div> -->
			<div class="col-12">
				<div class="row">
					<div class="col-10">
						<input type="text" class="form-control" name="texts_msg" id="texts_msg_{{$lead_id}}" value="" data-required="true">
						<div class="error error-message text-danger" id="error_texts_msg_{{$lead_id}}"></div>
					</div>
					<div class="col-2">
						<input type="button" class="btn btn-primary w-100" name="texts_msg_submit" value="{{ trans('global.send') }}" onclick="sendTextMessage({{$lead_id}});">
					</div>
				</div>
			</div>
		</div>
	</div>
	@if($text_msg_data)
		@foreach($text_msg_data as $txt_msg)
			@php
				$client_name = @$txt_msg->contact->display_name;
				$client_phone = @$txt_msg->contact->phone;
			@endphp
			<div class="texts_msg_data">
				<div class="row mb-2">
					<div class="col-12"><span><strong>{{ $client_name }}</strong></span> <span><strong>From: {{$client_phone}}</strong></span> <span>{{ $txt_msg->created_at->format('M d Y, g:i A') }} </span></div>
					<div class="col-12">{{$txt_msg->message}}</div>
				</div>
			</div>
		@endforeach
	@endif
</div>
