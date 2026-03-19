@extends('layouts.admin')
@section('title', "Bulk Email")
@section('content')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="content">

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Send Bulk Email</h5>
        </div>

        <form action="{{route('admin.bulkEmailSend')}}" method="POST">
            @csrf

            <div class="card-body">

                <!-- Select Users -->
                <div class="mb-3">
                    <label class="fw-semibold">Select Emails</label>
                    <select name="emails[]" class="form-select select2" multiple required>
                        @foreach($leads as $lead)
                        <option value="{{ $lead->email }}">
                            {{ $lead->first_name }} {{ $lead->last_name }} — {{ $lead->email }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Template dropdown -->
                <div class="mb-3">
                    <label class="fw-semibold">Select Template</label>
                    <select id="templateSelect" class="form-select" name="template_id">
                        <option value="">-- Select Template --</option>
                        @foreach($emailTemplates as $template)
                        <option value="{{ $template->id }}" data-email='@json($template)'>
                            {{ $template->template_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Subject -->
                <div class="mb-3">
                    <label class="fw-semibold">Subject</label>
                    <input type="text" id="subjectInput" name="subject" class="form-control" required>
                </div>

                <!-- Email Content + Preview -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Email Body</label>
                        <textarea class="form-control" name="body" id="emailBody" rows="10"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Preview</label>
                        <div class="border rounded p-3 bg-light" style="height:100%; overflow-y:auto;" id="emailPreview">
                            <p class="text-muted">Your email preview will appear here...</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary bg_s">
                    <i class="ph-paper-plane-tilt"></i> Send Email
                </button>
            </div>

        </form>
    </div>

</div>


@endsection

@section('scripts')

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    // initialize select2
    $('.select2').select2({
        placeholder: "Select Emails",
        width: '100%'
    });

    // template change logic
    $('#templateSelect').on('change', function() {
        let selected = $(this).find(':selected').data('email');
        if (selected) {
            $('#subjectInput').val(selected.subject);
            $('#emailBody').val(selected.body);
            $('#emailPreview').html(selected.body);
        } else {
            $('#subjectInput').val('');
            $('#emailBody').val('');
            $('#emailPreview').html('<p class="text-muted">Your email preview will appear here...</p>');
        }
    });

    // live preview update
    $('#emailBody').on('input', function() {
        $('#emailPreview').html($(this).val());
    });

});
</script>

@endsection
