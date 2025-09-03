@extends('layouts.admin')
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h5 class="page-title mb-0 crm_c">
                User Management
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
                    @can('user_create')
                    <a href="{{ route("admin.users.create") }}"
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
                        <table class=" table table-bordered table-striped table-hover datatable datatable-User" id="jsGrid1">
                            <thead>
                                <tr>

                                    <th>
                                        #
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    
                                    <th>
                                        {{ trans('cruds.user.fields.email') }}
                                    </th>
                                    <th>Phone</th>
                                    <th>LInk</th>

                                    <th>
                                        {{ trans('cruds.user.fields.roles') }}
                                    </th>
                                    <th>
                                       Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                <tr data-entry-id="{{ $user->id }}">

                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>
                                        {{ $user->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $user->email ?? '' }}
                                    </td>

                                    <td>
                                        {{ $user->phone ?? '' }}
                                    </td>

                                    <td>
                                        {{ $user->link ?? '' }}
                                    </td>

                                    <td>
                                        @foreach($user->roles as $key => $item)
                                        <span class="badge badge-info bg_s">{{ $item->title }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('user_show')
                                        <!-- <a class=""
                                            href="{{ route('admin.users.show', $user->id) }}">
                                            {{ trans('global.view') }}
                                        </a> -->
                                        @endcan

                                        @can('user_edit')
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-outline-info p-1">
                                            <i class="ph-pencil"></i>
                                        </a>
                                        @endcan

                                        @can('user_delete')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                                @if($user->id != 1)
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

@endsection