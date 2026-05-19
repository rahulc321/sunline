@extends('layouts.admin')
@section('title', 'Users')

@section('styles')
@parent
<style>
    .users-page {
        --user-ink: #111827;
        --user-muted: #667085;
        --user-border: #dbe3ef;
        --user-blue: #2563eb;
        --user-teal: #0f766e;
        --user-green: #16a34a;
        --user-gold: #f59e0b;
        font-family: inherit;
        color: var(--user-ink);
        position: relative;
        padding: 18px !important;
        border-radius: 18px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .92), rgba(238, 247, 255, .72)),
            radial-gradient(circle at 12% 4%, rgba(56, 189, 248, .20), transparent 31%),
            radial-gradient(circle at 92% 8%, rgba(129, 140, 248, .16), transparent 30%),
            #f7fbff;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .92);
    }

    .users-page .stat-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }

    .users-page .user-stat {
        position: relative;
        overflow: hidden;
        min-height: 132px;
        padding: 15px 16px 14px;
        border: 1px solid rgba(255, 255, 255, .34);
        border-radius: 13px;
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #0c6ca8 0%, #0583c2 54%, #25b7ee 100%);
        color: #ffffff;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .34),
            inset 0 -28px 42px rgba(255, 255, 255, .08),
            0 14px 24px rgba(15, 23, 42, .12);
        isolation: isolate;
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .users-page .user-stat:hover {
        transform: translateY(-2px);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .38),
            inset 0 -28px 42px rgba(255, 255, 255, .10),
            0 18px 28px rgba(15, 23, 42, .16);
    }

    .users-page .user-stat:before {
        content: "";
        position: absolute;
        inset: auto -38px -58px auto;
        width: 138px;
        height: 138px;
        border-radius: 50%;
        background:
            radial-gradient(circle at 34% 34%, rgba(255, 255, 255, .36), rgba(255, 255, 255, .05) 58%, transparent 60%),
            repeating-linear-gradient(90deg, rgba(255, 255, 255, .14) 0 1px, transparent 1px 6px);
        opacity: .55;
        z-index: -1;
    }

    .users-page .user-stat:after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, .24) 0%, rgba(255, 255, 255, 0) 34%);
        opacity: .58;
        pointer-events: none;
        z-index: -2;
    }

    .users-page .user-stat .stat-top:after {
        content: "";
        position: absolute;
        top: -10px;
        right: -8px;
        width: 72px;
        height: 28px;
        border-radius: 999px;
        background: linear-gradient(90deg, rgba(255, 255, 255, .34), rgba(255, 255, 255, 0));
        filter: blur(.2px);
        transform: rotate(-8deg);
        pointer-events: none;
    }

    .users-page .stat-indigo {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #4853bb 0%, #5b6bd8 56%, #8094ff 100%);
    }

    .users-page .stat-teal {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #0a9189 0%, #12b7ad 56%, #38dfcf 100%);
    }

    .users-page .stat-amber {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #d96822 0%, #ef8b37 56%, #ffc26d 100%);
    }

    .users-page .stat-green {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #158b4b 0%, #20b35f 56%, #58d887 100%);
    }

    .users-page .stat-rose {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #b6272e 0%, #d83a40 56%, #f06d6d 100%);
    }

    .users-page .stat-icon {
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

    .users-page .stat-top {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .users-page .stat-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .15);
        color: rgba(255, 255, 255, .92);
        font-size: 10px;
        font-weight: 850;
    }

    .users-page .stat-value {
        position: relative;
        z-index: 1;
        margin: 23px 0 3px;
        color: #ffffff;
        font-size: 28px;
        line-height: 1;
        font-weight: 850;
        letter-spacing: 0;
    }

    .users-page .stat-label {
        position: relative;
        z-index: 1;
        color: rgba(255, 255, 255, .86);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0;
    }

    .users-page .stat-pill {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 11px;
        padding: 5px 9px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .17);
        color: rgba(255, 255, 255, .94);
        font-size: 10px;
        font-weight: 850;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .16);
    }

    .users-page .users-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .76) !important;
        border-radius: 18px !important;
        background:
            linear-gradient(145deg, rgba(255, 255, 255, .94), rgba(246, 250, 255, .86));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .95),
            0 18px 38px rgba(21, 32, 51, .10) !important;
        backdrop-filter: blur(12px);
    }

    .users-page .panel-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 18px;
        border-bottom: 1px solid rgba(219, 227, 239, .78);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .82), rgba(255, 255, 255, .34)),
            linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(20, 184, 166, .10));
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .92);
    }

    .users-page .panel-title {
        margin: 0;
        color: var(--user-ink);
        font-size: 20px;
        font-weight: 850;
        letter-spacing: 0;
    }

    .users-page .panel-subtitle {
        margin-top: 3px;
        color: var(--user-muted);
        font-size: 12px;
    }

    .users-page .premium-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 40px;
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 800;
        box-shadow: none !important;
    }

    .users-page .btn-create {
        border: 0;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 36%),
            linear-gradient(135deg, var(--user-blue), var(--user-teal));
        color: #ffffff;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 10px 20px rgba(37, 99, 235, .20) !important;
    }

    .users-page .table-responsive {
        padding: 0 18px 18px;
    }

    .users-page .datatable-header {
        margin: 16px 18px 0;
        padding: 12px;
        border: 1px solid #e6ecf5;
        border-radius: 14px;
        background:
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(15, 118, 110, .08)),
            #f8fbff;
    }

    .users-page #jsGrid1_wrapper > .row:first-child {
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

    .users-page .datatable-header .form-control,
    .users-page .datatable-header .form-select,
    .users-page #jsGrid1_wrapper .form-control,
    .users-page #jsGrid1_wrapper .form-select,
    .users-page #jsGrid1_wrapper select {
        border-color: #d7dfec;
        border-radius: 10px;
        box-shadow: none;
    }

    .users-page #jsGrid1_filter {
        float: none;
        display: flex;
        justify-content: flex-end;
    }

    .users-page #jsGrid1_filter label,
    .users-page #jsGrid1_length label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: var(--user-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .users-page table.dataTable,
    .users-page .table {
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

    .users-page .table thead th {
        border: 0 !important;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .78), rgba(232, 243, 255, .92)) !important;
        color: #475467 !important;
        font-size: 11px;
        font-weight: 850;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .users-page .table tbody td {
        vertical-align: middle;
        border-color: #edf1f7 !important;
        color: #334155 !important;
        font-size: 13px;
        font-weight: 500;
        background: rgba(255, 255, 255, .62);
    }

    .users-page .table tbody tr:hover td {
        background: linear-gradient(135deg, rgba(239, 248, 255, .96), rgba(255, 255, 255, .88));
    }

    .users-page .user-identity {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 190px;
    }

    .users-page .user-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #0f766e);
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        letter-spacing: .03em;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .28),
            0 8px 18px rgba(37, 99, 235, .18);
    }

    .users-page .avatar-teal { background: linear-gradient(135deg, #0f766e, #2dd4bf); }
    .users-page .avatar-green { background: linear-gradient(135deg, #15803d, #86efac); }
    .users-page .avatar-gold { background: linear-gradient(135deg, #b45309, #fbbf24); }
    .users-page .avatar-rose { background: linear-gradient(135deg, #be123c, #fb7185); }

    .users-page .user-name {
        color: var(--user-ink);
        font-weight: 800;
        line-height: 1.2;
    }

    .users-page .user-email {
        color: var(--user-muted);
        font-size: 12px;
    }

    .users-page .role-badge {
        display: inline-flex;
        align-items: center;
        margin: 2px;
        padding: 5px 8px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, .72);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .72), rgba(255, 255, 255, .20)),
            rgba(37, 99, 235, .10);
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 750;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .86);
    }

    .users-page .role-superadmin {
        background: rgba(99, 102, 241, .14);
        color: #4338ca;
    }

    .users-page .role-admin {
        background: rgba(15, 118, 110, .13);
        color: #0f766e;
    }

    .users-page .role-sales-rep {
        background: rgba(245, 158, 11, .16);
        color: #b45309;
    }

    .users-page .role-director {
        background: rgba(190, 18, 60, .12);
        color: #be123c;
    }

    .users-page .role-user {
        background: rgba(37, 99, 235, .10);
        color: #1d4ed8;
    }

    .users-page .soft-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, .72);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .72), rgba(255, 255, 255, .20)),
            rgba(15, 118, 110, .10);
        color: #0f766e;
        font-size: 11px;
        font-weight: 800;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .86);
    }

    .users-page .action-cell {
        min-width: 82px;
        text-align: right;
        white-space: nowrap;
    }

    .users-page .icon-action {
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

    .users-page .datatable-footer {
        padding: 0 18px 16px;
        color: var(--user-muted);
        font-size: 13px;
    }

    @media (max-width: 991.98px) {
        .users-page .stat-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .users-page .panel-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 575.98px) {
        .users-page .stat-grid {
            grid-template-columns: 1fr;
        }

        .users-page .user-stat {
            min-height: 124px;
        }
    }
</style>
@endsection

@section('content')
@php
    $userCollection = collect($users);
    $totalUsers = $userCollection->count();
    $usersWithRoles = $userCollection->filter(fn($user) => $user->roles->count() > 0)->count();
    $emailUsers = $userCollection->filter(fn($user) => filled($user->email ?? null))->count();
    $zoomUsers = $userCollection->filter(fn($user) => filled($user->zoom_ext ?? null))->count();
    $connectedGmailUsers = $userCollection->filter(fn($user) => $user->is_email_connected && $user->email_provider === 'gmail')->count();
    $usersWithoutRoles = max($totalUsers - $usersWithRoles, 0);
@endphp

<div class="content users-page pt-0">
    <section class="stat-grid">
        <div class="user-stat">
            <div class="stat-top">
                <span class="stat-icon"><i class="ph-users-three"></i></span>
                <span class="stat-link">View <i class="ph-arrow-up-right"></i></span>
            </div>
            <div class="stat-value">{{ number_format($totalUsers) }}</div>
            <div class="stat-label">Total Users</div>
            <div class="stat-pill"><i class="ph-chart-line-up"></i> Directory</div>
        </div>
        <div class="user-stat stat-indigo">
            <div class="stat-top">
                <span class="stat-icon"><i class="ph-identification-card"></i></span>
                <span class="stat-link">View <i class="ph-arrow-up-right"></i></span>
            </div>
            <div class="stat-value">{{ number_format($usersWithRoles) }}</div>
            <div class="stat-label">Assigned Roles</div>
            <div class="stat-pill"><i class="ph-shield-check"></i> Access ready</div>
        </div>
        <div class="user-stat stat-teal">
            <div class="stat-top">
                <span class="stat-icon"><i class="ph-envelope-simple"></i></span>
                <span class="stat-link">View <i class="ph-arrow-up-right"></i></span>
            </div>
            <div class="stat-value">{{ number_format($emailUsers) }}</div>
            <div class="stat-label">Email Accounts</div>
            <div class="stat-pill"><i class="ph-at"></i> Contactable</div>
        </div>
        <div class="user-stat stat-amber">
            <div class="stat-top">
                <span class="stat-icon"><i class="ph-phone-call"></i></span>
                <span class="stat-link">View <i class="ph-arrow-up-right"></i></span>
            </div>
            <div class="stat-value">{{ number_format($zoomUsers) }}</div>
            <div class="stat-label">Zoom Extensions</div>
            <div class="stat-pill"><i class="ph-headset"></i> Calling setup</div>
        </div>
        <div class="user-stat stat-green">
            <div class="stat-top">
                <span class="stat-icon"><i class="ph-check"></i></span>
                <span class="stat-link">View <i class="ph-arrow-up-right"></i></span>
            </div>
            <div class="stat-value">{{ number_format($connectedGmailUsers) }}</div>
            <div class="stat-label">Gmail Connected</div>
            <div class="stat-pill"><i class="ph-plug-charging"></i> Connected</div>
        </div>
        <div class="user-stat stat-rose">
            <div class="stat-top">
                <span class="stat-icon"><i class="ph-warning-circle"></i></span>
                <span class="stat-link">View <i class="ph-arrow-up-right"></i></span>
            </div>
            <div class="stat-value">{{ number_format($usersWithoutRoles) }}</div>
            <div class="stat-label">Missing Roles</div>
            <div class="stat-pill"><i class="ph-user-focus"></i> Needs review</div>
        </div>
    </section>

    <div class="users-panel">
        <div class="panel-toolbar">
            <div>
                <h1 class="panel-title">Users</h1>
                <div class="panel-subtitle">Search, filter, and manage CRM users from one directory.</div>
            </div>
            @can('user_create')
            <a href="{{ route('admin.users.create') }}" class="btn premium-btn btn-create">
                <i class="ph-plus"></i> New User
            </a>
            @endcan
        </div>

        <div class="table-responsive">
            <table class="table table-hover datatable datatable-User" id="jsGrid1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('cruds.user.fields.name') }}</th>
                        <th>{{ trans('cruds.user.fields.email') }}</th>
                        <th>Phone</th>
                        <th>Link</th>
                        <th>{{ trans('cruds.user.fields.roles') }}</th>
                        <th>Zoom Ext.</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    @php
                        $name = $user->name ?? 'User';
                        $parts = preg_split('/\s+/', trim($name));
                        $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . substr($parts[1] ?? '', 0, 1));
                        $avatarClass = ['avatar-blue', 'avatar-teal', 'avatar-green', 'avatar-gold', 'avatar-rose'][$key % 5];
                    @endphp
                    <tr data-entry-id="{{ $user->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <div class="user-identity">
                                <span class="user-avatar {{ $avatarClass }}">{{ $initials }}</span>
                                <div>
                                    <div class="user-name">{{ $user->name ?? '' }}</div>
                                    <div class="user-email">ID: {{ $user->id ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email ?? '' }}</td>
                        <td>{{ $user->phone ?? '' }}</td>
                        <td>{{ $user->link ?? '' }}</td>
                        <td>
                            @foreach($user->roles as $key => $item)
                            @php
                                $roleClass = 'role-' . str($item->title)->lower()->replace([' ', '_'], '-');
                            @endphp
                            <span class="role-badge {{ $roleClass }}">{{ $item->title }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($user->zoom_ext)
                            <span class="soft-pill"><i class="ph-phone"></i>{{ $user->zoom_ext }}</span>
                            @endif
                        </td>
                        <td class="action-cell">
                            @can('user_show')
                            <!-- <a class=""
                                href="{{ route('admin.users.show', $user->id) }}">
                                {{ trans('global.view') }}
                            </a> -->
                            @endcan

                            @can('user_edit')
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="btn btn-outline-info icon-action" title="Edit">
                                <i class="ph-pencil"></i>
                            </a>
                            @endcan

                            @can('user_delete')
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                @foreach($user->roles as $key => $item)
                                @if(!in_array($item->title, ['Admin', env('SUPERADMIN')]))
                                <button type="submit" class="btn btn-outline-danger icon-action" title="Delete">
                                    <i class="ph-trash"></i>
                                </button>
                                @elseif(auth()->user()->roles->contains('title', 'Director'))
                                <button type="submit" class="btn btn-outline-danger icon-action" title="Delete">
                                    <i class="ph-trash"></i>
                                </button>
                                @endif
                                @endforeach
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
@endsection

@section('scripts')
@parent
@endsection
