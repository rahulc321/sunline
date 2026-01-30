@extends('layouts.admin')

@section('title', 'Compose Email')

@section('content')
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
			  <!-- left column -->
			  <div class="col-md-12">
				<!-- jquery validation -->
				<div class="card card-primary">
				  <form name="composeEmailForm" id="composeEmailForm" method="post" action="{{ route('admin.email.send') }}" >
				  @csrf	
					  <div class="card-header">
						<h3 class="card-title">Compose Email<small>&nbsp;</small></h3>
					  </div>
				     <!-- /.card-header -->
					  <div class="card-body">
							<div class="row mt-2">
							  <div class="col-2">
								<label for="from_email">From: </label>
							  </div>
							  <div class="col-10">
								<select id="from_email" name="from_email" class="form-control" style="width: 100%;">
									<option value="{{auth()->user()->id}}">{{auth()->user()->name}} | {{auth()->user()->email}}</option>
								</select>
								<div class="error error-message text-danger" id="error_from_email"></div>
							  </div>
							</div>
							<div class="row mt-2">
							  <div class="col-2">
								<label for="to_email">To: </label>
							  </div>
							  <div class="col-10">
								<select name="to_email[]" id="to_email" class="form-control select2" multiple data-required="true">
									<option value="" >Select</option>
									@if(isset($from_users_list) && !empty($from_users_list))
										@foreach($from_users_list as $key=>$value)
											<option value="{{$key}}" {{ (in_array($key, old('to_email', []))) ? 'selected' : '' }}>{{$value}}</option>
										@endforeach
									@endif
								</select>
								<div class="error error-message text-danger" id="error_to_email"></div>
							  </div>
							</div>
							<div class="row mt-2">
							  <div class="col-2">
								<label for="cc_email">CC: </label>
							  </div>
							  <div class="col-10">
								<select name="cc_email[]" id="cc_email" class="form-control select2" multiple>
									<option value="" >Select</option>
									@if(isset($from_users_list) && !empty($from_users_list))
										@foreach($from_users_list as $key=>$value)
											<option value="{{$key}}" {{ (in_array($key, old('cc_email', []))) ? 'selected' : '' }}>{{$value}}</option>
										@endforeach
									@endif
								</select>
								<div class="error error-message text-danger" id="error_cc_email"></div>
							  </div>
							</div>
							<div class="row mt-2">
							  <div class="col-2">
								<label for="bcc_email">BCC: </label>
							  </div>
							  <div class="col-10">
								<select name="bcc_email[]" id="bcc_email" class="form-control select2" multiple>
									<option value="" >Select</option>
									@if(isset($from_users_list) && !empty($from_users_list))
										@foreach($from_users_list as $key=>$value)
											<option value="{{$key}}" {{ (in_array($key, old('bcc_email', []))) ? 'selected' : '' }}>{{$value}}</option>
										@endforeach
									@endif
								</select>
								<div class="error error-message text-danger" id="error_bcc_email"></div>
							  </div>
							</div>
							<div class="row mt-2">
							  <div class="col-12">
								<input type="text" name="subject" class="form-control" id="subject" placeholder="Add a subject" data-required="true" />
								<div class="error error-message text-danger" id="error_subject"></div>
							  </div>
							</div>
							<div class="row mt-2">
							  <div class="col-12">
								<textarea type="text" name="message" class="form-control" id="message">{{old('message')}}</textarea>
								<div class="error error-message text-danger" id="error_message"></div>
							  </div>
							</div>	
					  </div>
					  <div class="card-footer" style="background-color: #fff;">
							<button type="submit" class="btn btn-primary"><i class="far fa-paper-plane ph-paper-plane"></i>&nbsp;Send</button>
							<button type="button" class="btn btn-primary"><i class="far fa-trash ph-trash" style="color: red;"></i>&nbsp;Cancel</button>
							<button type="button" class="btn btn-primary"><span class="far fa-paperclip ph-paperclip"></span>&nbsp;Attach File(s)</button>
					  </div>
				  </form>
				</div>
				<!-- /.card -->
				</div>
			  <!--/.col (left) -->
			  <!-- right column -->
			  <div class="col-md-6">

			  </div>
			  <!--/.col (right) -->
			</div>
			<!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	
	
@endsection

@section('scripts')
@parent
<script>
$(document).ready(function() {
	let lead_id = "{{$lead_id}}";
	$('#from_email').select2({
        placeholder: 'Select a user',
        ajax: {
            url: '{{ route('admin.users.select2') }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    element: 'from',
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });
    $('#to_email,#cc_email,#bcc_email').select2({
        placeholder: 'Select a user',
        ajax: {
            url: '{{ route('admin.users.select2') }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
	
	$('#composeEmailForm').on('submit', function(e) {
		e.preventDefault();
		$('.error-message').html('');
		let isValid=true;
		const inputs = document.querySelectorAll('#composeEmailForm [data-required="true"]');
		let errors = [];
		
		inputs.forEach(input => {
			if(!input.value.trim()) {
				isValid=false;
				let cleanName = input.name.replace(/a_/g,' ').toLowerCase();
				cleanName = cleanName.replace(/_/g,' ').toLowerCase();					
				$('#error_'+input.id).html(`The ${cleanName} field is required.`);
			}
		});		
		
		if(isValid) {
			let formData = new FormData(this);
			formData.append('lead_id', lead_id);
			
			$.ajax({
				url: '{{ route('admin.email.send') }}',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if(response.status=='success')
					{
						$('#createEditTaskModal').modal('hide');
						let tablejst = $('#jsGridTasks').DataTable();
						tablejst.draw();
						Swal.fire("Created!", response.message, "success");
					}
				},
				error: function(xhr) {
					console.error('Error: ', xhr.responseText);
				}
			});
		}
	});
});
</script>	
@endsection
