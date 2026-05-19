@extends('layouts.admin')

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

.card.ll {
    margin-left: -20px;
    margin-right: -20px;
}

.leads-page {
    --lead-ink: #111827;
    --lead-muted: #667085;
    --lead-border: #dbe3ef;
    --lead-blue: #2563eb;
    --lead-teal: #0f766e;
    --lead-green: #16a34a;
    --lead-gold: #f59e0b;
    font-family: inherit;
    color: var(--lead-ink);
    padding-top: 14px !important;
}

.leads-page .lead-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 18px 20px;
    margin-bottom: 14px;
    border: 1px solid var(--lead-border);
    border-radius: 16px;
    background:
        linear-gradient(135deg, rgba(15, 23, 42, .98), rgba(9, 37, 117, .92) 54%, rgba(11, 56, 182, .88)),
        linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px);
    background-size: auto, 34px 34px;
    color: #ffffff;
    box-shadow: 0 18px 42px rgba(15, 23, 42, .16);
}

.leads-page .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 5px 10px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, .18);
    background: rgba(255, 255, 255, .10);
    color: rgba(255, 255, 255, .82);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.leads-page .hero-title {
    margin: 10px 0 4px;
    color: #ffffff;
    font-size: 28px;
    line-height: 1.12;
    font-weight: 850;
    letter-spacing: 0;
}

.leads-page .hero-copy {
    margin: 0;
    color: rgba(255, 255, 255, .72);
    font-size: 13px;
}

.leads-page .btn-add-lead {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 40px;
    padding: 8px 15px;
    border: 0;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #0f766e);
    color: #ffffff;
    font-weight: 800;
    box-shadow: none !important;
}

.leads-page .stage-panel {
    position: relative;
    padding: 10px;
    margin-bottom: 14px;
    border: 1px solid var(--lead-border);
    border-radius: 14px;
    background:
        linear-gradient(135deg, rgba(37, 99, 235, .06), rgba(20, 184, 166, .07)),
        #ffffff;
    box-shadow: 0 12px 28px rgba(21, 32, 51, .06);
}

.leads-page .rk-stage-wrapper {
    display: flex;
    gap: 8px;
    padding: 2px 2px 7px;
    overflow-x: auto;
    overflow-y: hidden;
    background: transparent;
    border-radius: 0;
    scrollbar-width: thin;
    scrollbar-color: rgba(100, 116, 139, .35) transparent;
}

.leads-page .rk-stage-wrapper::-webkit-scrollbar {
    height: 4px;
}

.leads-page .rk-stage-wrapper::-webkit-scrollbar-track {
    background: transparent;
}

.leads-page .rk-stage-wrapper::-webkit-scrollbar-thumb {
    border-radius: 999px;
    background: rgba(100, 116, 139, .28);
}

.leads-page .rk-stage-item {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    flex: 0 0 auto;
    min-height: 38px;
    clip-path: none !important;
    margin-right: 0;
    padding: 7px 11px;
    border: 1px solid rgba(219, 230, 244, .95);
    border-radius: 999px !important;
    background: #ffffff;
    color: #344054;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0;
    box-shadow: 0 6px 16px rgba(21, 32, 51, .05);
    transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
}

.leads-page .rk-stage-item:hover {
    border-color: rgba(37, 99, 235, .28);
    transform: translateY(-1px);
    box-shadow: 0 10px 22px rgba(21, 32, 51, .08);
}

.leads-page .rk-clickable {
    cursor: pointer;
}

.leads-page .rk-stage-label {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    line-height: 1;
}

.leads-page .stage-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(37, 99, 235, .12);
    color: #2563eb;
    font-size: 13px;
}

.leads-page .stage-icon-new { background: rgba(37, 99, 235, .14); color: #2563eb; }
.leads-page .stage-icon-send-intro-email { background: rgba(8, 145, 178, .14); color: #0891b2; }
.leads-page .stage-icon-1st-attempt,
.leads-page .stage-icon-2nd-attempt,
.leads-page .stage-icon-3rd-attempt { background: rgba(245, 158, 11, .18); color: #b45309; }
.leads-page .stage-icon-under-construction { background: rgba(124, 58, 237, .14); color: #6d28d9; }
.leads-page .stage-icon-qualified { background: rgba(22, 163, 74, .14); color: #15803d; }
.leads-page .stage-icon-sold { background: rgba(15, 118, 110, .14); color: #0f766e; }
.leads-page .stage-icon-lost { background: rgba(220, 38, 38, .14); color: #dc2626; }
.leads-page .stage-icon-follow-up { background: rgba(79, 70, 229, .14); color: #4f46e5; }
.leads-page .stage-icon-unassigned { background: rgba(100, 116, 139, .16); color: #475569; }

.leads-page .stage-name {
    white-space: nowrap;
}

.leads-page .stage-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 22px;
    padding: 0 8px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .75);
    color: inherit;
    font-size: 11px;
    font-weight: 850;
}

.leads-page .rk-stage-item:nth-child(8n+1) { background: linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(14, 165, 233, .08)), #ffffff; }
.leads-page .rk-stage-item:nth-child(8n+2) { background: linear-gradient(135deg, rgba(8, 145, 178, .10), rgba(20, 184, 166, .08)), #ffffff; }
.leads-page .rk-stage-item:nth-child(8n+3) { background: linear-gradient(135deg, rgba(245, 158, 11, .13), rgba(249, 115, 22, .08)), #ffffff; }
.leads-page .rk-stage-item:nth-child(8n+4) { background: linear-gradient(135deg, rgba(79, 70, 229, .11), rgba(124, 58, 237, .08)), #ffffff; }
.leads-page .rk-stage-item:nth-child(8n+5) { background: linear-gradient(135deg, rgba(22, 163, 74, .11), rgba(101, 163, 13, .08)), #ffffff; }
.leads-page .rk-stage-item:nth-child(8n+6) { background: linear-gradient(135deg, rgba(220, 38, 38, .10), rgba(244, 63, 94, .08)), #ffffff; }
.leads-page .rk-stage-item:nth-child(8n+7) { background: linear-gradient(135deg, rgba(180, 83, 9, .11), rgba(245, 158, 11, .08)), #ffffff; }
.leads-page .rk-stage-item:nth-child(8n) { background: linear-gradient(135deg, rgba(67, 56, 202, .11), rgba(2, 132, 199, .08)), #ffffff; }

.leads-page .rk-stage-item.active {
    border-color: rgba(37, 99, 235, .22);
    background: linear-gradient(135deg, #2563eb, #0f766e);
    color: #ffffff;
    box-shadow: 0 12px 26px rgba(37, 99, 235, .18);
}

.leads-page .rk-stage-item.active .stage-count {
    background: rgba(255, 255, 255, .18);
    color: #ffffff;
}

.leads-page .rk-stage-item.active .stage-icon {
    background: rgba(255, 255, 255, .18);
    color: #ffffff;
}

.leads-page .lead-panel {
    overflow: hidden;
    border: 1px solid var(--lead-border) !important;
    border-radius: 16px !important;
    background: #ffffff;
    box-shadow: 0 14px 34px rgba(21, 32, 51, .08) !important;
}

.leads-page .lead-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 12px;
    border-bottom: 1px solid #edf1f7;
    background:
        linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(15, 118, 110, .08)),
        #fbfdff;
}

.leads-page .toolbar-left,
.leads-page .toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    position: relative;
}

.leads-page .lead-search {
    position: relative;
}

.leads-page .lead-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    color: #98a2b3;
    transform: translateY(-50%);
}

.leads-page .lead-search input {
    width: 260px;
    height: 38px;
    padding-left: 36px;
    border: 1px solid #d7dfec;
    border-radius: 10px;
    background: #ffffff;
    color: var(--lead-ink);
    box-shadow: none;
}

.leads-page .toolbar-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 38px;
    padding: 8px 13px;
    border: 1px solid rgba(37, 99, 235, .36);
    border-radius: 10px;
    background: #ffffff;
    color: #2563eb;
    font-size: 13px;
    font-weight: 800;
}

.leads-page .icon-only {
    width: 42px;
    padding: 0;
}

.leads-page .column-menu {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    z-index: 20;
    min-width: 210px;
    padding: 8px;
    border: 1px solid #dbe6f4;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 18px 38px rgba(15, 23, 42, .14);
}

.leads-page .column-menu.is-open {
    display: grid;
    gap: 4px;
}

.leads-page .column-menu label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    padding: 7px 8px;
    border-radius: 8px;
    color: #475467;
    font-size: 12px;
    font-weight: 750;
}

.leads-page .column-menu label:hover {
    background: #f3f7fc;
}

.leads-page .lead-filter-panel {
    display: none;
    padding: 10px 12px 12px;
    border-bottom: 1px solid #edf1f7;
    background: #f8fbff;
}

.leads-page .lead-filter-panel.is-open {
    display: block;
}

.leads-page .filter-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 8px;
}

.leads-page .lead-filter-panel label {
    margin-bottom: 4px;
    color: #475467;
    font-size: 10px;
    font-weight: 850;
    letter-spacing: .06em;
    text-transform: uppercase;
}

.leads-page .lead-filter-panel .form-control,
.leads-page .lead-filter-panel .form-select {
    height: 38px;
    min-height: 38px;
    border-color: #d7dfec;
    border-radius: 10px;
    font-size: 13px;
    box-shadow: none;
}

.leads-page .filter-actions {
    display: flex;
    gap: 7px;
    margin-top: 10px;
}

.leads-page .filter-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    min-height: 38px;
    border-radius: 10px;
    font-weight: 800;
}

.leads-page .apply,
.leads-page .exportCsv {
    border: 0;
    background: linear-gradient(135deg, #2563eb, #0f766e) !important;
    color: #ffffff;
}

.leads-page .table-wrap {
    padding: 0 10px 10px;
}

.leads-page #leadList_wrapper > .row:first-child {
    display: none;
}

.leads-page table.dataTable,
.leads-page .table {
    margin-top: 10px !important;
    border-collapse: separate !important;
    border-spacing: 0;
    border: 1px solid #e6ecf5;
    border-radius: 14px;
    overflow: hidden;
}

.leads-page .table thead th {
    padding: 7px 8px !important;
    border: 0 !important;
    background: linear-gradient(135deg, #f3f7fc, #eef6ff) !important;
    color: #667085 !important;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .06em;
    text-transform: uppercase;
}

.leads-page .table tbody td {
    padding: 8px 10px !important;
    vertical-align: middle;
    border-color: #d9e1ec !important;
    color: #667085 !important;
    font-size: 15px;
    font-weight: 300;
    line-height: 1.35;
    letter-spacing: .01em;
}

.leads-page .lead-person {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 190px;
}

.leads-page .lead-avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #0f766e);
    color: #ffffff;
    font-size: 11px;
    font-weight: 850;
}

.leads-page .avatar-0 { background: linear-gradient(135deg, #2563eb, #0f766e); }
.leads-page .avatar-1 { background: linear-gradient(135deg, #0f766e, #14b8a6); }
.leads-page .avatar-2 { background: linear-gradient(135deg, #4f46e5, #7c3aed); }
.leads-page .avatar-3 { background: linear-gradient(135deg, #be123c, #f97316); }
.leads-page .avatar-4 { background: linear-gradient(135deg, #0891b2, #2563eb); }
.leads-page .avatar-5 { background: linear-gradient(135deg, #15803d, #65a30d); }
.leads-page .avatar-6 { background: linear-gradient(135deg, #b45309, #f59e0b); }
.leads-page .avatar-7 { background: linear-gradient(135deg, #4338ca, #0284c7); }

.leads-page .lead-name-text {
    color: #1f2937;
    font-size: 15px;
    font-weight: 300;
    line-height: 1.25;
}

.leads-page .lead-name-text a {
    color: inherit;
    font-weight: 300;
    text-decoration: none;
}

.leads-page .lead-name-text a:hover {
    color: var(--lead-blue);
}

.leads-page .lead-meta-text {
    color: #8a98ad;
    font-size: 15px;
    font-weight: 300;
    line-height: 1.25;
}

.leads-page .status-pill {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(37, 99, 235, .16), rgba(8, 145, 178, .14));
    color: #1d4ed8;
    font-size: 15px;
    font-weight: 300;
}

.leads-page .status-new { background: linear-gradient(135deg, rgba(37, 99, 235, .16), rgba(14, 165, 233, .14)); color: #1d4ed8; }
.leads-page .status-send-intro-email { background: linear-gradient(135deg, rgba(8, 145, 178, .15), rgba(20, 184, 166, .16)); color: #0e7490; }
.leads-page .status-1st-attempt,
.leads-page .status-2nd-attempt,
.leads-page .status-3rd-attempt { background: linear-gradient(135deg, rgba(245, 158, 11, .20), rgba(249, 115, 22, .14)); color: #b45309; }
.leads-page .status-under-construction { background: linear-gradient(135deg, rgba(79, 70, 229, .15), rgba(124, 58, 237, .14)); color: #4338ca; }
.leads-page .status-qualified,
.leads-page .status-sold { background: linear-gradient(135deg, rgba(22, 163, 74, .15), rgba(101, 163, 13, .13)); color: #15803d; }
.leads-page .status-lost { background: linear-gradient(135deg, rgba(220, 38, 38, .15), rgba(244, 63, 94, .14)); color: #b91c1c; }
.leads-page .status-follow-up { background: linear-gradient(135deg, rgba(99, 102, 241, .15), rgba(6, 182, 212, .13)); color: #4f46e5; }
.leads-page .status-unassigned { background: linear-gradient(135deg, rgba(100, 116, 139, .16), rgba(148, 163, 184, .13)); color: #475569; }

.leads-page.is-compact .lead-toolbar {
    padding: 8px 10px;
}

.leads-page.is-compact .table-wrap {
    padding: 0 8px 8px;
}

.leads-page.is-compact .table thead th,
.leads-page.is-compact .table tbody td {
    padding: 6px 8px !important;
}

.leads-page .filter-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(100, 116, 139, .18), rgba(148, 163, 184, .16));
    color: #475569;
    font-size: 11px;
    font-weight: 850;
}

.leads-page .filter-count.is-active {
    background: linear-gradient(135deg, #2563eb, #0f766e);
    color: #ffffff;
}

.leads-page .datatable-header {
    display: none !important;
}

.leads-page .datatable-scroll-wrap {
    border: 0;
}

@media (max-width: 991.98px) {
    .leads-page .lead-hero,
    .leads-page .lead-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .leads-page .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575.98px) {
    .leads-page .lead-search input {
        width: 100%;
    }

    .leads-page .toolbar-left,
    .leads-page .toolbar-right,
    .leads-page .lead-search {
        width: 100%;
    }

    .leads-page .filter-grid {
        grid-template-columns: 1fr;
    }
}

</style>
<?php $status = config('fri.lead_status'); ?>
@php
$currentStatus = $lead->status ?? '';
$followUpCount = $upcoming->count() + $past->count();
$unassigned = $leads->whereNull('assign_rep')
    ->whereNotIn('status', ['Qualified','Sold'])
    ->count();
@endphp

<div class="content leads-page pt-0">
    <section class="lead-hero">
        <div>
            <span class="hero-eyebrow"><i class="ph-funnel"></i> Lead Management</span>
            <h1 class="hero-title">Leads</h1>
            <p class="hero-copy">Assign, filter, and track incoming opportunities across the sales pipeline.</p>
        </div>
        @can('lead_add')
        <a class="btn btn-add-lead" data-bs-toggle="offcanvas" data-bs-target="#addLeadModal" aria-controls="addLeadModal">
            <i class="ph-plus"></i> Add Lead
        </a>
        @endcan
    </section>

    <section class="stage-panel">
        <div class="rk-stage-wrapper">
            @php
            $stageIconMap = [
                'new' => 'ph-sparkle',
                'send intro email' => 'ph-paper-plane-tilt',
                '1st attempt' => 'ph-number-circle-one',
                '2nd attempt' => 'ph-number-circle-two',
                '3rd attempt' => 'ph-number-circle-three',
                'under construction' => 'ph-wrench',
                'qualified' => 'ph-check-circle',
                'sold' => 'ph-currency-dollar',
                'lost' => 'ph-x-circle',
            ];
            @endphp

            @foreach($status as $value)
            @php
            $count = $leads->where('status', $value)->count();
            $isActive = $currentStatus === $value;
            $stageKey = strtolower($value);
            $stageIcon = $stageIconMap[$stageKey] ?? 'ph-circle';
            $stageIconClass = 'stage-icon-' . preg_replace('/[^a-z0-9]+/', '-', $stageKey);
            @endphp

            <div class="rk-stage-item {{ $isActive ? 'active' : '' }}">
                <div class="rk-stage-label">
                    <span class="stage-icon {{ $stageIconClass }}"><i class="{{ $stageIcon }}"></i></span>
                    <span class="stage-name">{{ $value }}</span>
                    <span class="stage-count">{{ $count }}</span>
                </div>
            </div>
            @endforeach

            <div class="rk-stage-item rk-clickable" data-bs-toggle="offcanvas" data-bs-target="#followUpModal" aria-controls="followUpModal">
                <div class="rk-stage-label">
                    <span class="stage-icon stage-icon-follow-up"><i class="ph-clock-clockwise"></i></span>
                    <span class="stage-name">Follow Up</span>
                    <span class="stage-count">{{ $followUpCount }}</span>
                </div>
            </div>

            <div class="rk-stage-item">
                <div class="rk-stage-label">
                    <span class="stage-icon stage-icon-unassigned"><i class="ph-user-minus"></i></span>
                    <span class="stage-name">Unassigned</span>
                    <span class="stage-count">{{ $unassigned }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="lead-panel">
        <div class="lead-toolbar">
            <div class="toolbar-left">
                <div class="lead-search">
                    <i class="ph-magnifying-glass"></i>
                    <input type="search" id="leadQuickSearch" placeholder="Search">
                </div>
                <button type="button" class="toolbar-btn" id="leadFiltersToggle">
                    <i class="ph-sliders-horizontal"></i> Filters
                    <span class="filter-count" id="leadFilterCount">0</span>
                </button>
            </div>

            <div class="toolbar-right">
                <button type="button" class="toolbar-btn" id="leadColumnsToggle">
                    <i class="ph-list-bullets"></i> Columns
                </button>
                <div class="column-menu" id="leadColumnsMenu">
                    <label><input type="checkbox" data-column="1" checked> Lead Name</label>
                    <label><input type="checkbox" data-column="2" checked> Phone</label>
                    <label><input type="checkbox" data-column="3" checked> Email</label>
                    <label><input type="checkbox" data-column="4" checked> Address</label>
                    <label><input type="checkbox" data-column="5" checked> Status</label>
                    <label><input type="checkbox" data-column="6" checked> Lead Source</label>
                    <label><input type="checkbox" data-column="7" checked> Sales Rep</label>
                    <label><input type="checkbox" data-column="8" checked> Category</label>
                    <label><input type="checkbox" data-column="9" checked> Created At</label>
                    <label><input type="checkbox" data-column="10" checked> Action</label>
                </div>
                <button type="button" class="toolbar-btn icon-only" id="leadCompactToggle" title="Compact view">
                    <i class="ph-rows"></i>
                </button>
            </div>
        </div>

        <div class="lead-filter-panel" id="leadFilterPanel">
            <form id="leadFilterForm">
                <div class="filter-grid">
                    <div>
                        <label class="form-label1">Lead Source</label>
                        <select name="lead_source" id="lead_source" class="form-control">
                            <option value="">Select All</option>
                            @foreach($leadSource as $data)
                            <option value="{{ $data->id }}">{{ $data->source }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label1">Sales Rep</label>
                        <select name="assign_rep" id="assign_rep" class="form-control">
                            <option value="">Select All</option>
                            <option value="unassigned">Unassigned</option>
                            @foreach($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label1">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Select All</option>
                            @foreach($status as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label1">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control">
                    </div>

                    <div>
                        <label class="form-label1">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="button" class="btn apply">
                        <i class="ph-check-circle"></i> Apply
                    </button>
                    <button type="reset" class="btn btn-outline-secondary reset">
                        <i class="ph-arrow-counter-clockwise"></i> Reset
                    </button>
                    <button type="button" class="btn exportCsv">
                        <i class="ph-download-simple"></i> Export CSV
                    </button>
                </div>
            </form>
        </div>

        <div id="leads-container1"></div>

        <div class="table-wrap">
            <div class="table-responsive">
                <table class="table table-hover datatable datatable-Role text-wrap" id="leadList">
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
    </section>
</div>

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
        const escapeHtml = function(value) {
            return $('<div>').text(value ?? '').html();
        };

        const decodeHtml = function(value) {
            return $('<textarea>').html(value ?? '').text();
        };

        const textFromHtml = function(value) {
            const decoded = decodeHtml(value);
            return $.trim($('<div>').html(decoded).text() || decoded || '');
        };

        const cssToken = function(value) {
            return String(value || '')
                .toLowerCase()
                .replace(/&/g, 'and')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        };

        const initialsFromName = function(value) {
            const words = String(value || 'Lead').trim().split(/\s+/);
            return ((words[0] || 'L').charAt(0) + (words[1] || '').charAt(0)).toUpperCase();
        };

        const getLeadNameMeta = function(value, row) {
            const decoded = decodeHtml(value);
            const wrapper = $('<div>').html(decoded || '');
            const link = wrapper.find('a').first();
            const rawText = $.trim(wrapper.text() || decoded || 'Lead');
            const href = link.attr('href') || '';
            const idMatch = rawText.match(/ID[:\s#]*(\d+)/i) || href.match(/(\d+)(?!.*\d)/);
            const cleanText = rawText.replace(/ID[:\s#]*\d+/ig, '').trim() || 'Lead';

            return {
                initials: initialsFromName(cleanText),
                id: row.id || (idMatch ? idMatch[1] : ''),
                html: link.length ? $('<div>').append(link.clone()).html() : escapeHtml(cleanText)
            };
        };

        const updateFilterCount = function() {
            const filters = ['#lead_source', '#assign_rep', '#status', '#from_date', '#to_date'];
            const count = filters.filter(function(selector) {
                return ($(selector).val() || '').toString().trim() !== '';
            }).length;

            $('#leadFilterCount')
                .text(count)
                .toggleClass('is-active', count > 0);
        };

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
                url: "{{ route('admin.listLeads') }}",
                data: function(d) {
                    d.lead_source = $('#lead_source').val();
                    d.assign_rep = $('#assign_rep').val();
                    d.status = $('#status').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
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
                    name: 'name',
                    render: function(data, type, row, cellMeta) {
                        if (type !== 'display') {
                            return data;
                        }

                        const leadMeta = getLeadNameMeta(data, row);
                        const avatarClass = `avatar-${cellMeta.row % 8}`;

                        return `<div class="lead-person">
                            <span class="lead-avatar ${avatarClass}">${escapeHtml(leadMeta.initials)}</span>
                            <div>
                                <div class="lead-name-text">${leadMeta.html}</div>
                                <div class="lead-meta-text">${leadMeta.id ? `ID: ${escapeHtml(leadMeta.id)}` : 'Lead record'}</div>
                            </div>
                        </div>`;
                    }
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
                    name: 'status',
                    render: function(data, type) {
                        if (type !== 'display') {
                            return data;
                        }

                        const statusText = textFromHtml(data) || '-';
                        const statusClass = `status-${cssToken(statusText)}`;

                        return `<span class="status-pill ${statusClass}">${escapeHtml(statusText)}</span>`;
                    }
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

        $('#leadFiltersToggle').on('click', function() {
            $('#leadFilterPanel').toggleClass('is-open');
        });

        $('#leadColumnsToggle').on('click', function(event) {
            event.stopPropagation();
            $('#leadColumnsMenu').toggleClass('is-open');
        });

        $('#leadColumnsMenu').on('click', function(event) {
            event.stopPropagation();
        });

        $(document).on('click', function() {
            $('#leadColumnsMenu').removeClass('is-open');
        });

        $('#leadColumnsMenu input[type="checkbox"]').on('change', function() {
            table.column($(this).data('column')).visible(this.checked);
            table.columns.adjust();
        });

        $('#leadCompactToggle').on('click', function() {
            $('.leads-page').toggleClass('is-compact');
            table.columns.adjust();
        });

        $('#leadFilterForm').on('change input', 'select, input', updateFilterCount);
        updateFilterCount();

        $('#leadQuickSearch').on('input', function() {
            table.search(this.value).draw();
        });

        /* Apply filter */
        let applyBtn = $('.apply');
        const setApplyLoading = function(isLoading) {
            applyBtn.html(isLoading ?
                '<i class="ph-spinner-gap"></i> Applying...' :
                '<i class="ph-check-circle"></i> Apply'
            );
        };

        $('.apply').on('click', function() {
            setApplyLoading(true);
            updateFilterCount();
            table.ajax.reload();
        });

        /* Reset filter */
        $('.reset').on('click', function() {
            setApplyLoading(true);
            $('#leadFilterForm')[0].reset();
            updateFilterCount();
            table.ajax.reload();
        });

        /* Restore button text after request */
        table.on('xhr.dt', function() {
            setApplyLoading(false);
        });



    });


    $(document).on('click', '.follow_up', function() {
        let leadId = $(this).data('id'); // get lead id from button
        let leadName = $(this).data('name');
        $('.lead_id').val(leadId); // put it in hidden input of form
        $('.leadName').text(leadName);
    });

    $(document).on('click', '.view-lead', function() {
        try {
            let lead = $(this).data('lead'); // get JSON data safely

            if (!lead) {
                console.error("No lead data found on clicked element.");
                return;
            }

            // Fill modal fields with fallbacks
            $('.lead_id').val(lead?.id ?? '');
            $('.follow_up').attr('data-id', lead?.id ?? '');
            $('.follow_up').attr('data-name', [lead.first_name, lead.last_name].filter(Boolean).join(" ") ||
                'N/A');
            $('.name').text(
                [lead.first_name, lead.last_name].filter(Boolean).join(" ") || 'N/A'
            );
            $('#leadName').text(
                [lead.first_name, lead.last_name].filter(Boolean).join(" ") || 'N/A'
            );
            $('.lead_email').text(lead.email ?? 'N/A');
            $('.lead_phone').text(lead.phone ?? 'N/A');
            $('.lead_address').text(lead.address ?? 'N/A');
            $('.lead_status').val(lead.status ?? 'N/A');
            $('.lead_notes').text(lead.notes ?? '');

            $('.rejection_url').html(
                lead.rejection_url ?
                `<a href="${lead.rejection_url}" target="_blank" rel="noopener noreferrer">
                        ${lead.rejection_url}
                    </a>` :
                ' '
            );

            // Handle nested objects safely
            $('.lead_source').text(lead.lead_source?.source ?? 'N/A');
            $('.lead_roof_type').text(lead.roof_type ?? 'N/A');
            $('.lead_rebate').text(lead.elogible_for_rebate ?? 'N/A');
            $('.send_email_view').val(JSON.stringify(lead));

            // Assign user name safely
            $('.lead_assign_rep').text(lead.get_assign_user_name?.name ?? 'Unassigned');


            // attachments
            $('.fileCount').text('');
            $(".fileList").html('');
            let attachHtml = '';
            if (lead.images && lead.images.length) {
                lead.images.forEach(file => {
                    let fileUrl = file.image_path.replace(/^admin\//, '');
                    attachHtml += `<li><a href="/${fileUrl}" target="_blank">${file.image_path}</a>
                         <a href="javascript:void(0)"
                   class="text-danger delete-lead-image"
                   data-id="${file.id}"
                   data-tble="lead_images"
                   title="Delete">
                    <i class="fa fa-trash">Delete</i>
                </a>
                    </li>`;
                });
            }
            $('.fileCount').text(lead.images ? lead.images.length : 0);
            $(".fileList").html(attachHtml);

        } catch (error) {
            console.error("Error filling modal data:", error);
            alert("Something went wrong while loading lead details.");
        }
    });


    function leadCard(lead) {
        const statusColors = {
            "New": "primary",
            "Send Intro Email": "info",
            "1st Attempt": "warning",
            "2nd Attempt": "warning",
            "3rd Attempt": "warning",
            "Under Construction": "secondary",
            "Qualified": "success",
            "Lost": "danger"
        };

        let color = statusColors[lead.status] || "secondary"; // fallback

        return `
    <div class="card shadow-sm rounded-3 p-4 mb-3 form_1" id="lead-${lead.id}">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="mb-2">
                <h5 class="fw-bold mb-1 lead">
                    #${lead.id ?? ''} - ${lead.first_name ?? ''} ${lead.last_name ?? ''}
                    ${lead.project_id ? `<small class="text-warning fst-italic ms-2">Quote created</small>` : ''}
                </h5>
                
                <div class="text-muted mb-1">
                    <i class="ph-phone me-1"></i> ${lead.phone ?? ''} &nbsp;
                    <i class="ph-envelope me-1"></i> ${lead.email ?? ''}
                </div>
                <div class="text-muted mb-2">
                    <i class="ph-map-pin me-1"></i> ${lead.address ?? ''}
                </div>
                <div class="text-muted">
                    Source: <strong class="text-dark">${lead.lead_source?.source ?? ''}</strong> &nbsp;|&nbsp;
                    Follow-ups: <strong class="text-dark">${lead.lead_follow_up_count ?? 0}</strong> &nbsp;|&nbsp;
                    Storeys: <strong class="text-dark">${lead.storeys ?? ''}</strong> &nbsp;|&nbsp;
                    Roof: <strong class="text-dark">${lead.roof_type ?? ''}</strong> &nbsp;|&nbsp;
                    Rebate: <strong class="text-dark">${lead.elogible_for_rebate ?? ''}</strong> &nbsp;|&nbsp;
                    Category: <strong class="text-dark">${lead.category ?? ''}</strong>
                    ${(lead.category === 'Solar' || lead.category === 'Solar+Battery') && lead.solar_kw
                        ? ` &nbsp;|&nbsp; Solar KW: <strong class="text-dark">${lead.solar_kw}</strong>` 
                        : ''}
                    ${(lead.category === 'Battery' || lead.category === 'Solar+Battery') && lead.battery_kw
                        ? ` &nbsp;|&nbsp; Battery KW: <strong class="text-dark">${lead.battery_kw}</strong>` 
                        : ''}  &nbsp;|&nbsp;
                    Assign To: <strong class="text-dark">${lead.get_assign_user_name?.name ?? ''}</strong>
                </div>
            </div>

            <div class="text-end">
                <div class="d-flex align-items-center justify-content-end flex-wrap mb-2 gap-2">
                    <span class="badge text-${color} border border-${color} rounded-pill px-2 py-1">
                        ${lead.status ?? ''}
                    </span>
                     
                </div>

                <div class="d-flex flex-wrap justify-content-end gap-2">
                    @can('lead_email_access')
                        <button class="btn btn-sm btn-warning custom-btn send_email"
                            data-lead='${JSON.stringify(lead)}' 
                            data-bs-toggle="offcanvas"
                            data-bs-target="#emailModel"
                            aria-controls="emailModel">
                            <i class="ph-envelope-simple"></i>
                        </button>
                    @endcan

                    <button class="btn btn-sm btn-primary view-lead"
                        data-lead='${JSON.stringify(lead)}' 
                        data-bs-toggle="offcanvas"
                        data-bs-target="#leadDetailsModal"
                        aria-controls="leadDetailsModal">
                        <i class="ph-eye"></i>
                    </button>

                    @can('lead_edit')
                        <button class="btn btn-sm btn-outline-secondary edit_lead"
                            data-lead='${JSON.stringify(lead)}' 
                            data-bs-toggle="offcanvas"
                            data-bs-target="#editlead"
                            aria-controls="editlead">
                            <i class="ph-pencil-line"></i>
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>`;
    }



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

    <script>
    let offset = 0;
    let limit = 25;
    let isLoading = false;
    let hasMore = true;

    function loadLeads_old(reset = false) {
        if (reset) {
            offset = 0;
            hasMore = true;
            $('#leads-container').empty();
            $('#load-more').show();
        }

        if (isLoading || !hasMore) return;

        isLoading = true;
        $('#load-more').prop('disabled', true).text('Loading...');

        $.ajax({
                url: "{{ route('admin.listLeads') }}",
                method: 'GET',
                data: {
                    offset,
                    limit,
                    lead_source: $('select[name="lead_source"]').val(),
                    assign_rep: $('select[name="assign_rep"]').val(),
                    status: $('select[name="status"]').val()
                }
            })
            .done(function(res) {
                const leads = Array.isArray(res) ? res : (res.data || []);

                if (!leads.length) {
                    showNoData();
                    return;
                }

                let html = '';
                leads.forEach(lead => {
                    if (!document.getElementById(`lead-${lead.id}`)) {
                        html += leadCard(lead);
                    }
                });

                $('#leads-container').append(html);
                offset += leads.length;

                if (leads.length < limit) {
                    hasMore = false;
                    $('#load-more').hide();
                }

                $('.totalFollowups').text(res.followupCount || 0);
            })
            .always(function() {
                isLoading = false;
                if (hasMore) $('#load-more').prop('disabled', false).text('Load More');
            });
    }

    function loadLeads1(limit = 10, offset = 0) {

        $.ajax({
            url: "{{ route('admin.listLeads') }}", // 🔴 change to your route
            type: "GET",
            data: {
                limit: limit,
                offset: offset,
                lead_source: $('#lead_source').val() ?? '',
                assign_rep: $('#assign_rep').val() ?? '',
                status: $('#status').val() ?? ''
            },
            success: function(response) {

                let leads = response.data;
                let tbody = '';
                $('#no-data-container').html('');

                if (!leads || leads.length === 0) {
                    showNoData();
                    return;
                }

                $.each(leads, function(index, lead) {

                    tbody += `
                <tr>
                    <td>${offset + index + 1}</td>
                    <td>${lead.name ?? '-'}</td>
                    <td>${lead.phone ?? '-'}</td>
                    <td>${lead.email ?? '-'}</td>
                    <td>${lead.address ?? '-'}</td>
                    <td>${lead.lead_source?.name ?? '-'}</td>
                    <td>
                        <a href="/leads/${lead.id}" class="btn btn-sm btn-info">View</a>
                        <a href="/leads/${lead.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            `;
                });

                $('#jsGrid1 tbody').html(tbody);
            },
            error: function() {
                showNoData();
            }
        });
    }


    function showNoData() {
        $('#leads-container').html(`
        <div style="display:flex; justify-content:center; align-items:center; height:220px; margin:0;">
            <div style="text-align:center; padding:20px; border:1px dashed #ccc; border-radius:12px; background:#fff; max-width:350px; width:100%; margin:0; animation: fadeIn 0.6s;">
                <div style="font-size:48px; color:#f39c12; margin:0 0 10px 0; line-height:1; animation: pulse 1.5s infinite;">
                    ⚠️
                </div>
                <p style="margin:0; font-size:18px; font-weight:600; color:#555;">
                    Warning: No Data Found!
                </p>
            </div>
        </div>
        <style>
            @keyframes fadeIn {
                from {opacity: 0; transform: scale(0.95);}
                to {opacity: 1; transform: scale(1);}
            }
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.15); }
                100% { transform: scale(1); }
            }
        </style>
    `);

        hasMore = false;
        $('#load-more').hide();
    }

    // Apply button
    $(document).on('click', '.apply', function() {
        if (!$('#load-more').length || typeof loadLeads !== 'function') {
            return;
        }

        hasMore = true;
        $('#load-more').show();
        loadLeads(true);
    });

    // Reset button
    $(document).on('click', 'button[type="reset"]', function() {
        if (!$('#load-more').length || typeof loadLeads !== 'function') {
            return;
        }

        $('select').val('');
        hasMore = true;
        $('#load-more').show();
        loadLeads(true);
    });

    // Load More button
    $(document).on('click', '#load-more', function() {
        if (typeof loadLeads === 'function') {
            loadLeads();
        }
    });

    // First load
    $(document).ready(function() {
        if ($('#load-more').length && typeof loadLeads === 'function') {
            loadLeads(true);
        }
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
