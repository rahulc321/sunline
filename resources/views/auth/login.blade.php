@extends('layouts.app')

@section('content')
<style>
    .bg_s, .select-all, .deselect-all, input[value="Save"]{
	background: linear-gradient(135deg, hsl(214 84% 56%), hsl(214 84% 76%)) !important;
}
body{
    background: linear-gradient(135deg, hsl(214 84% 56%), hsl(214 84% 76%)) !important;
}
 
</style>
<div class="d-flex align-items-center justify-content-center" 
     style="min-height: 100vh; background: url('{{ asset('images/login-bg.jpg') }}') no-repeat center center/cover;">
    <div class="card shadow-lg border-0" style="max-width: 400px; width: 100%; border-radius: 15px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                
                <h3 class="mt-3 text-primary">{{ env('COMPANY', 'Sunline Energy') }}</h3>
                <p class="text-muted small">{{ env('TAG_LINE', 'Powering a Brighter Tomorrow') }}</p>
            </div>

            @if(session('message'))
                <p class="alert alert-danger">{{ session('message') }}</p>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="email">{{ trans('global.login_email') }}</label>
                    <input id="email" type="email" name="email" 
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                           value="{{ old('email') }}" required autofocus>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="password">{{ trans('global.login_password') }}</label>
                    <input id="password" type="password" name="password" 
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required>
                    @if($errors->has('password'))
                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">{{ trans('global.remember_me') }}</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 bg_s">{{ trans('global.login') }}</button>

                <div class="text-center">
                    <!-- <a href="{{ route('password.request') }}" class="small">{{ trans('global.forgot_password') }}</a> | 
                    <a href="{{ route('register') }}" class="small">{{ trans('global.register') }}</a> -->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
