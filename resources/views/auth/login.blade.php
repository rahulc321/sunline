@extends('layouts.app')

@section('content')
<style>
body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(to top, #001d3d, #87ceeb);
    overflow: hidden;
    font-family: Arial, sans-serif;
}

/* Sky wrapper */
.sky {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 0;
}

/* Clouds */
.cloud {
    position: absolute;
    font-size: 3em;
    opacity: 0.7;
    white-space: nowrap;
}

/* Different cloud positions (static at first) */
.cloud1 {
    top: 15%;
    left: 50px;
}

.cloud2 {
    top: 25%;
    left: 150px;
    font-size: 2.5em;
    opacity: 0.6;
}

.cloud3 {
    top: 35%;
    left: 250px;
    font-size: 3.5em;
    opacity: 0.8;
}

.cloud4 {
    top: 45%;
    left: 350px;
    font-size: 2em;
    opacity: 0.5;
}

.cloud5 {
    top: 55%;
    left: 450px;
    font-size: 3em;
    opacity: 0.7;
}

.cloud6 {
    top: 65%;
    left: 550px;
    font-size: 2.2em;
    opacity: 0.5;
}

.cloud7 {
    top: 75%;
    left: 650px;
    font-size: 3.2em;
    opacity: 0.9;
}

.cloud8 {
    top: 20%;
    left: 750px;
    font-size: 2.8em;
    opacity: 0.6;
}

/* Animation */
.move {
    animation: cloudMove linear infinite;
}

.cloud1.move {
    animation-duration: 60s;
}

.cloud2.move {
    animation-duration: 75s;
}

.cloud3.move {
    animation-duration: 90s;
}

.cloud4.move {
    animation-duration: 120s;
}

.cloud5.move {
    animation-duration: 80s;
}

.cloud6.move {
    animation-duration: 100s;
}

.cloud7.move {
    animation-duration: 110s;
}

.cloud8.move {
    animation-duration: 130s;
}

@keyframes cloudMove {
    from {
        left: -200px;
    }

    to {
        left: 120%;
    }
}

/* Login card overrides */
.login-wrapper {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

.login-card {
    max-width: 400px;
    width: 100%;
    border-radius: 15px;
}
</style>

<!-- Sky background -->
<div class="sky">
    <div class="cloud cloud1">☁️</div>
    <div class="cloud cloud2">☁️</div>
    <div class="cloud cloud3">☁️</div>
    <div class="cloud cloud4">☁️</div>
    <div class="cloud cloud5">☁️</div>
    <div class="cloud cloud6">☁️</div>
    <div class="cloud cloud7">☁️</div>
    <div class="cloud cloud8">☁️</div>
</div>

<!-- Login box -->
<div class="login-wrapper">
    <div class="card shadow-lg border-0 login-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="{{ url('/') }}/logo.png" style="top: 56px;
    left: 50%;
    width: 54%;
    position: absolute;
    transform: translate(-50%, -50%);" alt="Logo">
                <h3>&nbsp;</h3>
                <p>&nbsp;</p>
                <!-- <h3 class="mt-3 text-primary">{{ env('COMPANY', 'Sunline Energy') }}</h3>
                <p class="text-muted small">{{ env('TAG_LINE', 'Powering a Brighter Tomorrow') }}</p> -->
            </div>

            @if(session('message'))
            <p class="alert alert-danger">{{ session('message') }}</p>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="email">{{ trans('global.login_email') }}</label>
                    <input id="email" type="email" name="email"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"
                        required autofocus>
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
            </form>
        </div>
    </div>
</div>

<script>
// wait 5s then start moving all clouds
setTimeout(() => {
    document.querySelectorAll('.cloud').forEach(cloud => {
        cloud.classList.add('move');
    });
}, 3000);
</script>
@endsection