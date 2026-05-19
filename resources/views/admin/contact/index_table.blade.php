@extends('layouts.admin')

@section('title', "Contact")

@section('content')
<style>
.rk-contact-table-page {
    min-height: calc(100vh - 120px);
    padding: 12px 0;
    overflow-x: hidden;
    border-radius: 0;
    background:
        radial-gradient(circle at top left, rgba(16, 185, 129, .14), transparent 34%),
        radial-gradient(circle at top right, rgba(37, 99, 235, .12), transparent 30%),
        linear-gradient(180deg, #f8fbff 0%, #eef4f8 100%);
    color: #172033;
    font-family: Inter, "Segoe UI", sans-serif;
    font-size: 14px;
    font-weight: 500;
}

.rk-contact-table-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin: 0 14px 12px;
    padding: 22px;
    border: 1px solid rgba(148, 163, 184, .22);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(15, 23, 42, .96), rgba(30, 64, 175, .90)),
        #172033;
    box-shadow: 0 18px 45px rgba(15, 23, 42, .13);
    color: #fff;
}

.rk-contact-table-hero-main {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 0;
}

.rk-contact-table-icon {
    display: inline-flex;
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, .28);
    border-radius: 8px;
    background: linear-gradient(135deg, #14b8a6, #f59e0b);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .35), 0 14px 30px rgba(0, 0, 0, .22);
    color: #fff;
    font-size: 20px;
}

.rk-contact-table-kicker {
    display: block;
    margin-bottom: 4px;
    color: rgba(255, 255, 255, .70);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-contact-table-title {
    margin: 0;
    color: #fff;
    font-size: 26px;
    font-weight: 600;
    line-height: 1.18;
}

.rk-contact-table-subtitle {
    margin: 8px 0 0;
    color: rgba(255, 255, 255, .78);
    font-size: 13px;
}

.rk-contact-table-card {
    position: relative;
    border: 0;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 16px 35px rgba(15, 23, 42, .07);
}

.rk-contact-table-card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background:
        repeating-linear-gradient(90deg, #38a8ff 0 4px, transparent 4px 8px) top left / 100% 1px no-repeat,
        repeating-linear-gradient(90deg, #38a8ff 0 4px, transparent 4px 8px) bottom left / 100% 1px no-repeat,
        repeating-linear-gradient(180deg, #38a8ff 0 4px, transparent 4px 8px) top left / 1px 100% no-repeat,
        repeating-linear-gradient(180deg, #38a8ff 0 4px, transparent 4px 8px) top right / 1px 100% no-repeat;
    pointer-events: none;
}

.rk-contact-table-card > * {
    position: relative;
    z-index: 1;
}

.rk-contact-table-card {
    margin: 0;
    overflow: hidden;
}

.rk-contact-table-page > .content,
.rk-contact-table-page > .content > .content,
.rk-contact-table-page .row,
.rk-contact-table-page .col-xl-12 {
    margin-left: 0;
    margin-right: 0;
}

.rk-contact-table-page .col-xl-12 {
    padding-left: 0;
    padding-right: 0;
}

.rk-contact-table-card .card-body {
    padding: 10px 0 0;
}

.rk-contact-table-card .table-responsive {
    border-radius: 0;
}

#leadList {
    width: 100% !important;
    margin-bottom: 0 !important;
    border-color: #eef2f7;
    color: #172033;
    font-size: 13px;
    table-layout: fixed;
}

#leadList thead th {
    padding: 9px 10px;
    border-color: #e2e8f0;
    background: linear-gradient(180deg, #ffffff, #f8fafc);
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .02em;
    text-transform: uppercase;
    white-space: nowrap;
    vertical-align: middle;
    box-sizing: border-box;
}

#leadList tbody td {
    padding: 9px 10px;
    border-color: #eef2f7;
    vertical-align: middle;
    white-space: nowrap;
    box-sizing: border-box;
}

#leadList thead th:first-child,
#leadList tbody td:first-child {
    width: 54px;
    text-align: center;
}

#leadList thead th:nth-child(2),
#leadList tbody td:nth-child(2) {
    width: 220px;
    min-width: 220px;
}

#leadList tbody td:nth-child(2) a {
    display: flex;
    align-items: center;
    min-height: 32px;
    color: #172033;
    font-weight: 600;
    text-decoration: none;
}

#leadList .rk-contact-person {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}

#leadList .rk-contact-avatar {
    display: inline-flex;
    width: 34px;
    height: 34px;
    flex: 0 0 34px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, #0ea5e9, #2563eb);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .03em;
    box-shadow: 0 8px 18px rgba(37, 99, 235, .20);
}

#leadList .rk-avatar-tone-0 {
    background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
}

#leadList .rk-avatar-tone-1 {
    background: linear-gradient(135deg, #14b8a6 0%, #047857 100%);
}

#leadList .rk-avatar-tone-2 {
    background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
}

#leadList .rk-avatar-tone-3 {
    background: linear-gradient(135deg, #f97316 0%, #dc2626 100%);
}

#leadList .rk-avatar-tone-4 {
    background: linear-gradient(135deg, #22c55e 0%, #3f6212 100%);
}

#leadList .rk-avatar-tone-5 {
    background: linear-gradient(135deg, #ec4899 0%, #be123c 100%);
}

#leadList .rk-avatar-tone-6 {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
}

#leadList .rk-avatar-tone-7 {
    background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);
}

#leadList .rk-contact-name-wrap {
    display: block;
    min-width: 0;
}

#leadList .rk-contact-name {
    display: block;
    color: #172033;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.2;
}

#leadList .rk-contact-id {
    display: block;
    margin-top: 2px;
    color: #64748b;
    font-size: 12px;
    font-weight: 500;
    line-height: 1.2;
}

#leadList tbody td:nth-child(2) img,
#leadList tbody td:nth-child(2) .avatar,
#leadList tbody td:nth-child(2) .rounded-circle {
    width: 34px !important;
    height: 34px !important;
    flex: 0 0 34px;
    margin-right: 0;
    object-fit: cover;
}

#leadList tbody td:nth-child(2) > div,
#leadList tbody td:nth-child(2) .d-flex {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 32px;
}

#leadList tbody td:nth-child(2) [class*="avatar"],
#leadList tbody td:nth-child(2) .initials {
    width: 34px !important;
    height: 34px !important;
    flex: 0 0 34px;
}

#leadList thead th:nth-child(3),
#leadList tbody td:nth-child(3) {
    width: 140px;
    min-width: 140px;
}

#leadList thead th:nth-child(4),
#leadList tbody td:nth-child(4) {
    width: 220px;
    min-width: 220px;
}

#leadList thead th:nth-child(5),
#leadList tbody td:nth-child(5) {
    width: 250px;
    min-width: 250px;
    white-space: normal;
}

#leadList thead th:nth-child(6),
#leadList tbody td:nth-child(6) {
    width: 190px;
    min-width: 190px;
    white-space: normal;
}

#leadList tbody td:nth-child(6) .badge {
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

#leadList thead th:nth-child(7),
#leadList tbody td:nth-child(7) {
    width: 130px;
    min-width: 130px;
}

#leadList thead th:nth-child(8),
#leadList tbody td:nth-child(8),
#leadList thead th:nth-child(10),
#leadList tbody td:nth-child(10) {
    width: 145px;
    min-width: 145px;
}

#leadList thead th:nth-child(9),
#leadList tbody td:nth-child(9) {
    width: 190px;
    min-width: 190px;
    white-space: normal;
}

#leadList tbody td.rk-wrap-cell {
    line-height: 1.45;
    white-space: normal;
}

#leadList thead th:last-child,
#leadList tbody td:last-child {
    width: 90px;
    text-align: center;
}

#leadList tbody tr:hover {
    background: #fbfdff;
}

#leadList .btn {
    display: inline-flex;
    min-height: 32px;
    align-items: center;
    gap: 6px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.dataTables_wrapper {
    width: 100%;
}

.rk-dt-toolbar,
.rk-dt-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}

.rk-dt-toolbar {
    padding: 0 14px 10px;
    border-bottom: 1px solid #eef2f7;
    margin-bottom: 8px;
}

.rk-dt-footer {
    padding: 14px 0 0;
}

.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_length {
    margin: 0;
}

.dataTables_wrapper .dataTables_filter label {
    margin: 0;
}

.rk-dt-search,
.rk-dt-left {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
    min-height: 36px;
    border: 1px solid #d9e4ef;
    border-radius: 8px;
    background: #fbfdff;
    color: #172033;
    font-size: 13px;
}

.dataTables_wrapper .dataTables_filter input {
    min-width: 230px;
    margin-left: 0;
}

.rk-filter-toggle {
    display: inline-flex;
    min-height: 36px;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(79, 70, 229, .26);
    border-radius: 8px;
    background: #fff;
    color: #4f46e5;
    padding: 0 14px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 8px 18px rgba(79, 70, 229, .08);
}

.rk-filter-toggle .rk-filter-count {
    display: inline-flex;
    min-width: 20px;
    height: 20px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 11px;
}

.rk-contact-filter-panel {
    display: none;
    margin: 0 14px 14px;
    padding: 14px;
    border: 1px solid #dbeafe;
    border-radius: 8px;
    background: linear-gradient(180deg, #ffffff, #f8fbff);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .8);
}

.rk-contact-filter-panel.is-open {
    display: block;
}

.rk-contact-filter-panel label {
    margin-bottom: 5px;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
}

.rk-contact-filter-panel .form-control,
.rk-contact-filter-panel .form-select {
    min-height: 38px;
    border-color: #d9e4ef;
    border-radius: 8px;
    color: #172033;
    font-size: 13px;
}

.rk-filter-actions {
    display: flex;
    align-items: end;
    gap: 8px;
}

.rk-filter-actions .btn {
    min-height: 38px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.dataTables_wrapper .dt-buttons {
    display: none !important;
}

.dataTables_wrapper .dataTables_scroll {
    border: 1px solid #eef2f7;
    border-radius: 8px;
    overflow: hidden;
}

.dataTables_wrapper table.dataTable {
    margin: 0 !important;
    border-collapse: collapse !important;
}

.dataTables_wrapper .dataTables_scrollHead table,
.dataTables_wrapper .dataTables_scrollBody table {
    width: 100% !important;
    table-layout: fixed;
}

.dataTables_wrapper .dataTables_scrollHeadInner {
    width: 100% !important;
}

.dataTables_wrapper .dataTables_scrollHeadInner table {
    margin-bottom: 0 !important;
}

.dataTables_wrapper .dataTables_scrollHead,
.dataTables_wrapper .dataTables_scrollBody {
    border: 0 !important;
}

.dataTables_wrapper .dataTables_scrollBody {
    scrollbar-color: #cbd5e1 #f8fafc;
    scrollbar-width: thin;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
}

.badge {
    min-width: calc(var(--badge-padding-y) * 2 + var(--badge-font-size));
    box-shadow: none;
}

.log-item {
    background: #e8edf9;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

@media (max-width: 991px) {
    .rk-contact-table-page {
        padding: 10px 0;
    }

    .rk-contact-table-hero {
        margin: 0 10px 10px;
        flex-direction: column;
        align-items: flex-start;
    }

    .dataTables_wrapper .dataTables_filter input {
        min-width: 100%;
    }

    .rk-dt-search,
    .rk-dt-left {
        width: 100%;
    }

    .rk-filter-toggle {
        flex: 1;
        justify-content: center;
    }
}
</style>
<!-- Page header -->
<div class="page-header rk-contact-table-page">
    <div class="page-header-content d-lg-flex">
        <div class="rk-contact-table-hero w-100">
            <!-- Title + subtitle stacked -->
            <div class="rk-contact-table-hero-main">
                <span class="rk-contact-table-icon"><i class="ph-address-book"></i></span>
                <div>
                    <span class="rk-contact-table-kicker">Contact table</span>
                    <h4 class="page-title rk-contact-table-title">Qualified Contacts</h4>
                    <p class="rk-contact-table-subtitle">Manage qualified leads and track proposal engagement</p>
                </div>
            </div>

        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="content pt-0">

            <!-- Dashboard content -->
            <div class="row">
                <div class="col-xl-12">

                    <div class="card rk-contact-table-card">

                        <div class="card-body">
                            <div class="rk-contact-filter-panel" id="contactFilterPanel">
                                <form class="row g-3 align-items-end" id="leadFilterForm">
                                    <div class="col-lg-3 col-md-6">
                                        <label for="lead_source">Lead Source</label>
                                        <select name="lead_source" id="lead_source" class="form-control">
                                            <option value="">All sources</option>
                                            @foreach($leadSource as $data)
                                            <option value="{{ $data->id }}">{{ $data->source }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label for="assign_rep">Sales Rep</label>
                                        <select name="assign_rep" id="assign_rep" class="form-control">
                                            <option value="">All sales reps</option>
                                            <option value="unassigned">Unassigned</option>
                                            @foreach($users as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="">All statuses</option>
                                            <option value="pending">Pending</option>
                                            <option value="Getting Proposal Ready">Getting Proposal Ready</option>
                                            <option value="Proposal Sent">Proposal Sent</option>
                                            <option value="Follow Up Scheduled">Follow Up Scheduled</option>
                                            <option value="Proposal Accepted">Proposal Accepted</option>
                                            <option value="Lost">Lost</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 rk-filter-actions">
                                        <button type="button" class="btn btn-primary apply">
                                            <i class="ph-check-circle me-1"></i> Apply
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary reset">
                                            Reset
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-wrap" id="leadList">
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
                                                Lead Source
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

    </div>

    @endsection

    @section('scripts')
    @parent

    <script>
    $(function() {

        let table = $('#leadList').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"rk-dt-toolbar"<"rk-dt-left"<"rk-dt-search"f><"rk-filter-slot">><"rk-dt-length"l>>rt<"rk-dt-footer"ip>',
            scrollX: true,
            scrollCollapse: true,
            autoWidth: false,
            responsive: false,
            pageLength: 10,
            language: {
                search: '',
                searchPlaceholder: 'Search contacts...'
            },
            order: [
                [0, 'desc']
            ],

            ajax: {
                url: "{{ route('admin.listLeadsContact') }}",
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
            ],
            columnDefs: [
                {
                    targets: 0,
                    width: '54px',
                    className: 'text-center'
                },
                {
                    targets: 1,
                    width: '220px'
                },
                {
                    targets: 2,
                    width: '140px'
                },
                {
                    targets: 3,
                    width: '220px'
                },
                {
                    targets: 4,
                    width: '250px',
                    className: 'rk-wrap-cell'
                },
                {
                    targets: 5,
                    width: '190px',
                    className: 'rk-status-cell'
                },
                {
                    targets: 6,
                    width: '130px'
                },
                {
                    targets: [7, 9],
                    width: '145px'
                },
                {
                    targets: 8,
                    width: '190px',
                    className: 'rk-wrap-cell'
                },
                {
                    targets: -1,
                    width: '90px',
                    className: 'text-center'
                }
            ]
        });

        $('.rk-filter-slot').html(`
            <button type="button" class="rk-filter-toggle" id="contactFilterToggle">
                <i class="ph-sliders-horizontal"></i>
                <span>Filters</span>
                <span class="rk-filter-count" id="contactFilterCount">0</span>
            </button>
        `);

        function updateFilterCount() {
            let total = 0;
            $('#leadFilterForm select').each(function() {
                if ($(this).val()) {
                    total++;
                }
            });

            $('#contactFilterCount').text(total);
        }

        $(document).on('click', '#contactFilterToggle', function() {
            $('#contactFilterPanel').toggleClass('is-open');
        });

        $('.apply').on('click', function() {
            updateFilterCount();
            table.ajax.reload();
        });

        $('.reset').on('click', function() {
            setTimeout(function() {
                updateFilterCount();
                table.ajax.reload();
            }, 0);
        });

        updateFilterCount();

    });
    </script>


    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection
