@extends('layouts.admin')
@section('title', "Edit")
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                 Edit Category
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
            <div class="card form_1">

                <div class="card-body">
                    <form action="{{ route('admin.category.update', [$source->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Name -->
                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name">{{ trans('cruds.user.fields.name') }}</label>
                                    <input type="text" id="source" name="name" class="form-control"
                                        value="{{ old('name', isset($source) ? $source->name : '') }}" required>
                                    @if($errors->has('source'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('source') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.name_helper') }}
                                    </p>
                                </div>
                            </div>



                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1"
                                            {{ old('status', isset($source) ? $source->status : '') == 1 ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0"
                                            {{ old('status', isset($source) ? $source->status : '') == 0 ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>

                                </div>
                            </div>

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