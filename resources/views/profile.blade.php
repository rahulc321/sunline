@extends(auth('superadmin')->check() ? 'layouts.super' : 'layouts.admin')
@section('title', 'Profile')

@section('styles')
@parent
<style>
    .profile-page {
        --profile-ink: #111827;
        --profile-muted: #667085;
        --profile-blue: #2563eb;
        --profile-teal: #0f766e;
        position: relative;
        padding: 18px !important;
        border-radius: 18px;
        color: var(--profile-ink);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .94), rgba(239, 248, 255, .78)),
            radial-gradient(circle at 12% 6%, rgba(56, 189, 248, .18), transparent 32%),
            radial-gradient(circle at 92% 8%, rgba(129, 140, 248, .14), transparent 30%),
            #f7fbff;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .94);
    }

    .profile-shell {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 18px;
        background: linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(246, 250, 255, .86));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .96),
            0 18px 38px rgba(21, 32, 51, .10);
        backdrop-filter: blur(12px);
    }

    .profile-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px;
        border-bottom: 1px solid rgba(219, 227, 239, .78);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .36)),
            linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(20, 184, 166, .10));
    }

    .profile-person {
        display: flex;
        align-items: center;
        min-width: 0;
        gap: 14px;
    }

    .profile-avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        width: 52px;
        height: 52px;
        border: 1px solid rgba(255, 255, 255, .34);
        border-radius: 16px;
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .24), rgba(255, 255, 255, 0) 34%),
            linear-gradient(135deg, var(--profile-blue), var(--profile-teal));
        color: #ffffff;
        font-size: 18px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 10px 20px rgba(37, 99, 235, .18);
    }

    .profile-title {
        margin: 0;
        color: var(--profile-ink);
        font-size: 22px;
        font-weight: 850;
        letter-spacing: 0;
    }

    .profile-subtitle {
        margin-top: 3px;
        color: var(--profile-muted);
        font-size: 12px;
        font-weight: 650;
        overflow-wrap: anywhere;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        flex: 0 0 auto;
        min-height: 38px;
        padding: 8px 12px;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 999px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .78), rgba(255, 255, 255, .24)),
            rgba(37, 99, 235, .10);
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .88),
            0 10px 22px rgba(21, 32, 51, .05);
    }

    .profile-form {
        padding: 18px;
    }

    .profile-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 14px;
        color: #1f2937;
        font-size: 15px;
        font-weight: 850;
    }

    .profile-section-title i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--profile-blue), var(--profile-teal));
        color: #ffffff;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .26),
            0 8px 16px rgba(37, 99, 235, .16);
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 18px;
    }

    .profile-field.is-wide {
        grid-column: span 2;
    }

    .profile-label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 12px;
        font-weight: 850;
    }

    .profile-field .form-control {
        min-height: 44px;
        border: 1px solid #d7dfec;
        border-radius: 12px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .94), rgba(248, 251, 255, .84));
        color: #1f2937;
        font-weight: 750;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .92),
            0 8px 18px rgba(21, 32, 51, .04);
    }

    .profile-field textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .profile-field .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .profile-field .form-control[readonly] {
        color: #64748b;
        background: rgba(248, 250, 252, .88);
    }

    .invalid-feedback {
        display: block;
    }

    .profile-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid rgba(219, 227, 239, .72);
    }

    .profile-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        min-width: 170px;
        padding: 10px 16px;
        border: 0;
        border-radius: 12px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 36%),
            linear-gradient(135deg, var(--profile-blue), var(--profile-teal));
        color: #ffffff;
        font-size: 13px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 10px 20px rgba(37, 99, 235, .20);
    }

    @media (max-width: 767.98px) {
        .profile-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-field.is-wide {
            grid-column: span 1;
        }
    }

    @media (max-width: 575.98px) {
        .profile-page {
            padding: 12px !important;
        }

        .profile-actions,
        .profile-submit {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
@php
    $name = $user->name ?? 'User';
    $parts = preg_split('/\s+/', trim($name));
    $initials = strtoupper(substr($parts[0] ?? 'U', 0, 1) . substr($parts[1] ?? '', 0, 1));
    $profileRoute = auth('superadmin')->check() ? route('superadmin.updateProfile') : route('admin.updateProfile');
@endphp

<div class="content profile-page pt-0">
    <div class="profile-shell">
        <div class="profile-header">
            <div class="profile-person">
                <span class="profile-avatar">{{ $initials }}</span>
                <div>
                    <h1 class="profile-title">{{ $name }}</h1>
                    <div class="profile-subtitle">{{ $user->email ?? '' }}</div>
                </div>
            </div>
            <span class="profile-badge">
                <i class="ph-user-circle"></i> Profile Settings
            </span>
        </div>

        <form action="{{ $profileRoute }}" method="POST" enctype="multipart/form-data" class="profile-form">
            @csrf

            <h2 class="profile-section-title">
                <i class="ph-pencil-simple-line"></i>
                Account Details
            </h2>

            <div class="profile-grid">
                <div class="profile-field {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name" class="profile-label">{{ trans('cruds.user.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($user) ? $user->name : '') }}" required placeholder="Full Name">
                    @if($errors->has('name'))
                        <em class="invalid-feedback">{{ $errors->first('name') }}</em>
                    @endif
                </div>

                <div class="profile-field {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone" class="profile-label">Phone*</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        value="{{ old('phone', isset($user) ? $user->phone : '') }}" required>
                </div>

                <div class="profile-field {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="profile-label">{{ trans('cruds.user.fields.email') }}*</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', isset($user) ? $user->email : '') }}" readonly>
                    @if($errors->has('email'))
                        <em class="invalid-feedback">{{ $errors->first('email') }}</em>
                    @endif
                </div>

                <div class="profile-field {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password" class="profile-label">{{ trans('cruds.user.fields.password') }}</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @if($errors->has('password'))
                        <em class="invalid-feedback">{{ $errors->first('password') }}</em>
                    @endif
                </div>

                <div class="profile-field {{ $errors->has('zoom_ext') ? 'has-error' : '' }}">
                    <label for="zoom_ext" class="profile-label">Zoom Ext.</label>
                    <input type="text" id="zoom_ext" name="zoom_ext" class="form-control"
                        value="{{ old('zoom_ext', isset($user) ? $user->zoom_ext : '') }}">
                </div>

                <div class="profile-field {{ $errors->has('open_solar_password') ? 'has-error' : '' }}">
                    <label for="open_solar_password" class="profile-label">Open Solar Password</label>
                    <input type="text" id="open_solar_password" name="open_solar_password" class="form-control"
                        placeholder="Open Solar Password"
                        value="{{ old('open_solar_password', isset($user) ? $user->open_solar_password : '') }}">
                </div>

                <div class="profile-field is-wide {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address" class="profile-label">Address</label>
                    <textarea name="address" id="address" class="form-control" placeholder="Address Here.....">{{ old('address', isset($user) ? $user->address : '') }}</textarea>
                </div>

                <div class="profile-field d-none {{ $errors->has('link') ? 'has-error' : '' }}">
                    <label for="link" class="profile-label">Link</label>
                    <input type="text" id="link" name="link" class="form-control"
                        placeholder="abc.com" value="{{ old('link', isset($user) ? $user->link : '') }}">
                </div>
            </div>

            <div class="profile-actions">
                <button class="profile-submit" type="submit">
                    <i class="ph-check"></i> Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
