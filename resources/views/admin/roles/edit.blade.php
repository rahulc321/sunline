@extends('layouts.admin')
@section('title', 'Edit Role')

@section('styles')
@parent
<style>
    .role-form-page {
        --role-ink: #111827;
        --role-muted: #667085;
        --role-border: #dbe3ef;
        --role-blue: #2563eb;
        --role-teal: #0f766e;
        font-family: inherit;
        color: var(--role-ink);
    }

    .role-form-page .form-shell {
        overflow: hidden;
        border: 1px solid var(--role-border);
        border-radius: 18px;
        background:
            radial-gradient(circle at 14% 10%, rgba(37, 99, 235, .12), transparent 30%),
            linear-gradient(180deg, #f8fbff 0%, #ffffff 64%);
        box-shadow: 0 18px 42px rgba(21, 32, 51, .09);
    }

    .role-form-page .form-hero {
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

    .role-form-page .hero-eyebrow {
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

    .role-form-page .hero-title {
        margin: 10px 0 4px;
        color: #ffffff;
        font-size: 28px;
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: 0;
    }

    .role-form-page .hero-copy {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 13px;
    }

    .role-form-page .hero-icon {
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

    .role-form-page .form-card {
        max-width: 920px;
        margin: 0 auto;
        padding: 24px;
    }

    .role-form-page .field-panel {
        border: 1px solid var(--role-border);
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 14px 34px rgba(21, 32, 51, .07);
        padding: 20px;
    }

    .role-form-page label {
        margin-bottom: 7px;
        color: #475467;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .role-form-page .form-control,
    .role-form-page .select2-container--default .select2-selection--multiple {
        min-height: 44px;
        border-color: #d7dfec;
        border-radius: 11px;
        color: var(--role-ink);
        font-size: 14px;
        box-shadow: none;
    }

    .role-form-page .form-control:focus {
        border-color: rgba(37, 99, 235, .58);
        box-shadow: 0 0 0 .18rem rgba(37, 99, 235, .12);
    }

    .role-form-page .select-actions {
        display: inline-flex;
        gap: 6px;
        margin-left: 8px;
        vertical-align: middle;
    }

    .role-form-page .select-actions .btn {
        min-height: 26px;
        height: 26px;
        padding: 3px 8px;
        border: 0;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }

    .role-form-page .helper-block {
        margin: 8px 0 0;
        color: var(--role-muted);
        font-size: 12px;
    }

    .role-form-page .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 18px;
    }

    .role-form-page .premium-btn {
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

    .role-form-page .btn-save {
        border: 0;
        background: linear-gradient(135deg, var(--role-blue), var(--role-teal));
        color: #ffffff;
    }

    @media (max-width: 767.98px) {
        .role-form-page .form-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .role-form-page .form-card {
            padding: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="content role-form-page pt-0">
    <div class="form-shell">
        <section class="form-hero">
            <div>
                <span class="hero-eyebrow"><i class="ph-pencil"></i> User Management</span>
                <h1 class="hero-title">Edit Role</h1>
                <p class="hero-copy">Update the role name and permission set assigned to this access group.</p>
            </div>
            <span class="hero-icon"><i class="ph-users-three"></i></span>
        </section>

        <div class="form-card">
            <div class="field-panel">
                <form action="{{ route('admin.roles.update', [$role->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title">{{ trans('cruds.role.fields.title') }}*</label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ old('title', isset($role) ? $role->title : '') }}" required>
                        @if($errors->has('title'))
                        <em class="invalid-feedback d-block">
                            {{ $errors->first('title') }}
                        </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.role.fields.title_helper') }}
                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                        <label for="permissions">
                            {{ trans('cruds.role.fields.permissions') }}*
                            <span class="select-actions">
                                <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span>
                            </span>
                        </label>
                        <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple" required>
                            @foreach($permissions as $id => $permissions)
                            <option value="{{ $id }}"
                                {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                {{ $permissions }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('permissions'))
                        <em class="invalid-feedback d-block">
                            {{ $errors->first('permissions') }}
                        </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.role.fields.permissions_helper') }}
                        </p>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-light border premium-btn">
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
