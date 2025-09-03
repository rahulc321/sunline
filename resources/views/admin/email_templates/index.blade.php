@extends('layouts.admin')

@section('title', "Marketing Automation")

@section('content')
<?php
error_reporting(0);
?>
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
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">Marketing Automation
                </h4>
                <p class="mb-0 txt_1">Manage email templates, automation rules, and campaign performance</p>
            </div>

            <div class="col-md-3 ms-auto">
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Create Template
                </a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">


        <div class="card p-3 form_1">
            <form class="row align-items-end">
                <div class="col-md-4">
                    <label>Search</label>
                    <input type="text" class="form-control" placeholder="Search here...">
                </div>

                <div class="col-md-2">
                    <label>All Category</label>
                    <select class="form-select">
                        <option value="">Select</option>
                        @foreach($category as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2">
                    <label>Status</label>
                    <select class="form-select">
                        <option value="">Select</option>
                        @foreach($status as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary bg_s">Apply</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
            </form>
        </div>

        <!-- Templates grid -->
        <div class="row">
            @foreach($templates as $template)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm rounded-3 h-100 border">

                    <div class="card-body d-flex flex-column">
                        <!-- Title + Status badge -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0">{{ $template->subject }}</h6>
                            <span
                                class="badge rounded-pill {{ $template->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $template->status }}
                            </span>
                        </div>

                        <!-- Short description -->
                        <p class="text-muted small mb-2">
                            {{ Str::limit(strip_tags($template->body), 50) }}
                        </p>

                        <!-- Category badge -->
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


                        <!-- Stats row -->
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span><i class="ph-trend-up"></i> {{ $template->uses_count ?? 0 }} uses</span>
                            <span><i class="ph-calendar"></i> {{ $template->updated_at->format('Y-m-d') }}</span>
                        </div>

                        <!-- Action buttons -->
                        <div class="d-flex justify-content-between gap-1">
                            <button class="btn btn-sm btn-outline-secondary flex-fill">
                                <i class="ph-eye"></i> Preview
                            </button>
                            <a href="#" class="btn btn-sm btn-outline-primary flex-fill editTemplate"
                                data-templete="{{ json_encode($template) }}" data-bs-toggle="modal"
                                data-bs-target="#editTemplate">
                                <i class="ph-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.emailTemplate.destroy',[$template->id]) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger flex-fill">
                                    <i class="ph-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>



    </section>
    @include('admin.email_templates._add_modal')
    @include('admin.email_templates._edit_modal')


    @endsection

    @section('scripts')
    @parent

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js">
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById('addLeadModal');

        // initialize when modal is fully visible
        modal.addEventListener('shown.bs.modal', function() {
            setTimeout(function() {
                if (CKEDITOR.instances.editorBody) {
                    CKEDITOR.instances.editorBody.destroy(true);
                }
                CKEDITOR.replace('editorBody', {
                    height: 250
                });
            }, 200); // small delay so modal animation finishes
        });

        // destroy when modal hidden
        modal.addEventListener('hidden.bs.modal', function() {
            if (CKEDITOR.instances.editorBody) {
                CKEDITOR.instances.editorBody.updateElement();
                CKEDITOR.instances.editorBody.destroy(true);
            }
            modal.querySelector('form').reset();
        });
    });

    $(document).on('click', '.editTemplate', function() {
        // get template data from button attribute or hidden field
        let template = $(this).data('templete');
        //alert(11);
        if (typeof template === 'string') {
            template = JSON.parse(template); // convert JSON string to object
        }

        let modal = $('#editModel');

        // reset form
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

        // loop through keys of template and match input/textarea/select by name
        $.each(template, function(key, value) {
            let field = modal.find('[name="' + key + '"]');

            if (field.is('select')) {
                field.val(value).trigger('change');
            } else if (field.is('textarea')) {
                field.val(value);
            } else {
                field.val(value);
            }
        });

        // finally show modal
        modal.modal('show');
    });
    </script>

    <script>
    $(document).on('click', '.insert-tag', function() {
        let tag = $(this).data('tag');

        // If CKEditor is enabled
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

        // Fallback for normal textarea
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