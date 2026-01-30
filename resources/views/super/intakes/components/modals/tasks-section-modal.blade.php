<!-- Task Section - Add Task Form Modal  -->
<div class="modal fade" id="createEditTaskModal" tabindex="-1" role="dialog" aria-labelledby="createEditTaskModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="createEditTaskForm" id="createEditTaskForm" method="post" action="{{ route('admin.lead-tasks.store') }}" >
	  @csrf
	  <input type="hidden" name="task_form_type" id="task_form_type" value="" />
	  <input type="hidden" name="pop_task_id" id="pop_task_id" />
	  <div class="card-header">
		<h3 class="card-title" id="headingTaskForm">{{ trans('tasks.add_task') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">
		@if(isset($lead_data) && !empty($lead_data->id))
			<input type="hidden" name="client_id" id="client_id" value="{{$lead_data->id}}" />
		@else	
		<div class="row mt-2" id="client_id_container">
		  <div class="col-4">
			<label for="client_id">{{ trans('tasks.client_name') }} </label>
		  </div>
		  <div class="col-8">
			<select class="form-control" name="client_id" id="client_id" data-required="true">
				<option value="">{{ trans('global.select') }}</option>	
			</select>
			<div class="error error-message text-danger" id="error_client_id"></div>
		  </div>
		</div>
		@endif
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_type">{{ trans('tasks.tasks_type') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_tasks_type" id="pop_tasks_type" class="form-control select2">
				<option value="" >Select</option>
				@if(isset($tasks_type_list) && !empty($tasks_type_list))
					@foreach($tasks_type_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('pop_tasks_type', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_category">{{ trans('tasks.tasks_category') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_tasks_category[]" id="pop_tasks_category" class="form-control select2">
				<option value="" >Choose a Tasks Category</option>
				@if(isset($tasks_category_list) && !empty($tasks_category_list))
					@foreach($tasks_category_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('tasks_category', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_subject">{{ trans('tasks.subject') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<input type="text" name="pop_tasks_subject" class="form-control" id="pop_tasks_subject" data-required="true" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_description">{{ trans('tasks.description') }} </label>
		  </div>
		  <div class="col-8">
			<textarea type="text" name="pop_tasks_description" class="form-control" id="pop_tasks_description" placeholder="Enter Desc" >{{old('pop_tasks_description')}}</textarea>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_duedate">{{ trans('tasks.due_date') }} </label>
		  </div>
		  <div class="col-8 d-flex">
			<input type="date" name="pop_tasks_duedate" class="form-control" id="pop_tasks_duedate" />
			<input type="time" name="pop_tasks_duedate_tm" class="form-control mx-1" id="pop_tasks_duedate_tm" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_assignto">{{ trans('tasks.assign_to') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_tasks_assignto" id="pop_tasks_assignto" class="form-control select2">
				@if(isset($created_by_list) && !empty($created_by_list))
					@foreach($created_by_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('event_created_by', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_priority">{{ trans('tasks.priority') }} </label>
		  </div>
		  <div class="col-8">
			<select name="pop_tasks_priority" id="pop_tasks_priority" class="form-control select2">
				<option value="" >{{ trans('global.select') }}</option>
				<option value="low" >{{ trans('tasks.low') }}</option>
				<option value="standard" >{{ trans('tasks.standard') }}</option>
				<option value="high" >{{ trans('tasks.high') }}</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_act_utbms">{{ trans('tasks.activity') }} ({{ trans('tasks.utbms') }}) </label>
		  </div>
		  <div class="col-8">
			<select name="pop_tasks_act_utbms" id="pop_tasks_act_utbms" class="form-control select2">
				<option value="" >{{ trans('global.select') }}</option>
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_bill_client">{{ trans('tasks.billable_to_client') }} </label>
		  </div>
		  <div class="col-8">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="pop_tasks_bill_client" id="pop_tasks_bill_client" />
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_notify">Notify Assignee(s) About New Task via Text Message </label>
		  </div>
		  <div class="col-8">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="pop_tasks_notify" id="pop_tasks_notify" />
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_add_cal_event">{{ trans('tasks.add_calendar_event') }} </label>
		  </div>
		  <div class="col-8">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="pop_tasks_add_cal_event" id="pop_tasks_add_cal_event" />
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_ap_remind">{{ trans('tasks.trigger_appointment_reminders') }}? </label>
		  </div>
		  <div class="col-8">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" id="pop_tasks_ap_remind" />
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_tsk_remind">{{ trans('tasks.task_reminders') }} </label>
		  </div>
		  <div class="col-8">
			<div class="d-flex justify-content-end align-items-center mb-2">
				<a href="javascript:;" class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupTaskReminder"  id="pop_tasks_tsk_remind" >+ {{ trans('global.add') }}</a>
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="pop_tasks_tsk_doc">{{ trans('tasks.task_documents') }} </label>
		  </div>
		  <div class="col-8">
			<div class="d-flex justify-content-end align-items-center mb-2">
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="btn btn-primary float-right mr-1" 
						   href="javascript:;" 
						   role="button"
						   aria-expanded="false">
							+ {{ trans('global.add') }}
						</a>
						<ul class="dropdown-menu" style="position: absolute; border: 1px solid #ccc; padding: 10px; background: white; z-index:4; top:0px; right:70px;">
							<li><a class="dropdown-item" id="new-document-button" href="javascript:;" role="button" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#popupLeadDocumentUpload" >{{ trans('documents.upload_files') }}</a></li>
							<li><a class="dropdown-item" id="use-template-button" href="javascript:;" role="button" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#popupUseTemplateDocument">{{ trans('documents.use_a_document_template') }}</a></li>
						</ul>
					</li>
				</ul>
			</div>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-primary" id="btnSubmitUpdateTask">{{ trans('global.save') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>

<!-- Task Section - Task Remider Form Modal  -->
<div class="modal fade" id="popupTaskReminder" tabindex="-1" role="dialog" aria-labelledby="popupTaskReminder" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content card card-primary">
	<form name="taskReminderForm" id="taskReminderForm" method="post" action="javascript:;" >
	  @csrf
	  <div class="card-header">
		<h3 class="card-title">{{ trans('tasks.reminder') }}</h3>
		<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="card-body">	
		<div class="row mt-2">
		  <div class="col-4">
			<label for="reminder_number">{{ trans('tasks.when_do_we_send_a_reminder') }} <span class="required text-danger">*</span></label>
		  </div>
		  <div class="col-8">
			<input type="number" name="reminder_number" class="form-control" id="reminder_number" min="0" value="0" data-required="true" />
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="reminder_operator">&nbsp; </label>
		  </div>
		  <div class="col-8">
			<select name="reminder_operator" id="reminder_operator" class="form-control select2">
				<option value="" >Select</option>
				<option value="0">Business Days After</option>
				<option value="1">Business Days Before</option>
				<option value="2">Calendar Days After</option>
				<option value="3">Calendar Days Before</option>
				<option value="5">Months After</option>
				<option value="6">Months Before</option>
				<option value="7">Years After</option>
				<option value="8">Years Before</option>
				@if(isset($reminder_operator_list) && !empty($reminder_operator_list))
					@foreach($reminder_operator_list as $key=>$value)
						<option value="{{$key}}" {{ (in_array($key, old('reminder_operator', []))) ? 'selected' : '' }}>{{$value}}</option>
					@endforeach
				@endif
			</select>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="email_reminder">{{ trans('tasks.email_reminder') }} </label>
		  </div>
		  <div class="col-8">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="email_reminder" id="email_reminder" />
			</div>
		  </div>
		</div>
		<div class="row mt-2">
		  <div class="col-4">
			<label for="text_eminder">{{ trans('tasks.text_reminder') }} </label>
		  </div>
		  <div class="col-8">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="text_eminder" id="text_eminder" />
			</div>
		  </div>
		</div>
	</div>
	<div class="card-footer">
		<button type="button" class="btn btn-primary" id="btnReminder">{{ trans('global.ok') }}</button>
		<button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal" aria-label="Cancel" >{{ trans('global.cancel') }}</button>
	</div>
	</form>
	</div>
  </div>
</div>