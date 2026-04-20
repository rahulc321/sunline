@extends('layouts.admin')
@section('title', 'Permissions')

@section('styles')
@parent
<style>
    .permission-page {
        --perm-ink: #111827;
        --perm-muted: #667085;
        --perm-border: #dbe3ef;
        --perm-blue: #2563eb;
        --perm-teal: #0f766e;
        --perm-red: #dc2626;
        font-family: inherit;
        color: var(--perm-ink);
    }

    .permission-page .permission-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border: 1px solid var(--perm-border);
        border-radius: 16px;
        background:
            linear-gradient(135deg, rgba(15, 23, 42, .98), rgba(9, 37, 117, .92) 54%, rgba(11, 56, 182, .88)),
            linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: auto, 34px 34px;
        box-shadow: 0 18px 42px rgba(15, 23, 42, .16);
        color: #ffffff;
    }

    .permission-page .hero-eyebrow {
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

    .permission-page .hero-title {
        margin: 10px 0 4px;
        color: #ffffff;
        font-size: 28px;
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: 0;
    }

    .permission-page .hero-copy {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 13px;
    }

    .permission-page .hero-stat {
        min-width: 132px;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, .16);
        background: rgba(255, 255, 255, .10);
        text-align: right;
    }

    .permission-page .hero-stat span {
        display: block;
        color: rgba(255, 255, 255, .66);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .permission-page .hero-stat strong {
        display: block;
        margin-top: 4px;
        color: #ffffff;
        font-size: 26px;
        line-height: 1;
    }

    .permission-page .permission-panel {
        overflow: hidden;
        border: 1px solid var(--perm-border) !important;
        border-radius: 16px !important;
        background: #ffffff;
        box-shadow: 0 14px 34px rgba(21, 32, 51, .08) !important;
    }

    .permission-page .panel-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 18px;
        border-bottom: 1px solid #edf1f7;
        background: #fbfdff;
    }

    .permission-page .panel-title {
        margin: 0;
        color: var(--perm-ink);
        font-size: 16px;
        font-weight: 800;
    }

    .permission-page .panel-subtitle {
        margin-top: 2px;
        color: var(--perm-muted);
        font-size: 12px;
    }

    .permission-page .premium-btn {
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

    .permission-page .btn-create {
        border: 0;
        background: linear-gradient(135deg, var(--perm-blue), var(--perm-teal));
        color: #ffffff;
    }

    .permission-page .table-responsive {
        padding: 0 18px 18px;
    }

    .permission-page table.dataTable,
    .permission-page .table {
        margin-top: 16px !important;
        border-collapse: separate !important;
        border-spacing: 0;
        border: 1px solid #e6ecf5;
        border-radius: 14px;
        overflow: hidden;
    }

    .permission-page .table thead th {
        border: 0 !important;
        background: #f3f7fc !important;
        color: #475467 !important;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .permission-page .table tbody td {
        vertical-align: middle;
        border-color: #edf1f7 !important;
        color: #334155 !important;
        font-size: 13px;
        font-weight: 500;
    }

    .permission-page .permission-name {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: var(--perm-ink);
        font-weight: 700;
    }

    .permission-page .permission-name i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 9px;
        background: rgba(37, 99, 235, .10);
        color: var(--perm-blue);
    }

    .permission-page .action-cell {
        width: 110px;
        text-align: right;
        white-space: nowrap;
    }

    .permission-page .icon-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 9px;
    }

    .permission-page .dataTables_wrapper {
        color: var(--perm-muted);
        font-size: 13px;
    }

    @media (max-width: 767.98px) {
        .permission-page .permission-hero,
        .permission-page .panel-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .permission-page .hero-stat {
            width: 100%;
            text-align: left;
        }
    }
</style>
@endsection

@section('content')
<div class="content permission-page pt-0">
    <section class="permission-hero mb-3">
        <div>
            <span class="hero-eyebrow"><i class="ph-shield-check"></i> User Management</span>
            <h1 class="hero-title">Permissions</h1>
            <p class="hero-copy">Review and maintain access rules used across the CRM.</p>
        </div>
        <div class="hero-stat">
            <span>Total Permissions</span>
            <strong>{{ number_format($permissions->count()) }}</strong>
        </div>
    </section>

    <div class="permission-panel">
        <div class="panel-toolbar">
            <div>
                <h2 class="panel-title">Permission Directory</h2>
                <div class="panel-subtitle">Manage permission names and access records.</div>
            </div>
            @can('permission_create')
            <a href="{{ route('admin.permissions.create') }}" class="btn premium-btn btn-create">
                <i class="ph-plus"></i> New Permission
            </a>
            @endcan
        </div>

        <div class="table-responsive">
            <table class="table table-hover datatable datatable-Permission" id="permissionsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('cruds.permission.fields.title') }}</th>
                        <th class="text-end">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                    <tr data-entry-id="{{ $permission->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <span class="permission-name">
                                <i class="ph-key"></i>
                                {{ $permission->title ?? '' }}
                            </span>
                        </td>
                        <td class="action-cell">
                            @can('permission_edit')
                            <a class="btn btn-outline-info icon-action"
                                href="{{ route('admin.permissions.edit', $permission->id) }}" title="Edit">
                                <i class="ph-pencil"></i>
                            </a>
                            @endcan

                            @can('permission_delete')
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST"
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
@endsection

@section('scripts')
@parent
<script>
$(function() {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('permission_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.permissions.massDestroy') }}",
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
    $('.datatable-Permission:not(.ajaxTable)').DataTable({
        buttons: dtButtons
    })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
</script>
@endsection
