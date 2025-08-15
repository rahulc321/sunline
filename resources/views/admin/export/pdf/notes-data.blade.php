<style>
.text-primary { color:#20a8d8!important; }
.mt-2 { margin-top:2px; }
</style>
@if(isset($notes_list))
	@foreach($notes_list as $notes)
		<div class="mt-2"><span class="text-primary">Date: </span>
		@php
			$notes_date='';
			if(isset($notes['notes_date']) && $notes['notes_date']!='') {
				$notes_date = $notes['notes_date'];
			}
			echo $notes_date;
		@endphp
		</div>
		<div class="mt-2"><span class="text-primary">Author: </span>		
		@php
			$user_name='';
			if(isset($notes['user_name']) && $notes['user_name']!='') {
				$user_name = $notes['user_name'];
			}
			echo $user_name;
		@endphp
		</div>
		<div class="mt-2"><span class="text-primary">Category: </span>
		@php
			$category='No Category';
			if(isset($notes['category']) && $notes['category']!='') {
				$category = $notes['category'];
			}
			echo $category;
		@endphp
		</div>
		<div class="mt-2"><textarea>{{$notes['notes']}}</textarea></div>
		<div class="mt-2">{{ ((isset($notes['attachment']) && $notes['attachment'] !='') ? "1 Attachment" : "0 Attachment") }}</div>
		
		@if((isset($notes['attachment']) && $notes['attachment'] !=''))
			<div class="mt-2"><a href="{{ $notes['attachment'] }}">View Attachment</a></div>
		@endif
	@endforeach
@endif