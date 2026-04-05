@extends('layouts.super')

@section('title', "Sales Pipeline")

@section('content')
<style>
.d-flex.justify-content-between {
    color: color: hsl(215, 16%, 47%);
    color: hsl(215, 16%, 47%);
    font-size: 16px;

}

.epf {
    font-weight: 500;
    padding: 2px;
}

b,
strong {
    font-weight: 500;
}

.d-flex.justify-content-between.epf {
    border-bottom: 1px solid #f3f3f3;
}

.log-item {
    background: #e8edf9;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.badge {
    min-width: calc(var(--badge-padding-y) * 2 + var(--badge-font-size));
    /* box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px; */
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
}

.rk-stage-wrapper {
    display: flex;
    overflow-x: auto;
    background: #dfeceb;
    padding: 10px;
    border-radius: 8px;
}

/* each step */
.rk-stage-item {
    position: relative;
    padding: 10px 22px;
    font-size: 13px;
    color: #2c3e50;
    background: #b7d8d4;
    margin-right: 4px;
    white-space: nowrap;
    clip-path: polygon(0 0,
            calc(100% - 16px) 0,
            100% 50%,
            calc(100% - 16px) 100%,
            0 100%);
    transition: all .15s ease;
}

/* first */
.rk-stage-item:first-child {
    border-radius: 6px 0 0 6px;
}

/* last */
.rk-stage-item:last-child {
    margin-right: 0;
    border-radius: 0 6px 6px 0;
}

/* active stage (like Lost in screenshot) */
.rk-stage-item.active {
    background: #3aa69b;
    color: #fff;
    font-weight: 600;
}

/* clickable hover */
.rk-clickable {
    cursor: pointer;
}

.rk-clickable:hover {
    transform: translateY(-1px);
}

.card.ll {
    margin-left: -20px;
    margin-right: -20px;
}

.rk-tabs .nav-link {
    border-radius: 10px;
    padding: 6px 18px;
    font-size: 13px;
    color: #2c3e50;
    background: #e6f2f1;
    margin-right: 6px;
    transition: all .2s ease;
}

.rk-tabs .nav-link.active {
    background: #3aa69b;
    color: #fff;
    font-weight: 600;
}

.rk-tabs .nav-link:hover {
    background: #cfe8e5;
}
</style>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle stacked -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">{{$title}}</h4>
                <p class="mb-0 txt_1">{{$desc}}</p>
            </div>

            <div class="col-md-3 ms-auto">
                @can('lead_add')
                <!-- <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Add Lead
                </a> -->


                @endcan
            </div>

        </div>
    </div>
    <?php $status = config('fri.lead_status'); ?>

    <!-- Main content -->
    <section class="content">

        <!-- Tabs -->
        <ul class="nav nav-pills mb-3 rk-tabs" id="leadTabs">
            @foreach($tabs as $name => $statuses)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="javascript:void(0)"
                    data-status='@json($statuses)'>
                    {{ $name }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="content pt-0">

            <!-- Dashboard content -->
            <div class="row">
                <div class="col-xl-12">

                    <div class="card ll">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class=" table table-bordered table-striped table-hover datatable datatable-Role text-wrap"
                                    id="leadList">
                                    <thead>
                                        <tr>

                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Lead Name
                                            </th>
                                            <th>
                                                Phone
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Address
                                            </th>
                                            <th>Status</th>
                                            <th>
                                                Lead Sourse
                                            </th>
                                            <th>Sales Rep</th>
                                            <th>Category</th>
                                            <th>Created At</th>
                                             
                                        </tr>
                                    </thead>

                                </table>
                                <div id="no-data-container"></div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
    #leadList th,
    #leadList td {
        white-space: nowrap;
    }

    /* enable bottom horizontal scroll for DataTable */
    .dataTables_wrapper {
        width: 100%;
    }
    </style>
    <!--Models -->
    <!-- Add Lead Modal -->
    @include('admin.leads._add_lead_modal')
    @include('admin.leads._edit_modal')
    @include('admin.leads._view_lead_modal')
    @include('admin.leads._followup_lead_modal')
    @include('admin.leads._sync_modal')
    @include('admin.leads._listfollowup_modal', [
    'upcoming' => $upcoming,
    'past' => $past
    ])
    @include('admin.leads._email_modal',['emailTemplates'=>$emailTemplates])

    @endsection

    @section('scripts')
    @parent
    <script>
    $(function() {
        let status = @json($lstatus);
        let tabs = @json($tabs); // 🔥 from controller
        let currentStatus = Object.keys(tabs).length ? Object.values(tabs)[0] : [];
        let table = $('#leadList').DataTable({
            processing: true,
            serverSide: true,
            // scrollY: '100vh',        // vertical scroll (adjust height)
            // scrollX: true,          // horizontal scroll
            // scrollCollapse: true,
            responsive: false,
            pageLength: 10,
            order: [
                [0, 'desc']
            ],

            ajax: {
                url: "{{ route('superadmin.listLeads') }}",
                data: function(d) {
                    d.lead_source = $('#lead_source').val();
                    d.assign_rep = $('#assign_rep').val();
                    d.status = currentStatus;
                    d.url = window.location.pathname.split('/').pop();
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'lead_source',
                    name: 'lead_source'
                },
                {
                    data: 'salesRep',
                    name: 'salesRep'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                } 
            ]
        });

        $('#leadTabs').on('click', '.nav-link', function() {

            $('#leadTabs .nav-link').removeClass('active');
            $(this).addClass('active');

            let statusData = $(this).attr('data-status');

            try {
                currentStatus = JSON.parse(statusData); // ensure array
            } catch (e) {
                currentStatus = [];
            }

            table.ajax.reload();
        });

        /* Apply filter */
        let applyBtn = $('.apply');

        $('.apply').on('click', function() {
            applyBtn.text('Applying...');
            table.ajax.reload();
        });

        /* Reset filter */
        $('.reset').on('click', function() {
            applyBtn.text('Applying...');
            $('#leadFilterForm')[0].reset();
            table.ajax.reload();
        });

        /* Restore button text after request */
        table.on('xhr.dt', function() {
            applyBtn.text('Apply');
        });
    });

    // Export csv logic
    $('.exportCsv').click(function() {

        let lead_source = $('#lead_source').val();
        let assign_rep = $('#assign_rep').val();
        let status = $('#status').val();
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();

        let url = "/admin/exportLead?" +
            "lead_source=" + lead_source +
            "&assign_rep=" + assign_rep +
            "&status=" + status +
            "&from_date=" + from_date +
            "&to_date=" + to_date;

        window.location.href = url;
    });
    </script>
    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection