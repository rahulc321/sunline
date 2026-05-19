@extends('layouts.super')

@section('title', "Leads")

@section('content')
@php
    $status = config('fri.lead_status');
    $newLeadsCount = $leads->where('status', 'New')->count();
    $constructionCount = $leads->where('status', 'Under Construction')->count();
    $followUpCount = $upcoming->count() + $past->count();
    $unassigned = $leads->whereNull('assign_rep')->whereNotIn('status', ['Qualified','Sold'])->count();
@endphp

<style>
:root {
    --sales-ink: #102033;
    --sales-muted: #65758b;
    --sales-blue: #1769aa;
    --sales-green: #36b37e;
    --sales-gold: #f6b445;
    --sales-line: #dce6ef;
    --sales-bg: #f4f8fb;
}

.content-inner {
    background:
        linear-gradient(180deg, rgba(23, 105, 170, 0.08), transparent 280px),
        var(--sales-bg);
    padding: 22px;
}

.sales-page {
    color: var(--sales-ink);
    font-family: "Inter", "Segoe UI", sans-serif;
}

.sales-hero {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 20px;
    align-items: center;
    margin-bottom: 18px;
    padding: 22px;
    border: 1px solid rgba(23, 105, 170, 0.14);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(7, 26, 47, 0.96), rgba(13, 61, 103, 0.94) 56%, rgba(54, 179, 126, 0.88)),
        url("{{ asset('vendor/images/demo/cover3.jpg') }}") center/cover no-repeat;
    box-shadow: 0 18px 48px rgba(16, 32, 51, 0.12);
    overflow: hidden;
}

.sales-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    padding: 6px 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 999px;
    color: rgba(255, 255, 255, 0.82);
    background: rgba(255, 255, 255, 0.1);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.sales-hero h1 {
    margin: 0;
    color: #ffffff;
    font-size: 30px;
    line-height: 1.15;
    font-weight: 850;
    letter-spacing: 0;
}

.sales-hero p {
    max-width: 680px;
    margin: 8px 0 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 14px;
    line-height: 1.6;
}

.sales-hero-count {
    min-width: 150px;
    padding: 16px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    text-align: center;
}

.sales-hero-count span {
    display: block;
    color: rgba(255, 255, 255, 0.72);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.sales-hero-count strong {
    display: block;
    margin-top: 6px;
    font-size: 34px;
    font-weight: 850;
    line-height: 1;
}

.sales-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 18px;
}

.sales-stat-card {
    position: relative;
    overflow: hidden;
    min-height: 118px;
    padding: 16px;
    border: 1px solid var(--sales-line);
    border-radius: 8px;
    background: #ffffff;
    box-shadow: 0 14px 34px rgba(16, 32, 51, 0.07);
}

.sales-stat-card::after {
    content: "";
    position: absolute;
    top: -34px;
    right: -28px;
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: var(--stat-soft);
}

.sales-stat-card.blue { --stat-main: var(--sales-blue); --stat-end: #51b7d8; --stat-soft: rgba(23, 105, 170, 0.14); }
.sales-stat-card.green { --stat-main: var(--sales-green); --stat-end: #58c79b; --stat-soft: rgba(54, 179, 126, 0.14); }
.sales-stat-card.gold { --stat-main: var(--sales-gold); --stat-end: #e8792e; --stat-soft: rgba(246, 180, 69, 0.18); }
.sales-stat-card.slate { --stat-main: #0f466f; --stat-end: #268765; --stat-soft: rgba(15, 70, 111, 0.14); }

.sales-stat-top {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.sales-stat-icon {
    display: inline-flex;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #ffffff;
    background: linear-gradient(135deg, var(--stat-main), var(--stat-end));
    font-size: 19px;
    box-shadow: 0 12px 24px rgba(16, 32, 51, 0.14);
}

.sales-stat-card span.label {
    display: block;
    margin-bottom: 8px;
    color: var(--sales-muted);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.sales-stat-card strong {
    color: var(--sales-ink);
    font-size: 28px;
    font-weight: 850;
    line-height: 1;
}

.sales-panel {
    border: 1px solid var(--sales-line) !important;
    border-radius: 8px !important;
    background: #ffffff;
    box-shadow: 0 14px 34px rgba(16, 32, 51, 0.07) !important;
    overflow: hidden;
}

.sales-panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 16px 18px;
    border-bottom: 1px solid #e8eff6;
    background: linear-gradient(180deg, #ffffff, #fbfdff);
}

.sales-panel-title {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0;
    color: var(--sales-ink);
    font-size: 15px;
    font-weight: 850;
}

.sales-panel-title i {
    color: var(--sales-blue);
    font-size: 19px;
}

.sales-panel-chip {
    border: 1px solid rgba(23, 105, 170, 0.14);
    background: rgba(23, 105, 170, 0.07);
    color: var(--sales-blue);
    border-radius: 999px;
    padding: 5px 10px;
    font-size: 11px;
    font-weight: 800;
}

.sales-filter-body {
    padding: 18px;
}

.sales-filter-body .form-label1 {
    display: block;
    margin-bottom: 7px;
    color: #34455a;
    font-size: 12px;
    font-weight: 850;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.sales-filter-body .form-control,
.sales-filter-body .form-select {
    min-height: 42px;
    border: 1px solid #d8e3ed;
    border-radius: 8px;
    color: var(--sales-ink);
    background-color: #f8fbfd;
    box-shadow: none;
}

.sales-filter-body .form-control:focus,
.sales-filter-body .form-select:focus {
    border-color: rgba(23, 105, 170, 0.58);
    background-color: #ffffff;
    box-shadow: 0 0 0 0.18rem rgba(23, 105, 170, 0.12);
}

.sales-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.sales-actions .btn,
.sales-page .dt-buttons .btn {
    min-height: 40px;
    height: auto;
    border-radius: 8px;
    padding: 8px 14px;
    font-weight: 800;
}

.sales-actions .apply,
.sales-page .btn-primary {
    border-color: transparent !important;
    background: linear-gradient(135deg, var(--sales-blue), var(--sales-green)) !important;
    color: #ffffff !important;
}

.sales-actions .exportCsv,
.sales-page .btn-success {
    border-color: transparent !important;
    background: linear-gradient(135deg, #268765, var(--sales-green)) !important;
    color: #ffffff !important;
}

.sales-actions .reset {
    border-color: #cfdbe6 !important;
    color: #52667c !important;
    background: #ffffff !important;
}

.sales-table-card {
    margin-top: 18px;
}

.sales-table-body {
    padding: 0;
}

.sales-table-wrap {
    width: 100%;
    overflow-x: auto;
}

#leadList {
    width: 100% !important;
    margin-bottom: 0 !important;
}

#leadList th,
#leadList td {
    white-space: nowrap;
    vertical-align: middle;
}

#leadList thead th {
    border: 0 !important;
    background: linear-gradient(135deg, var(--sales-blue), var(--sales-green)) !important;
    color: #ffffff !important;
    font-size: 12px;
    font-weight: 850;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

#leadList tbody td {
    border-color: #edf3f8 !important;
    color: #53687f !important;
    font-size: 13px;
}

#leadList tbody tr:hover td {
    background: #f7fbfd;
}

#leadList .sales-name-cell,
#leadList .sales-rep-cell {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--sales-ink);
    font-weight: 800;
    text-decoration: none;
}

#leadList .sales-name-cell:hover {
    color: var(--sales-blue);
}

#leadList .sales-name-avatar,
#leadList .sales-rep-avatar {
    display: inline-flex;
    width: 30px;
    height: 30px;
    min-width: 30px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #ffffff;
    font-size: 12px;
    font-weight: 850;
    box-shadow: 0 8px 18px rgba(16, 32, 51, 0.16);
}

#leadList .sales-rep-cell.is-muted {
    color: var(--sales-muted);
}


.sales-page .dataTables_wrapper {
    width: 100%;
    padding: 16px;
}

.sales-page .dataTables_length label,
.sales-page .dataTables_filter label,
.sales-page .dataTables_info {
    color: var(--sales-muted);
    font-size: 13px;
    font-weight: 700;
}

.sales-page .dataTables_filter input,
.sales-page .dataTables_length select {
    min-height: 36px;
    border: 1px solid #d8e3ed;
    border-radius: 8px;
    margin-left: 8px;
    padding: 6px 10px;
    background: #f8fbfd;
}

.sales-page .pagination .page-link {
    border-color: #dce6ef;
    color: var(--sales-blue);
    font-weight: 700;
}

.sales-page .pagination .active .page-link,
.sales-page .page-item.active .page-link {
    border-color: transparent;
    background: linear-gradient(135deg, var(--sales-blue), var(--sales-green));
    color: #ffffff;
}

.badge {
    min-width: calc(var(--badge-padding-y) * 2 + var(--badge-font-size));
    box-shadow: rgba(60, 64, 67, 0.18) 0 1px 2px 0, rgba(60, 64, 67, 0.12) 0 2px 6px 2px;
}

.epf {
    font-weight: 500;
    padding: 2px;
}

b,
strong {
    font-weight: 600;
}

.log-item {
    background: #e8edf9;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.rk-stage-wrapper {
    display: flex;
    overflow-x: auto;
    background: #dfeceb;
    padding: 10px;
    border-radius: 8px;
}

.rk-stage-item {
    position: relative;
    padding: 10px 22px;
    font-size: 13px;
    color: #2c3e50;
    background: #b7d8d4;
    margin-right: 4px;
    white-space: nowrap;
    clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 50%, calc(100% - 16px) 100%, 0 100%);
    transition: all 0.15s ease;
}

.rk-stage-item:first-child {
    border-radius: 6px 0 0 6px;
}

.rk-stage-item:last-child {
    margin-right: 0;
    border-radius: 0 6px 6px 0;
}

.rk-stage-item.active {
    background: #3aa69b;
    color: #ffffff;
    font-weight: 600;
}

.rk-clickable {
    cursor: pointer;
}

.rk-clickable:hover {
    transform: translateY(-1px);
}

@media (max-width: 991.98px) {
    .content-inner {
        padding: 16px;
    }

    .sales-hero {
        grid-template-columns: 1fr;
    }

    .sales-hero-count {
        justify-self: start;
        text-align: left;
    }

    .sales-stat-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575.98px) {
    .content-inner {
        padding: 12px;
    }

    .sales-hero {
        padding: 18px;
    }

    .sales-hero h1 {
        font-size: 24px;
    }

    .sales-stat-grid {
        grid-template-columns: 1fr;
    }

    .sales-panel-head {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>

<div class="sales-page">
    <div class="sales-hero">
        <div>
            <div class="sales-kicker"><i class="ph ph-trend-up"></i> Sales Pipeline</div>
            <h1>Manage every lead from first contact to closed sale.</h1>
            <p>Filter the pipeline, review assignments, and take action without changing the workflow your team already uses.</p>
        </div>
        <div class="sales-hero-count">
            <span>Total Leads</span>
            <strong>{{ number_format($leads->count()) }}</strong>
        </div>
    </div>

    <div class="sales-stat-grid">
        <div class="sales-stat-card blue">
            <div class="sales-stat-top">
                <div>
                    <span class="label">New Leads</span>
                    <strong>{{ number_format($newLeadsCount) }}</strong>
                </div>
                <span class="sales-stat-icon"><i class="ph ph-users-three"></i></span>
            </div>
        </div>
        <div class="sales-stat-card green">
            <div class="sales-stat-top">
                <div>
                    <span class="label">Under Construction</span>
                    <strong>{{ number_format($constructionCount) }}</strong>
                </div>
                <span class="sales-stat-icon"><i class="ph ph-clock-countdown"></i></span>
            </div>
        </div>
        <div class="sales-stat-card gold">
            <div class="sales-stat-top">
                <div>
                    <span class="label">Follow-ups Due</span>
                    <strong class="totalFollowups1">{{ number_format($followUpCount) }}</strong>
                </div>
                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#followUpModal" class="sales-stat-icon"><i class="ph ph-bell-ringing"></i></a>
            </div>
        </div>
        <div class="sales-stat-card slate">
            <div class="sales-stat-top">
                <div>
                    <span class="label">Unassigned</span>
                    <strong>{{ number_format($unassigned) }}</strong>
                </div>
                <span class="sales-stat-icon"><i class="ph ph-user-focus"></i></span>
            </div>
        </div>
    </div>

    <section class="content d-none">
        @php
            $currentStatus = $lead->status ?? '';
        @endphp

        <div class="rk-stage-wrapper">
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

            <div class="rk-stage-item rk-clickable" data-bs-toggle="modal" data-bs-target="#followUpModal">
                <div class="rk-stage-label">
                    Follow Up ({{ $followUpCount }})
                </div>
            </div>

            <div class="rk-stage-item">
                <div class="rk-stage-label">
                    Unassigned ({{ $unassigned }})
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="sales-panel">
            <div class="sales-panel-head">
                <h2 class="sales-panel-title"><i class="ph ph-funnel"></i> Pipeline Filters</h2>
                <span class="sales-panel-chip">Refine results</span>
            </div>
            <div class="sales-filter-body">
                <form id="leadFilterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label1">Lead Source</label>
                            <select name="lead_source" id="lead_source" class="form-control">
                                <option value="">Select All</option>
                                @foreach($leadSource as $data)
                                    <option value="{{ $data->id }}">{{ $data->source }}</option>
                                @endforeach
                            </select>
                        </div>

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

                        <div class="col-md-2">
                            <label class="form-label1">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Select All</option>
                                @foreach($status as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label1">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label1">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control">
                        </div>
                    </div>

                    <div class="sales-actions mt-3">
                        <button type="button" class="btn btn-primary apply">
                            <i class="ph ph-check-circle me-1"></i> Apply
                        </button>

                        <button type="reset" class="btn btn-outline-secondary reset">
                            <i class="ph ph-arrow-counter-clockwise me-1"></i> Reset
                        </button>

                        <button type="button" class="btn btn-success exportCsv">
                            <i class="ph ph-download-simple me-1"></i> Export CSV
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="leads-container1"></div>

        <div class="sales-panel sales-table-card">
            <div class="sales-panel-head">
                <h2 class="sales-panel-title"><i class="ph ph-list-bullets"></i> Lead List</h2>
                <span class="sales-panel-chip">Live table</span>
            </div>
            <div class="sales-table-body">
                <div class="sales-table-wrap">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Role text-wrap" id="leadList">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lead Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Lead Source</th>
                                <th>Sales Rep</th>
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="no-data-container"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--Models -->
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
    let leadId = $(this).data('id');
    let leadName = $(this).data('name');
    $('.lead_id').val(leadId);
    $('.leadName').text(leadName);
});

$(document).on('click', '.send_email', function() {
    let lead = $(this).data('lead');

    $('.lead_id').val(lead.id);
    $('.lead_name').text(lead.first_name + ' ' + lead.last_name);
    $('.lead_email').val(lead.email);
});

$(document).on('click', '.send_email_inner', function() {
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
