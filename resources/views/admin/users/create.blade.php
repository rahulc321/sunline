@extends('layouts.admin')
@section('content')
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0 crm_c">
                Users - <span class="fw-normal">Create</span>
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
                    <form action="{{ route("admin.users.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf
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


                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="phone">Phone*</label>
                            <input type="text" id="phone" name="phone" class="form-control"
                                value="" required  >
                            
                        </div>

                        
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                            @if($errors->has('email'))
                            <em class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.user.fields.email_helper') }}
                            </p>
                        </div>
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

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="phone">Address</label>
                             <textarea name="address" class="form-control" placeholder="Address Here....."></textarea>
                            
                        </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="phone">Link</label>
                            <input type="text" id="link" name="link" class="form-control"
                            placeholder="abc.com"   >
                            
                        </div>

                        

                        <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                            <label for="roles">{{ trans('cruds.user.fields.roles') }}*
                                <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                                <span
                                    class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                            <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                                @foreach($roles as $id => $roles)
                                <option value="{{ $id }}"
                                    {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                    {{ $roles }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roles'))
                            <em class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.user.fields.roles_helper') }}
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