@extends('layouts.app')

@section('content')
<style>
:root {
    --admin-ink: #102033;
    --admin-muted: #65758b;
    --admin-blue: #1769aa;
    --admin-green: #36b37e;
    --admin-line: rgba(16, 32, 51, 0.12);
}

html,
body {
    min-height: 100%;
}

body {
    margin: 0;
    min-height: 100vh;
    overflow-x: hidden;
    color: var(--admin-ink);
    font-family: Arial, sans-serif;
    background:
        linear-gradient(135deg, rgba(23, 105, 170, 0.9), rgba(54, 179, 126, 0.72)),
        url("{{ asset('vendor/images/demo/cover3.jpg') }}") center/cover no-repeat;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background:
        linear-gradient(90deg, rgba(6, 24, 44, 0.88) 0%, rgba(6, 24, 44, 0.58) 46%, rgba(255, 255, 255, 0.08) 100%),
        radial-gradient(circle at 80% 14%, rgba(255, 255, 255, 0.3), transparent 28%);
    pointer-events: none;
}

.app,
.container {
    min-height: 100vh;
}

.container {
    max-width: 1180px;
}

.super-login {
    position: relative;
    z-index: 1;
    min-height: 100vh;
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(360px, 440px);
    gap: 48px;
    align-items: center;
    padding: 40px 0;
}

.brand-panel {
    color: #fff;
    max-width: 620px;
}

.brand-logo {
    width: 210px;
    max-width: 62vw;
    margin-bottom: 42px;
    filter: drop-shadow(0 14px 24px rgba(0, 0, 0, 0.22));
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 8px 12px;
    margin-bottom: 22px;
    border: 1px solid rgba(255, 255, 255, 0.28);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.11);
    color: rgba(255, 255, 255, 0.88);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.eyebrow i {
    color: #ffd166;
}

.brand-panel h1 {
    margin: 0 0 18px;
    color: #fff;
    font-size: 48px;
    line-height: 1.06;
    font-weight: 800;
    letter-spacing: 0;
}

.brand-panel p {
    max-width: 500px;
    margin: 0;
    color: rgba(255, 255, 255, 0.82);
    font-size: 17px;
    line-height: 1.7;
}

.quick-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    max-width: 560px;
    margin-top: 42px;
}

.quick-stat {
    padding: 17px;
    border: 1px solid rgba(255, 255, 255, 0.22);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
}

.quick-stat strong {
    display: block;
    color: #fff;
    font-size: 19px;
    line-height: 1.1;
}

.quick-stat span {
    display: block;
    margin-top: 7px;
    color: rgba(255, 255, 255, 0.72);
    font-size: 12px;
}

.login-card {
    width: 100%;
    border: 0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 28px 70px rgba(7, 24, 42, 0.34);
}

.login-card .card-body {
    padding: 34px;
    background: rgba(255, 255, 255, 0.98);
}

.login-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 26px;
}

.login-icon {
    display: inline-flex;
    width: 48px;
    height: 48px;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #fff;
    background: linear-gradient(135deg, var(--admin-blue), var(--admin-green));
    box-shadow: 0 12px 24px rgba(23, 105, 170, 0.22);
}

.login-header h2 {
    margin: 0;
    color: var(--admin-ink);
    font-size: 24px;
    font-weight: 800;
}

.login-header p {
    margin: 3px 0 0;
    color: var(--admin-muted);
    font-size: 13px;
}

.alert {
    border-radius: 8px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label,
.form-check-label {
    color: #34455a;
    font-size: 13px;
    font-weight: 700;
}

.input-wrap {
    position: relative;
}

.input-wrap i {
    position: absolute;
    top: 50%;
    left: 15px;
    color: #8ca0b3;
    transform: translateY(-50%);
}

.form-control {
    height: 48px;
    padding-left: 44px;
    border: 1px solid var(--admin-line);
    border-radius: 8px;
    color: var(--admin-ink);
    background: #f8fbfd;
    transition: border-color 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
}

.form-control:focus {
    border-color: rgba(23, 105, 170, 0.58);
    background: #fff;
    box-shadow: 0 0 0 0.2rem rgba(23, 105, 170, 0.14);
}

.form-check {
    display: flex;
    align-items: center;
    gap: 9px;
    padding-left: 0;
}

.form-check-input {
    position: static;
    margin: 0;
}

.login-button {
    height: 50px;
    margin-top: 8px;
    border: 0;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--admin-blue), var(--admin-green));
    font-weight: 800;
    box-shadow: 0 16px 28px rgba(23, 105, 170, 0.22);
}

.login-button:hover,
.login-button:focus {
    background: linear-gradient(135deg, #125b95, #2e9e70);
    box-shadow: 0 18px 32px rgba(23, 105, 170, 0.27);
}

.login-footer {
    margin: 24px -34px -34px;
    padding: 16px 34px;
    border-top: 1px solid var(--admin-line);
    background: #f5f8fb;
    color: var(--admin-muted);
    font-size: 12px;
}

@media (max-width: 991.98px) {
    body {
        background-position: center;
    }

    .container {
        max-width: 720px;
    }

    .super-login {
        grid-template-columns: 1fr;
        gap: 28px;
        padding: 30px 0;
    }

    .brand-panel {
        text-align: center;
        margin: 0 auto;
    }

    .brand-logo {
        margin-bottom: 24px;
    }

    .brand-panel h1 {
        font-size: 36px;
    }

    .brand-panel p {
        margin: 0 auto;
    }

    .quick-stats {
        display: none;
    }

    .login-card {
        max-width: 440px;
        margin: 0 auto;
    }
}

@media (max-width: 575.98px) {
    body {
        overflow-y: auto;
    }

    .super-login {
        padding: 22px 0;
    }

    .brand-logo {
        width: 170px;
    }

    .brand-panel h1 {
        font-size: 30px;
    }

    .brand-panel p {
        font-size: 15px;
        line-height: 1.55;
    }

    .login-card .card-body {
        padding: 24px;
    }

    .login-footer {
        margin: 22px -24px -24px;
        padding: 14px 24px;
    }
}
</style>

<div class="super-login">
    <section class="brand-panel" aria-label="Sunline administrator portal">
        <img src="{{ asset('logo.png') }}" class="brand-logo" alt="Sunline">
        <div class="eyebrow">
            <i class="fas fa-shield-alt"></i>
            Superadmin Portal
        </div>
        <h1>Command center for Sunline operations.</h1>
        <p>Review sales activity, manage approvals, and keep teams aligned from one secure workspace.</p>

        <div class="quick-stats" aria-hidden="true">
            <div class="quick-stat">
                <strong>Leads</strong>
                <span>Pipeline oversight</span>
            </div>
            <div class="quick-stat">
                <strong>Rebates</strong>
                <span>Process tracking</span>
            </div>
            <div class="quick-stat">
                <strong>Teams</strong>
                <span>Role-based access</span>
            </div>
        </div>
    </section>

    <div class="card login-card">
        <div class="card-body">
            <div class="login-header">
                <span class="login-icon" aria-hidden="true">
                    <i class="fas fa-user-lock"></i>
                </span>
                <div>
                    <h2>Administrator Login</h2>
                    <p>Use your superadmin credentials to continue.</p>
                </div>
            </div>

            @if(session('message'))
                <p class="alert alert-danger">{{ session('message') }}</p>
            @endif

            <form method="POST" action="{{ route('superadmin.loginSubmit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ trans('global.login_email') }}</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <input id="email" type="email" name="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            value="{{ old('email') }}" required autofocus autocomplete="email">
                    </div>
                    @if($errors->has('email'))
                        <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('global.login_password') }}</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input id="password" type="password" name="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            required autocomplete="current-password">
                    </div>
                    @if($errors->has('password'))
                        <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">{{ trans('global.remember_me') }}</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block login-button">{{ trans('global.login') }}</button>
            </form>

            <div class="login-footer">
                Protected access for authorized Sunline administrators.
            </div>
        </div>
    </div>
</div>
@endsection
