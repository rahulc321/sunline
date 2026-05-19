@extends('layouts.admin')
@section('title', 'Bulk Email')

@section('styles')
@parent
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .bulk-email-page {
        --bulk-ink: #111827;
        --bulk-muted: #667085;
        --bulk-blue: #2563eb;
        --bulk-teal: #0f766e;
        position: relative;
        padding: 18px !important;
        border-radius: 18px;
        color: var(--bulk-ink);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .94), rgba(239, 248, 255, .78)),
            radial-gradient(circle at 10% 5%, rgba(56, 189, 248, .20), transparent 32%),
            radial-gradient(circle at 92% 8%, rgba(129, 140, 248, .16), transparent 30%),
            #f7fbff;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .94);
    }

    .bulk-shell {
        display: grid;
        gap: 16px;
    }

    .bulk-toolbar,
    .bulk-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 18px;
        background: linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(246, 250, 255, .86));
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .96),
            0 18px 38px rgba(21, 32, 51, .10);
        backdrop-filter: blur(12px);
    }

    .bulk-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .36)),
            linear-gradient(135deg, rgba(37, 99, 235, .10), rgba(20, 184, 166, .10));
    }

    .bulk-title {
        margin: 0;
        color: var(--bulk-ink);
        font-size: 22px;
        font-weight: 850;
        letter-spacing: 0;
    }

    .bulk-subtitle {
        margin-top: 3px;
        color: var(--bulk-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .bulk-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
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

    .bulk-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .bulk-stat {
        position: relative;
        overflow: hidden;
        min-height: 122px;
        padding: 15px 16px;
        border: 1px solid rgba(255, 255, 255, .34);
        border-radius: 13px;
        color: #ffffff;
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #0c6ca8 0%, #0583c2 54%, #25b7ee 100%);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .34),
            inset 0 -28px 42px rgba(255, 255, 255, .08),
            0 14px 24px rgba(15, 23, 42, .12);
        isolation: isolate;
    }

    .bulk-stat:before {
        content: "";
        position: absolute;
        right: -38px;
        bottom: -58px;
        width: 138px;
        height: 138px;
        border-radius: 50%;
        background:
            radial-gradient(circle at 34% 34%, rgba(255, 255, 255, .36), rgba(255, 255, 255, .05) 58%, transparent 60%),
            repeating-linear-gradient(90deg, rgba(255, 255, 255, .14) 0 1px, transparent 1px 6px);
        opacity: .55;
        z-index: -1;
    }

    .bulk-stat.stat-green {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #158b4b 0%, #20b35f 56%, #58d887 100%);
    }

    .bulk-stat.stat-indigo {
        background:
            linear-gradient(155deg, rgba(255, 255, 255, .22) 0%, rgba(255, 255, 255, .05) 31%, rgba(255, 255, 255, 0) 32%),
            linear-gradient(145deg, #4853bb 0%, #5b6bd8 56%, #8094ff 100%);
    }

    .stat-top {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 11px;
        background: rgba(255, 255, 255, .18);
        color: #ffffff;
        font-size: 18px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 8px 14px rgba(15, 23, 42, .10);
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .16);
        color: rgba(255, 255, 255, .94);
        font-size: 10px;
        font-weight: 850;
    }

    .stat-value {
        position: relative;
        z-index: 1;
        margin: 18px 0 3px;
        color: #ffffff;
        font-size: 30px;
        line-height: 1;
        font-weight: 850;
    }

    .stat-label {
        position: relative;
        z-index: 1;
        color: rgba(255, 255, 255, .88);
        font-size: 12px;
        font-weight: 800;
    }

    .bulk-panel-head {
        padding: 16px 18px;
        border-bottom: 1px solid rgba(219, 227, 239, .78);
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .82), rgba(255, 255, 255, .34)),
            linear-gradient(135deg, rgba(37, 99, 235, .08), rgba(20, 184, 166, .08));
    }

    .bulk-panel-title {
        margin: 0;
        font-size: 18px;
        font-weight: 850;
        color: var(--bulk-ink);
    }

    .bulk-panel-subtitle {
        margin-top: 3px;
        color: var(--bulk-muted);
        font-size: 12px;
        font-weight: 650;
    }

    .bulk-form {
        padding: 18px;
    }

    .bulk-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .bulk-field,
    .composer-card,
    .preview-card {
        padding: 14px;
        border: 1px solid rgba(255, 255, 255, .78);
        border-radius: 15px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .88), rgba(255, 255, 255, .42)),
            rgba(37, 99, 235, .04);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .94),
            0 10px 22px rgba(21, 32, 51, .05);
    }

    .bulk-field {
        min-height: 122px;
    }

    .bulk-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        color: #334155;
        font-size: 13px;
        font-weight: 850;
    }

    .bulk-label i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--bulk-blue), var(--bulk-teal));
        color: #ffffff;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .26),
            0 8px 16px rgba(37, 99, 235, .16);
    }

    .bulk-field .form-control,
    .bulk-field .form-select,
    .composer-card .form-control {
        min-height: 42px;
        border: 1px solid #d7dfec;
        border-radius: 12px;
        background: rgba(255, 255, 255, .82);
        color: #1f2937;
        font-weight: 750;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .90);
    }

    .bulk-field .form-control:focus,
    .bulk-field .form-select:focus,
    .composer-card .form-control:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .bulk-page-tools {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .bulk-link-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, .76);
        border-radius: 999px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(37, 99, 235, .10);
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 850;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .88);
    }

    .composer-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 14px;
        margin-top: 14px;
    }

    .composer-card textarea {
        min-height: 280px;
        resize: vertical;
    }

    .email-preview {
        min-height: 323px;
        max-height: 420px;
        overflow-y: auto;
        border: 1px solid #d7dfec;
        border-radius: 12px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .92), rgba(248, 251, 255, .86));
        color: #334155;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .92);
    }

    .bulk-footer {
        display: flex;
        justify-content: flex-end;
        padding: 0 18px 18px;
    }

    .send-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        min-width: 160px;
        padding: 10px 16px;
        border: 0;
        border-radius: 12px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 36%),
            linear-gradient(135deg, var(--bulk-blue), var(--bulk-teal));
        color: #ffffff;
        font-size: 13px;
        font-weight: 850;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, .30),
            0 10px 20px rgba(37, 99, 235, .20);
    }

    .bulk-email-page .select2-container--default .select2-selection--multiple,
    .bulk-email-page .select2-container--default .select2-selection--single {
        min-height: 42px;
        border: 1px solid #d7dfec;
        border-radius: 12px;
        background: rgba(255, 255, 255, .82);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .90);
    }

    .bulk-email-page .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border: 1px solid rgba(255, 255, 255, .76);
        border-radius: 999px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .76), rgba(255, 255, 255, .24)),
            rgba(37, 99, 235, .10);
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 750;
    }

    @media (max-width: 991.98px) {
        .bulk-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .bulk-stats,
        .bulk-grid,
        .composer-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        .bulk-email-page {
            padding: 12px !important;
        }

        .bulk-footer,
        .send-btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
@php
    $status = config('fri.lead_status');
    $leadCount = $leads->count();
    $templateCount = $emailTemplates->count();
    $statusCount = count($status);
@endphp

<div class="content bulk-email-page pt-0">
    <div class="bulk-shell">
        <div class="bulk-toolbar">
            <div>
                <h1 class="bulk-title">Bulk Email</h1>
                <div class="bulk-subtitle">Send templated emails to filtered lead groups.</div>
            </div>
            <span class="bulk-badge">
                <i class="ph-paper-plane-tilt"></i> Campaign Sender
            </span>
        </div>

        <section class="bulk-stats">
            <div class="bulk-stat">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-users-three"></i></span>
                    <span class="stat-pill">Leads</span>
                </div>
                <div class="stat-value">{{ number_format($leadCount) }}</div>
                <div class="stat-label">Available Recipients</div>
            </div>
            <div class="bulk-stat stat-green">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-envelope-simple"></i></span>
                    <span class="stat-pill">Templates</span>
                </div>
                <div class="stat-value">{{ number_format($templateCount) }}</div>
                <div class="stat-label">Email Templates</div>
            </div>
            <div class="bulk-stat stat-indigo">
                <div class="stat-top">
                    <span class="stat-icon"><i class="ph-funnel"></i></span>
                    <span class="stat-pill">Filters</span>
                </div>
                <div class="stat-value">{{ number_format($statusCount) }}</div>
                <div class="stat-label">Lead Statuses</div>
            </div>
        </section>

        <div class="bulk-panel">
            <div class="bulk-panel-head">
                <h2 class="bulk-panel-title">Compose Bulk Email</h2>
                <div class="bulk-panel-subtitle">Choose a status, select recipients, load a template, and review the message before sending.</div>
            </div>

            <form action="{{ route('admin.bulkEmailSend') }}" method="POST">
                @csrf
                <div class="bulk-form">
                    <div class="bulk-grid">
                        <div class="bulk-field">
                            <label class="bulk-label">
                                <i class="ph-funnel"></i>
                                Lead Status
                            </label>
                            <select id="statusFilter" name="status" class="form-select">
                                <option value="">-- Select Status --</option>
                                @foreach($status as $val)
                                    <option value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bulk-field">
                            <label class="bulk-label">
                                <i class="ph-envelope-simple"></i>
                                Select Emails
                            </label>
                            <select id="emailSelect" name="emails[]" class="form-select select2" multiple required>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->email }}" data-status="{{ $lead->status }}">
                                        {{ $lead->first_name }} {{ $lead->last_name }} - {{ $lead->email }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="bulk-page-tools">
                                <a href="javascript:;" id="selectAll" class="bulk-link-pill">
                                    <i class="ph-checks"></i> Select All
                                </a>
                                <a href="javascript:;" id="deselectAll" class="bulk-link-pill">
                                    <i class="ph-x"></i> Deselect All
                                </a>
                            </div>
                        </div>

                        <div class="bulk-field">
                            <label class="bulk-label">
                                <i class="ph-file-text"></i>
                                Select Template
                            </label>
                            <select id="templateSelect" class="form-select" name="template_id">
                                <option value="">-- Select Template --</option>
                                @foreach($emailTemplates as $template)
                                    <option value="{{ $template->id }}" data-email='@json($template)'>
                                        {{ $template->template_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="bulk-field mt-3">
                        <label class="bulk-label">
                            <i class="ph-text-aa"></i>
                            Subject
                        </label>
                        <input type="text" id="subjectInput" name="subject" class="form-control" required>
                    </div>

                    <div class="composer-grid">
                        <div class="composer-card">
                            <label class="bulk-label">
                                <i class="ph-pencil-simple-line"></i>
                                Email Body
                            </label>
                            <textarea class="form-control" name="body" id="emailBody" rows="10"></textarea>
                        </div>

                        <div class="preview-card">
                            <label class="bulk-label">
                                <i class="ph-eye"></i>
                                Preview
                            </label>
                            <div class="email-preview p-3" id="emailPreview">
                                <p class="text-muted mb-0">Your email preview will appear here...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bulk-footer">
                    <button type="submit" class="send-btn">
                        <i class="ph-paper-plane-tilt"></i> Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    let allOptions = [];

    $('#emailSelect option').each(function() {
        allOptions.push({
            id: $(this).val(),
            text: $(this).text(),
            status: $(this).data('status')
        });
    });

    $('#emailSelect').select2({
        placeholder: "Select Emails",
        width: '100%',
        data: allOptions
    });

    $('#templateSelect').on('change', function() {
        let selected = $(this).find(':selected').data('email');
        if (selected) {
            $('#subjectInput').val(selected.subject);
            $('#emailBody').val(selected.body);
            $('#emailPreview').html(selected.body);
        } else {
            $('#subjectInput').val('');
            $('#emailBody').val('');
            $('#emailPreview').html('<p class="text-muted mb-0">Your email preview will appear here...</p>');
        }
    });

    $('#emailBody').on('input', function() {
        $('#emailPreview').html($(this).val());
    });

    $('#statusFilter').on('change', function() {
        let selectedStatus = $(this).val();
        let filtered = [];

        if (!selectedStatus) {
            filtered = allOptions;
        } else {
            filtered = allOptions.filter(function(item) {
                return item.status == selectedStatus;
            });
        }

        $('#emailSelect').empty().select2({
            placeholder: "Select Emails",
            width: '100%',
            data: filtered
        });
    });

    $('#selectAll').on('click', function() {
        let selectedStatus = $('#statusFilter').val();
        let values = [];

        if (!selectedStatus) {
            values = allOptions.map(item => item.id);
        } else {
            values = allOptions
                .filter(item => item.status == selectedStatus)
                .map(item => item.id);
        }

        $('#emailSelect').val(values).trigger('change');
    });

    $('#deselectAll').on('click', function() {
        $('#emailSelect').val([]).trigger('change');
    });
});
</script>
@endsection
