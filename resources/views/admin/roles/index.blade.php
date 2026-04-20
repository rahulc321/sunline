@extends('layouts.admin')
@section('title', 'Roles')

@section('styles')
@parent
<style>
    .role-page {
        --role-ink: #111827;
        --role-muted: #667085;
        --role-border: #dbe3ef;
        --role-blue: #2563eb;
        --role-teal: #0f766e;
        --role-red: #dc2626;
        font-family: inherit;
        color: var(--role-ink);
    }

    .role-page .role-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border: 1px solid var(--role-border);
        border-radius: 16px;
        background:
            linear-gradient(135deg, rgba(15, 23, 42, .98), rgba(9, 37, 117, .92) 54%, rgba(11, 56, 182, .88)),
            linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: auto, 34px 34px;
        box-shadow: 0 18px 42px rgba(15, 23, 42, .16);
        color: #ffffff;
    }

    .role-page .hero-eyebrow {
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

    .role-page .hero-title {
        margin: 10px 0 4px;
        color: #ffffff;
        font-size: 28px;
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: 0;
    }

    .role-page .hero-copy {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 13px;
    }

    .role-page .hero-stat {
        min-width: 132px;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, .16);
        background: rgba(255, 255, 255, .10);
        text-align: right;
    }

    .role-page .hero-stat span {
        display: block;
        color: rgba(255, 255, 255, .66);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .role-page .hero-stat strong {
        display: block;
        margin-top: 4px;
        color: #ffffff;
        font-size: 26px;
        line-height: 1;
    }

    .role-page .role-panel {
        overflow: hidden;
        border: 1px solid var(--role-border) !important;
        border-radius: 16px !important;
        background: #ffffff;
        box-shadow: 0 14px 34px rgba(21, 32, 51, .08) !important;
    }

    .role-page .panel-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 18px;
        border-bottom: 1px solid #edf1f7;
        background: #fbfdff;
    }

    .role-page .panel-title {
        margin: 0;
        color: var(--role-ink);
        font-size: 16px;
        font-weight: 800;
    }

    .role-page .panel-subtitle {
        margin-top: 2px;
        color: var(--role-muted);
        font-size: 12px;
    }

    .role-page .premium-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 38px;
        padding: 8px 13px;
        border-radius: 10px;
        font-weight: 700;
        box-shadow: none !important;
    }

    .role-page .btn-create {
        border: 0;
        background: linear-gradient(135deg, var(--role-blue), var(--role-teal));
        color: #ffffff;
    }

    .role-page .table-responsive {
        padding: 0 18px 18px;
    }

    .role-page table.dataTable,
    .role-page .table {
        margin-top: 16px !important;
        border-collapse: separate !important;
        border-spacing: 0;
        border: 1px solid #e6ecf5;
        border-radius: 14px;
        overflow: hidden;
    }

    .role-page .table thead th {
        border: 0 !important;
        background: #f3f7fc !important;
        color: #475467 !important;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .role-page .table tbody td {
        vertical-align: middle;
        border-color: #edf1f7 !important;
        color: #334155 !important;
        font-size: 13px;
        font-weight: 500;
    }

    .role-page .role-name {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: var(--role-ink);
        font-weight: 800;
    }

    .role-page .role-name i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 9px;
        background: rgba(37, 99, 235, .10);
        color: var(--role-blue);
    }

    .role-page .permission-badge {
        display: inline-flex;
        align-items: center;
        margin: 2px;
        padding: 5px 8px;
        border-radius: 999px;
        background: rgba(37, 99, 235, .10) !important;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 700;
    }

    .role-page .action-cell {
        width: 110px;
        text-align: right;
        white-space: nowrap;
    }

    .role-page .icon-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 9px;
    }

    .role-page .dataTables_wrapper {
        color: var(--role-muted);
        font-size: 13px;
    }

    @media (max-width: 767.98px) {
        .role-page .role-hero,
        .role-page .panel-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .role-page .hero-stat {
            width: 100%;
            text-align: left;
        }
    }
</style>
@endsection

@section('content')
<div class="content role-page pt-0">
    <section class="role-hero mb-3">
        <div>
            <span class="hero-eyebrow"><i class="ph-users-three"></i> User Management</span>
            <h1 class="hero-title">Roles</h1>
            <p class="hero-copy">Manage role names and the permission sets assigned to each role.</p>
        </div>
        <div class="hero-stat">
            <span>Total Roles</span>
            <strong>{{ number_format($roles->count()) }}</strong>
        </div>
    </section>

    <div class="role-panel">
        <div class="panel-toolbar">
            <div>
                <h2 class="panel-title">Role Directory</h2>
                <div class="panel-subtitle">Review access groups and their mapped permissions.</div>
            </div>
            @can('role_create')
            <a href="{{ route('admin.roles.create') }}" class="btn premium-btn btn-create">
                <i class="ph-plus"></i> New Role
            </a>
            @endcan
        </div>

        <div class="table-responsive">
            <table class="table table-hover datatable datatable-Role text-wrap" id="rolesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('cruds.role.fields.title') }}</th>
                        <th>{{ trans('cruds.role.fields.permissions') }}</th>
                        <th class="text-end">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                    <tr data-entry-id="{{ $role->id }}">
                        <td>{{ $role->id ?? '' }}</td>
                        <td>
                            <span class="role-name">
                                <i class="ph-identification-card"></i>
                                {{ $role->title ?? '' }}
                            </span>
                        </td>
                        <td>
                            @foreach($role->permissions as $key => $item)
                            <span class="permission-badge">{{ $item->title }}</span>
                            @endforeach
                        </td>
                        <td class="action-cell">
                            @can('role_show')
                            <!-- <a class="btn btn-xs btn-primary"
                                href="{{ route('admin.roles.show', $role->id) }}">
                                {{ trans('global.view') }}
                            </a> -->
                            @endcan

                            @can('role_edit')
                            @php
                            $loggedInUser = auth()->user();
                            @endphp

                            @if(
                            $loggedInUser->roles->contains('title', env('SUPERADMIN')) ||
                              $role->title !=
                            'Director')
                            <a class="btn btn-outline-info icon-action"
                                href="{{ route('admin.roles.edit', $role->id) }}" title="Edit">
                                <i class="ph-pencil"></i>
                            </a>
                            @endif
                            @endcan

                            @can('role_delete')
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                @if($role->title !== env('SUPERADMIN') && $role->users_count == 0)
                                <button type="submit" class="btn btn-outline-danger icon-action" title="Delete">
                                    <i class="ph-trash"></i>
                                </button>
                                @endif
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
<script>
$(function() {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('role_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.roles.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
            var ids = $.map(dt.rows({
                selected: true
            }).nodes(), function(entry) {
                return $(entry).data('entry-id')
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')

                return
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                        headers: {
                            'x-csrf-token': _token
                        },
                        method: 'POST',
                        url: config.url,
                        data: {
                            ids: ids,
                            _method: 'DELETE'
                        }
                    })
                    .done(function() {
                        location.reload()
                    })
            }
        }
    }
    dtButtons.push(deleteButton)
    @endcan

    $.extend(true, $.fn.dataTable.defaults, {
        order: [
            [1, 'desc']
        ],
        pageLength: 100,
    });
    $('.datatable-Role:not(.ajaxTable)').DataTable({
        buttons: dtButtons
    })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
</script>
@endsection
