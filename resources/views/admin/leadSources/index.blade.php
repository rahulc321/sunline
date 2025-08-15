@extends('layouts.admin')
@section('title', "Lead Source")
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h5 class="page-title mb-0 crm_c">
                Lead Source
            </h5>

            <a href="#page_header"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
            <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                <div class="d-inline-flex align-items-center">
                    @can('leadSource_add')
                    <a href="{{ route("admin.leadSource.create") }}"
                        class="btn btn-primary btn-icon w-32px h-32px rounded-pill bg_s">
                        <i class="ph-plus"></i>
                    </a>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content area -->
<div class="content pt-0">

    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable datatable-User">
                            <thead>
                                <tr>

                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Source
                                    </th>
                                    <th>
                                        Status
                                    </th>


                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leadSources as $key => $value)
                                <tr data-entry-id="{{ $value->id }}">

                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>
                                        {{ $value->source ?? '' }}
                                    </td>


                                    <td>
                                        @if($value->status == 1)
                                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                        @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>

                                        @can('leadSource_edit')
                                        <a href="{{ route('admin.leadSource.edit', $value->id) }}"
                                            class="btn btn-sm btn-outline-info p-1">
                                            <i class="ph-pencil"></i>
                                        </a>
                                        @endcan

                                        @can('leadSource_delete')
                                        <form action="{{ route('admin.leadSource.destroy', $value->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1">
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


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
$(function() {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('user_delete')
    let deleteButtonTrans = '{{ trans('
    global.datatables.delete ') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.users.massDestroy') }}",
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
    $('.datatable-User:not(.ajaxTable)').DataTable({
        buttons: dtButtons
    })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
</script>
@endsection