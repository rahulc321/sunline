@extends('layouts.admin')
@section('title', 'Tier')

@section('styles')
@parent
<style>
    .tier-page {
        --tier-ink: #111827;
        --tier-muted: #667085;
        --tier-blue: #2563eb;
        --tier-teal: #0f766e;
        position: relative;
        padding: 18px !important;
        border-radius: 18px;
        color: var(--tier-ink);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .94), rgba(239, 248, 255, .78)),
            radial-gradient(circle at 10% 5%, rgba(56, 189, 248, .20), transparent 32%),
            radial-gradient(circle at 92% 8%, rgba(129, 140, 248, .16), transparent 30%),
            #f7fbff;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .94);
    }

    .tier-shell {
        display: grid;
        gap: 16px;
    }

    .tier-toolbar,
    .tier-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 18px;
        background: linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(246, 250, 255, .86));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .96),
            0 18px 38px rgba(21, 32, 51, .10);
        backdrop-filter: blur(12px);
    }

    .tier-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .36)),
            linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(20, 184, 166, .10));
    }

    .tier-title {
        margin: 0;
        color: var(--tier-ink);
        font-size: 22px;
        font-weight: 850;
        letter-spacing: 0;
    }

    .tier-subtitle {
        margin-top: 3px;
        color: var(--tier-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .gloss-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 40px;
        padding: 9px 14px;
        border: 0;
        border-radius: 12px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 36%),
            linear-gradient(135deg, var(--tier-blue), var(--tier-teal));
        color: #ffffff;
        font-size: 13px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 10px 20px rgba(37, 99, 235, .20);
    }

    .gloss-btn:hover {
        color: #ffffff;
        transform: translateY(-1px);
    }

    .tier-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .tier-stat {
        position: relative;
        overflow: hidden;
        min-height: 122px;
        padding: 15px 16px;
        border: 1px solid rgba(255, 255, 255, .34);
        border-radius: 13px;
        color: #ffffff;
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #0c6ca8 0%, #0583c2 54%, #25b7ee 100%);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .34),
            inset 0 -28px 42px rgba(255, 255, 255, .08),
            0 14px 24px rgba(15, 23, 42, .12);
        isolation: isolate;
    }

    .tier-stat:before {
        content: "";
        position: absolute;
        right: -38px;
        bottom: -58px;
        width: 138px;
        height: 138px;
        border-radius: 50%;
        background:
            radial-gradient(circle at 34% 34%, rgba(255, 255, 255, .36), rgba(255, 255, 255, .05) 58%, transparent 60%),
            repeating-linear-gradient(90deg, rgba(255, 255, 255, .14) 0 1px, transparent 1px 6px);
        opacity: .55;
        z-index: -1;
    }

    .tier-stat:after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, .24) 0%, rgba(255, 255, 255, 0) 34%);
        opacity: .58;
        pointer-events: none;
        z-index: -2;
    }

    .tier-stat.stat-green {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #158b4b 0%, #20b35f 56%, #58d887 100%);
    }

    .tier-stat.stat-amber {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #d96822 0%, #ef8b37 56%, #ffc26d 100%);
    }

    .tier-stat.stat-indigo {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #4853bb 0%, #5b6bd8 56%, #8094ff 100%);
    }

    .stat-top {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 11px;
        background: rgba(255, 255, 255, .18);
        color: #ffffff;
        font-size: 18px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 8px 14px rgba(15, 23, 42, .10);
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .16);
        color: rgba(255, 255, 255, .94);
        font-size: 10px;
        font-weight: 850;
    }

    .stat-value {
        position: relative;
        z-index: 1;
        margin: 18px 0 3px;
        color: #ffffff;
        font-size: 30px;
        line-height: 1;
        font-weight: 850;
    }

    .stat-label {
        position: relative;
        z-index: 1;
        color: rgba(255, 255, 255, .88);
        font-size: 12px;
        font-weight: 800;
    }

    .tier-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 18px;
        border-bottom: 1px solid rgba(219, 227, 239, .78);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .82), rgba(255, 255, 255, .34)),
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(20, 184, 166, .08));
    }

    .tier-panel-title {
        margin: 0;
        font-size: 18px;
        font-weight: 850;
        color: var(--tier-ink);
    }

    .tier-panel-subtitle {
        margin-top: 3px;
        color: var(--tier-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .category-switch {
        display: inline-flex;
        gap: 8px;
        padding: 7px;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .42));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .94),
            0 10px 22px rgba(21, 32, 51, .05);
    }

    .category-switch a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 34px;
        padding: 7px 11px;
        border-radius: 10px;
        color: #475467;
        font-size: 12px;
        font-weight: 850;
    }

    .category-switch a.is-active {
        color: #ffffff;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 36%),
            linear-gradient(135deg, var(--tier-blue), var(--tier-teal));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 8px 16px rgba(37, 99, 235, .16);
    }

    .tier-table-wrap {
        padding: 0 18px 18px;
    }

    .tier-page #jsGrid1_wrapper > .row:first-child {
        margin: 16px 18px 0 !important;
        padding: 12px;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 14px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .42)),
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(15, 118, 110, .08));
        align-items: center;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .94),
            0 10px 22px rgba(21, 32, 51, .05);
    }

    .tier-page #jsGrid1_filter {
        display: flex;
        justify-content: flex-end;
    }

    .tier-page #jsGrid1_filter label,
    .tier-page #jsGrid1_length label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: var(--tier-muted);
        font-size: 12px;
        font-weight: 750;
    }

    .tier-page #jsGrid1_wrapper .form-control,
    .tier-page #jsGrid1_wrapper .form-select,
    .tier-page #jsGrid1_wrapper select {
        border-color: #d7dfec;
        border-radius: 10px;
        box-shadow: none;
    }

    .tier-table {
        margin-top: 14px !important;
        border-collapse: separate !important;
        border-spacing: 0;
        border: 1px solid rgba(224, 232, 245, .92);
        border-radius: 14px;
        overflow: hidden;
        background: rgba(255, 255, 255, .82);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .95),
            0 12px 24px rgba(21, 32, 51, .05);
    }

    .tier-table thead th {
        border: 0 !important;
        background: linear-gradient(135deg, rgba(255, 255, 255, .80), rgba(232, 243, 255, .94)) !important;
        color: #475467 !important;
        font-size: 11px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .tier-table tbody td {
        vertical-align: middle;
        border-color: #edf1f7 !important;
        background: rgba(255, 255, 255, .62);
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .tier-table tbody tr:hover td {
        background: linear-gradient(135deg, rgba(239, 248, 255, .96), rgba(255, 255, 255, .88));
    }

    .tier-id,
    .tier-range,
    .tier-commission,
    .tier-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 30px;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, .76);
        border-radius: 999px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(37, 99, 235, .10);
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 850;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .88);
    }

    .tier-range {
        color: #0f766e;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(15, 118, 110, .12);
    }

    .tier-commission {
        color: #b45309;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(245, 158, 11, .16);
    }

    .tier-category {
        color: #0f766e;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(15, 118, 110, .12);
    }

    .tier-category.is-solar {
        color: #b45309;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(245, 158, 11, .16);
    }

    .tier-name {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--tier-ink);
        font-weight: 850;
    }

    .tier-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #0f766e);
        color: #ffffff;
        font-size: 15px;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .28),
            0 8px 18px rgba(37, 99, 235, .18);
    }

    .tier-avatar.is-solar {
        background: linear-gradient(135deg, #f59e0b, #ef4444);
    }

    .action-cell {
        min-width: 92px;
        text-align: right;
        white-space: nowrap;
    }

    .icon-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 9px;
        background: linear-gradient(135deg, rgba(255, 255, 255, .78), rgba(255, 255, 255, .22));
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .88);
    }

    @media (max-width: 991.98px) {
        .tier-toolbar,
        .tier-panel-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .tier-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .tier-page {
            padding: 12px !important;
        }

        .tier-stats {
            grid-template-columns: 1fr;
        }

        .category-switch {
            width: 100%;
        }

        .category-switch a {
            flex: 1;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
@php
    $tierCollection = collect($tiers);
    $currentType = request('type') ?: optional($tierCollection->first())->category ?: 'solar';
    $typeLabel = ucfirst($currentType);
    $totalTiers = $tierCollection->count();
    $minRange = $tierCollection->min('min_value') ?? 0;
    $maxRange = $tierCollection->max('max_value') ?? 0;
    $avgCommission = $totalTiers ? $tierCollection->avg('commission') : 0;
@endphp

<div class="content tier-page pt-0">
    <div class="tier-shell">
        <div class="tier-toolbar">
            <div>
                <h1 class="tier-title">{{ $typeLabel }} Tier</h1>
                <div class="tier-subtitle">Manage commission tiers and value ranges without changing workflow.</div>
            </div>

            <a href="{{ route('admin.tier.create') }}" class="gloss-btn">
                <i class="ph-plus"></i> New Tier
            </a>
        </div>

        <section class="tier-stats">
            <div class="tier-stat">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-trophy"></i></span>
                    <span class="stat-pill">{{ $typeLabel }}</span>
                </div>
                <div class="stat-value">{{ number_format($totalTiers) }}</div>
                <div class="stat-label">Total Tiers</div>
            </div>
            <div class="tier-stat stat-green">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-arrow-line-up"></i></span>
                    <span class="stat-pill">Minimum</span>
                </div>
                <div class="stat-value">{{ number_format($minRange) }}</div>
                <div class="stat-label">Starting Range</div>
            </div>
            <div class="tier-stat stat-amber">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-chart-line-up"></i></span>
                    <span class="stat-pill">Maximum</span>
                </div>
                <div class="stat-value">{{ number_format($maxRange) }}</div>
                <div class="stat-label">Top Range</div>
            </div>
            <div class="tier-stat stat-indigo">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-currency-inr"></i></span>
                    <span class="stat-pill">Average</span>
                </div>
                <div class="stat-value">₹{{ number_format($avgCommission, 0) }}</div>
                <div class="stat-label">Commission</div>
            </div>
        </section>

        <div class="tier-panel">
            <div class="tier-panel-head">
                <div>
                    <h2 class="tier-panel-title">Tier Directory</h2>
                    <div class="tier-panel-subtitle">Search, sort, and update {{ strtolower($typeLabel) }} commission ranges.</div>
                </div>
                <div class="category-switch">
                    <a href="{{ route('admin.tier.index', ['type' => 'solar']) }}" class="{{ $currentType === 'solar' ? 'is-active' : '' }}">
                        <i class="ph-sun"></i> Solar
                    </a>
                    <a href="{{ route('admin.tier.index', ['type' => 'battery']) }}" class="{{ $currentType === 'battery' ? 'is-active' : '' }}">
                        <i class="ph-battery-charging"></i> Battery
                    </a>
                </div>
            </div>

            <div class="table-responsive tier-table-wrap">
                <table id="jsGrid1" class="table table-hover datatable datatable-User tier-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tier</th>
                            <th>Range</th>
                            <th>Commission</th>
                            <th>Category</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tiers as $key => $tier)
                            @php
                                $isSolar = $tier->category === 'solar';
                            @endphp
                            <tr data-entry-id="{{ $tier->id }}">
                                <td><span class="tier-id">#{{ $key + 1 }}</span></td>
                                <td>
                                    <div class="tier-name">
                                        <span class="tier-avatar {{ $isSolar ? 'is-solar' : '' }}">
                                            <i class="{{ $isSolar ? 'ph-sun' : 'ph-battery-charging' }}"></i>
                                        </span>
                                        <span>{{ $tier->tier_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="tier-range">{{ $tier->min_value }} - {{ $tier->max_value }}</span>
                                </td>
                                <td>
                                    <span class="tier-commission">₹{{ number_format($tier->commission, 2) }}</span>
                                </td>
                                <td>
                                    @if($tier->category == 'solar')
                                        <span class="tier-category is-solar"><i class="ph-sun"></i> Solar</span>
                                    @elseif($tier->category == 'battery')
                                        <span class="tier-category"><i class="ph-battery-charging"></i> Battery</span>
                                    @else
                                        <span class="tier-category"><i class="ph-question"></i> {{ ucfirst($tier->category) }}</span>
                                    @endif
                                </td>
                                <td class="action-cell">
                                    <a href="{{ route('admin.tier.edit', $tier->id) }}"
                                        class="btn btn-outline-info icon-action" title="Edit">
                                        <i class="ph-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.tier.destroy', $tier->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger icon-action" title="Delete">
                                            <i class="ph-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(function() {
    if ($.fn.DataTable && ! $.fn.DataTable.isDataTable('#jsGrid1')) {
        $('#jsGrid1').DataTable({
            order: [[0, 'asc']],
            pageLength: 100
        });
    }
});
</script>
@endsection
