<div class="modal fade" id="emailModel" tabindex="-1" aria-labelledby="emailModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="emailModelLabel">Send Email to <span class="lead_name">{{@$lead->first_name.' '.@$lead->last_name}}</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.sendEmail') }}" method="post">
                @csrf
                <input type="hidden" class="form-control lead_id" name="lead_id" value="{{@$lead->id}}">
                <div class="modal-body">

                    <!-- Recipient -->
                    <div class="mb-3 d-flex align-items-center">
                        <div class="me-2">
                            <span class="badge bg-success rounded-pill">To</span>
                        </div>
                        <input type="text" class="form-control lead_email" name="email" placeholder="Recipient Email" required value="{{@$lead->email}}">
                    </div>

                    <!-- Template dropdown -->
                    <select id="templateSelect" class="form-select" name="template_id">
                        <option value="">-- Select Template --</option>
                        @foreach($emailTemplates as $template)
                        <option value="{{ $template->id }}" data-email='@json($template)'>
                            {{ $template->template_name }}
                        </option>
                        @endforeach
                    </select>

                    <div class="mb-3">
                        <label class="form-label1 fw-semibold">Subject Line</label>
                        <input type="text" class="form-control" name="subject" id="subjectInput"
                            placeholder="Enter email subject" required>
                    </div>

                    <!-- Email Content + Preview -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label1 fw-semibold">Email Content</label>
                            <textarea class="form-control" name="body" id="emailBody" rows="10"
                                placeholder="Type your email..."></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label1 fw-semibold">Email Preview</label>
                            <div class="border rounded p-3 bg-light" style="height: 100%; overflow-y: auto;"
                                id="emailPreview">
                                <p class="text-muted">Your email preview will appear here...</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary bg_s"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-send h-4 w-4 mr-2"
                            data-lov-id="src/components/shared/EmailTemplateModal.tsx:254:18" data-lov-name="Send"
                            data-component-path="src/components/shared/EmailTemplateModal.tsx" data-component-line="254"
                            data-component-file="EmailTemplateModal.tsx" data-component-name="Send"
                            data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                            <path
                                d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
                            </path>
                            <path d="m21.854 2.147-10.94 10.939"></path>
                        </svg> Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).on('change', '#templateSelect', function() {
    let selected = $(this).find(':selected').data('email');

    if (selected) {
        // fill subject
        $('#subjectInput').val(selected.subject);

        // fill body
        $('#emailBody').val(selected.body);

        // show in preview
        $('#emailPreview').html(selected.body);
    } else {
        // reset fields if nothing is selected
        $('#subjectInput').val('');
        $('#emailBody').val('');
        $('#emailPreview').html('<p class="text-muted">Your email preview will appear here...</p>');
    }
});
</script>