@extends('layouts.admin')

@section('title', 'Tasks')

@section('styles')

@endsection

@section('content')
	<!--<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					Tasks <span class="fw-normal">&nbsp;</span>
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
					<section id="tasks">					
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-6">
											<h5 class="m-0"><i class="far fa-check ph-check"></i> All Tasks</h5>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">
												<button type="button" class="btn btn-primary float-right" href="javascript:;" data-bs-toggle="modal" data-bs-target="#createEditTaskModal" id="addTask">Add Task</button>	
											</div>	
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row align-items-center mb-2">
										<div class="col-7">
											<div class="d-flex flex-wrap">
												<div class="mx-2">
													<a href="javascript:;" ><i class="far fa-check ph-check"></i> Mark as Completed</a>
												</div>
												<div class="mx-2">
													<a href="javascript:;" ><i class="far fa-exchange ph-exchange"></i> Transfer Task</a>
												</div>
												<div class="mx-2">
													<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#dateRangeModal" ><i class="far fa-file-excel ph-file-excel"></i> Export Task Report</a>
												</div>
											</div>
										</div>
										<div class="col-5">
											<div class="d-flex flex-wrap" style="float:right;">
												<div class="mx-2">
													<input type="text" class="form-control" name="search_tasks" id="search_tasks" placeholder="Search Tasks">
												</div>
												<div class="mx-2">
													<button type="button" class="btn btn-primary" id="toggleFormBtn">Filters</button>
												</div>
										   </div>
									   </div>
									</div>
									<div class="row">
										<div class="col-12">
											<div id="dropdownForm" style="display: none; position: absolute; border: 1px solid #ccc; padding: 10px; background: white; z-index:4; right:25px;">
												<form>
													<div class="card-body">
														<div class="row mt-2">
														  <div class="col-4">
															<label for="filter_date_range">Date Range </label>
														  </div>
														  <div class="col-8">
															<select name="filter_date_range" id="filter_date_range" class="form-control select2">
																<option value="all" >{{ trans('global.all_time') }}</option>
																<option value="today" >{{ trans('global.today') }}</option>
																<option value="last_week" >{{ trans('global.last_week') }}</option>
																<option value="current_month" >{{ trans('global.current_month') }}</option>
																<option value="last_month" >{{ trans('global.last_month') }}</option>
																<option value="last_year" >{{ trans('global.last_year') }}</option>
																<option value="custom" >{{ trans('global.custom') }}</option>
															</select>
														  </div>
														</div>
														<div class="row mt-2">
														  <div class="col-4">
															<label for="filter_tasks_type">Type </label>
														  </div>
														  <div class="col-8">
															<select name="filter_tasks_type[]" id="filter_tasks_type" class="form-control select2" multiple placeholder="Select">
																<option value="all" selected >All</option>
																@if(isset($tasks_type_list) && !empty($tasks_type_list))
																	@foreach($tasks_type_list as $key=>$value)
																		<option value="{{$key}}" {{ (in_array($key, old('filter_tasks_type', []))) ? 'selected' : '' }}>{{$value}}</option>
																	@endforeach
																@endif
															</select>
														  </div>
														</div>
														<div class="row mt-2">
														  <div class="col-4">
															<label for="filter_tasks_category">Category </label>
														  </div>
														  <div class="col-8">
															<select name="filter_tasks_category[]" id="filter_tasks_category" class="form-control select2" multiple>
																<option value="all" selected >All</option>
																@if(isset($tasks_category_list) && !empty($tasks_category_list))
																	@foreach($tasks_category_list as $key=>$value)
																		<option value="{{$key}}" {{ (in_array($key, old('filter_tasks_category', []))) ? 'selected' : '' }}>{{$value}}</option>
																	@endforeach
																@endif
															</select>
														  </div>
														</div>
														<div class="row mt-2">
														  <div class="col-4">
															<label for="filter_tasks_assignto">Assign To </label>
														  </div>
														  <div class="col-8">
															<select name="filter_tasks_assignto" id="filter_tasks_assignto" class="form-control select2">
																@if(isset($created_by_list) && !empty($created_by_list))
																	@foreach($created_by_list as $key=>$value)
																		<option value="{{$key}}" {{ (in_array($key, old('filter_tasks_assignto', []))) ? 'selected' : '' }}>{{$value}}</option>
																	@endforeach
																@endif
															</select>
														  </div>
														</div>
														<div class="row mt-2">
														  <div class="col-4">
															<label for="filter_assigned_by">Assigned By </label>
														  </div>
														  <div class="col-8">
															<select name="filter_assigned_by" id="filter_assigned_by" class="form-control select2">
																<option value="all" >All</option>
																@if(isset($users_list) && !empty($users_list))
																	@foreach($users_list as $key=>$value)
																		<option value="{{$key}}" {{ (in_array($key, old('filter_assigned_by', []))) ? 'selected' : '' }}>{{$value}}</option>
																	@endforeach
																@endif
															</select>
														  </div>
														</div>
														<div class="row mt-2">
														  <div class="col-4">
															<label for="filter_status">Status </label>
														  </div>
														  <div class="col-8">
															<div class="d-flex flex-wrap">
																<div class="mx-2">
																	<input class="checkbox filter_status" type="checkbox" name="filter_status[]" value="incomplete" {{ (in_array('incomplete', old('filter_status', []))) ? 'checked' : '' }} > Incomplete Tasks
																</div>
																<div class="mx-2">
																	<input class="checkbox filter_status" type="checkbox" name="filter_status[]" value="completed" {{ (in_array('completed', old('filter_status', []))) ? 'checked' : '' }} > Completed Tasks
																</div>
															</div>
														  </div>
														</div>
														<div class="row mt-2">
															<div class="col-4">
																<button type="button" class="btn btn-primary" id="filterApplyBtn">Apply</button>
															</div>
														</div>
													</div>
												  </form>
											  </div>
										</div>
									</div>
									<div class="row">
									  <div class="col-12">
										<table class="table" id="jsGridTasksMain">
											<thead>
												<tr>					
													<th>Due Date</th>
													<th>Description</th>
													<th>Task Type</th>
													<th>Task Category</th>
													<th>Name</th>
													<th>Assigned To</th>
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
		@include('admin.intakes.components.modals.tasks-section-modal')		
		@include('admin.common.modals.date-range-modal')
		
	
@endsection

@section('scripts')
@parent	
<script>
const route = {
		admin: {
			lead_tasks_list: "{{ route('admin.lead-tasks.list') }}",
			lead_tasks_add: "{{ route('admin.lead-tasks.store') }}",
			intakes_select2: "{{ route('admin.intakes.select2') }}",
		}
};
</script>
<script src="{{asset('js/lead/task.js')}}"></script>
@endsection
