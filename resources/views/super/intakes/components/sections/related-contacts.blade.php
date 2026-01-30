<section id="RelatedContacts" class="section" style="display:none;">
	<div class="card-header">
		<div class="row">
			<div class="col-8">
				<h5 class="card-title">Related Contacts</h5>
			</div>
			<div class="col-4">
				<div class="d-flex justify-content-end align-items-center">
					<button type="button" class="btn btn-primary float-right" href="javascript:;" data-bs-toggle="modal" data-bs-target="#popupCardParty" id="addParty">+Add Party</button>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-12">
				<div class="card card-primary card-outline">
				{{--<div class="card-header">
						<h5 class="m-0">&nbsp;</h5>
					</div>--}}
					<div class="card-body">
						<div class="row">
						  <div class="col-12">
							<div class="row mb-3">
								<div class="col-6">
									<button type="button" class="btn btn-primary">Resolve Issues</button>
									<a class="btn btn-primary" href="{{route('admin.email.compose',['lead'=>$lead_data->id])}}" target="_blank" >Compose Email</a>
								</div> 
								<div class="col-3">
									<input type="text" class="form-control" id="contact_search" placeholder="Type to Search">
								</div>
								<div class="col-3">
									<select class="form-control" id="contact_type">
										<option value="">Filter</option>	
									</select>
								</div>	
							</div>
							<table class="table" id="jsGridRelatedContacts">
								<thead>
									<tr>					
										<th>Name</th>
										<th>Role</th>
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
		</div>
	</div>
</section>