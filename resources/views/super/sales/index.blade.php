@extends('layouts.super')

@section('title', "Leads")

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

</style>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle stacked -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">Sales Pipeline</h4>
                <p class="mb-0 txt_1">Manage and track workflow progress</p>
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
    <section class="content d-none">
        @php
        $currentStatus = $lead->status ?? '';

        $followUpCount = $upcoming->count() + $past->count();

        $unassigned = $leads->whereNull('assign_rep')
        ->whereNotIn('status', ['Qualified','Sold'])
        ->count();
        @endphp

        <div class="rk-stage-wrapper">

            {{-- lifecycle statuses --}}
            @foreach($status as $value)
            @php
            $count = $leads->where('status', $value)->count();
            $isActive = $currentStatus === $value;
            @endphp

            <div class="rk-stage-item {{ $isActive ? 'active' : '' }}">
                <div class="rk-stage-label">
                    {{ $value }} ({{ $count }})
                </div>
            </div>
            @endforeach

            {{-- Follow Up --}}
            <div class="rk-stage-item rk-clickable" data-bs-toggle="modal" data-bs-target="#followUpModal">
                <div class="rk-stage-label">
                    Follow Up ({{ $followUpCount }})
                </div>
            </div>

            {{-- Unassigned --}}
            <div class="rk-stage-item">
                <div class="rk-stage-label">
                    Unassigned ({{ $unassigned }})
                </div>
            </div>

        </div>


    </section>


    <!-- Main content -->
    <section class="content">
        <div class="card p-2 form_1 d-none">
            <form class="d-flex align-items-center justify-content-between flex-wrap">

                <!-- Left stats -->
                <div class="d-flex gap-4 flex-wrap">

                    <!-- New Leads -->
                    <div class="d-flex align-items-center">
                        <div class="rounded p-2 d-flex align-items-center justify-content-center"
                            style="background-color: #eef4ff; width: 40px; height: 40px;">
                            <!-- icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-users h-5 w-5 text-primary">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <small class="text-muted">New Leads</small>
                            <div class="fw-bold fwb">{{$leads->where('status', 'New')->count()}}</div>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="d-flex align-items-center">
                        <div class="rounded p-2 d-flex align-items-center justify-content-center"
                            style="background-color: #e9f9ee; width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-clock h-5 w-5 text-secondary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <small class="text-muted">Under Construction</small>
                            <div class="fw-bold fwb">{{$leads->where('status', 'Under Construction')->count()}}</div>
                        </div>
                    </div>

                    <!-- Follow-ups Due -->
                    <div class="d-flex align-items-center">
                        <div class="rounded p-2 d-flex align-items-center justify-content-center"
                            style="background-color: #fdecec; width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-circle-alert h-5 w-5 text-destructive">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#followUpModal"><small
                                    class="text-muted">Follow-ups Due</small></a>
                            <div class="fw-bold fwb totalFollowups1">{{$upcoming->count() + $past->count()}}</div>
                        </div>
                    </div>
                </div>

                <!-- Right button -->
                <div>
                    <a href="#" class="btn btn-outline-danger d-flex align-items-center gap-1 d-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-alert h-4 w-4 mr-2"
                            data-lov-id="src/components/leads/LeadsSummaryBar.tsx:62:12" data-lov-name="AlertCircle"
                            data-component-path="src/components/leads/LeadsSummaryBar.tsx" data-component-line="62"
                            data-component-file="LeadsSummaryBar.tsx" data-component-name="AlertCircle"
                            data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" x2="12" y1="8" y2="12"></line>
                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                        </svg>
                        View Follow-ups Due
                    </a>
                </div>

            </form>
        </div>

        <div class="card p-3 form_1">
            <form id="leadFilterForm">

                <div class="row g-3">

                    <!-- Lead Source -->
                    <div class="col-md-3">
                        <label class="form-label1">Lead Source</label>
                        <select name="lead_source" id="lead_source" class="form-control">
                            <option value="">Select All</option>
                            @foreach($leadSource as $data)
                            <option value="{{ $data->id }}">{{ $data->source }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sales Rep -->
                    <div class="col-md-3">
                        <label class="form-label1">Sales Rep</label>
                        <select name="assign_rep" id="assign_rep" class="form-control">
                            <option value="">Select All</option>
                            <option value="unassigned">Unassigned</option>
                            @foreach($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-2">
                        <label class="form-label1">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Select All</option>
                            @foreach($status as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="col-md-2">
                        <label class="form-label1">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control">
                    </div>

                    <!-- To Date -->
                    <div class="col-md-2">
                        <label class="form-label1">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control">
                    </div>

                </div>

                <!-- Buttons Row -->
                <div class="row mt-3">
                    <div class="col-md-12 d-flex gap-2">
                        <button type="button" class="btn btn-primary apply">
                            Apply
                        </button>

                        <button type="reset" class="btn btn-outline-secondary reset">
                            Reset
                        </button>

                        <button type="button" class="btn btn-success exportCsv">
                            Export CSV
                        </button>
                    </div>
                </div>

            </form>

        </div>

        <!-- List leads -->
        <div class="card shadow-sm rounded-3 p-4 mb-3 form_1 d-none">
            <div class="d-flex justify-content-between align-items-start">

                <!-- Left: Name & Details -->
                <div>
                    <h5 class="fw-bold mb-1 lead">John Mitchell</h5>
                    <div class="text-muted  mb-1">
                        <i class="ph-phone me-1"></i> +61 2 9876 5432 &nbsp;
                        <i class="ph-envelope me-1 "></i> john.mitchell@email.com
                    </div>
                    <div class="text-muted  mb-2">
                        <i class="ph-map-pin me-1"></i> 123 Solar Street, Sydney NSW 2000
                    </div>
                    <div class=" text-muted">
                        Source: <strong class="text-dark">Solar Choice</strong> &nbsp;|&nbsp;
                        Follow-ups: <strong class="text-dark">0</strong> &nbsp;|&nbsp;
                        Storeys: <strong class="text-dark">2</strong> &nbsp;|&nbsp;
                        Roof: <strong class="text-dark">Tile</strong> &nbsp;|&nbsp;
                        Rebate: <strong class="text-dark">Yes</strong>
                    </div>
                </div>


                <!-- Right: Status & Actions -->
                <div class="d-flex flex-column align-items-center justify-content-center text-center">
                    <span class="badge bg-primary rounded-pill px-3 py-1 mb-2">New</span>
                    <div class="mb-2">
                        <small class="text-muted">Assigned to:</small><br>
                        <strong class="text-dark">Vinod Sharma</strong>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-warning me-1 custom-btn">
                            <i class="ph-envelope-simple"></i>&nbsp; Email
                        </button>
                        <button class="btn btn-sm btn-primary bg_s px-4 py-2">
                            View
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <div id="leads-container1"></div>

        <!-- <div class="text-center mt-3">
            <button id="load-more" class="btn btn-primary px-4 bg_s">Load More</button>
        </div> -->

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
                                            <th>
                                                Action
                                            </th>
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

    <!-- Follow-up Modal -->
    <!-- Follow-up Modal -->








    @endsection

    @section('scripts')
    @parent


    <script>
    $(function() {

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
                    d.status = $('#status').val();
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
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
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


    $(document).on('click', '.follow_up', function() {
        let leadId = $(this).data('id'); // get lead id from button
        let leadName = $(this).data('name');
        $('.lead_id').val(leadId); // put it in hidden input of form
        $('.leadName').text(leadName);
    });

   
    $(document).on('click', '.send_email', function() {
        // parse string value into object
        let lead = $(this).data('lead');

        $('.lead_id').val(lead.id);
        $('.lead_name').text(lead.first_name + ' ' + lead.last_name);
        $('.lead_email').val(lead.email);
    });


    $(document).on('click', '.send_email_inner', function() {
        // parse string value into object
        let lead = JSON.parse($('.send_email_view').val());

        $('.lead_id').val(lead.id);
        $('.lead_name').text(lead.first_name + ' ' + lead.last_name);
        $('.lead_email').val(lead.email);
    });
    </script>

    
    


    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection