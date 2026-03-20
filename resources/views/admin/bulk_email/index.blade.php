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

                <?php $status = config('fri.lead_status'); ?>

                <div class="mb-3">
                    <label class="fw-semibold">Lead Status</label>
                    <select id="statusFilter" name="status" class="form-select">
                        <option value="">-- Select Status --</option>
                        @foreach($status as $val)
                        <option value="{{ $val }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Users -->
                <div class="mb-3">
                    <label class="fw-semibold">Select Emails</label>
                    <select id="emailSelect" name="emails[]" class="form-select select2" multiple required>
                        @foreach($leads as $lead)
                        <option value="{{ $lead->email }}" data-status="{{ $lead->status }}">
                            {{ $lead->first_name }} {{ $lead->last_name }} — {{ $lead->email }}
                        </option>
                        @endforeach
                    </select>

                    <div class="mb-2">
                        <a href="javascript:;" id="selectAll">
                            Select All
                        </a> | 

                        <a href="javascript:;" id="deselectAll">
                            Deselect All
                        </a>
                    </div>
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
                        <div class="border rounded p-3 bg-light" style="height:100%; overflow-y:auto;"
                            id="emailPreview">
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
$(document).ready(function() {

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


$(document).ready(function() {

    // store all options initially
    let allOptions = [];

    $('#emailSelect option').each(function() {
        allOptions.push({
            id: $(this).val(),
            text: $(this).text(),
            status: $(this).data('status')
        });
    });

    // initialize select2
    $('#emailSelect').select2({
        placeholder: "Select Emails",
        width: '100%',
        data: allOptions
    });

    // filter logic
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

        // rebuild select2
        $('#emailSelect').empty().select2({
            placeholder: "Select Emails",
            width: '100%',
            data: filtered
        });

    });

    // ✅ SELECT ALL (FIXED)
    $('#selectAll').on('click', function() {

        let selectedStatus = $('#statusFilter').val();

        let values = [];

        if (!selectedStatus) {
            // select all
            values = allOptions.map(item => item.id);
        } else {
            // select filtered only
            values = allOptions
                .filter(item => item.status == selectedStatus)
                .map(item => item.id);
        }

        $('#emailSelect').val(values).trigger('change');
    });

    // ✅ DESELECT ALL
    $('#deselectAll').on('click', function() {
        $('#emailSelect').val([]).trigger('change');
    });

});
</script>

@endsection