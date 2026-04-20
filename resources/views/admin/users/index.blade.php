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
        padding-top: 14px !important;
    }

    .users-page .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 14px;
    }

    .users-page .user-stat {
        position: relative;
        overflow: hidden;
        min-height: 108px;
        padding: 18px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 16px;
        background:
            linear-gradient(145deg, rgba(15, 23, 42, .98) 0%, rgba(9, 37, 117, .92) 55%, rgba(11, 56, 182, .88) 100%),
            linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: auto, 34px 34px;
        color: #ffffff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .14);
    }

    .users-page .user-stat:after {
        content: "";
        position: absolute;
        inset: -42px -34px auto auto;
        width: 112px;
        height: 112px;
        border-radius: 36px;
        background: rgba(255, 255, 255, .10);
        transform: rotate(18deg);
    }

    .users-page .user-stat.stat-teal {
        background: linear-gradient(145deg, #0f172a 0%, #0f766e 58%, #14b8a6 100%);
    }

    .users-page .user-stat.stat-green {
        background: linear-gradient(145deg, #0f172a 0%, #166534 58%, #22c55e 100%);
    }

    .users-page .user-stat.stat-gold {
        background: linear-gradient(145deg, #0f172a 0%, #92400e 58%, #f59e0b 100%);
    }

    .users-page .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: rgba(255, 255, 255, .14);
        color: #ffffff;
        font-size: 18px;
    }

    .users-page .stat-value {
        position: relative;
        z-index: 1;
        margin: 12px 0 2px;
        color: #ffffff;
        font-size: 28px;
        line-height: 1;
        font-weight: 850;
    }

    .users-page .stat-label {
        position: relative;
        z-index: 1;
        color: rgba(255, 255, 255, .72);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .users-page .users-panel {
        overflow: hidden;
        border: 1px solid var(--user-border) !important;
        border-radius: 16px !important;
        background: #ffffff;
        box-shadow: 0 14px 34px rgba(21, 32, 51, .08) !important;
    }

    .users-page .panel-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 18px;
        border-bottom: 1px solid #edf1f7;
        background:
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(15, 118, 110, .08)),
            #fbfdff;
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
        background: linear-gradient(135deg, var(--user-blue), var(--user-teal));
        color: #ffffff;
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
        border: 1px solid #e6ecf5;
        border-radius: 14px;
        background:
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(15, 118, 110, .08)),
            #f8fbff;
        align-items: center;
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
        border: 1px solid #e6ecf5;
        border-radius: 14px;
        overflow: hidden;
    }

    .users-page .table thead th {
        border: 0 !important;
        background: linear-gradient(135deg, #f3f7fc, #eef6ff) !important;
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
        box-shadow: 0 8px 18px rgba(37, 99, 235, .18);
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
        background: rgba(37, 99, 235, .10);
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 750;
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
        background: rgba(15, 118, 110, .10);
        color: #0f766e;
        font-size: 11px;
        font-weight: 800;
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
    }

    .users-page .datatable-footer {
        padding: 0 18px 16px;
        color: var(--user-muted);
        font-size: 13px;
    }

    @media (max-width: 991.98px) {
        .users-page .stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
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
@endphp

<div class="content users-page pt-0">
    <section class="stat-grid">
        <div class="user-stat">
            <span class="stat-icon"><i class="ph-users-three"></i></span>
            <div class="stat-value">{{ number_format($totalUsers) }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="user-stat stat-teal">
            <span class="stat-icon"><i class="ph-identification-card"></i></span>
            <div class="stat-value">{{ number_format($usersWithRoles) }}</div>
            <div class="stat-label">Assigned Roles</div>
        </div>
        <div class="user-stat stat-green">
            <span class="stat-icon"><i class="ph-envelope-simple"></i></span>
            <div class="stat-value">{{ number_format($emailUsers) }}</div>
            <div class="stat-label">Email Accounts</div>
        </div>
        <div class="user-stat stat-gold">
            <span class="stat-icon"><i class="ph-phone-call"></i></span>
            <div class="stat-value">{{ number_format($zoomUsers) }}</div>
            <div class="stat-label">Zoom Extensions</div>
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
