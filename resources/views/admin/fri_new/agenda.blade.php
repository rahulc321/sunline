@extends('layouts.admin')

@section('title', 'Agenda')

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
					<section id="Agenda">					
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-12">
											<h5 class="card-title">Tasks<small>&nbsp;&nbsp;</small><button type="button" class="btn btn-primary float-right" href="javascript:;" data-bs-toggle="modal" data-bs-target="#createEditTaskModal" id="addTask"><i class="far fa-plus ph-plus"></i></button></h5>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
									  <div class="col-12">
										<table class="table" id="jsGridTasksAgenda">
											<thead>
												<tr>					
													<th>Due Date</th>
													<th>Subject/Description</th>
													<th>Task Type</th>
													<th>Task Category</th>
													<th>Assigned To</th>
													<th>Assigned By</th>
													<th>Assigned Date</th>
													<th>Status</th>
													<th>Priority</th>
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
						
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-12">
											<h5 class="card-title">Events<small>&nbsp;&nbsp;</small><button type="button" class="btn btn-primary float-right" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardAddEvent" id="addEvents"><i class="far fa-plus ph-plus"></i></button></h5>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
									  <div class="col-12">
										<table class="table" id="jsGridEventsAgenda">
											<thead>
												<tr>					
													<th>Date/Time</th>
													<th>Event Title</th>
													<th>Event Type</th>
													<th>Location</th>
													<th>Owner</th>
													<th>Event Status</th>
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
						
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h5 class="m-0">Newsfeed</h5>
								</div>
								<div class="card-body">
									<div class="row">
									  <div class="col-12">
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
		@include('admin.intakes.components.modals.events-section-modal')
		
	
@endsection

@section('scripts')
@parent	
<script>
const route = {
		admin: {
			lead_tasks_list: "{{ route('admin.lead-tasks.list') }}",
			lead_events_list: "{{ route('admin.lead-events.list') }}",
			lead_tasks_add: "{{ route('admin.lead-tasks.store') }}",
			intakes_select2: "{{ route('admin.intakes.select2') }}",
			lead_events_add: "{{ route('admin.lead-events.store') }}",
			lead_event_type_color_list: "{{ route('admin.lead-events.color-type') }}",
			lead_event_type_add: "{{ route('admin.lead-events.type-add') }}",
			lead_event_type_list: "{{ route('admin.lead-events.type-list') }}",
		}
};
</script>
<script src="{{ asset('vendor/js/vendor/ui/fullcalendar/main.min.js') }}"></script>
<script src="{{asset('js/lead/event-agenda.js')}}"></script>
<script src="{{asset('js/lead/event-calendar-location.js')}}"></script>
@endsection
