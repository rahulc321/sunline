@extends('layouts.admin')
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Permissions - <span class="fw-normal">Edit</span>
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
                    <form action="{{ route("admin.permissions.update", [$permission->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title">{{ trans('cruds.permission.fields.title') }}*</label>
                            <input type="text" id="title" name="title" class="form-control"
                                value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                            @if($errors->has('title'))
                            <em class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.permission.fields.title_helper') }}
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