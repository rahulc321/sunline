@extends('layouts.admin')

@section('title', "{{ trans('email_marketing.email_marketing') }}")

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
											<h5 class="m-0">{{ trans('email_marketing.email_marketing') }} </h5>
										</div>
										<div class="col-6">
											<div class="d-flex justify-content-end align-items-center">
												<a href="{{ route('admin.email-marketing.createEmailCampaign') }}" class="btn btn-primary float-right">{{ trans('email_marketing.new_email_campaign') }}</a>
											</div>	
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
									  <div class="col-12">
										<h4 class="m-0">How effective are they? </h4>
									  </div>
									</div>
									
									<div class="row py-3">
									  <div class="col-3">
										<select name="filter_em_months" id="filter_em_months" class="form-control select2">
											<option value="">{{ trans('email_marketing.select') }} {{ trans('email_marketing.month') }}</option>
											<option value="current">{{ trans('email_marketing.current') }} {{ trans('email_marketing.month') }}</option>
											<option value="1">{{ trans('email_marketing.last') }} {{ trans('email_marketing.month') }}</option>
											<option value="2">{{ trans('email_marketing.last') }} 2 {{ trans('email_marketing.months') }}</option>
											<option value="3">{{ trans('email_marketing.last') }} 3 {{ trans('email_marketing.months') }}</option>
											<option selected value="6">{{ trans('email_marketing.last') }} 6 {{ trans('email_marketing.months') }}</option>
											<option value="9">{{ trans('email_marketing.last') }} 9 {{ trans('email_marketing.months') }}</option>
											<option value="12">{{ trans('email_marketing.last') }} 12 {{ trans('email_marketing.months') }}</option>
										</select>
									  </div>
									  <div class="col-4 d-flex align-items-center">
										<input type="date" class="form-control" name="filter_from" id="filter_from" placeholder="">
										<input type="date" class="form-control mx-1" name="filter_to" id="filter_to" placeholder="">
										<button type="submit" class="mx-1 btn btn-primary" id="apply_filter">{{ trans('email_marketing.apply') }}</button>
										<div id="formLoader" class="text-center d-none">
											<div class="spinner-border text-primary" role="status">
												<span class="visually-hidden">Loading...</span>
											</div>
										</div>
									  </div>
									</div>
									
									<div class="row">
									  <div class="col-12">
										<p class="mt-3">Please be advised that this report will only show the number of Sent/Viewed/Clicked emails, and it may differ from the results of the number of related leads/intakes, since there may be 1 lead/intake with multiple emails.</p>
									  </div>
									</div>
									
									<div class="row text-center">
										<!-- Card 1 -->
										<div class="col-md-2 col-sm-4 col-6 mb-3">
										  <div class="card">
											<div class="card-header bg-primary text-white">{{ trans('email_marketing.sent') }}</div>
											<div class="card-body">
											  <h5 class="card-title text-muted mb-0" id="counter-sent">0</h5>
											</div>
										  </div>
										</div>

										<!-- Card 2 -->
										<div class="col-md-2 col-sm-4 col-6 mb-3">
										  <div class="card">
											<div class="card-header bg-primary text-white">{{ trans('email_marketing.viewed') }}</div>
											<div class="card-body">
											  <h5 class="card-title text-muted mb-0" id="counter-viewed">0</h5>
											</div>
										  </div>
										</div>

										<!-- Card 3 -->
										<div class="col-md-2 col-sm-4 col-6 mb-3">
										  <div class="card">
											<div class="card-header bg-primary text-white">% {{ trans('email_marketing.viewed') }}</div>
											<div class="card-body">
											  <h5 class="card-title text-muted mb-0" id="counter-viewed-percent">0%</h5>
											</div>
										  </div>
										</div>

										<!-- Card 4 -->
										<div class="col-md-2 col-sm-4 col-6 mb-3">
										  <div class="card">
											<div class="card-header bg-primary text-white">{{ trans('email_marketing.clicked') }}</div>
											<div class="card-body">
											  <h5 class="card-title text-muted mb-0" id="counter-clicked">0</h5>
											</div>
										  </div>
										</div>

										<!-- Card 5 -->
										<div class="col-md-2 col-sm-4 col-6 mb-3">
										  <div class="card">
											<div class="card-header bg-primary text-white">% {{ trans('email_marketing.clicked') }}</div>
											<div class="card-body">
											  <h5 class="card-title text-muted mb-0" id="counter-clicked-percent">0%</h5>
											</div>
										  </div>
										</div>
									  </div>
									
									<div class="row mt-2">
									  <div class="col-12">
										<table class="table" id="jsGridEmailMarketing">
										<thead>
											<tr>	
												<th class="d-none"><input type="checkbox" id="select-all"></th>
												<th>{{ trans('email_marketing.email_campaign_name') }}</th>
												<th>{{ trans('email_marketing.date') }}/{{ trans('email_marketing.time_edited') }}</th>
												<th>{{ trans('email_marketing.date') }}/{{ trans('email_marketing.time_sent') }}</th>
												<th># {{ trans('email_marketing.of_recipients') }}</th>
												<th>{{ trans('email_marketing.sent') }}</th>
												<th>{{ trans('email_marketing.viewed') }}</th>
												<th>% {{ trans('email_marketing.viewed') }}</th>
												<th>{{ trans('email_marketing.clicked') }}</th>
												<th>% {{ trans('email_marketing.clicked') }}</th>
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
	function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }

    function setDateRange(monthsAgo = 6) {
      const end = new Date();
      const start = new Date();
      start.setMonth(end.getMonth() - monthsAgo);
      document.getElementById('filter_from').value = formatDate(start);
      document.getElementById('filter_to').value = formatDate(end);
    }

    function setCurrentMonthRange() {
      const now = new Date();
      const start = new Date(now.getFullYear(), now.getMonth(), 1);
      const end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
      document.getElementById('filter_from').value = formatDate(start);
      document.getElementById('filter_to').value = formatDate(end);
    }
	
	function updateEmailMarketingCounters() {
		let from = $('#filter_from').val();
		let to = $('#filter_to').val();

		$.ajax({
			url: '{{ route("admin.email-marketing.getEmailMarketingSummary") }}',
			type: 'POST',
			data: {
				filter_from: from,
				filter_to: to
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function (response) {
				$('#counter-sent').text(response.sent);
				$('#counter-viewed').text(response.viewed);
				$('#counter-viewed-percent').text(response.viewed_percent + '%');
				$('#counter-clicked').text(response.clicked);
				$('#counter-clicked-percent').text(response.clicked_percent + '%');
			},
			error: function () {
				console.error('Failed to update counters');
			}
		});
	}

	
	$(document).ready(function () {
		
		setDateRange(6);
		updateEmailMarketingCounters();	
		
		$('#filter_em_months').on('change', function () {
			const month_filter = $(this).val();

			if (month_filter === '') {
				$('#filter_from').val('');
				$('#filter_to').val('');
				return;
			}

			if (month_filter === 'current') {
				setCurrentMonthRange(); 
			} else {
				const months = parseInt(month_filter);
				setDateRange(months);
			}
		});
		
		let table = $('#jsGridEmailMarketing').DataTable({
			dom: 'rtp',
			processing: true,
			serverSide: true,
			"ajax": {
				url: '{{ route('admin.email-marketing.getEmailMarketingList') }}',
				data: function (d) {
					
				}
			},
			"autoWidth": false,
			"aaSorting": [[2, "desc"]],
			columns: [				
				{ data: 'checkbox', name: 'checkbox', visible:false, orderable:false, searchable:false },
				{ data: 'campaign_type', name: 'campaign_type', orderable:false },
				{ data: 'datetime_edited', name: 'datetime_edited', orderable:false },
				{ data: 'datetime_sent', name: 'datetime_sent', orderable:false },
				{ data: 'of_recipients', name: 'of_recipients', orderable:false },
				{ data: 'sent', name: 'sent', orderable:false },
				{ data: 'viewed', name: 'viewed', orderable:false },
				{ data: 'viewed_percentage', name: 'viewed_percentage', orderable:false },
				{ data: 'clicked', name: 'clicked', orderable:false },
				{ data: 'clicked_percentage', name: 'clicked_percentage', orderable:false },
			],
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "All"] // change per page values here
			],
			// set the initial value
			"pageLength": 10,
			"sPaginationType": "full_numbers",
			"columnDefs": [{  // set default column settings
				'orderable': true,
				'targets': [0]
			}, {  // set default column settings
				'targets': [2],
				"visible": true,
				"searchable": false
			}
			],
			"fnInitComplete": function () {
				$(".dataTables_length").addClass("hidden-xs");
				$(this).removeClass("hidden");
			},
			"order": [
				[2, "DESC"]
			]
		});
		
		//Handle Select All
		$('#select-all').on('click', function() {
			var rows = table.rows({'search':'applied'}).nodes();
			$('input[type="checkbox"].user-checkbox', rows).prop('checked',this.checked);
		});
		
		$('#emailMarketingForm').on('submit', function (e) {
			e.preventDefault();	
			updateEmailMarketingCounters();	
			$('#formLoader').removeClass('d-none');
			table.ajax.reload(function () {
				$('#formLoader').addClass('d-none');
			});
		});
		
	});
</script>

@endsection
