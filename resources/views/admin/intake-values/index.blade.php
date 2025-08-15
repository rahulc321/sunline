@extends('layouts.admin')

@section('title', 'Intake Values')

@section('content')
    <!-- Main content -->
	<section class="content">
	  <div class="card">
		<div class="card-header">
			Intake Values List
			<div class="float-right">
				<form action="{{ route('admin.intake-values.index') }}" method="GET" class="form-inline">
					<select name="module" class="form-control mr-2" id="module">
						<option value="">All Modules</option>
						@foreach($modules as $moduleOption)
							<option value="{{ $moduleOption }}" {{ $module == $moduleOption ? 'selected' : '' }}>
								{{ ucfirst(str_replace("_"," ",$moduleOption)) }}
							</option>
						@endforeach
					</select>
				</form>
			</div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
		  <!-- <div id="jsGrid1"></div> -->
		  <table class="table" id="jsGrid1">
			<thead>
				<tr>
					<th>#</th>
					<th>Id</th>
					<th>Type</th>
					<th>Value</th>
					<th>Action</th>
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
			let table = $('#jsGrid1').DataTable({
				processing: true,
				serverSide: true,
				"ajax": {
					url: '{{ route('admin.intake-values.getIntakeValues') }}',
					data: function (d) {
						d.module = $('#module').val();
					}
				},
				"autoWidth": false,
				"aaSorting": [[1, "desc"]],
				columns: [
					{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
					{ data: 'id', name: 'id' },
					{ data: 'type', name: 'type' },
					{ data: 'value', name: 'value' },
					{ data: 'action', name: 'action', orderable: false, searchable: false }
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
					'targets': [1],
					"visible": false,
					"searchable": false
				}
				],
				"fnInitComplete": function () {
					$(".dataTables_length").addClass("hidden-xs");
					$(this).removeClass("hidden");
				},
				"order": [
					[1, "DESC"]
				]
			});
			
			$('#module').on('change', function() {
				table.draw();
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
							url: "/admin/intake-values/" + dataId,
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
	</script>
@endsection