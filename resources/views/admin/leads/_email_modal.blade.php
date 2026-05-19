<div class="offcanvas offcanvas-end rk-email-modal rk-email-shell" id="emailModel" tabindex="-1" aria-labelledby="emailModelLabel">

            <div class="offcanvas-header rk-email-header">
                <div class="rk-email-title-wrap">
                    <span class="rk-email-icon">
                        <span>✈</span>
                    </span>
                    <div>
                        <span class="rk-email-kicker">Lead communication</span>
                        <h5 class="modal-title" id="emailModelLabel">Send Email to <span class="lead_name">{{@$lead->first_name.' '.@$lead->last_name}}</span></h5>
                    </div>
                </div>
                <button type="button" class="btn-close rk-email-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.sendEmail') }}" method="post" class="rk-email-form">
                @csrf
                <input type="hidden" class="form-control lead_id" name="lead_id" value="{{@$lead->id}}">
                <div class="offcanvas-body rk-email-body">

                    <!-- Recipient -->
                    <div class="rk-email-field rk-recipient-field">
                        <label class="rk-email-label">Recipient</label>
                        <div class="rk-email-recipient">
                            <span class="rk-recipient-pill">To</span>
                            <input type="text" class="form-control lead_email" name="email" placeholder="Recipient Email" required value="{{@$lead->email}}">
                        </div>
                    </div>

                    <!-- Template dropdown -->
                    <div class="rk-email-field">
                        <label class="rk-email-label">Template</label>
                        <select id="templateSelect" class="form-select" name="template_id">
                            <option value="">-- Select Template --</option>
                            @foreach($emailTemplates as $template)
                            <option value="{{ $template->id }}" data-email='@json($template)'>
                                {{ $template->template_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="rk-email-field">
                        <label class="rk-email-label">Subject Line</label>
                        <input type="text" class="form-control" name="subject" id="subjectInput"
                            placeholder="Enter email subject" required>
                    </div>

                    <!-- Email Content + Preview -->
                    <div class="row rk-email-compose-grid">
                        <div class="col-md-6">
                            <label class="rk-email-label">Email Content</label>
                            <textarea class="form-control" name="body" id="emailBody" rows="10"
                                placeholder="Type your email..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="rk-email-label">Email Preview</label>
                            <div class="rk-email-preview" id="emailPreview">
                                <p class="text-muted">Your email preview will appear here...</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="rk-email-footer">
                    <button type="button" class="btn rk-email-cancel" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn rk-email-send"><svg xmlns="http://www.w3.org/2000/svg"
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
<style>
.rk-email-shell {
    width: min(880px, 100vw) !important;
    overflow: hidden;
    border: 0;
    border-radius: 18px 0 0 18px;
    background:
        radial-gradient(circle at top left, rgba(20, 184, 166, .18), transparent 34%),
        radial-gradient(circle at top right, rgba(56, 168, 255, .16), transparent 32%),
        linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
    box-shadow: 0 28px 80px rgba(15, 23, 42, .28);
    color: #172033;
    font-size: 13px;
}

.rk-email-form {
    display: flex;
    min-height: 0;
    flex: 1 1 auto;
    flex-direction: column;
}

.rk-email-header {
    align-items: center;
    padding: 18px 22px;
    border: 0;
    background: linear-gradient(135deg, #0f172a 0%, #164e63 58%, #0f766e 100%);
    color: #fff;
}

.rk-email-title-wrap {
    display: flex;
    align-items: center;
    gap: 13px;
    min-width: 0;
}

.rk-email-icon {
    display: inline-flex;
    width: 44px;
    height: 44px;
    flex: 0 0 44px;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, .30);
    border-radius: 14px;
    background: rgba(255, 255, 255, .14);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .34), 0 12px 26px rgba(0, 0, 0, .20);
    color: #c7fff6;
    font-size: 16px;
}

.rk-email-icon span {
    transform: translateX(-1px);
}

.rk-email-kicker {
    display: block;
    margin-bottom: 3px;
    color: rgba(255, 255, 255, .68);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-email-header .modal-title {
    margin: 0;
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    line-height: 1.25;
}

.rk-email-header .lead_name {
    color: #d9fffa;
}

.rk-email-close {
    width: 36px;
    height: 36px;
    border-radius: 999px;
    background-color: rgba(255, 255, 255, .86);
    opacity: 1;
}

.rk-email-body {
    flex: 1 1 auto;
    padding: 22px;
    overflow-y: auto;
}

.rk-email-field {
    margin-bottom: 15px;
}

.rk-email-label {
    display: block;
    margin-bottom: 7px;
    color: #334155;
    font-size: 11px;
    font-weight: 600;
}

.rk-email-modal .form-control,
.rk-email-modal .form-select {
    min-height: 44px;
    border: 1px solid #d9e4ef;
    border-radius: 11px;
    background-color: rgba(255, 255, 255, .88);
    color: #172033;
    font-size: 13px;
    font-weight: 500;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .7);
    transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
}

.rk-email-modal .form-control:focus,
.rk-email-modal .form-select:focus {
    border-color: #14b8a6;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, .13);
}

.rk-email-recipient {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px;
    border: 1px solid #d9e4ef;
    border-radius: 13px;
    background: rgba(248, 252, 255, .9);
}

.rk-email-recipient .form-control {
    min-height: 34px;
    padding: 4px 8px;
    border: 0;
    border-radius: 8px;
    background: transparent;
    box-shadow: none;
}

.rk-email-recipient .form-control:focus {
    box-shadow: none;
}

.rk-recipient-pill {
    display: inline-flex;
    min-width: 36px;
    height: 28px;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: linear-gradient(135deg, #0f766e, #14b8a6);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
}

.rk-email-compose-grid {
    row-gap: 16px;
}

.rk-email-compose-grid textarea.form-control,
.rk-email-preview {
    min-height: 250px;
}

.rk-email-compose-grid textarea.form-control {
    padding: 14px;
    resize: vertical;
}

.rk-email-preview {
    height: 100%;
    padding: 16px;
    overflow-y: auto;
    border: 1px dashed rgba(56, 168, 255, .85);
    border-radius: 13px;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, .78), rgba(247, 251, 255, .94)),
        repeating-linear-gradient(135deg, rgba(56, 168, 255, .05) 0 8px, transparent 8px 16px);
    color: #334155;
    font-size: 13px;
    line-height: 1.55;
}

.rk-email-preview p {
    margin: 0;
}

.rk-email-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 22px 20px;
    border: 0;
    background: linear-gradient(180deg, rgba(248, 251, 255, .65), #fff);
}

.rk-email-cancel,
.rk-email-send {
    display: inline-flex;
    min-height: 40px;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border-radius: 11px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 600;
}

.rk-email-cancel {
    border: 1px solid rgba(249, 115, 22, .34);
    background: #fff7ed;
    color: #c2410c;
}

.rk-email-cancel:hover {
    border-color: rgba(249, 115, 22, .55);
    background: #ffedd5;
    color: #9a3412;
}

.rk-email-send {
    border: 0;
    background: linear-gradient(135deg, #2563eb, #14b8a6);
    box-shadow: 0 12px 24px rgba(37, 99, 235, .22);
    color: #fff;
}

.rk-email-send:hover {
    transform: translateY(-1px);
    box-shadow: 0 16px 30px rgba(20, 184, 166, .24);
    color: #fff;
}

.rk-email-send svg {
    width: 16px;
    height: 16px;
}

@media (max-width: 768px) {
    .rk-email-header,
    .rk-email-body,
    .rk-email-footer {
        padding-left: 16px;
        padding-right: 16px;
    }

    .rk-email-header .modal-title {
        font-size: 16px;
    }
}
</style>
<script>
document.addEventListener('click', function(event) {
    const trigger = event.target.closest('[data-bs-target="#emailModel"]');
    if (trigger && trigger.getAttribute('data-bs-toggle') === 'modal') {
        trigger.setAttribute('data-bs-toggle', 'offcanvas');
        trigger.setAttribute('aria-controls', 'emailModel');
    }
}, true);

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
