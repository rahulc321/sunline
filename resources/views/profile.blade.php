@extends('layouts.admin')
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Profile
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
                    <form action="{{ route("admin.updateProfile") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- name -->
                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', isset($user) ? $user->name : '') }}" required placeholder="Full Name">
                                    @if($errors->has('name'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.name_helper') }}
                                    </p>
                                </div>
                            </div>

                            <!-- phone -->
                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone">Phone*</label>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone', isset($user) ? $user->phone : '') }}" required>
                                </div>
                            </div>

                            <!-- email -->
                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email', isset($user) ? $user->email : '') }}" readonly>
                                    @if($errors->has('email'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.email_helper') }}
                                    </p>
                                </div>
                            </div>

                            <!-- password -->
                            <div class="col-sm-6 d-none">
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    @if($errors->has('password'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.password_helper') }}
                                    </p>
                                </div>
                            </div>

                            <!-- address -->
                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" placeholder="Address Here.....">{{ old('address', isset($user) ? $user->address : '') }}</textarea>
                                </div>
                            </div>

                            <!-- link -->
                            <div class="col-sm-6 d-none">
                                <div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
                                    <label for="link">Link</label>
                                    <input type="text" id="link" name="link" class="form-control"
                                        placeholder="abc.com" value="{{ old('link', isset($user) ? $user->link : '') }}">
                                </div>
                            </div>

                             
                        </div> <!-- row -->

                        <div class="mt-3">
                            <input class="btn btn-info bg_s" type="submit" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
