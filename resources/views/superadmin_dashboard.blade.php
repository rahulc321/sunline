@extends('layouts.super')
@section('title', 'Dashboard')

@section('content')
@php
    $openLeadsCount = $assign_lead->count();
    $contactsCount = $contacts->count();
    $closedSalesCount = $closed_sale->count();
    $trackedTotal = $openLeadsCount + $contactsCount + $closedSalesCount;

    $statCards = [
        [
            'title' => 'Open Leads',
            'value' => $openLeadsCount,
            'link' => route('superadmin.sales'),
            'link_label' => 'View leads',
            'icon' => 'ph-user-circle-plus',
            'tone' => 'blue',
        ],
        [
            'title' => 'Qualified Contacts',
            'value' => $contactsCount,
            'link' => route('superadmin.sales'),
            'link_label' => 'View contacts',
            'icon' => 'ph-address-book',
            'tone' => 'green',
        ],
        [
            'title' => 'Closed Sales',
            'value' => $closedSalesCount,
            'link' => route('superadmin.sales'),
            'link_label' => 'View sales',
            'icon' => 'ph-check-circle',
            'tone' => 'gold',
        ],
        [
            'title' => 'Tracked Pipeline',
            'value' => $trackedTotal,
            'link' => route('superadmin.sales'),
            'link_label' => 'View pipeline',
            'icon' => 'ph-chart-pie-slice',
            'tone' => 'slate',
        ],
    ];

    $sourceLabels = $source_breakdown->pluck('source')->values();
    $sourceCounts = $source_breakdown->pluck('count')->values();
    $sourceColors = ['#1769aa', '#36b37e', '#f6b445', '#db2777', '#7c3aed', '#0891b2', '#e8792e', '#16a34a'];
    $sourceChartColors = array_slice($sourceColors, 0, max(count($sourceLabels), 1));
@endphp

<style>
:root {
    --dash-ink: #102033;
    --dash-muted: #65758b;
    --dash-blue: #1769aa;
    --dash-green: #36b37e;
    --dash-gold: #f6b445;
    --dash-line: #dce6ef;
    --dash-bg: #f4f8fb;
}

.content-inner {
    background:
        linear-gradient(180deg, rgba(23, 105, 170, 0.08), transparent 260px),
        var(--dash-bg);
    padding: 22px;
}

.rk-dashboard {
    font-family: "Inter", "Segoe UI", sans-serif;
    color: var(--dash-ink);
}

.rk-hero {
    position: relative;
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 20px;
    align-items: center;
    margin-bottom: 18px;
    padding: 22px;
    border: 1px solid rgba(23, 105, 170, 0.14);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(7, 26, 47, 0.97), rgba(23, 105, 170, 0.92) 48%, rgba(54, 179, 126, 0.88)),
        url("{{ asset('vendor/images/demo/cover3.jpg') }}") center/cover no-repeat;
    box-shadow: 0 18px 48px rgba(16, 32, 51, 0.12);
    overflow: hidden;
}

.rk-hero::before {
    content: "";
    position: absolute;
    top: 50%;
    right: 9%;
    width: 280px;
    height: 128px;
    background: url("{{ asset('logo.png') }}") center/contain no-repeat;
    opacity: 0.13;
    filter: brightness(0) invert(1) drop-shadow(0 0 36px rgba(255, 255, 255, 0.95));
    transform: translateY(-50%);
    pointer-events: none;
}

.rk-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 78% 45%, rgba(255, 255, 255, 0.34), transparent 24%),
        radial-gradient(circle at 18% 15%, rgba(246, 180, 69, 0.22), transparent 20%);
    pointer-events: none;
}

.rk-hero > * {
    position: relative;
    z-index: 1;
}

.rk-hero-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    padding: 6px 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 999px;
    color: rgba(255, 255, 255, 0.8);
    background: rgba(255, 255, 255, 0.1);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.rk-hero h1 {
    margin: 0;
    color: #ffffff;
    font-size: 30px;
    line-height: 1.15;
    font-weight: 800;
    letter-spacing: 0;
}

.rk-hero p {
    max-width: 650px;
    margin: 8px 0 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 14px;
    line-height: 1.6;
}

.rk-hero-action {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    min-height: 40px;
    padding: 0 14px;
    border-radius: 8px;
    background: #ffffff;
    color: var(--dash-blue);
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 14px 30px rgba(4, 18, 32, 0.24);
}

.rk-stat-card,
.rk-panel {
    border: 1px solid var(--dash-line) !important;
    border-radius: 8px !important;
    background: #ffffff;
    box-shadow: 0 14px 34px rgba(16, 32, 51, 0.07) !important;
}

.rk-stat-card {
    position: relative;
    overflow: hidden;
    min-height: 148px;
    padding: 18px;
    background:
        linear-gradient(135deg, #ffffff 0%, color-mix(in srgb, var(--tone-main) 7%, #ffffff) 48%, color-mix(in srgb, var(--tone-end) 14%, #ffffff) 100%);
}

.rk-stat-card::before {
    content: "";
    position: absolute;
    inset: 0 auto 0 0;
    width: 5px;
    background: linear-gradient(180deg, var(--tone-main), var(--tone-end));
}

.rk-stat-card::after {
    content: "";
    position: absolute;
    top: -28px;
    right: -22px;
    width: 118px;
    height: 118px;
    border-radius: 50%;
    background: radial-gradient(circle, var(--tone-soft), transparent 68%);
}

.rk-stat-top {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 22px;
}

.rk-stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--tone-main), var(--tone-end));
    color: #ffffff;
    font-size: 21px;
    box-shadow: 0 16px 30px var(--tone-shadow);
}

.rk-stat-label {
    margin: 0 0 6px;
    color: var(--dash-muted);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.rk-stat-value {
    margin: 0;
    color: var(--dash-ink);
    font-size: 30px;
    font-weight: 850;
    line-height: 1;
    letter-spacing: 0;
}

.rk-stat-link {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--tone-main);
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
}

.rk-stat-link:hover {
    color: var(--tone-end);
}

.rk-tone-blue { --tone-main: var(--dash-blue); --tone-end: #51b7d8; --tone-soft: rgba(23, 105, 170, 0.2); --tone-shadow: rgba(23, 105, 170, 0.22); }
.rk-tone-green { --tone-main: var(--dash-green); --tone-end: #58c79b; --tone-soft: rgba(54, 179, 126, 0.2); --tone-shadow: rgba(54, 179, 126, 0.22); }
.rk-tone-gold { --tone-main: var(--dash-gold); --tone-end: #e8792e; --tone-soft: rgba(246, 180, 69, 0.22); --tone-shadow: rgba(246, 180, 69, 0.22); }
.rk-tone-slate { --tone-main: #7c3aed; --tone-end: #db2777; --tone-soft: rgba(124, 58, 237, 0.18); --tone-shadow: rgba(124, 58, 237, 0.18); }

.rk-panel {
    overflow: hidden;
    background: linear-gradient(180deg, #ffffff, #fbfdff) !important;
}

.rk-panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 16px 18px;
    border-bottom: 1px solid #e8eff6;
    background: linear-gradient(180deg, #ffffff, #fbfdff);
}

.rk-panel-title {
    display: flex;
    align-items: center;
    gap: 9px;
    color: var(--dash-ink);
    font-size: 15px;
    font-weight: 850;
}

.rk-panel-title i {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #ffffff;
    background: linear-gradient(135deg, var(--dash-blue), var(--dash-green));
    font-size: 17px;
    box-shadow: 0 10px 20px rgba(23, 105, 170, 0.16);
}

.rk-panel-chip {
    border: 1px solid rgba(23, 105, 170, 0.14);
    background: rgba(23, 105, 170, 0.07);
    color: var(--dash-blue);
    border-radius: 999px;
    padding: 5px 10px;
    font-size: 11px;
    font-weight: 800;
}

.rk-lead-list {
    max-height: 408px;
    overflow-y: auto;
}

.rk-lead-row {
    display: grid;
    grid-template-columns: 54px 1fr auto;
    gap: 14px;
    padding: 16px 18px;
    border-bottom: 1px solid #edf3f8;
}

.rk-lead-row:last-child {
    border-bottom: 0;
}

.rk-date-box {
    width: 46px;
    border-radius: 8px;
    background: linear-gradient(135deg, #7c3aed, #db2777);
    color: #ffffff;
    text-align: center;
    padding: 8px 4px;
    font-weight: 850;
    line-height: 1.05;
    box-shadow: 0 12px 24px rgba(23, 105, 170, 0.18);
}

.rk-date-box strong {
    display: block;
    font-size: 20px;
}

.rk-date-box span {
    display: block;
    font-size: 10px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    opacity: 0.9;
}

.rk-lead-name {
    margin: 0 0 7px;
    color: #1f3652;
    font-size: 14px;
    font-weight: 850;
}

.rk-lead-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.rk-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 9px;
    border-radius: 999px;
    background: linear-gradient(135deg, #f8fbfd, rgba(81, 183, 216, 0.12));
    border: 1px solid #e3ecf4;
    color: #5c7087;
    font-size: 11px;
    font-weight: 750;
}

.rk-lead-status {
    align-self: start;
    display: inline-flex;
    align-items: center;
    max-width: 160px;
    border-radius: 999px;
    background: rgba(54, 179, 126, 0.1);
    color: #268765;
    font-size: 11px;
    font-weight: 850;
    padding: 5px 9px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rk-chart-body {
    padding: 18px;
}

.rk-donut-grid {
    display: grid;
    grid-template-columns: minmax(220px, 290px) 1fr;
    gap: 20px;
    align-items: center;
}

.rk-donut-wrap {
    position: relative;
    height: 270px;
}

.rk-donut-center {
    position: absolute;
    inset: 50% auto auto 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.rk-donut-center small {
    display: block;
    margin-bottom: 5px;
    color: var(--dash-muted);
    font-size: 12px;
    font-weight: 800;
}

.rk-donut-center strong {
    color: var(--dash-ink);
    font-size: 38px;
    line-height: 1;
    font-weight: 850;
}

.rk-source-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.rk-source-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto auto;
    gap: 12px;
    align-items: center;
    padding: 10px 12px;
    border: 1px solid #e6eef6;
    border-radius: 8px;
    background: linear-gradient(135deg, #ffffff, #fbfdff 58%, rgba(246, 180, 69, 0.08));
    color: #314760;
    font-size: 13px;
}

.rk-source-name {
    display: flex;
    align-items: center;
    gap: 9px;
    min-width: 0;
}

.rk-source-dot {
    width: 9px;
    height: 9px;
    border-radius: 999px;
    flex: 0 0 auto;
}

.rk-source-label {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 750;
}

.rk-source-count {
    color: var(--dash-ink);
    font-weight: 850;
}

.rk-source-percent {
    color: var(--dash-muted);
    font-weight: 800;
}

.rk-summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    padding: 18px;
}

.rk-summary-box {
    border: 1px solid #e3ecf4;
    border-radius: 8px;
    padding: 16px;
    background: linear-gradient(135deg, #ffffff, #f8fbfd 55%, rgba(54, 179, 126, 0.08));
    position: relative;
    overflow: hidden;
}

.rk-summary-box:nth-child(1) { background: linear-gradient(135deg, #ffffff, rgba(23, 105, 170, 0.12)); }
.rk-summary-box:nth-child(2) { background: linear-gradient(135deg, #ffffff, rgba(54, 179, 126, 0.14)); }
.rk-summary-box:nth-child(3) { background: linear-gradient(135deg, #ffffff, rgba(246, 180, 69, 0.16)); }
.rk-summary-box:nth-child(4) { background: linear-gradient(135deg, #ffffff, rgba(124, 58, 237, 0.12)); }

.rk-summary-box::after {
    content: "";
    position: absolute;
    right: -24px;
    top: -26px;
    width: 74px;
    height: 74px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(23, 105, 170, 0.18), transparent 68%);
}

.rk-summary-box:nth-child(2)::after { background: radial-gradient(circle, rgba(54, 179, 126, 0.2), transparent 68%); }
.rk-summary-box:nth-child(3)::after { background: radial-gradient(circle, rgba(246, 180, 69, 0.22), transparent 68%); }
.rk-summary-box:nth-child(4)::after { background: radial-gradient(circle, rgba(124, 58, 237, 0.18), transparent 68%); }

.rk-summary-box span {
    display: block;
    color: var(--dash-muted);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 850;
}

.rk-summary-box strong {
    display: block;
    margin-top: 8px;
    color: var(--dash-ink);
    font-size: 25px;
    font-weight: 850;
}


/* glossy dashboard finish */
.rk-stat-card,
.rk-panel,
.rk-summary-box,
.rk-source-row {
    position: relative;
    isolation: isolate;
}

.rk-stat-card {
    border-color: color-mix(in srgb, var(--tone-main) 18%, #ffffff) !important;
    box-shadow: 0 18px 42px rgba(16, 32, 51, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.84) !important;
}

.rk-stat-card .rk-stat-top,
.rk-stat-card .rk-stat-link {
    position: relative;
    z-index: 2;
}

.rk-stat-card::after {
    z-index: 0;
}

.rk-stat-card .rk-stat-icon {
    position: relative;
    overflow: hidden;
}

.rk-stat-card .rk-stat-icon::after {
    content: "";
    position: absolute;
    inset: 4px auto auto 5px;
    width: 58%;
    height: 34%;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.38);
    filter: blur(2px);
}

.rk-panel {
    border-color: rgba(23, 105, 170, 0.14) !important;
    box-shadow: 0 18px 42px rgba(16, 32, 51, 0.09), inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
}

.rk-panel::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 5px;
    background: linear-gradient(90deg, #1769aa, #36b37e, #f6b445, #db2777, #7c3aed);
    z-index: 2;
}

.rk-panel::after {
    content: "";
    position: absolute;
    top: -80px;
    right: -70px;
    width: 190px;
    height: 190px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(81, 183, 216, 0.18), transparent 68%);
    pointer-events: none;
    z-index: 0;
}

.rk-panel > * {
    position: relative;
    z-index: 1;
}

.rk-panel-head {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(248, 252, 255, 0.86), rgba(54, 179, 126, 0.08));
}

.rk-date-box,
.rk-panel-title i,
.rk-status-icon,
.rk-source-dot {
    box-shadow: 0 12px 24px rgba(16, 32, 51, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.34);
}

.rk-source-row {
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(16, 32, 51, 0.045), inset 0 1px 0 rgba(255, 255, 255, 0.8);
}

.rk-source-row::before {
    content: "";
    position: absolute;
    inset: 0 auto 0 0;
    width: 4px;
    background: linear-gradient(180deg, #1769aa, #36b37e);
}

.rk-summary-box {
    box-shadow: 0 14px 30px rgba(16, 32, 51, 0.07), inset 0 1px 0 rgba(255, 255, 255, 0.88);
}

.rk-summary-box::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 4px;
    background: linear-gradient(90deg, #1769aa, #36b37e);
}

.rk-summary-box:nth-child(2)::before { background: linear-gradient(90deg, #36b37e, #51b7d8); }
.rk-summary-box:nth-child(3)::before { background: linear-gradient(90deg, #f6b445, #e8792e); }
.rk-summary-box:nth-child(4)::before { background: linear-gradient(90deg, #7c3aed, #db2777); }

@media (max-width: 991.98px) {
    .content-inner {
        padding: 16px;
    }

    .rk-hero {
        grid-template-columns: 1fr;
    }

    .rk-hero-action {
        justify-self: start;
    }

    .rk-donut-grid,
    .rk-summary-grid {
        grid-template-columns: 1fr;
    }

    .rk-lead-row {
        grid-template-columns: 48px 1fr;
    }

    .rk-lead-status {
        grid-column: 2;
        justify-self: start;
    }
}

@media (max-width: 575.98px) {
    .content-inner {
        padding: 12px;
    }

    .rk-hero {
        padding: 18px;
    }

    .rk-hero h1 {
        font-size: 24px;
    }

    .rk-stat-value {
        font-size: 26px;
    }
}
</style>

<div class="rk-dashboard">
    <div class="rk-hero">
        <div>
            <div class="rk-hero-kicker"><i class="ph ph-sun"></i> Superadmin Dashboard</div>
            <h1>Control center for sales, approvals, and pipeline health..</h1>
            <p>Track active leads, monitor source performance, and jump into the work that needs attention.</p>
        </div>
        <a href="{{ route('superadmin.sales') }}" class="rk-hero-action">
            Open pipeline
            <i class="ph ph-arrow-right"></i>
        </a>
    </div>

    <div class="row g-3 mb-3">
        @foreach($statCards as $card)
            <div class="col-md-6 col-xl-3">
                <div class="rk-stat-card rk-tone-{{ $card['tone'] }}">
                    <div class="rk-stat-top">
                        <div>
                            <p class="rk-stat-label">{{ $card['title'] }}</p>
                            <h5 class="rk-stat-value">{{ number_format($card['value']) }}</h5>
                        </div>
                        <span class="rk-stat-icon"><i class="ph {{ $card['icon'] }}"></i></span>
                    </div>
                    <a href="{{ $card['link'] }}" class="rk-stat-link">
                        {{ $card['link_label'] }}
                        <i class="ph ph-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-5">
            <div class="rk-panel h-100">
                <div class="rk-panel-head">
                    <div class="rk-panel-title"><i class="ph ph-calendar-blank"></i> Recent Leads</div>
                    <span class="rk-panel-chip">Latest 6</span>
                </div>
                <div class="rk-lead-list">
                    @forelse($recent_leads as $lead)
                        <div class="rk-lead-row">
                            <div class="rk-date-box">
                                <strong>{{ \Carbon\Carbon::parse($lead->getRawOriginal('created_at'))->format('d') }}</strong>
                                <span>{{ \Carbon\Carbon::parse($lead->getRawOriginal('created_at'))->format('M') }}</span>
                            </div>
                            <div>
                                <p class="rk-lead-name">{{ trim(($lead->first_name ?? '').' '.($lead->last_name ?? '')) ?: 'Unnamed Lead' }}</p>
                                <div class="rk-lead-meta">
                                    <span class="rk-meta-pill"><i class="ph ph-hash"></i> #{{ $lead->id }}</span>
                                    <span class="rk-meta-pill"><i class="ph ph-globe"></i> {{ optional($lead->leadSource)->source ?: 'Unknown Source' }}</span>
                                    <span class="rk-meta-pill"><i class="ph ph-user"></i> {{ optional($lead->getAssignUserName)->name ?: 'Unassigned' }}</span>
                                </div>
                            </div>
                            <span class="rk-lead-status">{{ $lead->status ?: 'Lead' }}</span>
                        </div>
                    @empty
                        <div class="p-4 text-muted">No recent leads found.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="rk-panel h-100">
                <div class="rk-panel-head">
                    <div class="rk-panel-title"><i class="ph ph-chart-donut"></i> Leads By Source</div>
                    <span class="rk-panel-chip">Current mix</span>
                </div>
                <div class="rk-chart-body">
                    <div class="rk-donut-grid">
                        <div class="rk-donut-wrap">
                            <canvas id="leadSourceChart"></canvas>
                            <div class="rk-donut-center">
                                <small>Total Leads</small>
                                <strong>{{ number_format($trackedTotal) }}</strong>
                            </div>
                        </div>

                        <div class="rk-source-list">
                            @forelse($source_breakdown as $index => $item)
                                <div class="rk-source-row">
                                    <div class="rk-source-name">
                                        <span class="rk-source-dot" style="background: {{ $sourceColors[$index % count($sourceColors)] }}"></span>
                                        <span class="rk-source-label">{{ $item['source'] }}</span>
                                    </div>
                                    <span class="rk-source-count">{{ $item['count'] }}</span>
                                    <span class="rk-source-percent">{{ $item['percent'] }}%</span>
                                </div>
                            @empty
                                <div class="text-muted">No source data available.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rk-panel">
        <div class="rk-panel-head">
            <div class="rk-panel-title"><i class="ph ph-squares-four"></i> Pipeline Snapshot</div>
            <span class="rk-panel-chip">Overview</span>
        </div>
        <div class="rk-summary-grid">
            <div class="rk-summary-box">
                <span>Open Leads</span>
                <strong>{{ number_format($openLeadsCount) }}</strong>
            </div>
            <div class="rk-summary-box">
                <span>Qualified</span>
                <strong>{{ number_format($contactsCount) }}</strong>
            </div>
            <div class="rk-summary-box">
                <span>Closed</span>
                <strong>{{ number_format($closedSalesCount) }}</strong>
            </div>
            <div class="rk-summary-box">
                <span>Total Tracked</span>
                <strong>{{ number_format($trackedTotal) }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(() => {
    const chartEl = document.getElementById('leadSourceChart');
    if (!chartEl) return;

    const labels = @json($sourceLabels);
    const data = @json($sourceCounts);
    const colors = @json($sourceChartColors);

    new Chart(chartEl, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data,
                backgroundColor: colors,
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 4,
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: '#102033',
                    padding: 10,
                    displayColors: true,
                }
            }
        }
    });
})();
</script>
@endsection
