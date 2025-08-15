<section id="ActivityLogs" class="section" style="display:none;">
	<div class="card-header">
		<div class="row">
			<div class="col-4">
				<h5 class="card-title">Activity Logs<small>&nbsp;</small></h5>
			</div>
			<div class="col-8">
				<div class="d-flex justify-content-end align-items-center">
					<div class="col-6 mx-1 d-flex">
						<label for="activity_category" style="margin:8px;" >Category</label>
						<select name="activity_category[]" id="activity_category" class="form-control select2" multiple="multiple" data-required="true">
							<option value="all" selected >{{ trans('global.all') }}</option>
							@if(isset($intake_values['activity_type']) && !empty($intake_values['activity_type']))
								@foreach($intake_values['activity_type'] as $key=>$value)
									<option value="{{$key}}" {{ (in_array($key, old('filter_type', []))) ? 'selected' : '' }}>{{$value}}</option>
								@endforeach
							@endif
						</select>
					  </div>
					  <div class="col-6 d-flex">
						<label for="search_activity" style="margin:8px;">Search</label>
						<input type="text" class="form-control" name="search_activity" id="search_activity">
					  </div>	
				</div>	
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
		  <div class="col-12">
			<table class="table" id="jsGridActivityLogs">
				<thead>
					<tr>					
						<th>Completed On</th>
						<th>User Name</th>
						<th>Activity Description</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		</div>
	</div>
</section>