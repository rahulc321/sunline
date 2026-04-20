@extends('layouts.admin')
@section('title', 'Create Permission')

@section('styles')
@parent
<style>
    .permission-form-page {
        --perm-ink: #111827;
        --perm-muted: #667085;
        --perm-border: #dbe3ef;
        --perm-blue: #2563eb;
        --perm-teal: #0f766e;
        font-family: inherit;
        color: var(--perm-ink);
    }

    .permission-form-page .form-shell {
        border: 1px solid var(--perm-border);
        border-radius: 18px;
        background:
            radial-gradient(circle at 14% 10%, rgba(37, 99, 235, .12), transparent 30%),
            linear-gradient(180deg, #f8fbff 0%, #ffffff 64%);
        box-shadow: 0 18px 42px rgba(21, 32, 51, .09);
        overflow: hidden;
    }

    .permission-form-page .form-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 22px;
        background:
            linear-gradient(135deg, rgba(15, 23, 42, .98), rgba(9, 37, 117, .92) 54%, rgba(11, 56, 182, .88)),
            linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: auto, 34px 34px;
        color: #ffffff;
    }

    .permission-form-page .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, .18);
        background: rgba(255, 255, 255, .10);
        color: rgba(255, 255, 255, .82);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .permission-form-page .hero-title {
        margin: 10px 0 4px;
        color: #ffffff;
        font-size: 28px;
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: 0;
    }

    .permission-form-page .hero-copy {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 13px;
    }

    .permission-form-page .hero-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, .16);
        background: rgba(255, 255, 255, .12);
        color: #ffffff;
        font-size: 28px;
    }

    .permission-form-page .form-card {
        max-width: 760px;
        margin: 0 auto;
        padding: 24px;
    }

    .permission-form-page .field-panel {
        border: 1px solid var(--perm-border);
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 14px 34px rgba(21, 32, 51, .07);
        padding: 20px;
    }

    .permission-form-page label {
        margin-bottom: 7px;
        color: #475467;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .permission-form-page .form-control {
        min-height: 44px;
        border-color: #d7dfec;
        border-radius: 11px;
        color: var(--perm-ink);
        font-size: 14px;
        box-shadow: none;
    }

    .permission-form-page .form-control:focus {
        border-color: rgba(37, 99, 235, .58);
        box-shadow: 0 0 0 .18rem rgba(37, 99, 235, .12);
    }

    .permission-form-page .helper-block {
        margin: 8px 0 0;
        color: var(--perm-muted);
        font-size: 12px;
    }

    .permission-form-page .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 18px;
    }

    .permission-form-page .premium-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 40px;
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 700;
        box-shadow: none !important;
    }

    .permission-form-page .btn-save {
        border: 0;
        background: linear-gradient(135deg, var(--perm-blue), var(--perm-teal));
        color: #ffffff;
    }

    @media (max-width: 767.98px) {
        .permission-form-page .form-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .permission-form-page .form-card {
            padding: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="content permission-form-page pt-0">
    <div class="form-shell">
        <section class="form-hero">
            <div>
                <span class="hero-eyebrow"><i class="ph-plus-circle"></i> User Management</span>
                <h1 class="hero-title">Create Permission</h1>
                <p class="hero-copy">Add a new access rule that can be assigned to roles.</p>
            </div>
            <span class="hero-icon"><i class="ph-key"></i></span>
        </section>

        <div class="form-card">
            <div class="field-panel">
                <form action="{{ route('admin.permissions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title">{{ trans('cruds.permission.fields.title') }}*</label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                        @if($errors->has('title'))
                        <em class="invalid-feedback d-block">
                            {{ $errors->first('title') }}
                        </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.permission.fields.title_helper') }}
                        </p>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-light border premium-btn">
                            <i class="ph-arrow-left"></i> Back
                        </a>
                        <button class="btn premium-btn btn-save" type="submit">
                            <i class="ph-check-circle"></i> {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
