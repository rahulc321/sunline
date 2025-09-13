@extends('layouts.admin')
@section('content')

<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Roles
            </h4>

            <a href="#page_header"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
            <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                <div class="d-inline-flex align-items-center">
                    @can('role_create')
                    <a href="{{ route("admin.roles.create") }}"
                        class="btn btn-primary btn-icon w-32px h-32px rounded-pill bg_s">
                        <i class="ph-plus"></i>
                    </a>
                    @endcan

                </div>
            </div>
        </div>


    </div>
</div>
<div class="content pt-0">

    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">

            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            class=" table table-bordered table-striped table-hover datatable datatable-Role text-wrap"
                            id="jsGrid1">
                            <thead>
                                <tr>

                                    <th>
                                        #
                                    </th>
                                    <th>
                                        {{ trans('cruds.role.fields.title') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.role.fields.permissions') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $key => $role)
                                <tr data-entry-id="{{ $role->id }}">

                                    <td>
                                        {{ $role->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $role->title ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($role->permissions as $key => $item)
                                        <span class="badge badge-info bg_s">{{ $item->title }}</span>
                                        @endforeach
                                    </td>
                                    <td>
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

                                        <?php ?>
                                        @if(
                                        $loggedInUser->roles->contains('title', env('SUPERADMIN')) ||
                                          $role->title !=
                                        'Director')
                                       
                                        <a class="btn btn-sm btn-outline-info p-1"
                                            href="{{ route('admin.roles.edit', $role->id) }}">
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

                                            @if($role->title !== env('SUPERADMIN'))
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1">
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
    let deleteButtonTrans = '{{ trans('
    global.datatables.delete ') }}'
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
                alert('{{ trans('
                    global.datatables.zero_selected ') }}')

                return
            }

            if (confirm('{{ trans('
                    global.areYouSure ') }}')) {
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