<style>
.text-primary { color:#20a8d8!important; }
.mt-2 { margin-top:2px; }
</style>
@if(isset($communications_list))
	@foreach($communications_list as $communications)
		<div class="mt-2"><span class="text-primary">Date: </span>
		@php
			$communications_date='';
			if(isset($communications['communications_date']) && $communications['communications_date']!='') {
				$communications_date = $communications['communications_date'];
			}
			echo $communications_date;
		@endphp
		</div>
		<div class="mt-2"><span class="text-primary">From: </span>		
		@php
			$from_email='';
			if(isset($communications['from_email']) && $communications['from_email']!='') {
				$from_email = $communications['from_email'];
			}
			echo $from_email;
		@endphp
		</div>
		<div class="mt-2"><span class="text-primary">To: </span>		
		@php
			$to_email='';
			if(isset($communications['to_email']) && $communications['to_email']!='') {
				$to_email = $communications['to_email'];
			}
			echo $to_email;
		@endphp
		</div>
		<div class="mt-2"><span class="text-primary">Cc: </span>		
		@php
			$cc_email='';
			if(isset($communications['cc_email']) && $communications['cc_email']!='') {
				$cc_email = $communications['cc_email'];
			}
			echo $cc_email;
		@endphp
		</div>
		<div class="mt-2"><span class="text-primary">Bcc: </span>		
		@php
			$bcc_email='';
			if(isset($communications['bcc_email']) && $communications['bcc_email']!='') {
				$bcc_email = $communications['bcc_email'];
			}
			echo $bcc_email;
		@endphp
		</div>
		<div class="mt-2"><span class="text-primary">Subject: </span>		
		@php
			$subject='';
			if(isset($communications['subject']) && $communications['subject']!='') {
				$subject = $communications['subject'];
			}
			echo $subject;
		@endphp
		</div>
		<div class="mt-2"><textarea>{{$communications['message']}}</textarea></div>
		<div class="mt-2">{{ ((isset($communications['attachment']) && $communications['attachment'] !='') ? "1 Attachment" : "0 Attachment") }}</div>
		
		@if((isset($communications['attachment']) && $communications['attachment'] !=''))
			<div class="mt-2"><a href="{{ $communications['attachment'] }}">View Attachment</a></div>
		@endif
	@endforeach
@endif