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
            'link_label' => 'View Open Leads',
            'accent' => 'rk-accent-blue',
            'icon' => 'ph-user-circle-plus',
        ],
        [
            'title' => 'Qualified Contacts',
            'value' => $contactsCount,
            'link' => route('superadmin.sales'),
            'link_label' => 'View Contacts',
            'accent' => 'rk-accent-pink',
            'icon' => 'ph-address-book',
        ],
        [
            'title' => 'Closed Sales',
            'value' => $closedSalesCount,
            'link' => route('superadmin.sales'),
            'link_label' => 'View Closed Sales',
            'accent' => 'rk-accent-orange',
            'icon' => 'ph-seal-check',
        ],
        [
            'title' => 'Tracked Pipeline',
            'value' => $trackedTotal,
            'link' => route('superadmin.sales'),
            'link_label' => 'View Pipeline',
            'accent' => 'rk-accent-teal',
            'icon' => 'ph-chart-donut',
        ],
    ];

    $sourceLabels = $source_breakdown->pluck('source')->values();
    $sourceCounts = $source_breakdown->pluck('count')->values();
    $sourceColors = ['#3b82f6', '#8b5cf6', '#10b981', '#f59e0b', '#1d4ed8', '#ef4444', '#06b6d4', '#f97316'];
    $sourceChartColors = array_slice($sourceColors, 0, max(count($sourceLabels), 1));
@endphp

<style>
.rk-dashboard {
    padding: 4px 0 18px;
    font-family: "Inter", "Segoe UI", sans-serif;
}

.rk-dashboard-header {
    margin-bottom: 18px;
}

.rk-dashboard-title {
    font-size: 30px;
    line-height: 1.1;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: #172b4d;
    margin: 0;
}

.rk-dashboard-subtitle {
    margin: 6px 0 0;
    color: #708399;
    font-size: 14px;
}

.rk-stat-card,
.rk-panel {
    background: #fff;
    border: 1px solid #dbe5f0;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
}

.rk-stat-card {
    position: relative;
    overflow: hidden;
    padding: 16px 18px 14px;
}

.rk-stat-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 3px;
    background: var(--rk-accent);
}

.rk-accent-blue { --rk-accent: #6366f1; --rk-soft: #eef2ff; }
.rk-accent-pink { --rk-accent: #ec4899; --rk-soft: #fdf2f8; }
.rk-accent-orange { --rk-accent: #f97316; --rk-soft: #fff7ed; }
.rk-accent-teal { --rk-accent: #14b8a6; --rk-soft: #ecfeff; }

.rk-stat-top {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
}

.rk-stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--rk-accent);
    color: #fff;
    font-size: 18px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.24);
}

.rk-stat-label {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #7b8da1;
    margin: 0 0 3px;
}

.rk-stat-value {
    font-size: 18px;
    font-weight: 800;
    letter-spacing: -0.03em;
    color: #172b4d;
    margin: 0;
}

.rk-stat-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
    font-size: 12px;
    font-weight: 700;
    color: var(--rk-accent);
    text-decoration: none;
}

.rk-panel {
    overflow: hidden;
}

.rk-panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 14px 16px;
    border-bottom: 1px solid #e7eef6;
}

.rk-panel-title {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #1f2937;
    font-size: 15px;
    font-weight: 700;
}

.rk-panel-chip {
    border: 1px solid #dbe5f0;
    background: #f7faff;
    color: #8a99aa;
    border-radius: 999px;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 700;
}

.rk-lead-list {
    max-height: 382px;
    overflow-y: auto;
}

.rk-lead-row {
    display: grid;
    grid-template-columns: 56px 1fr auto;
    gap: 14px;
    padding: 14px 16px;
    border-bottom: 1px solid #edf2f7;
}

.rk-lead-row:last-child {
    border-bottom: 0;
}

.rk-date-box {
    width: 44px;
    border-radius: 12px;
    background: linear-gradient(180deg, #c87920 0%, #a95f10 100%);
    color: #fff;
    text-align: center;
    padding: 8px 4px;
    font-weight: 800;
    line-height: 1.05;
}

.rk-date-box strong {
    display: block;
    font-size: 20px;
}

.rk-date-box span {
    display: block;
    font-size: 10px;
    letter-spacing: .08em;
    text-transform: uppercase;
    opacity: .9;
}

.rk-lead-name {
    font-size: 14px;
    font-weight: 700;
    color: #22324b;
    margin: 0 0 6px;
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
    background: #f5f7fb;
    border: 1px solid #e2e8f0;
    color: #59708a;
    font-size: 11px;
    font-weight: 700;
}

.rk-lead-status {
    align-self: start;
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    background: #fff6e8;
    color: #d17a00;
    font-size: 11px;
    font-weight: 800;
    padding: 5px 9px;
}

.rk-chart-body {
    padding: 14px 16px 16px;
}

.rk-donut-grid {
    display: grid;
    grid-template-columns: minmax(220px, 280px) 1fr;
    gap: 18px;
    align-items: center;
}

.rk-donut-wrap {
    position: relative;
    height: 260px;
}

.rk-donut-center {
    position: absolute;
    inset: 50% auto auto 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.rk-donut-center small {
    display: block;
    font-size: 12px;
    color: #8da0b3;
    margin-bottom: 4px;
}

.rk-donut-center strong {
    font-size: 38px;
    line-height: 1;
    color: #1f3652;
    font-weight: 800;
}

.rk-source-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.rk-source-row {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 12px;
    align-items: center;
    font-size: 13px;
    color: #314760;
}

.rk-source-name {
    display: flex;
    align-items: center;
    gap: 9px;
    min-width: 0;
}

.rk-source-dot {
    width: 8px;
    height: 8px;
    border-radius: 999px;
    flex: 0 0 auto;
}

.rk-source-label {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rk-source-count {
    font-weight: 800;
    color: #1f3652;
}

.rk-source-percent {
    color: #8da0b3;
    font-weight: 700;
}

.rk-summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    padding: 16px;
}

.rk-summary-box {
    border: 1px solid #e5edf6;
    border-radius: 14px;
    padding: 14px;
    background: #fbfdff;
}

.rk-summary-box span {
    display: block;
    color: #8ea0b1;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 800;
}

.rk-summary-box strong {
    display: block;
    margin-top: 8px;
    color: #1c3048;
    font-size: 24px;
    font-weight: 800;
}

@media (max-width: 991.98px) {
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
</style>

<div class="rk-dashboard">
    <div class="rk-dashboard-header">
        <h4 class="rk-dashboard-title">Dashboard</h4>
        <p class="rk-dashboard-subtitle">Track lead flow, recent activity, and source performance from one view.</p>
    </div>

    <div class="row g-3 mb-3">
        @foreach($statCards as $card)
            <div class="col-md-6 col-xl-3">
                <div class="rk-stat-card {{ $card['accent'] }}">
                    <div class="rk-stat-top">
                        <span class="rk-stat-icon"><i class="ph {{ $card['icon'] }}"></i></span>
                        <div>
                            <p class="rk-stat-label">{{ $card['title'] }}</p>
                            <h5 class="rk-stat-value">{{ number_format($card['value']) }}</h5>
                        </div>
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
                    <div class="rk-panel-title"><i class="ph ph-chart-donut"></i> Lead By Source</div>
                    <span class="rk-panel-chip">Current Mix</span>
                </div>
                <div class="rk-chart-body">
                    <div class="rk-donut-grid">
                        <div class="rk-donut-wrap">
                            <canvas id="leadSourceChart"></canvas>
                            <div class="rk-donut-center">
                                <small>Total Leads</small>
                                <strong>{{ $trackedTotal }}</strong>
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
                hoverOffset: 3,
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: '#172b4d',
                    padding: 10,
                    displayColors: true,
                }
            }
        }
    });
})();
</script>
@endsection
