@extends('layouts.admin')
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Roles - <span class="fw-normal">Create</span>
            </h4>

            <a href="#page_header"
                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>


    </div>
</div>
<div class="content pt-0">

    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <form action="{{ route("admin.roles.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title">{{ trans('cruds.role.fields.title') }}*</label>
                            <input type="text" id="title" name="title" class="form-control"
                                value="{{ old('title', isset($role) ? $role->title : '') }}" required>
                            @if($errors->has('title'))
                            <em class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.role.fields.title_helper') }}
                            </p>
                        </div>
                        <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                            <label for="permissions">{{ trans('cruds.role.fields.permissions') }}*
                                <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                                <span
                                    class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                            <select name="permissions[]" id="permissions" class="form-control select2"
                                multiple="multiple" required>
                                @foreach($permissions as $id => $permissions)
                                <option value="{{ $id }}"
                                    {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                    {{ $permissions }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('permissions'))
                            <em class="invalid-feedback">
                                {{ $errors->first('permissions') }}
                            </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.role.fields.permissions_helper') }}
                            </p>
                        </div>
                        <div>
                            <input class="btn btn-info" type="submit" value="{{ trans('global.save') }}">
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection