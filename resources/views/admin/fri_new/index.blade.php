@extends('layouts.admin')

@section('title','RFI')

@section('content')
<style>
#friTable td,
#friTable th {
    white-space: nowrap;
}

.notify-dot {
    position: relative;
    display: inline-block;
    width: 10px;
    height: 10px;
    background: red;
    border-radius: 50%;
    margin-left: 6px;
}

.notify-dot::after {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: red;
    top: 0;
    left: 0;
    animation: ping 1.5s infinite;
}

@keyframes ping {
    0% {
        transform: scale(1);
        opacity: 0.8;
    }

    70% {
        transform: scale(2.5);
        opacity: 0;
    }

    100% {
        transform: scale(2.5);
        opacity: 0;
    }
}
</style>
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">RFI Management</h4>
                <p class="mb-0 txt_1">Manage requests for information and project communications</p>
            </div>

            <div class="col-md-3 ms-auto">
                @can('RFI_create')
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Create RFI
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>


<section class="content">

    <div class="card p-3 mb-3">

        <form id="filterForm">

            <div class="row">

                <div class="col-md-4">
                    <label>Search</label>
                    <input type="text" class="form-control" name="search_key">
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        @foreach($status as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Priority</label>
                    <select name="priority" class="form-select">
                        <option value="">All</option>
                        @foreach($priority as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Category</label>
                    <select name="category" class="form-select">
                        <option value="">All</option>
                        @foreach($category as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2 align-items-end">

                    <button class="btn btn-primary apply">Apply</button>

                    <button type="reset" class="btn btn-secondary reset">Reset</button>

                </div>

            </div>

        </form>

    </div>



    <div class="card p-3">

        <div class="table-responsive1">

            <table class="table table-bordered table-striped table-hover datatable datatable-Role" id="friTable">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Subject</th>
                         
                        <th>Lead</th>
                        <th>Status</th>
                        <th>Priority</th>

                        <th>Due Date</th>
                        <th>Created By</th>
                        <th>Assigned To</th>
                        <th>Action</th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

</section>

@include('admin.fri_new._add_modal', ['users' => $users, 'status' => $status, 'categories' =>
$categories,'leads'=>$leads])
@include('admin.fri_new._edit_modal', ['users' => $users, 'status' => $status, 'categories' => $categories])
@include('admin.fri_new._view_modal',['status' => $status])
@include('admin.fri_new._reply_modal')
@endsection



@section('scripts')

<script>
$(function() {

    let table = $('#friTable').DataTable({

        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: false,
        order: [
            [0, 'desc']
        ],

        ajax: {
            url: "{{ route('admin.listFritable') }}",
            data: function(d) {
                d.search_key = $('input[name="search_key"]').val();
                d.status = $('select[name="status"]').val();
                d.priority = $('select[name="priority"]').val();
                d.category = $('select[name="category"]').val();
            }
        },

        drawCallback: function() {
            fetchUnreadReplies();
        },

        columns: [{
                data: 'id'
            },
            {
                data: 'subject'
            },
            
            {
                data: 'lead'
            },
            {
                data: 'status'
            },
            {
                data: 'priority'
            },
            {
                data: 'due_date'
            },
            {
                data: 'created_by'
            },
            {
                data: 'assigned_to'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]

    });


    $('.apply').click(function(e) {

        e.preventDefault();
        table.ajax.reload();

    });


    $('.reset').click(function() {

        setTimeout(function() {

            table.ajax.reload();

        }, 200);

    });

});
</script>

@endsection