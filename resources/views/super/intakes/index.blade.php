@extends('layouts.admin')

@section('title', "{{ trans('intake.new_intake') }}")

@section('content')
<div class="page-header-content d-lg-flex">
                        <div class="d-flex">
                            <h4 class="page-title mb-0">
                                {{ trans('intake.new_intake_list') }} - <span class="fw-normal">{{ trans('intake.create') }}</span>
                            </h4>

                            <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                            </a>
                        </div>

                  
                    </div>
    <!-- Main content -->
	<section class="content">
	  <div class="card">
		<div class="card-header">
		  <h3 class="card-title"></h3>
		  @can('intake_create')
		  <a href="{{ route('admin.intakes.create') }}" class="btn btn-success m-1" style="float: right;">{{ trans('intake.create') }}</a>
		  @endcan
		  <button class="btn btn-info m-1" style="float: right;" data-bs-toggle="modal" data-bs-target="#dateRangeModal">{{ trans('intake.export_data') }}</button>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
		  <!-- <div id="jsGrid1"></div> -->
		  <table class="table" id="jsGrid1">
			<thead>
				<tr>
					<th><input type="checkbox" id="select-all"></th>
					<th>#</th>
					<th>{{ trans('intake.case_role') }}</th>
					<th>{{ trans('intake.case_type') }}</th>
					<th>{{ trans('intake.marketing_source') }}</th>
					<th>{{ trans('intake.assignee') }}</th>
					<th>{{ trans('intake.owner') }}</th>
					<th>{{ trans('intake.ad_campaign') }}</th>
					<th>{{ trans('intake.status') }}</th>
					<th>{{ trans('intake.created_at') }}</th>
					<th>{{ trans('intake.action') }}</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		</div>
		<!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</section>
	<!-- /.content -->
	
	<!-- Modal -->
    @include('admin.common.modals.date-range-modal')
	
@endsection

@section('styles')
<style>
.nowrap-column { white-space: nowrap;}
</style>
@endsection

@section('scripts')
@parent
	<script>
	  $(function () {
		$("#exportBtn").on("click", function () {
			var gridData = $("#jsGrid1").jsGrid("option", "data");
			var wb = XLSX.utils.book_new();
			var ws = XLSX.utils.json_to_sheet(gridData);
			XLSX.utils.book_append_sheet(wb, ws, "Sheet 1");
			XLSX.writeFile(wb, "jsgrid_export.xlsx");
		});
	
	  });
	</script>
	
	<script type="text/javascript">
		$(document).ready(function () {
			var table = $('#jsGrid1').DataTable({
				processing: true,
				serverSide: true,
				"ajax": {
					url: '{{ route('admin.intakes.getIntakes') }}',
					data: function (d) {
						// Add custom parameters to the Ajax request
					}
				},
				"autoWidth": false,
				"aaSorting": [[5, "desc"]],
				columns: [
					{ data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
					{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
					{ data: 'case_role', name: 'case_role', className: 'nowrap-column' },
					{ data: 'case_type', name: 'case_type', className: 'nowrap-column' },
					{ data: 'marketing_source', name: 'marketing_source', className: 'nowrap-column' },
					{ data: 'assignee', name: 'assignee', className: 'nowrap-column' },
					{ data: 'owner', name: 'owner', className: 'nowrap-column' },
					{ data: 'ad_campaign', name: 'ad_campaign', className: 'nowrap-column' },
					{ data: 'status', name: 'status', className: 'nowrap-column' },
					{ data: 'created_at', name: 'created_at', className: 'nowrap-column' },
					{ data: 'action', name: 'action', orderable: false, searchable: false, className: 'nowrap-column' }
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
					'targets': [10],
					"visible": true,
					"searchable": false
				}
				],
				"fnInitComplete": function () {
					$(".dataTables_length").addClass("hidden-xs");
					$(this).removeClass("hidden");
				},
				"order": [
					[10, "DESC"]
				]
			});
			
			//Handle Select All
			$('#select-all').on('click', function() {
				var rows = table.rows({'search':'applied'}).nodes();
				$('input[type="checkbox"].user-checkbox', rows).prop('checked',this.checked);
			});
			
			$(document).on('click', '.delete-btn', function () {
				let dataId = $(this).data('id');
				
				Swal.fire({
					title: "Are you sure?",
					text: "You won't be able to revert this!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#d33",
					cancelButtonColor: "#3085d6",
					confirmButtonText: "Yes, delete it!"
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: "/admin/intakes/" + dataId,
							type: "DELETE",
							headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
							success: function (response) {
								Swal.fire("Deleted!", response.message, "success");
								$('#jsGrid1').DataTable().ajax.reload();
							},
							error: function (xhr) {
								Swal.fire("Error!", "Something went wrong.", "error");
							}
						});
					}
				});
			});
			
		});
		
		function checkExportForm()
		{
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			
			if(from_date!='' && to_date !='' ){
				$('#dateRangeModal').modal('hide');
			}
		}
	</script>
@endsection
