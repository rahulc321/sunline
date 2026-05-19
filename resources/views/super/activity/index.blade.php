@extends('layouts.admin')

@section('title', 'Newsfeed')

@section('styles')

@endsection

@section('content')
	<!--<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					Agenda <span class="fw-normal">&nbsp;</span>
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
					<section id="activity">					
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-6">
											<h5 class="m-0"><i class="far fa-clipboard-list ph-note"></i> {{ trans('activity.newsfeed') }}</h5>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">	
											</div>	
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-7">
											<div class="card-body">
												<div class="row">
												  <div class="col-4">
													<label for="filter_date_range">{{ trans('activity.date_range') }} </label>
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
													<label for="filter_type">{{ trans('activity.type') }} </label>
												  </div>
												  <div class="col-8">
													<select name="filter_type[]" id="filter_type" class="form-control select2" multiple placeholder="Select">
														<option value="all" selected >{{ trans('global.all') }}</option>
														@if(isset($intake_values['activity_type']) && !empty($intake_values['activity_type']))
															@foreach($intake_values['activity_type'] as $key=>$value)
																<option value="{{$key}}" {{ (in_array($key, old('filter_type', []))) ? 'selected' : '' }}>{{$value}}</option>
															@endforeach
														@endif
													</select>
												  </div>
												</div>
												<div class="row mt-2">
												  <div class="col-4">
													<label for="filter_case_type">{{ trans('activity.case_type') }} </label>
												  </div>
												  <div class="col-8">
													<select name="filter_case_type[]" id="filter_case_type" class="form-control select2" multiple>
														<option value="all" selected >{{ trans('global.all') }}</option>
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
													<label for="filter_status">{{ trans('activity.status') }} </label>
												  </div>
												  <div class="col-8">
													<select name="filter_status[]" id="filter_status" class="form-control select2" multiple>
														<option value="all" selected >{{ trans('global.all') }}</option>
														@if(isset($intake_values['status']) && !empty($intake_values['status']))
															@foreach($intake_values['status'] as $key=>$value)
																<option value="{{$key}}" {{ (in_array($key, old('filter_status', []))) ? 'selected' : '' }}>{{$value}}</option>
															@endforeach
														@endif
													</select>
												  </div>
												</div>
											</div>
										</div>
										<div class="col-5">
											<div class="row">
												<div class="d-flex flex-wrap mt-2" style="float:right;">
													<div class="mx-2">
														<input type="text" class="form-control" name="search_activity" id="search_activity" placeholder="Search">
													</div>
											   </div>
										   </div>
									   </div>
									</div>
									<div class="row mb-2">
										<div class="col-6">
											<div class="d-flex flex-wrap" >
												<div class="">
													<label for="filter_activity_type"><b>{{ trans('activity.activity_type') }}</b> </label>
												</div>
												<div class="d-flex flex-wrap">
													<div class="mx-2">
														<input class="checkbox filter_activity_type" type="checkbox" name="filter_activity_type[]" value="lead" {{ (in_array('lead', old('filter_activity_type', []))) ? 'checked' : '' }} > {{ trans('intake.leads') }}/{{ trans('intake.intakes') }}
													</div>
													<div class="mx-2">
														<input class="checkbox filter_activity_type" type="checkbox" name="filter_activity_type[]" value="case" {{ (in_array('case', old('filter_activity_type', []))) ? 'checked' : '' }} > {{ trans('activity.cases') }}
													</div>
												</div>
											</div>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center" >
												<div class="mx-1">
													<button type="button" class="btn btn-primary" id="filterApplyBtn">{{ trans('activity.apply_filter') }}</button>
												</div>
												<div class="mx-1">
													<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#dateRangeModal" ><i class="far fa-file-excel ph-note"></i> {{ trans('activity.export') }}</a>
												</div>
											</div>
										</div>
									</div> 
									<div class="row">
									  <div class="col-12">
										<table class="table" id="jsGridActivity">
											<thead>
												<tr>					
													<th>{{ trans('activity.completed_on') }}</th>
													<th>{{ trans('activity.lead_id') }}</th>
													<th>{{ trans('activity.case_type') }}</th>
													<th>{{ trans('activity.client') }}</th>
													<th>{{ trans('activity.user_name') }}</th>
													<th>{{ trans('activity.description') }}</th>
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
				  </div>
			</div>
			<!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
		
		<!-- Modal with Card -->	
		@include('admin.common.modals.date-range-modal')
		
	
@endsection

@section('scripts')
@parent	
<script>
const route = {
		admin: {
			lead_activity_list: "{{ route('admin.activity.list') }}",
		}
};
</script>
<script src="{{asset('js/common.js')}}"></script>
<script src="{{asset('js/lead/activity.js')}}"></script>
@endsection
