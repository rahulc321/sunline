@extends('layouts.super')

@section('title', "Sales Pipeline")

@section('content')
<style>
:root {
    --pipeline-ink: #102033;
    --pipeline-muted: #65758b;
    --pipeline-blue: #1769aa;
    --pipeline-green: #36b37e;
    --pipeline-line: #dce6ef;
    --pipeline-soft: #f4f8fb;
}

.content-inner {
    background: linear-gradient(180deg, rgba(23, 105, 170, 0.05), transparent 220px), #f4f8fb;
    padding: 10px 12px 14px;
}

.pipeline-page {
    color: var(--pipeline-ink);
    font-family: "Inter", "Segoe UI", sans-serif;
    max-width: 100%;
}

.pipeline-page .content {
    padding: 0 !important;
}


.pipeline-command {
    position: relative;
    overflow: hidden;
    margin-bottom: 12px;
    padding: 18px;
    border: 1px solid rgba(23, 105, 170, 0.16);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(16, 32, 51, 0.97), rgba(23, 105, 170, 0.91) 45%, rgba(54, 179, 126, 0.88)),
        url("{{ asset('vendor/images/demo/cover3.jpg') }}") center/cover no-repeat;
    box-shadow: 0 18px 42px rgba(16, 32, 51, 0.16);
}

.pipeline-command::before {
    content: "";
    position: absolute;
    top: 50%;
    right: 7%;
    width: 260px;
    height: 120px;
    background: url("{{ asset('logo.png') }}") center/contain no-repeat;
    opacity: 0.13;
    filter: brightness(0) invert(1) drop-shadow(0 0 34px rgba(255, 255, 255, 0.95));
    transform: translateY(-50%);
    pointer-events: none;
}

.pipeline-command::after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 78% 48%, rgba(255, 255, 255, 0.34), transparent 24%),
        linear-gradient(90deg, rgba(255,255,255,0.08), transparent 42%, rgba(255,255,255,0.14));
    pointer-events: none;
}

.pipeline-command-inner {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 18px;
    align-items: center;
}

.pipeline-title-wrap {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.pipeline-title-icon {
    display: inline-flex;
    width: 48px;
    height: 48px;
    min-width: 48px;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #ffffff;
    background: linear-gradient(135deg, #36b37e, #51b7d8);
    font-size: 23px;
    box-shadow: 0 16px 30px rgba(4, 18, 32, 0.24);
}

.pipeline-kicker {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 5px;
    color: rgba(255, 255, 255, 0.78);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.pipeline-kicker i {
    color: #f6b445;
    font-size: 14px;
}

.pipeline-title {
    margin: 0;
    color: #ffffff;
    font-size: 27px;
    font-weight: 850;
    line-height: 1.12;
    letter-spacing: 0;
}

.pipeline-subtitle {
    margin: 5px 0 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 13px;
    font-weight: 600;
}

.pipeline-metrics {
    display: grid;
    grid-template-columns: repeat(3, minmax(94px, 1fr));
    gap: 9px;
}

.pipeline-metric {
    min-height: 58px;
    padding: 10px 12px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    backdrop-filter: blur(8px);
}

.pipeline-metric span {
    display: flex;
    align-items: center;
    gap: 6px;
    color: rgba(255, 255, 255, 0.74);
    font-size: 10px;
    font-weight: 850;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.pipeline-metric span i {
    color: #f6b445;
    font-size: 13px;
}

.pipeline-metric strong {
    display: block;
    margin-top: 5px;
    color: #ffffff;
    font-size: 18px;
    font-weight: 850;
    line-height: 1;
}

.pipeline-tabs-card {
    margin-bottom: 10px;
    padding: 0;
    border: 1px solid var(--pipeline-line);
    border-radius: 8px;
    background: #ffffff;
    box-shadow: 0 12px 28px rgba(16, 32, 51, 0.06);
}

.rk-tabs {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0;
}

.rk-tabs .nav-item {
    margin: 0;
}

.rk-tabs .nav-link {
    width: 100%;
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 0;
    padding: 9px 16px;
    color: #52667c;
    background: #ffffff;
    font-size: 13px;
    font-weight: 850;
    transition: background 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
}

.rk-tabs .nav-item:first-child .nav-link {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.rk-tabs .nav-item:last-child .nav-link {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.rk-tabs .nav-link i {
    width: 24px;
    height: 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 15px;
    background: rgba(255, 255, 255, 0.72);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.85), 0 8px 18px rgba(16, 32, 51, 0.08);
}

.rk-tabs .nav-item:nth-child(1) .nav-link i { color: #1769aa; }
.rk-tabs .nav-item:nth-child(2) .nav-link i { color: #7c3aed; }
.rk-tabs .nav-item:nth-child(3) .nav-link i { color: #36b37e; }

.rk-tabs .nav-link.active {
    color: #ffffff;
    background: linear-gradient(135deg, #1769aa, #36b37e);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.42), inset 0 -3px 0 rgba(255, 255, 255, 0.22), 0 12px 24px rgba(23, 105, 170, 0.2);
}

.rk-tabs .nav-link.active i {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.16);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.34), 0 10px 20px rgba(4, 18, 32, 0.12);
}

.rk-tabs .nav-link:hover:not(.active) {
    background: #f4faf9;
    color: var(--pipeline-blue);
}

.pipeline-table-card {
    position: relative;
    border: 1px solid rgba(23, 105, 170, 0.16) !important;
    border-radius: 8px !important;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 252, 255, 0.98)),
        radial-gradient(circle at 14% 0%, rgba(81, 183, 216, 0.22), transparent 28%),
        radial-gradient(circle at 94% 12%, rgba(54, 179, 126, 0.18), transparent 24%);
    box-shadow: 0 18px 44px rgba(16, 32, 51, 0.10), inset 0 1px 0 rgba(255, 255, 255, 0.92) !important;
    overflow: hidden;
}

.pipeline-table-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 3px;
    background: linear-gradient(90deg, #1769aa, #36b37e, #f6b445, #db2777);
    z-index: 1;
}

.pipeline-table-head {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 11px 14px 10px;
    border-bottom: 1px solid rgba(216, 227, 237, 0.88);
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(246, 250, 253, 0.92)),
        radial-gradient(circle at 10% 0%, rgba(23, 105, 170, 0.11), transparent 32%);
}

.pipeline-table-title {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0;
    color: var(--pipeline-ink);
    font-size: 15px;
    font-weight: 850;
}

.pipeline-table-title i {
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #ffffff;
    font-size: 16px;
    background: linear-gradient(135deg, #1769aa, #36b37e);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.38), 0 10px 20px rgba(23, 105, 170, 0.22);
}

.pipeline-live-chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    min-height: 24px;
    padding: 4px 9px;
    border-radius: 999px;
    border: 1px solid rgba(23, 105, 170, 0.16);
    background: linear-gradient(180deg, #ffffff, #f3fbf8);
    color: var(--pipeline-blue);
    font-size: 11px;
    font-weight: 850;
}

.pipeline-live-chip::before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--pipeline-green);
    box-shadow: 0 0 0 3px rgba(54, 179, 126, 0.14), 0 0 14px rgba(54, 179, 126, 0.34);
}

.pipeline-table-body {
    padding: 0;
}

.pipeline-table-wrap {
    width: 100%;
    overflow-x: auto;
}

#leadList {
    width: 100% !important;
    margin: 0 !important;
    border-collapse: separate !important;
    border-spacing: 0;
    background: #ffffff;
}

#leadList th,
#leadList td {
    white-space: nowrap;
    vertical-align: middle;
}

#leadList thead th {
    position: relative;
    border-top: 0 !important;
    border-bottom: 1px solid rgba(10, 31, 51, 0.08) !important;
    border-right: 1px solid rgba(255, 255, 255, 0.24) !important;
    background: #1769aa !important;
    color: #ffffff !important;
    padding: 10px 10px !important;
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.22), inset 0 -12px 24px rgba(4, 18, 32, 0.08);
}

#leadList thead th::after {
    content: "";
    position: absolute;
    left: 8px;
    right: 8px;
    bottom: 0;
    height: 1px;
    background: rgba(255, 255, 255, 0.35);
}

#leadList thead th:first-child {
    border-top-left-radius: 8px;
}

#leadList thead th:last-child {
    border-top-right-radius: 8px;
}

#leadList tbody td {
    border-color: rgba(229, 238, 246, 0.9) !important;
    color: #52667c !important;
    padding: 8px 10px !important;
    font-size: 13px;
    background: rgba(255, 255, 255, 0.92);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.75);
}

#leadList tbody tr:nth-child(even) td {
    background: rgba(247, 251, 254, 0.96);
}

#leadList tbody tr:hover td {
    background: linear-gradient(180deg, #ffffff, #f0fbf7) !important;
    color: #263d55 !important;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.95), 0 8px 22px rgba(23, 105, 170, 0.07);
}

.dataTables_wrapper {
    width: 100%;
    padding: 10px 12px 12px;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.72), rgba(248, 252, 255, 0.6)),
        radial-gradient(circle at 100% 0%, rgba(246, 180, 69, 0.08), transparent 24%);
}

.dataTables_wrapper .row:first-child {
    align-items: center;
    margin-bottom: 8px !important;
}

.dataTables_length label,
.dataTables_filter label,
.dataTables_info {
    color: var(--pipeline-muted);
    font-size: 13px;
    font-weight: 700;
}

.dataTables_filter input,
.dataTables_length select {
    min-height: 36px;
    border: 1px solid rgba(216, 227, 237, 0.96);
    border-radius: 8px;
    margin-left: 8px;
    padding: 6px 10px;
    background: linear-gradient(180deg, #ffffff, #f7fbfd);
    color: var(--pipeline-ink);
    outline: 0;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 8px 18px rgba(16, 32, 51, 0.04);
}

.dataTables_filter input:focus,
.dataTables_length select:focus {
    border-color: rgba(23, 105, 170, 0.5);
    background: #ffffff;
    box-shadow: 0 0 0 0.18rem rgba(23, 105, 170, 0.11);
}

.pagination .page-link {
    border-color: #dce6ef;
    color: var(--pipeline-blue);
    font-weight: 700;
    background: linear-gradient(180deg, #ffffff, #f7fbfd);
}

.page-item.active .page-link {
    border-color: transparent;
    background: linear-gradient(135deg, var(--pipeline-blue), var(--pipeline-green));
    color: #ffffff;
}

#leadList .sales-person-link,
#leadList .sales-person-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: inherit;
    font-weight: 500;
    text-decoration: none;
}

#leadList .sales-person-link {
    color: #1769aa !important;
    font-weight: 700;
}

#leadList .sales-person-link:hover {
    color: #0f466f !important;
}

#leadList .sales-person-avatar {
    display: inline-flex;
    width: 26px;
    height: 26px;
    min-width: 26px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    line-height: 1;
    border: 2px solid rgba(255, 255, 255, 0.82);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.34), 0 8px 18px rgba(16, 32, 51, 0.20);
}

#leadList .sales-person-chip.is-muted {
    color: #8a99aa;
}

#leadList .sales-status-badge {
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    min-height: 25px;
    padding: 4px 9px;
    border: 1px solid color-mix(in srgb, var(--status-color) 32%, #ffffff);
    border-radius: 999px;
    background: linear-gradient(180deg, #ffffff, color-mix(in srgb, var(--status-color) 11%, #ffffff));
    color: var(--status-color);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.02em;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 9px 20px color-mix(in srgb, var(--status-color) 14%, transparent);
}

#leadList .sales-status-badge::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 50%;
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.72), transparent);
    pointer-events: none;
}

#leadList .sales-status-badge i {
    font-size: 14px;
    line-height: 1;
}

.badge {
    min-width: calc(var(--badge-padding-y) * 2 + var(--badge-font-size));
    box-shadow: rgba(60, 64, 67, 0.18) 0 1px 2px 0, rgba(60, 64, 67, 0.12) 0 2px 6px 2px;
}

@media (max-width: 991.98px) {
    .content-inner {
        padding: 8px;
    }

    .pipeline-command-inner {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 575.98px) {
    .content-inner {
        padding: 6px;
    }

    .pipeline-command {
        padding: 14px;
    }

    .pipeline-title {
        font-size: 24px;
    }

    .pipeline-title-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
    }

}
</style>

<div class="pipeline-page">
    <div class="pipeline-command">
        <div class="pipeline-command-inner">
            <div class="pipeline-title-wrap">
                <span class="pipeline-title-icon"><i class="ph ph-trend-up"></i></span>
                <div>
                    <div class="pipeline-kicker"><i class="ph ph-sparkle"></i> Revenue Command Center</div>
                    <h4 class="pipeline-title">{{ $title }}</h4>
                    <p class="pipeline-subtitle">{{ $desc }}</p>
                </div>
            </div>
            <div class="pipeline-metrics">
                <div class="pipeline-metric">
                    <span><i class="ph ph-funnel"></i> Board</span>
                    <strong>{{ count($tabs) }}</strong>
                </div>
                <div class="pipeline-metric">
                    <span><i class="ph ph-lightning"></i> Status</span>
                    <strong>Live</strong>
                </div>
                <div class="pipeline-metric">
                    <span><i class="ph ph-shield-check"></i> Access</span>
                    <strong>Super</strong>
                </div>
            </div>
        </div>
    </div>

    <?php $status = config('fri.lead_status'); ?>

    <section class="content">
        @php
            $tabIcons = [
                'Leads' => 'ph-trend-up',
                'Contacts' => 'ph-address-book',
                'Sales' => 'ph-chart-line-up',
            ];
        @endphp
        <div class="pipeline-tabs-card">
            <ul class="nav nav-pills rk-tabs" id="leadTabs">
                @foreach($tabs as $name => $statuses)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="javascript:void(0)"
                        data-status='@json($statuses)'>
                        <i class="ph {{ $tabIcons[$name] ?? 'ph-circle' }}"></i>
                        <span>{{ $name }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="pipeline-table-card">
            <div class="pipeline-table-head">
                <h2 class="pipeline-table-title"><i class="ph ph-list-bullets"></i> Lead List</h2>
                <span class="pipeline-live-chip">Live table</span>
            </div>
            <div class="pipeline-table-body">
                <div class="pipeline-table-wrap">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Role text-wrap" id="leadList">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lead Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Lead Sourse</th>
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
    </section>
</div>

@include('admin.leads._add_lead_modal')
@include('super.leads._edit_modal')
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
    let tabs = @json($tabs);
    let currentStatus = Object.keys(tabs).length ? Object.values(tabs)[0] : [];
    let table = $('#leadList').DataTable({
        processing: true,
        serverSide: true,
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
            currentStatus = JSON.parse(statusData);
        } catch (e) {
            currentStatus = [];
        }

        table.ajax.reload();
    });

    let applyBtn = $('.apply');

    $('.apply').on('click', function() {
        applyBtn.text('Applying...');
        table.ajax.reload();
    });

    $('.reset').on('click', function() {
        applyBtn.text('Applying...');
        $('#leadFilterForm')[0].reset();
        table.ajax.reload();
    });

    table.on('xhr.dt', function() {
        applyBtn.text('Apply');
    });
});

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
