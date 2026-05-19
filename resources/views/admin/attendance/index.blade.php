@extends('layouts.admin')

@section('title', 'Attendance')

@section('styles')
@parent
<style>
    .attendance-page {
        --att-ink: #111827;
        --att-muted: #667085;
        --att-border: rgba(218, 228, 242, .86);
        position: relative;
        padding: 18px !important;
        border-radius: 18px;
        color: var(--att-ink);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .94), rgba(239, 248, 255, .78)),
            radial-gradient(circle at 10% 5%, rgba(56, 189, 248, .20), transparent 32%),
            radial-gradient(circle at 92% 8%, rgba(129, 140, 248, .16), transparent 30%),
            #f7fbff;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .94);
    }

    .attendance-shell {
        display: grid;
        gap: 16px;
    }

    .attendance-toolbar,
    .attendance-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 18px;
        background: linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(246, 250, 255, .86));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .96),
            0 18px 38px rgba(21, 32, 51, .10);
        backdrop-filter: blur(12px);
    }

    .attendance-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .36)),
            linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(20, 184, 166, .10));
    }

    .attendance-title {
        margin: 0;
        color: var(--att-ink);
        font-size: 22px;
        font-weight: 850;
        letter-spacing: 0;
    }

    .attendance-subtitle {
        margin-top: 3px;
        color: var(--att-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .attendance-filter {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border: 1px solid rgba(255, 255, 255, .82);
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .42));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .94),
            0 10px 22px rgba(21, 32, 51, .06);
    }

    .attendance-filter .form-control {
        min-height: 38px;
        border: 1px solid #d8e3f2;
        border-radius: 11px;
        color: #334155;
        font-weight: 750;
        box-shadow: none;
    }

    .attendance-filter .btn {
        min-height: 38px;
        border: 0;
        border-radius: 11px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 36%),
            linear-gradient(135deg, #2563eb, #0f766e);
        color: #ffffff;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 10px 20px rgba(37, 99, 235, .20);
    }

    .attendance-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .attendance-stat {
        position: relative;
        overflow: hidden;
        min-height: 118px;
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

    .attendance-stat:before {
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

    .attendance-stat.stat-green {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #158b4b 0%, #20b35f 56%, #58d887 100%);
    }

    .attendance-stat.stat-amber {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #d96822 0%, #ef8b37 56%, #ffc26d 100%);
    }

    .attendance-stat.stat-rose {
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
        font-size: 28px;
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

    .attendance-panel-head {
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

    .attendance-panel-title {
        margin: 0;
        font-size: 18px;
        font-weight: 850;
        color: var(--att-ink);
    }

    .attendance-legend {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .legend-pill,
    .status-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
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

    .legend-present,
    .status-present {
        color: #0f766e;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(15, 118, 110, .12);
    }

    .legend-partial,
    .status-partial {
        color: #b45309;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(245, 158, 11, .16);
    }

    .legend-absent,
    .status-absent {
        color: #be123c;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(190, 18, 60, .12);
    }

    .attendance-table-wrap {
        padding: 0 18px 18px;
        overflow-x: auto;
    }

    .attendance-table {
        min-width: 980px;
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

    .attendance-table thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        border: 0 !important;
        background: linear-gradient(135deg, rgba(255, 255, 255, .80), rgba(232, 243, 255, .94)) !important;
        color: #475467 !important;
        font-size: 11px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .04em;
        white-space: nowrap;
    }

    .attendance-table tbody td {
        vertical-align: middle;
        border-color: #edf1f7 !important;
        background: rgba(255, 255, 255, .62);
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .attendance-table tbody tr:hover td {
        background: linear-gradient(135deg, rgba(239, 248, 255, .96), rgba(255, 255, 255, .88));
    }

    .attendance-user {
        position: sticky;
        left: 0;
        z-index: 1;
        min-width: 190px;
        background: linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(246, 250, 255, .94)) !important;
        box-shadow: 8px 0 18px rgba(21, 32, 51, .04);
    }

    .attendance-user-name {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--att-ink);
        font-weight: 850;
    }

    .attendance-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #0f766e);
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .28),
            0 8px 18px rgba(37, 99, 235, .18);
    }

    @media (max-width: 991.98px) {
        .attendance-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .attendance-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .attendance-page {
            padding: 12px !important;
        }

        .attendance-filter {
            width: 100%;
            align-items: stretch;
            flex-direction: column;
        }

        .attendance-filter .form-control,
        .attendance-filter .btn {
            width: 100%;
        }

        .attendance-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $monthLabel = \Carbon\Carbon::parse($month)->format('F Y');
    $totalUsers = count($data);
    $presentDays = 0;
    $partialDays = 0;
    $absentDays = 0;

    foreach ($data as $userData) {
        foreach ($userData['days'] as $day) {
            if ($day['status'] === 'P') {
                $presentDays++;
            } elseif ($day['status'] === 'SP') {
                $partialDays++;
            } else {
                $absentDays++;
            }
        }
    }
@endphp

<div class="content attendance-page pt-0">
    <div class="attendance-shell">
        <div class="attendance-toolbar">
            <div>
                <h1 class="attendance-title">Attendance</h1>
                <div class="attendance-subtitle">All users attendance for {{ $monthLabel }}</div>
            </div>

            <form method="GET" class="attendance-filter">
                <input type="month" name="month" value="{{ $month }}" class="form-control">
                <button class="btn" type="submit">
                    <i class="ph-funnel"></i> Filter
                </button>
            </form>
        </div>

        <section class="attendance-stats">
            <div class="attendance-stat">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-users-three"></i></span>
                    <span class="stat-pill">{{ $monthLabel }}</span>
                </div>
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
                <div class="stat-label">Tracked Users</div>
            </div>
            <div class="attendance-stat stat-green">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-check-circle"></i></span>
                    <span class="stat-pill">P</span>
                </div>
                <div class="stat-value">{{ number_format($presentDays) }}</div>
                <div class="stat-label">Present Days</div>
            </div>
            <div class="attendance-stat stat-amber">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-clock-countdown"></i></span>
                    <span class="stat-pill">SP</span>
                </div>
                <div class="stat-value">{{ number_format($partialDays) }}</div>
                <div class="stat-label">Single Punch</div>
            </div>
            <div class="attendance-stat stat-rose">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-warning-circle"></i></span>
                    <span class="stat-pill">A</span>
                </div>
                <div class="stat-value">{{ number_format($absentDays) }}</div>
                <div class="stat-label">Absent Days</div>
            </div>
        </section>

        <div class="attendance-panel">
            <div class="attendance-panel-head">
                <h2 class="attendance-panel-title">Monthly Register</h2>
                <div class="attendance-legend">
                    <span class="legend-pill legend-present">P Present</span>
                    <span class="legend-pill legend-partial">SP Single Punch</span>
                    <span class="legend-pill legend-absent">A Absent</span>
                </div>
            </div>

            <div class="attendance-table-wrap">
                <table class="table table-bordered attendance-table" id="jsGrid1">
                    <thead>
                        <tr>
                            <th class="attendance-user">User</th>
                            @for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay())
                                <th class="text-center">{{ $date->format('d') }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $userData)
                            @php
                                $name = $userData['user']->name ?? 'User';
                                $parts = preg_split('/\s+/', trim($name));
                                $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . substr($parts[1] ?? '', 0, 1));
                            @endphp
                            <tr>
                                <td class="attendance-user">
                                    <div class="attendance-user-name">
                                        <span class="attendance-avatar">{{ $initials }}</span>
                                        <span>{{ $name }}</span>
                                    </div>
                                </td>

                                @foreach ($userData['days'] as $day)
                                    @php
                                        $statusClass = match($day['status']) {
                                            'P' => 'status-present',
                                            'SP' => 'status-partial',
                                            default => 'status-absent',
                                        };
                                    @endphp
                                    <td class="text-center">
                                        <span class="status-chip {{ $statusClass }}" title="In: {{ $day['punch_in'] }} | Out: {{ $day['punch_out'] }}">
                                            {{ $day['status'] }}
                                        </span>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
