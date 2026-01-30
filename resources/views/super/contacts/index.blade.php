@extends('layouts.admin')

@section('title', "{{ trans('contacts.contacts') }}")

@section('content')
	<div class="page-header">
		<div class="page-header-content d-lg-flex">
			<div class="d-flex">
				<h4 class="page-title mb-0">
					{{ trans('contacts.contacts_list') }} - <span class="fw-normal">{{ trans('contacts.create') }}</span>
				</h4>

				<a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
					<i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
				</a>
			</div>
		</div>
	</div>
    <!-- Main content -->
	<section class="content pt-0">
	  <div class="card">
		<div class="card-header">
		  <h3 class="card-title"></h3>
		  @can('contact_create')
		  <a href="javascript:;" onclick="createEditContactModal('create');" class="btn btn-success m-1 createEditContact" style="float: right;">{{ trans('contacts.new_contact') }}</a>
		  @endcan
		</div>
		<!-- /.card-header -->
		<div class="card-body">
		  <div class="row mb-3">
			  <div class="col-6">
				<label class="form-label" for="contact_search">{{ trans('contacts.search') }}</label>
				<input type="text" class="form-control" id="contact_search">
			  </div>
			  <div class="col-6">
				<label class="form-label" for="contact_type">{{ trans('contacts.contact_type') }}</label>
				<select class="form-control" id="contact_type">
					<option value="">{{ trans('global.select') }}</option>
					@if($contact_type_list)
						@foreach($contact_type_list as $key=>$value)
							<option value="{{$key}}">{{$value}}</option>
						@endforeach
					@endif	
				</select>
			  </div>
			</div>
		  <table class="table" id="jsGridContactsMain">
			<thead>
				<tr>
					<th>{{ trans('contacts.contact_name') }}</th>
					<th>{{ trans('contacts.contact_type') }}</th>
					<th>{{ trans('contacts.date_created') }}</th>
					<th>{{ trans('contacts.primary_email') }}</th>
					<th>{{ trans('contacts.phone') }}</th>
					<th>{{ trans('contacts.primary_address') }}</th>
					<th>&nbsp;</th>
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
	@include('admin.intakes.components.modals.create-edit-contact-modal')
	@include('admin.intakes.components.modals.add-address-modal')
		
@endsection

@section('styles')
<style>
.nowrap-column { white-space: nowrap;}
</style>
@endsection

@section('scripts')
@parent
	<script>
		const route = {
			admin: {
				contacts_store: "{{ route('admin.contacts.store') }}",
				contact_update: "{{ route('admin.contacts.contact_update') }}",
				contactDetails: "{{ route('admin.contacts.contactDetails') }}",
				addAddress: "{{ route('admin.contacts.addAddress') }}",
				contactAddressList: "{{ route('admin.contacts.contactAddressList') }}",
			}
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function () {
			var table = $('#jsGridContactsMain').DataTable({
				dom: 'rtp', //rtip Bfrtip lfrtip
				processing: true,
				serverSide: true,
				"ajax": {
					url: '{{ route('admin.contacts.contactList') }}',
					data: function (d) {
						d.contact_search = $('#contact_search').val();
						d.contact_type = $('#contact_type').val();
					}
				},
				"autoWidth": false,
				"aaSorting": [[5, "desc"]],
				columns: [
					{ data: 'name', name: 'name', className: 'nowrap-column' },
					{ data: 'contact_type', name: 'contact_type', className: 'nowrap-column' },
					{ data: 'created_at', name: 'created_at', className: 'nowrap-column' },
					{ data: 'email', name: 'email', className: 'nowrap-column' },
					{ data: 'phone', name: 'phone', className: 'nowrap-column' },
					{ data: 'address', name: 'address', className: 'nowrap-column' },
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
					'targets': [3]
				}, {  // set default column settings
					'targets': [3],
					"visible": true,
					"searchable": false
				}
				],
				"fnInitComplete": function () {
					$(".dataTables_length").addClass("hidden-xs");
					$(this).removeClass("hidden");
				},
				"order": [
					[3, "DESC"]
				]
			});
			
			$('#contact_search').on('keyup', function() {
				table.draw();
			});
			$('#contact_type').on('change', function() {
				table.draw();
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
							url: "/admin/contacts/" + dataId,
							type: "DELETE",
							headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
							success: function (response) {
								Swal.fire("Deleted!", response.message, "success");
								$('#jsGridContactsMain').DataTable().ajax.reload();
							},
							error: function (xhr) {
								Swal.fire("Error!", "Something went wrong.", "error");
							}
						});
					}
				});
			});
			
			$(document).on('click', '.editPopupContactBtn', function () {
				$('.error-message').remove();
				let contact_id = $(this).data('id');
				$('#pop_contact_id').val(contact_id);
				
				$.ajax({
					url:route.admin.contactDetails,
					type:'POST',
					data: {
						'id':contact_id,
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(response) {
						if(response.status=='success')
						{
							$('#pop_contact_id').val(contact_id);
							$('input[name="contact_nature"][value="'+response.data.nature+'"]').prop('checked', true);
							$('#a_contact_type').val(response.data.type);
							$('#contact_prefix').val(response.data.prefix);
							$('#contact_first_name').val(response.data.first_name);		
							$('#contact_middle_name').val(response.data.middle_name);		
							$('#contact_last_name').val(response.data.last_name);	
							$('#contact_suffix').val(response.data.suffix);	
							$('#contact_gender').val(response.data.gender);	
							$('#contact_alias').val(response.data.alias);
							$('#contact_marital_status').val(response.data.marital_status);
							$('#contact_company_name').val(response.data.company_name);
							$('#contact_job_title').val(response.data.job_title);
							$('#contact_ssn').val(response.data.ssn);
							$('#contact_work_phone').val(response.data.work_phone);
							$('#contact_home_phone').val(response.data.home_phone);
							$('#a_contact_phone').val(response.data.phone);
							$('#contact_whentocontact').val(response.data.whentocontact);
							$('#a_contact_email').val(response.data.email);
							$('#contact_preference').val(response.data.contact_preference);
							$('#contact_fax').val(response.data.fax);
							$('#contact_secondary_email').val(response.data.secondary_email);
							$('#contact_language').val(response.data.language);
							$('#contact_drivers_license').val(response.data.drivers_license);
							$('#contact_dob').val(response.data.dob);
							$('#contact_dodeath').val(response.data.dodeath);
							$('#contact_dobankruptcy').val(response.data.dobankruptcy);
							$('#contact_notes').val(response.data.notes);
							
							createEditContactModal('edit');					
						}
					},
					error: function(xhr) {
						console.error('Error: ', xhr.responseText);
					}
				});
			});			
		});
	</script>
	<script src="{{asset('js/lead/create-edit-contact.js')}}"></script>
@endsection
