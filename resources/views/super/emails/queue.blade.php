@extends('layouts.admin')

@section('title', 'Queue Email')

@section('content')
    <!-- Main content -->
		<section class="content">
		  <div class="container mt-5">
			<h2>Email Queue</h2>
			
			@if(session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			
			<a href="{{ route('admin.email.compose') }}" class="btn btn-primary mb-3">Compose New Email</a>
			
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>To Email</th>
							<th>Subject</th>
							<th>Status</th>
							<th>Created</th>
							<th>Sent</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($emails as $email)
							@php
								$email_status = @$email->email_status->title;
							@endphp
							<tr>
								<td>{{ $email->id }}</td>
								<td>
									<small>{{ $email->to_email }}</small>
								</td>
								<td>{{ Str::limit($email->subject, 30) }}</td>
								<td>
									@switch($email_status)
										@case('Queued')
											<span class="badge bg-warning">Queued</span>
											@break
										@case('Pending')
											<span class="badge bg-warning">Pending</span>
											@break
										@case('Processing')
											<span class="badge bg-info">Sending</span>
											@break
										@case('Sent')
											<span class="badge bg-success">Sent</span>
											@break
										@case('Failed')
											<span class="badge bg-danger">Failed</span>
											@break
									@endswitch
								</td>
								<td>{{ $email->created_at->format('M d, Y H:i') }}</td>
								<td>{{ $email->sent_at ? $email->sent_at->format('M d, Y H:i') : '-' }}</td>
								<td>
									@if($email_status === 'Failed')
										<form action="{{ route('admin.email.resend', $email->id) }}" method="POST" style="display: inline;">
											@csrf
											<button type="submit" class="btn btn-sm btn-warning">Resend</button>
										</form>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No emails found</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			
			{{ $emails->links() }}
		</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	
	
@endsection

@section('scripts')
@parent
<script>

</script>	
@endsection
