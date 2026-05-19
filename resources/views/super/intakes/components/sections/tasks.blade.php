<section id="Tasks" class="section" style="display:none;">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h5 class="card-title">Tasks<small>&nbsp;</small></h5>
			</div>
			<div class="col-6">
				<div class="d-flex justify-content-end align-items-center">
					<button type="button" class="btn btn-primary float-right" href="javascript:;" onclick="createEditTaskModal('create');" id="addTask">Add Task</button>	
				</div>	
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<div class="row mb-3">
				  <div class="col-4">
					<label for="task_type">Type</label>
					<select name="task_type[]" id="task_type" class="form-control select2" multiple="multiple" data-required="true">
					<option value="all" selected >All</option>
					@if(isset($tasks_type_list) && !empty($tasks_type_list))
						@foreach($tasks_type_list as $key=>$value)
							<option value="{{$key}}" {{ (in_array($key, old('task_type', []))) ? 'selected' : '' }}>{{$value}}</option>
						@endforeach
					@endif
					</select>
				  </div>
				  <div class="col-4">
					<label for="tasks_category">Category</label>
					<select name="tasks_category[]" id="tasks_category" class="form-control select2" multiple="multiple" data-required="true">
					<option value="all" selected >All</option>
					@if(isset($tasks_category_list) && !empty($tasks_category_list))
						@foreach($tasks_category_list as $key=>$value)
							<option value="{{$key}}" {{ (in_array($key, old('tasks_category', []))) ? 'selected' : '' }}>{{$value}}</option>
						@endforeach
					@endif
					</select>
				  </div>
				  <div class="col-4">
					<label for="search_tasks">Search</label>
					<input type="text" class="form-control" name="search_tasks" id="search_tasks">
				  </div>
				</div>
				<table class="table" id="jsGridTasks">
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
</section>