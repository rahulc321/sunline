@extends('layouts.admin')

@section('title', "{{ trans('email_marketing.email_marketing_settings') }}")

@section('styles')

@endsection

@section('content')
	<!--<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					{{ trans('email_marketing.email_marketing') }} <span class="fw-normal">&nbsp;</span>
				</h4>
			</div>
		</div>
	</div> -->
    <!-- Main content -->
		<section class="content">
		  <div class="container-fluid">
			<div class="row">
			  <!-- form start -->
				  <form id="emailMarketingForm" method="POST" action="javascript:;">
					@csrf
					<section id="email_marketing">						
						<div class="col-12">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<div class="row">
										<div class="col-6">
											<h5 class="m-0">{{ trans('email_marketing.email_marketing_settings') }} </h5>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">
											</div>	
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row mt-4">
									  <div class="col-12">
										<h4 class="m-0">Select the Recipients for Your Campaign </h4>
									  </div>
									</div>
									
									<div class="row mt-2">
									  <div class="col-12">
										<div class="row mt-2">
											<div class="col-4">
												<label class="form-label text-dark" for="filter_unsent_campaign">{{ trans('email_marketing.select_unsent_campaign') }}({{ trans('email_marketing.optional') }}) </label>
											</div>
											<div class="col-4">
												<select name="filter_unsent_campaign" id="filter_unsent_campaign" class="form-control select2">
													<option value="" selected >-{{ trans('email_marketing.select') }}-</option>
												</select>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label class="form-label text-dark" for="filter_campaign_name">{{ trans('email_marketing.campaign_name') }} </label>
											</div>
											<div class="col-4">
												<input type="text" class="form-control" name="filter_campaign_name" id="filter_campaign_name" placeholder="">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label class="form-label text-dark" for="filter_case_type">{{ trans('email_marketing.select_case_type') }} </label>
											</div>
											<div class="col-4">
												<select name="filter_case_type[]" id="filter_case_type" class="form-control select2" multiple >
													<option value="all" selected >{{ trans('email_marketing.all_cases') }}</option>
													@if(isset($intake_values['case_type']) && !empty($intake_values['case_type']))
														@foreach($intake_values['case_type'] as $key=>$value)
															<option value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
										
										<div class="row mt-2 align-items-center">
											<div class="col-md-4">
												<label class="form-label text-dark" for="filter_from">
													{{ trans('email_marketing.date_created_from') }}
												</label>
											</div>
											<div class="col-md-8">
												<div class="d-flex align-items-center flex-wrap gap-2">
													<input type="date" class="form-control" name="filter_from" id="filter_from" style="max-width: 160px;">
													
													<span>{{ trans('email_marketing.to') }}</span>
													
													<input type="date" class="form-control" name="filter_to" id="filter_to" style="max-width: 160px;">
													
													<div class="form-check ms-3">
														<input class="form-check-input" type="checkbox" name="is_all_date" id="is_all_date" checked>
														<label class="form-check-label" for="is_all_date">
															{{ trans('email_marketing.all_dates') }} ({{ trans('email_marketing.ignore_date_range') }})
														</label>
													</div>
												</div>
											</div>
										</div>

										<div class="row mt-2">
											<div class="col-4">
												<label class="form-label text-dark" for="filter_email_come_from">{{ trans('email_marketing.who_will_this_email_come_from') }} </label>
											</div>
											<div class="col-4">
												<select name="filter_email_come_from" id="filter_email_come_from" class="form-control select2">
													<option value="" selected >{{ trans('email_marketing.select') }}</option>
												</select>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label class="form-label text-dark" for="filter_current_status">{{ trans('email_marketing.current_status') }} </label>
											</div>
											<div class="col-4">
												<select name="filter_current_status[]" id="filter_current_status" class="form-control select2" multiple >
													<option value="all" selected >{{ trans('email_marketing.all_status') }}</option>
													@if(isset($intake_values['status']) && !empty($intake_values['status']))
														@foreach($intake_values['status'] as $key=>$value)
															<option value="{{$key}}">{{$value}}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label class="form-label text-dark" for="filter_tags">{{ trans('email_marketing.tags') }} </label>
											</div>
											<div class="col-4">
												<select name="filter_tags[]" id="filter_tags" class="form-control select2" multiple>
													<option value="" selected >{{ trans('email_marketing.all_tags') }}</option>
												</select>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-4">
												<label class="form-label text-dark" for="filter_source">{{ trans('email_marketing.source') }} </label>
											</div>
											<div class="col-4">
												<select name="filter_source[]" id="filter_source" class="form-control select2" multiple readonly disabled style="cursor: auto;">
													<option value="all" selected >{{ trans('email_marketing.all_sources') }}</option>
													@if(isset($intake_values['marketing_source']) && !empty($intake_values['marketing_source']))
														@foreach($intake_values['marketing_source'] as $key=>$value)
															<option value="{{$value->id}}">{{$value->value}}</option>
														@endforeach
													@endif
												</select>
											</div>
										</div>										
									  </div>									  
									</div>
									
									<div class="row mt-2">
									  <div class="col-12">
										<p class="text-danger">Leads that have Unsubscribed / Have been opted out from receiving email alerts will not show in this list.</p>
									  </div>
									</div>
									
									<div class="row mt-3">
									  <div class="col-12">
										<h3>Total Recipients that will be emailed: <span class="recipient_count">0</span></h3>
									  </div>
									</div>
									
									<div class="row mt-4">
									  <div class="col-12">
										<div class="d-flex justify-content-center align-items-center">
											<button type="submit" class="btn btn-secondary" id="advSrchFormSubmitBtn">{{ trans('email_marketing.create_and_continue') }}</button>
											<button type="button" class="btn btn-light mx-1" id="resetAdvancedSearchForm">{{ trans('global.cancel') }}</button>
										</div>
									  </div>
									</div>
									
									
									
								</div>
							</div>
						</div>
					</section>					
				  </form>
			</div>
			<!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
		
		<!-- Modal with Card -->
		
	
@endsection

@section('scripts')
@parent	
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		const fromInput = document.getElementById("filter_from");
		const toInput = document.getElementById("filter_to");
		const allDateCheckbox = document.getElementById("is_all_date");

		// Helper: format date to YYYY-MM-DD
		function formatDate(date) {
			const year = date.getFullYear();
			const month = String(date.getMonth() + 1).padStart(2, "0");
			const day = String(date.getDate()).padStart(2, "0");
			return `${year}-${month}-${day}`;
		}

		// Set default dates
		function setDefaultDates() {
			fromInput.value = "1900-01-01";
			toInput.value = formatDate(new Date());
		}

		// Initial load setup
		setDefaultDates();
		allDateCheckbox.checked = true;

		// Listen for checkbox toggle
		allDateCheckbox.addEventListener("change", function () {
			if (this.checked) {
				setDefaultDates();
			} else {
				fromInput.value = "";
				toInput.value = "";
			}
		});
	});
	
	$(document).ready(function () {
		$('#emailMarketingForm').on('submit', function (e) {
			e.preventDefault();

			let form = $(this);
			let formData = form.serialize();

			// Remove old error messages
			form.find('.invalid-feedback').remove();
			form.find('.is-invalid').removeClass('is-invalid');

			$.ajax({
				url: "{{ route('admin.email-marketing.store') }}",
				type: "POST",
				data: formData,
				beforeSend: function () {
					$('#advSrchFormSubmitBtn').prop('disabled', true).text('Saving...');
				},
				success: function (response) {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: response.message
					}).then(() => {
						form.trigger('reset');
						$('.select2').val(null).trigger('change');
					});
				},
				error: function (xhr) {
					if (xhr.status === 422) {
						// Laravel validation errors
						let errors = xhr.responseJSON.errors;
						$.each(errors, function (key, messages) {
							let field = form.find('[name="' + key + '"]');

							if (field.length) {
								field.addClass('is-invalid');
								field.after('<div class="invalid-feedback d-block">' + messages[0] + '</div>');
							}
						});
					} else {
						// Server error
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Something went wrong on the server'
						});
					}
				},
				complete: function () {
					$('#advSrchFormSubmitBtn').prop('disabled', false).text('Create and Continue');
				}
			});
		});
	});
</script>

@endsection
