@extends('layouts.admin')
@section('title', 'Lead Source')

@section('styles')
@parent
<style>
    .lead-source-page {
        --ls-ink: #111827;
        --ls-muted: #667085;
        --ls-blue: #2563eb;
        --ls-teal: #0f766e;
        position: relative;
        padding: 18px !important;
        border-radius: 18px;
        color: var(--ls-ink);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .94), rgba(239, 248, 255, .78)),
            radial-gradient(circle at 10% 5%, rgba(56, 189, 248, .20), transparent 32%),
            radial-gradient(circle at 92% 8%, rgba(129, 140, 248, .16), transparent 30%),
            #f7fbff;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .94);
    }

    .lead-source-shell {
        display: grid;
        gap: 16px;
    }

    .lead-source-toolbar,
    .lead-source-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 18px;
        background: linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(246, 250, 255, .86));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .96),
            0 18px 38px rgba(21, 32, 51, .10);
        backdrop-filter: blur(12px);
    }

    .lead-source-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .36)),
            linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(20, 184, 166, .10));
    }

    .lead-source-title {
        margin: 0;
        color: var(--ls-ink);
        font-size: 22px;
        font-weight: 850;
        letter-spacing: 0;
    }

    .lead-source-subtitle {
        margin-top: 3px;
        color: var(--ls-muted);
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
            linear-gradient(135deg, var(--ls-blue), var(--ls-teal));
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

    .lead-source-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .lead-source-stat {
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

    .lead-source-stat:before {
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

    .lead-source-stat:after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, .24) 0%, rgba(255, 255, 255, 0) 34%);
        opacity: .58;
        pointer-events: none;
        z-index: -2;
    }

    .lead-source-stat.stat-green {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #158b4b 0%, #20b35f 56%, #58d887 100%);
    }

    .lead-source-stat.stat-rose {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #b6272e 0%, #d83a40 56%, #f06d6d 100%);
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

    .lead-source-panel-head {
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

    .lead-source-panel-title {
        margin: 0;
        font-size: 18px;
        font-weight: 850;
        color: var(--ls-ink);
    }

    .lead-source-panel-subtitle {
        margin-top: 3px;
        color: var(--ls-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .lead-source-table-wrap {
        padding: 0 18px 18px;
    }

    .lead-source-page #jsGrid1_wrapper > .row:first-child {
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

    .lead-source-page #jsGrid1_filter {
        display: flex;
        justify-content: flex-end;
    }

    .lead-source-page #jsGrid1_filter label,
    .lead-source-page #jsGrid1_length label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: var(--ls-muted);
        font-size: 12px;
        font-weight: 750;
    }

    .lead-source-page #jsGrid1_wrapper .form-control,
    .lead-source-page #jsGrid1_wrapper .form-select,
    .lead-source-page #jsGrid1_wrapper select {
        border-color: #d7dfec;
        border-radius: 10px;
        box-shadow: none;
    }

    .lead-source-table {
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

    .lead-source-table thead th {
        border: 0 !important;
        background: linear-gradient(135deg, rgba(255, 255, 255, .80), rgba(232, 243, 255, .94)) !important;
        color: #475467 !important;
        font-size: 11px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .lead-source-table tbody td {
        vertical-align: middle;
        border-color: #edf1f7 !important;
        background: rgba(255, 255, 255, .62);
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .lead-source-table tbody tr:hover td {
        background: linear-gradient(135deg, rgba(239, 248, 255, .96), rgba(255, 255, 255, .88));
    }

    .source-id {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        min-height: 28px;
        padding: 5px 9px;
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

    .source-name {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--ls-ink);
        font-weight: 850;
    }

    .source-avatar {
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

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, .76);
        border-radius: 999px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(15, 118, 110, .12);
        color: #0f766e;
        font-size: 11px;
        font-weight: 850;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .88);
    }

    .status-badge.is-inactive {
        color: #be123c;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(190, 18, 60, .12);
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, .12);
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
        .lead-source-toolbar,
        .lead-source-panel-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .lead-source-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .lead-source-page {
            padding: 12px !important;
        }

        .lead-source-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $sourceCollection = collect($leadSources);
    $totalSources = $sourceCollection->count();
    $activeSources = $sourceCollection->where('status', 1)->count();
    $inactiveSources = max($totalSources - $activeSources, 0);
@endphp

<div class="content lead-source-page pt-0">
    <div class="lead-source-shell">
        <div class="lead-source-toolbar">
            <div>
                <h1 class="lead-source-title">Lead Source</h1>
                <div class="lead-source-subtitle">Manage where new CRM leads originate from.</div>
            </div>

            @can('leadSource_add')
                <a href="{{ route('admin.leadSource.create') }}" class="gloss-btn">
                    <i class="ph-plus"></i> New Source
                </a>
            @endcan
        </div>

        <section class="lead-source-stats">
            <div class="lead-source-stat">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-globe"></i></span>
                    <span class="stat-pill">All time</span>
                </div>
                <div class="stat-value">{{ number_format($totalSources) }}</div>
                <div class="stat-label">Total Sources</div>
            </div>
            <div class="lead-source-stat stat-green">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-check-circle"></i></span>
                    <span class="stat-pill">Live</span>
                </div>
                <div class="stat-value">{{ number_format($activeSources) }}</div>
                <div class="stat-label">Active Sources</div>
            </div>
            <div class="lead-source-stat stat-rose">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-pause-circle"></i></span>
                    <span class="stat-pill">Paused</span>
                </div>
                <div class="stat-value">{{ number_format($inactiveSources) }}</div>
                <div class="stat-label">Inactive Sources</div>
            </div>
        </section>

        <div class="lead-source-panel">
            <div class="lead-source-panel-head">
                <div>
                    <h2 class="lead-source-panel-title">Source Directory</h2>
                    <div class="lead-source-panel-subtitle">Search, sort, edit, and retire lead acquisition channels.</div>
                </div>
            </div>

            <div class="table-responsive lead-source-table-wrap">
                <table class="table table-hover datatable datatable-User lead-source-table" id="jsGrid1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leadSources as $key => $value)
                            <tr data-entry-id="{{ $value->id }}">
                                <td>
                                    <span class="source-id">#{{ $value->id }}</span>
                                </td>
                                <td>
                                    <div class="source-name">
                                        <span class="source-avatar"><i class="ph-globe-hemisphere-east"></i></span>
                                        <span>{{ $value->source ?? '' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($value->status == 1)
                                        <span class="status-badge"><span class="status-dot"></span>Active</span>
                                    @else
                                        <span class="status-badge is-inactive"><span class="status-dot"></span>Inactive</span>
                                    @endif
                                </td>
                                <td class="action-cell">
                                    @can('leadSource_edit')
                                        <a href="{{ route('admin.leadSource.edit', $value->id) }}"
                                            class="btn btn-outline-info icon-action" title="Edit">
                                            <i class="ph-pencil"></i>
                                        </a>
                                    @endcan

                                    @can('leadSource_delete')
                                        <form action="{{ route('admin.leadSource.destroy', $value->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger icon-action" title="Delete">
                                                <i class="ph-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
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
    $.extend(true, $.fn.dataTable.defaults, {
        order: [[0, 'desc']],
        pageLength: 100,
    });

    $('.datatable-User:not(.ajaxTable)').DataTable();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
});
</script>
@endsection
