@extends('layouts.admin')

@section('title', "Marketing Automation")

@section('content')
<?php error_reporting(0); ?>

<style>
.cke_notification {
    display: none;
}
</style>

<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">Marketing Automation</h4>
                <p class="mb-0 txt_1">Manage email templates, automation rules, and campaign performance</p>
            </div>

            <div class="col-md-3 ms-auto">
                @can('automation_create')
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Create Template
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">

    <!-- Filter Card -->
    <div class="card p-3 form_1 mb-3">
        <form class="row align-items-end" method="GET" action="">
            <div class="col-md-4">
                <label>Search</label>
                <input type="text" class="form-control" placeholder="Search here..." name="search_key"
                    value="{{ request('search_key') }}">
            </div>

            <div class="col-md-2">
                <label>All Category</label>
                <select name="category" class="form-select">
                    <option value="">Select</option>
                    <option value="Welcome" {{ request('category') == 'Welcome' ? 'selected' : '' }}>Welcome</option>
                    <option value="Follow-up" {{ request('category') == 'Follow-up' ? 'selected' : '' }}>Follow-up
                    </option>
                    <option value="Proposal" {{ request('category') == 'Proposal' ? 'selected' : '' }}>Proposal</option>
                    <option value="Thank You" {{ request('category') == 'Thank You' ? 'selected' : '' }}>Thank You
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="">Select</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Archived" {{ request('status') == 'Archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary bg_s">Apply</button>

                {{-- Reset clears filters by redirecting back to index --}}
                <a href="{{ route('admin.emailTemplate.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs nav-tabs-solid nav-tabs-solid-custom mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#templates" role="tab">
                <i class="ph-envelope"></i> Email Templates
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#rules" role="tab">
                <i class="ph-lightning"></i> Automation Rules
            </a>
        </li>

    </ul>

    <!-- Tab content -->
    <div class="tab-content">

        <!-- Templates -->
        <div class="tab-pane fade show active" id="templates" role="tabpanel">
            <div class="row">
                @foreach($templates as $template)
                <?php
                    $usersCount = DB::table('emails')->where('template_id',$template->id)->get()->count();
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm rounded-3 h-100 border">
                        <div class="card-body d-flex flex-column">

                            <h6 class="text-muted small mb-2">
                                <span>{{ $template->template_name }}</span>
                            </h6>
                            <div class="d-flex justify-content-between align-items-start mb-2">

                                <p class="mb-0">{{ $template->subject }}</p>

                                <span
                                    class="badge rounded-pill {{ $template->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $template->status }}
                                </span>
                            </div>

                            <p class="text-muted small mb-2">
                                {{ Str::limit(strip_tags($template->body), 50) }}
                            </p>

                            <div class="text-start">
                                <span class="badge bg-light text-primary mb-2">
                                    {{ ucfirst($template->category) }}
                                </span>
                                @if($template->lead_status)
                                <span class="badge bg-light text-warning mb-2">
                                    {{ ucfirst($template->lead_status) }}
                                </span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between text-muted small mb-3">
                                <span><i class="ph-trend-up"></i> {{ $usersCount ?? 0 }} uses</span>
                                <span><i class="ph-calendar"></i> {{ $template->updated_at->format('Y-m-d') }}</span>
                            </div>

                            <div class="d-flex justify-content-between gap-1">
                                <!-- <button class="btn btn-sm btn-outline-secondary flex-fill">
                                    <i class="ph-eye"></i> Preview
                                </button> -->
                                @can('automation_edit')
                                <a href="#" class="btn btn-sm btn-outline-primary flex-fill editTemplate"
                                    data-templete="{{ json_encode($template) }}" data-bs-toggle="modal"
                                    data-bs-target="#editTemplate">
                                    <i class="ph-pencil"></i> Edit
                                </a>
                                @endcan
                                @can('automation_delete')
                                <form action="{{ route('admin.emailTemplate.destroy',[$template->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger flex-fill">
                                        <i class="ph-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($templates->count() == 0)
                <div style="display:flex; justify-content:center; align-items:center; height:220px; margin:0;">
                    <div
                        style="text-align:center; padding:20px; border:1px dashed #ccc; border-radius:12px; background:#fff; max-width:350px; width:100%; margin:0; animation: fadeIn 0.6s;">
                        <div
                            style="font-size:48px; color:#f39c12; margin:0 0 10px 0; line-height:1; animation: pulse 1.5s infinite;">
                            ⚠️
                        </div>
                        <p style="margin:0; font-size:18px; font-weight:600; color:#555;">
                            Warning: No Data Found!
                        </p>
                    </div>
                </div>
                <style>
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: scale(0.95);
                    }

                    to {
                        opacity: 1;
                        transform: scale(1);
                    }
                }

                @keyframes pulse {
                    0% {
                        transform: scale(1);
                    }

                    50% {
                        transform: scale(1.15);
                    }

                    100% {
                        transform: scale(1);
                    }
                }
                </style>
                @endif

            </div>
        </div>

        <!-- Automation Rules -->
        <div class="tab-pane fade" id="rules" role="tabpanel">
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">API Tester</h5>

                <form id="apiForm" class="row g-3">
                    @csrf

                    <div class="col-md-3">
                        <label for="method" class="form-label1 fw-bold">Method</label>
                        <select class="form-select" name="method" id="method">
                            <option>GET</option>
                            <option>POST</option>
                            <option>PUT</option>
                            <option>DELETE</option>
                        </select>
                    </div>

                    <div class="col-md-9">
                        <label for="url" class="form-label1 fw-bold">URL</label>
                        <input type="text" class="form-control" id="url" name="url"
                            placeholder="https://example.com/api/v1/getToken">
                    </div>

                    <div class="col-12">
                        <label for="bearer_token" class="form-label1 fw-bold">Bearer Token</label>
                        <input type="text" class="form-control" id="bearer_token" name="bearer_token"
                            placeholder="Paste token here">
                    </div>

                    <div class="col-12">
                        <label for="body" class="form-label1 fw-bold">Body (JSON)</label>
                        <textarea class="form-control" id="body" name="body" rows="5">{}</textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4" id="sendBtn">
                            <span id="btnText">Send</span>
                            <span id="btnLoader" class="spinner-border spinner-border-sm ms-2 d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </form>

                <h5 class="mt-4">Response</h5>
                <pre id="response" class="p-3 bg-dark text-success rounded"
                    style="min-height: 200px; white-space: pre-wrap; word-wrap: break-word;"></pre>
            </div>
        </div>




    </div>
</section>

@include('admin.email_templates._add_modal')
@include('admin.email_templates._edit_modal')

@endsection

@section('scripts')
@parent
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
document.getElementById('apiForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const token = document.querySelector('input[name="_token"]').value;
    const sendBtn = document.getElementById('sendBtn');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');
    const responseBox = document.getElementById('response');

    // show loader
    btnText.textContent = "Sending...";
    btnLoader.classList.remove('d-none');
    sendBtn.disabled = true;
    responseBox.textContent = "⏳ Waiting for response...";

    try {
        const res = await fetch('/admin/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                method: document.getElementById('method').value,
                url: document.getElementById('url').value,
                body: document.getElementById('body').value,
                bearer_token: document.getElementById('bearer_token').value
            })
        });

        const data = await res.json();
        responseBox.textContent = JSON.stringify(data, null, 2);
    } catch (err) {
        responseBox.textContent = "❌ Error: " + err.message;
    } finally {
        // hide loader
        btnText.textContent = "Send";
        btnLoader.classList.add('d-none');
        sendBtn.disabled = false;
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById('addLeadModal');

    modal.addEventListener('shown.bs.modal', function() {
        setTimeout(function() {
            if (CKEDITOR.instances.editorBody) {
                CKEDITOR.instances.editorBody.destroy(true);
            }
            CKEDITOR.replace('editorBody', {
                height: 250
            });
        }, 200);
    });

    modal.addEventListener('hidden.bs.modal', function() {
        if (CKEDITOR.instances.editorBody) {
            CKEDITOR.instances.editorBody.updateElement();
            CKEDITOR.instances.editorBody.destroy(true);
        }
        modal.querySelector('form').reset();
    });
});

$(document).on('click', '.editTemplate', function() {
    let template = $(this).data('templete');
    if (typeof template === 'string') template = JSON.parse(template);

    let modal = $('#editModel');
    modal.find('form')[0].reset();
    modal.find('select').val('').trigger('change');

    setTimeout(function() {
        if (CKEDITOR.instances.editorBody1) {
            CKEDITOR.instances.editorBody1.destroy(true);
        }
        CKEDITOR.replace('editorBody1', {
            height: 250
        });
    }, 200);

    $.each(template, function(key, value) {
        let field = modal.find('[name="' + key + '"]');
        if (field.is('select')) field.val(value).trigger('change');
        else field.val(value);
    });

    modal.modal('show');
});
</script>

<script>
$(document).on('click', '.insert-tag', function() {
    let tag = $(this).data('tag');
    if (typeof CKEDITOR !== 'undefined') {
        if (CKEDITOR.instances.editorBody && CKEDITOR.instances.editorBody.focusManager.hasFocus) {
            CKEDITOR.instances.editorBody.insertText(tag);
            return;
        }
        if (CKEDITOR.instances.editorBody1 && CKEDITOR.instances.editorBody1.focusManager.hasFocus) {
            CKEDITOR.instances.editorBody1.insertText(tag);
            return;
        }
    }
    let textarea = document.activeElement;
    if (textarea && textarea.classList.contains('editorBody')) {
        let start = textarea.selectionStart;
        let end = textarea.selectionEnd;
        let text = textarea.value;
        textarea.value = text.substring(0, start) + tag + text.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + tag.length;
        textarea.focus();
    }
});
</script>

<script src="{{asset('js/lead/edit-lead.js')}}"></script>
<script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
<script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
@endsection