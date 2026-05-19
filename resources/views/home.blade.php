@extends('layouts.admin')
@section('title', 'Dashboard')

@section('styles')
@parent
<style>
    .sunline-dashboard {
        --sun-ink: #152033;
        --sun-muted: #667085;
        --sun-border: #dbe3ef;
        --sun-blue: #2563eb;
        --sun-teal: #0f766e;
        --sun-gold: #f59e0b;
        --sun-green: #16a34a;
        --sun-red: #dc2626;
        --sun-panel: rgba(255, 255, 255, 0.88);
        --sun-glass-line: rgba(255, 255, 255, 0.68);
        color: var(--sun-ink);
        font-family: "Inter", "Segoe UI", sans-serif;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .sunline-dashboard .premium-shell {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 16% 8%, rgba(56, 168, 255, 0.26), transparent 30%),
            radial-gradient(circle at 86% 4%, rgba(245, 158, 11, 0.20), transparent 28%),
            radial-gradient(circle at 64% 74%, rgba(20, 184, 166, 0.15), transparent 34%),
            linear-gradient(180deg, #f7fbff 0%, #ecf5ff 44%, #ffffff 100%);
        border: 1px solid rgba(219, 227, 239, 0.85);
        border-left: 0;
        border-right: 0;
        border-radius: 0;
        padding: 18px;
        box-shadow: 0 20px 55px rgba(21, 32, 51, 0.10);
    }

    .sunline-dashboard .premium-shell:before,
    .sunline-dashboard .premium-shell:after {
        content: "";
        position: absolute;
        pointer-events: none;
    }

    .sunline-dashboard .premium-shell:before {
        inset: 0;
        background:
            linear-gradient(115deg, rgba(255, 255, 255, 0.48), transparent 25%, transparent 72%, rgba(255, 255, 255, 0.42)),
            repeating-linear-gradient(90deg, rgba(37, 99, 235, 0.05) 0 1px, transparent 1px 42px);
        opacity: .72;
    }

    .sunline-dashboard .premium-shell:after {
        top: -160px;
        right: -120px;
        width: 390px;
        height: 390px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(56, 168, 255, 0.28), rgba(96, 165, 250, 0.12) 46%, transparent 70%);
        filter: blur(3px);
    }

    .sunline-dashboard .premium-shell > * {
        position: relative;
        z-index: 1;
    }

    .sunline-dashboard .hero-panel {
        position: relative;
        overflow: hidden;
        min-height: 210px;
        padding: 24px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 18px;
        background:
            radial-gradient(circle at 16% 20%, rgba(125, 211, 252, 0.38), transparent 28%),
            radial-gradient(circle at 84% 0%, rgba(255, 255, 255, 0.22), transparent 34%),
            linear-gradient(135deg, rgba(18, 34, 68, 0.98), rgba(37, 99, 235, 0.9) 54%, rgba(14, 116, 144, 0.9)),
            linear-gradient(90deg, rgba(255, 255, 255, 0.10) 1px, transparent 1px),
            linear-gradient(180deg, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: auto, auto, auto, 38px 38px, 38px 38px;
        color: #ffffff;
        box-shadow:
            0 24px 55px rgba(23, 37, 84, 0.26),
            inset 0 1px 0 rgba(255, 255, 255, 0.28),
            inset 0 -1px 0 rgba(255, 255, 255, 0.14);
    }

    .sunline-dashboard .hero-panel:before {
        content: "";
        position: absolute;
        inset: 0 auto 0 -44%;
        width: 34%;
        transform: skewX(-18deg);
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.34), transparent);
        animation: dashboard-gloss-sheen 6.5s ease-in-out infinite;
        pointer-events: none;
    }

    .sunline-dashboard .hero-panel:after {
        content: "";
        position: absolute;
        inset: 18px 22px auto auto;
        width: 178px;
        height: 178px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 36px;
        background:
            linear-gradient(145deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0.04)),
            url("{{ asset('logo.png') }}");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 118px auto;
        opacity: .9;
        transform: rotate(-4deg);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.32),
            0 24px 42px rgba(6, 25, 73, 0.22);
    }

    .sunline-dashboard .hero-content {
        position: relative;
        z-index: 1;
    }

    .sunline-dashboard .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 11px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.88);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .sunline-dashboard .hero-title {
        max-width: 560px;
        margin: 16px 0 8px;
        color: #ffffff;
        font-size: clamp(26px, 3vw, 38px);
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: 0;
    }

    .sunline-dashboard .hero-copy {
        max-width: 560px;
        margin: 0;
        color: rgba(255, 255, 255, 0.78);
        font-size: 14px;
        line-height: 1.55;
    }

    .sunline-dashboard .hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }

    .sunline-dashboard .hero-stat {
        min-width: 130px;
        padding: 11px 14px;
        border: 1px solid rgba(255, 255, 255, 0.24);
        border-radius: 14px;
        background:
            linear-gradient(145deg, rgba(255, 255, 255, 0.20), rgba(255, 255, 255, 0.08)),
            rgba(255, 255, 255, 0.12);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.28),
            0 14px 28px rgba(6, 25, 73, 0.14);
        backdrop-filter: blur(12px);
    }

    .sunline-dashboard .hero-stat span {
        display: block;
        color: rgba(255, 255, 255, 0.68);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .sunline-dashboard .hero-stat strong {
        display: block;
        margin-top: 5px;
        color: #ffffff;
        font-size: 22px;
        line-height: 1;
    }

    .sunline-dashboard .punch-card,
    .sunline-dashboard .filter-panel,
    .sunline-dashboard .metric-card,
    .sunline-dashboard .insight-panel {
        position: relative;
        overflow: hidden;
        border: 1px dashed rgba(56, 168, 255, 0.72) !important;
        border-radius: 16px !important;
        background:
            linear-gradient(145deg, rgba(255, 255, 255, 0.94), rgba(248, 251, 255, 0.76)),
            var(--sun-panel);
        box-shadow:
            0 18px 42px rgba(21, 32, 51, 0.10) !important,
            inset 0 1px 0 var(--sun-glass-line);
        backdrop-filter: blur(14px);
    }

    .sunline-dashboard .punch-card:after,
    .sunline-dashboard .filter-panel:after,
    .sunline-dashboard .insight-panel:after {
        content: "";
        position: absolute;
        inset: 4px;
        border: 1px solid rgba(255, 255, 255, 0.58);
        border-radius: 12px;
        pointer-events: none;
    }

    .sunline-dashboard .punch-card:before,
    .sunline-dashboard .filter-panel:before,
    .sunline-dashboard .metric-card:before,
    .sunline-dashboard .insight-panel:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(120deg, rgba(255, 255, 255, 0.68), transparent 34%),
            radial-gradient(circle at 100% 0%, rgba(56, 168, 255, 0.12), transparent 34%);
        pointer-events: none;
    }

    .sunline-dashboard .punch-card > *,
    .sunline-dashboard .filter-panel > *,
    .sunline-dashboard .metric-card > *,
    .sunline-dashboard .insight-panel > * {
        position: relative;
        z-index: 1;
    }

    .sunline-dashboard .punch-card {
        padding: 18px;
        height: 100%;
    }

    .sunline-dashboard .punch-card h6,
    .sunline-dashboard .filter-panel h6,
    .sunline-dashboard .insight-panel h6 {
        margin: 0;
        color: var(--sun-ink);
        font-size: 15px;
        font-weight: 800;
    }

    .sunline-dashboard .muted-copy {
        color: var(--sun-muted);
        font-size: 13px;
        line-height: 1.5;
    }

    .sunline-dashboard .premium-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 38px;
        border-radius: 11px;
        font-weight: 700;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.24) !important;
    }

    .sunline-dashboard .btn-punch-in {
        border: 0;
        background: linear-gradient(135deg, #16a34a, #0f766e);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(22, 163, 74, 0.22), inset 0 1px 0 rgba(255, 255, 255, 0.26) !important;
    }

    .sunline-dashboard .btn-punch-out {
        border: 1px solid rgba(220, 38, 38, 0.22);
        background: linear-gradient(135deg, #fffafa, #fff1f1);
        color: var(--sun-red);
    }

    .sunline-dashboard .filter-panel {
        padding: 12px;
    }

    .sunline-dashboard .compact-filter-form {
        display: grid;
        grid-template-columns: minmax(150px, .9fr) minmax(132px, .7fr) minmax(132px, .7fr) minmax(170px, .9fr) minmax(170px, .9fr) minmax(164px, auto);
        align-items: end;
        gap: 10px;
    }

    .sunline-dashboard .filter-title {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 38px;
        padding-right: 8px;
    }

    .sunline-dashboard .filter-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
    }

    .sunline-dashboard .filter-panel label {
        margin-bottom: 4px;
        color: #475467;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .sunline-dashboard .filter-panel .form-control,
    .sunline-dashboard .filter-panel .form-select {
        height: 38px;
        min-height: 38px;
        border-color: rgba(215, 223, 236, 0.86);
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.82);
        color: var(--sun-ink);
        font-size: 13px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72);
    }

    .sunline-dashboard .filter-panel .form-control:focus,
    .sunline-dashboard .filter-panel .form-select:focus {
        border-color: rgba(37, 99, 235, .55);
        box-shadow: 0 0 0 .18rem rgba(37, 99, 235, .12);
    }

    .sunline-dashboard .btn-apply {
        border: 0;
        background: linear-gradient(135deg, var(--sun-blue), #38a8ff);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.20), inset 0 1px 0 rgba(255, 255, 255, 0.28) !important;
    }

    .sunline-dashboard .filter-actions {
        display: grid;
        grid-template-columns: 1fr 42px;
        gap: 8px;
    }

    .sunline-dashboard .metric-card {
        min-height: 174px;
        padding: 20px;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .sunline-dashboard .metric-card:hover {
        transform: translateY(-3px);
        border-color: rgba(37, 99, 235, 0.82) !important;
        box-shadow:
            0 22px 48px rgba(21, 32, 51, 0.14) !important,
            inset 0 1px 0 #ffffff;
    }

    .sunline-dashboard .metric-card:after {
        content: "";
        position: absolute;
        top: -68%;
        left: -46%;
        width: 38%;
        height: 220%;
        background: linear-gradient(105deg, transparent, rgba(255, 255, 255, 0.58), transparent);
        transform: rotate(14deg);
        opacity: 0;
        pointer-events: none;
        transition: left .46s ease, opacity .24s ease;
    }

    .sunline-dashboard .metric-card:hover:after {
        left: 112%;
        opacity: 1;
    }

    .sunline-dashboard .metric-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
    }

    .sunline-dashboard .metric-label {
        margin: 0;
        color: var(--sun-muted);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .02em;
    }

    .sunline-dashboard .metric-value {
        margin: 16px 0 8px;
        color: var(--sun-ink);
        font-size: 32px;
        line-height: 1;
        font-weight: 850;
    }

    .sunline-dashboard .metric-note {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--sun-muted);
        font-size: 12px;
        line-height: 1.35;
    }

    .sunline-dashboard .metric-note.positive {
        color: var(--sun-green);
        font-weight: 700;
    }

    .sunline-dashboard .icon-tile {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        width: 48px;
        height: 48px;
        border-radius: 13px;
        color: #ffffff;
        box-shadow:
            0 12px 26px rgba(21, 32, 51, .18),
            inset 0 1px 0 rgba(255, 255, 255, 0.36);
    }

    .sunline-dashboard .tile-blue { background: linear-gradient(135deg, #2563eb, #60a5fa); }
    .sunline-dashboard .tile-teal { background: linear-gradient(135deg, #0f766e, #2dd4bf); }
    .sunline-dashboard .tile-gold { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .sunline-dashboard .tile-green { background: linear-gradient(135deg, #16a34a, #86efac); }
    .sunline-dashboard .tile-rose { background: linear-gradient(135deg, #e11d48, #fb7185); }
    .sunline-dashboard .tile-indigo { background: linear-gradient(135deg, #4f46e5, #818cf8); }
    .sunline-dashboard .tile-slate { background: linear-gradient(135deg, #334155, #64748b); }
    .sunline-dashboard .tile-cyan { background: linear-gradient(135deg, #0891b2, #67e8f9); }

    .sunline-dashboard .mini-meter {
        height: 7px;
        margin-top: 18px;
        overflow: hidden;
        border-radius: 999px;
        background: rgba(226, 232, 240, 0.78);
        box-shadow: inset 0 1px 2px rgba(21, 32, 51, 0.08);
    }

    .sunline-dashboard .mini-meter span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background:
            linear-gradient(180deg, rgba(255, 255, 255, 0.42), transparent),
            linear-gradient(90deg, var(--sun-blue), #38a8ff, var(--sun-gold));
        box-shadow: 0 0 18px rgba(56, 168, 255, 0.26);
    }

    .sunline-dashboard .insight-panel {
        padding: 20px;
        height: 100%;
    }

    .sunline-dashboard .pipeline-row {
        display: grid;
        grid-template-columns: 112px 1fr 54px;
        align-items: center;
        gap: 12px;
        margin-top: 16px;
        color: var(--sun-muted);
        font-size: 13px;
        font-weight: 700;
    }

    .sunline-dashboard .pipeline-bar {
        height: 10px;
        overflow: hidden;
        border-radius: 999px;
        background: rgba(238, 242, 247, 0.9);
        box-shadow: inset 0 1px 2px rgba(21, 32, 51, 0.08);
    }

    .sunline-dashboard .pipeline-bar span {
        display: block;
        height: 100%;
        border-radius: inherit;
        box-shadow: 0 0 18px rgba(56, 168, 255, 0.24);
    }

    .sunline-dashboard .source-list {
        display: grid;
        gap: 13px;
        margin-top: 18px;
    }

    .sunline-dashboard .source-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px;
        border-radius: 13px;
        background:
            linear-gradient(145deg, rgba(255, 255, 255, 0.92), rgba(248, 251, 255, 0.78));
        border: 1px solid rgba(229, 235, 245, 0.9);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.74);
    }

    .sunline-dashboard .source-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
    }

    .sunline-dashboard .source-name {
        color: var(--sun-ink);
        font-size: 13px;
        font-weight: 800;
    }

    .sunline-dashboard .source-meta {
        color: var(--sun-muted);
        font-size: 12px;
    }

    @keyframes dashboard-gloss-sheen {
        0%,
        54% {
            left: -44%;
        }
        100% {
            left: 118%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .sunline-dashboard .hero-panel:before {
            animation: none;
        }

        .sunline-dashboard .metric-card:after {
            transition: none;
        }
    }

    @media (max-width: 1199.98px) {
        .sunline-dashboard .compact-filter-form {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .sunline-dashboard .filter-title,
        .sunline-dashboard .filter-actions {
            grid-column: auto;
        }
    }

    @media (max-width: 991.98px) {
        .sunline-dashboard .premium-shell {
            padding: 14px;
            border-radius: 14px;
        }

        .sunline-dashboard .hero-panel {
            padding: 22px;
        }

        .sunline-dashboard .hero-panel:after {
            opacity: .22;
        }

        .sunline-dashboard .compact-filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .sunline-dashboard .filter-title,
        .sunline-dashboard .filter-actions {
            grid-column: 1 / -1;
        }

        .sunline-dashboard .pipeline-row {
            grid-template-columns: 88px 1fr 44px;
        }
    }

    @media (max-width: 575.98px) {
        .sunline-dashboard .compact-filter-form {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $assignedLeadCount = isset($assign_lead) && is_countable($assign_lead) ? count($assign_lead) : 0;
    $contactedCount = isset($contacts) && is_countable($contacts) ? count($contacts) : 0;
    $closedSaleCount = isset($closed_sale) && is_countable($closed_sale) ? count($closed_sale) : 0;
    $quoteCount = 33;
    $productCount = 156;
    $conversionRate = $assignedLeadCount > 0 ? round(($closedSaleCount / $assignedLeadCount) * 100, 1) : 0;
    $contactRate = $assignedLeadCount > 0 ? round(($contactedCount / $assignedLeadCount) * 100, 1) : 0;
@endphp

<div class="content sunline-dashboard pt-0">
    <div class="premium-shell">
        <div class="row g-3 align-items-stretch">
            <div class="col-xl-8">
                <section class="hero-panel">
                    <div class="hero-content">
                        <span class="eyebrow"><i class="ph-sparkle"></i> Sales Command Center</span>
                        <h1 class="hero-title">Sales visibility for every Sunline Energy opportunity.</h1>
                        <p class="hero-copy">
                            Track assigned leads, contact quality, quotes, conversion, and revenue movement from one polished dashboard.
                        </p>

                        <div class="hero-actions">
                            <div class="hero-stat">
                                <span>Assigned Leads</span>
                                <strong>{{ number_format($assignedLeadCount) }}</strong>
                            </div>
                            <div class="hero-stat">
                                <span>Contact Rate</span>
                                <strong>{{ $contactRate }}%</strong>
                            </div>
                            <div class="hero-stat">
                                <span>Closed Sales</span>
                                <strong>{{ number_format($closedSaleCount) }}</strong>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-xl-4">
                <aside class="punch-card">
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                        <div>
                            <h6>Attendance</h6>
                            <div class="muted-copy mt-1">Start or close your active work session.</div>
                        </div>
                        <span class="icon-tile tile-gold"><i class="ph-clock fs-4"></i></span>
                    </div>

                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.attendance.punchin') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn premium-btn btn-punch-in w-100">
                                <i class="ph-arrow-circle-right"></i> Punch In
                            </button>
                        </form>

                        <form action="{{ route('admin.attendance.punchout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn premium-btn btn-punch-out w-100">
                                <i class="ph-arrow-circle-left"></i> Punch Out
                            </button>
                        </form>
                    </div>

                    <div class="source-item mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="source-dot bg-success"></span>
                            <div>
                                <div class="source-name">Live dashboard</div>
                                <div class="source-meta">Pipeline metrics refreshed by CRM data</div>
                            </div>
                        </div>
                        <i class="ph-shield-check text-success fs-5"></i>
                    </div>
                </aside>
            </div>
        </div>

        <section class="filter-panel mt-2">
            <form class="compact-filter-form">
                <div class="filter-title">
                    <span class="icon-tile tile-blue filter-icon">
                        <i class="ph-funnel"></i>
                    </span>
                    <div>
                        <h6>Filters</h6>
                        <div class="muted-copy">Date, rep and source</div>
                    </div>
                </div>

                <div>
                    <label>From Date</label>
                    <input type="date" class="form-control">
                </div>

                <div>
                    <label>To Date</label>
                    <input type="date" class="form-control">
                </div>

                <div>
                    <label>Sales Rep</label>
                    <select class="form-select">
                        <option>All Sales Reps</option>
                        <option>Rep 1</option>
                        <option>Rep 2</option>
                    </select>
                </div>

                <div>
                    <label>Lead Source</label>
                    <select class="form-select">
                        <option>All Sources</option>
                        <option>Source 1</option>
                        <option>Source 2</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn premium-btn btn-apply">
                        <i class="ph-check-circle"></i> Apply
                    </button>
                    <button type="reset" class="btn premium-btn btn-light border" title="Reset filters">
                        <i class="ph-arrow-counter-clockwise"></i>
                    </button>
                </div>
            </form>
        </section>

        <section class="row g-3 mt-1">
            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Total Leads Assigned</p>
                        <span class="icon-tile tile-blue"><i class="ph-users-three fs-4"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($assignedLeadCount) }}</div>
                    <div class="metric-note positive"><i class="ph-trend-up"></i> +12% from last month</div>
                    <div class="mini-meter"><span style="width: 78%"></span></div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Leads Contacted</p>
                        <span class="icon-tile tile-teal"><i class="ph-phone-call fs-4"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($contactedCount) }}</div>
                    <div class="metric-note positive"><i class="ph-activity"></i> {{ $contactRate }}% contact rate</div>
                    <div class="mini-meter"><span style="width: {{ min($contactRate, 100) }}%"></span></div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Quotes Sent</p>
                        <span class="icon-tile tile-gold"><i class="ph-file-text fs-4"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($quoteCount) }}</div>
                    <div class="metric-note positive"><i class="ph-trend-up"></i> +8% from last month</div>
                    <div class="mini-meter"><span style="width: 64%"></span></div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Sales Closed</p>
                        <span class="icon-tile tile-green"><i class="ph-currency-dollar fs-4"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($closedSaleCount) }}</div>
                    <div class="metric-note positive"><i class="ph-target"></i> {{ $conversionRate }}% conversion rate</div>
                    <div class="mini-meter"><span style="width: {{ min($conversionRate, 100) }}%"></span></div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Products Sold</p>
                        <span class="icon-tile tile-rose"><i class="ph-package fs-4"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($productCount) }}</div>
                    <div class="metric-note"><i class="ph-stack"></i> Battery, solar, heat pump and aircon mix</div>
                    <div class="mini-meter"><span style="width: 82%"></span></div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Total Conversion</p>
                        <span class="icon-tile tile-indigo"><i class="ph-crosshair fs-4"></i></span>
                    </div>
                    <div class="metric-value">{{ $conversionRate }}%</div>
                    <div class="metric-note positive"><i class="ph-arrow-up-right"></i> +2.3% from last month</div>
                    <div class="mini-meter"><span style="width: {{ min($conversionRate, 100) }}%"></span></div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Total Conversation</p>
                        <span class="icon-tile tile-cyan"><i class="ph-lightning fs-4"></i></span>
                    </div>
                    <div class="metric-value">87.6%</div>
                    <div class="metric-note"><i class="ph-chats-circle"></i> Contact rate from calls and meetings</div>
                    <div class="mini-meter"><span style="width: 88%"></span></div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="metric-card">
                    <div class="metric-top">
                        <p class="metric-label">Lead Cost Spend</p>
                        <span class="icon-tile tile-slate"><i class="ph-wallet fs-4"></i></span>
                    </div>
                    <div class="metric-value">$12,485</div>
                    <div class="metric-note"><i class="ph-chart-line-up"></i> Based on source costs and volumes</div>
                    <div class="mini-meter"><span style="width: 58%"></span></div>
                </div>
            </div>
        </section>

        <section class="row g-3 mt-1">
            <div class="col-xl-7">
                <div class="insight-panel">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <h6>Pipeline Momentum</h6>
                            <div class="muted-copy mt-1">A compact read on where leads are moving right now.</div>
                        </div>
                        <i class="ph-chart-bar text-primary fs-3"></i>
                    </div>

                    <div class="pipeline-row">
                        <span>Assigned</span>
                        <div class="pipeline-bar"><span class="tile-blue" style="width: 92%"></span></div>
                        <strong>{{ number_format($assignedLeadCount) }}</strong>
                    </div>
                    <div class="pipeline-row">
                        <span>Contacted</span>
                        <div class="pipeline-bar"><span class="tile-teal" style="width: {{ min($contactRate, 100) }}%"></span></div>
                        <strong>{{ number_format($contactedCount) }}</strong>
                    </div>
                    <div class="pipeline-row">
                        <span>Quoted</span>
                        <div class="pipeline-bar"><span class="tile-gold" style="width: 56%"></span></div>
                        <strong>{{ number_format($quoteCount) }}</strong>
                    </div>
                    <div class="pipeline-row">
                        <span>Closed</span>
                        <div class="pipeline-bar"><span class="tile-green" style="width: {{ min($conversionRate, 100) }}%"></span></div>
                        <strong>{{ number_format($closedSaleCount) }}</strong>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="insight-panel">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <h6>Product Mix</h6>
                            <div class="muted-copy mt-1">Sold product split across the most active categories.</div>
                        </div>
                        <i class="ph-sun text-warning fs-3"></i>
                    </div>

                    <div class="source-list">
                        <div class="source-item">
                            <div class="d-flex align-items-center gap-2">
                                <span class="source-dot" style="background:#2563eb"></span>
                                <div>
                                    <div class="source-name">Battery</div>
                                    <div class="source-meta">Standalone storage</div>
                                </div>
                            </div>
                            <strong>40</strong>
                        </div>
                        <div class="source-item">
                            <div class="d-flex align-items-center gap-2">
                                <span class="source-dot" style="background:#0f766e"></span>
                                <div>
                                    <div class="source-name">Solar + Battery</div>
                                    <div class="source-meta">Bundled energy systems</div>
                                </div>
                            </div>
                            <strong>60</strong>
                        </div>
                        <div class="source-item">
                            <div class="d-flex align-items-center gap-2">
                                <span class="source-dot" style="background:#f59e0b"></span>
                                <div>
                                    <div class="source-name">Heat Pump</div>
                                    <div class="source-meta">Hot water efficiency</div>
                                </div>
                            </div>
                            <strong>20</strong>
                        </div>
                        <div class="source-item">
                            <div class="d-flex align-items-center gap-2">
                                <span class="source-dot" style="background:#e11d48"></span>
                                <div>
                                    <div class="source-name">Aircon</div>
                                    <div class="source-meta">Comfort upgrades</div>
                                </div>
                            </div>
                            <strong>14</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="{{ asset('vendor/demo/pages/dashboard.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/donuts.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/bars.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/progress.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/pies.js') }}"></script>
@endsection
