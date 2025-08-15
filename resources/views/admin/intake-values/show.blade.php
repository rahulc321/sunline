@extends('layouts.admin')

@section('title', 'Show Intake Values')

@section('content')
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
			  <!-- left column -->
			  <div class="col-md-12">
				<!-- jquery validation -->
				<div class="card card-primary">
				  <div class="card-header">
					<h3 class="card-title">Show Intake Values <small>&nbsp;</small></h3>
				  </div>
				  <!-- /.card-header -->
				  <!-- form start -->
				  <form class="col-md-6">
					@csrf
					<div class="card-body">
					  <div class="form-group">
						<label for="type">Type</label>
						<select name="type" class="form-control" id="type" readonly disabled style="cursor: auto;" >
							<option @if(old('type',$intake_values->type)=='case_role') selected @endif value="case_role" >Case Role</option>
							<option @if(old('type',$intake_values->type)=='case_type') selected @endif value="case_type" >Case Type</option>
							<option @if(old('type',$intake_values->type)=='status') selected @endif value="status" >Status</option>
							<option @if(old('type',$intake_values->type)=='marketing_source') selected @endif value="marketing_source" >Marketing Source</option>
							<option @if(old('type',$intake_values->type)=='assignee') selected @endif value="assignee" >Assignee</option>
							<option @if(old('type',$intake_values->type)=='owner') selected @endif value="owner" >Owner</option>
							<option @if(old('type',$intake_values->type)=='ad_campaign') selected @endif value="ad_campaign" >Ad Campaign</option>
						</select>
						@error('type')
							<div class="error text-danger">{{$message}}</div>
						@enderror
					  </div>
					  <div class="form-group">
						<label for="value">Value</label>
						<input name="value" class="form-control" id="value" value="{{old('value',$intake_values->value)}}" readonly />
						@error('value')
							<div class="error text-danger">{{$message}}</div>
						@enderror
					  </div>
					</div>
					<!-- /.card-body -->
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

@section('styles')
	<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('scripts')
@parent
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@endsection
