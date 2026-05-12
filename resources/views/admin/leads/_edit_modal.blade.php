<div class="offcanvas offcanvas-end rk-edit-modal rk-edit-shell" id="editlead" tabindex="-1" aria-labelledby="editleadLabel">

            <div class="offcanvas-header rk-edit-header">
                <div class="rk-edit-title-wrap">
                    <span class="rk-edit-icon">✎</span>
                    <div>
                        <span class="rk-edit-kicker">Lead profile</span>
                        <h5 class="offcanvas-title modal-title" id="editleadLabel">Edit Lead</h5>
                    </div>
                </div>
                <button type="button" class="btn-close rk-edit-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!-- Start form -->
            <form action="{{route('admin.updateStore')}}" method="post" class="rk-edit-form">
                @csrf
                <div class="offcanvas-body rk-edit-body">
                    <input type="hidden" name="id">
                    <div class="rk-edit-section">
                        <span class="rk-edit-section-title">Contact Information</span>
                    </div>

                    <div class="row rk-edit-grid">
                        <!-- Left Column -->
                        <div class="col-sm-6 rk-edit-field">
                            <label for="firstName" class="rk-edit-label">First Name</label>
                            <input type="text" id="firstName" name="first_name" class="form-control"
                                placeholder="Enter first name" required>
                        </div>

                        <!-- Right Column -->
                        <div class="col-sm-6 rk-edit-field">
                            <label for="lastName" class="rk-edit-label">Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="form-control"
                                placeholder="Enter last name" required>
                        </div>

                        <!-- Email -->
                        <div class="col-sm-6 rk-edit-field">
                            <label for="email" class="rk-edit-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                                required>
                        </div>

                        <!-- Phone -->
                        <div class="col-sm-6 rk-edit-field">
                            <label for="phone" class="rk-edit-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone"
                                required>
                        </div>

                        <div class="col-sm-6 rk-edit-field">
                            <label class="rk-edit-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter Address">
                        </div>

                        <div class="col-sm-6 rk-edit-field">
                            <label class="rk-edit-label">Assigned Rep</label>

                            <select name="assign_rep" class="form-control">
                                <option value="">Select</option>
                                @foreach($users as $data)
                                <option value="{{@$data->id}}">{{@$data['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 rk-edit-field">
                            <label class="rk-edit-label">Lead Source</label>
                            <select name="lead_source" class="form-control">
                                <option value="">Select</option>
                                @foreach($leadSource as $data)
                                <option value="{{@$data->id}}">{{@$data['source']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-3 rk-edit-field">
                            @php
                            $roofTypes = ['Flat', 'Pitched', 'Hipped', 'Gabled', 'Mansard', 'Shed'];
                            @endphp

                            <label for="roof_type" class="rk-edit-label">Roof Type</label>
                            <select id="roof_type" name="roof_type" class="form-control">
                                <option value="">-- Select Roof Type --</option>
                                @foreach($roofTypes as $type)
                                <option value="{{ strtolower($type) }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-3 rk-edit-field">
                            <label class="rk-edit-label">Eligible for Rebate</label>
                            <select name="elogible_for_rebate" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>

                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-3 rk-edit-field">
                            <label class="rk-edit-label">Category</label>
                            <select name="category" class="form-control category">
                                <option value="">--Select--</option>
                                <option value="Solar">Solar</option>
                                <option value="Battery">Battery</option>
                                <option value="Solar+Battery">Solar+Battery</option>
                                <option value="Heat Pump">Heat Pump</option>
                                <option value="AirCon">AirCon</option>
                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-3 rk-edit-field hide solar_kw">
                            <label class="rk-edit-label">Solar KW</label>
                            <input type="text" name="solar_kw" class="form-control" placeholder="Solar KW">
                        </div>

                        <div class="col-sm-6 col-lg-3 rk-edit-field hide battery_kw">
                            <label class="rk-edit-label">Battery KW</label>
                            <input type="text" name="battery_kw" class="form-control" placeholder="Battery KW">
                        </div>

                        <div class="col-sm-12 rk-edit-field">
                            <label class="rk-edit-label">Proposal Url</label>
                            <input type="text" name="proposal_url" class="form-control" placeholder="Proposal Url" value="{{@$lead->proposal_url}}">
                        </div>

                    </div>
                </div>

                <!-- Footer inside the form -->
                <div class="rk-edit-footer">
                    <button type="button" class="btn rk-edit-cancel" data-bs-dismiss="offcanvas">Close</button>
                    <button type="submit" class="btn rk-edit-save">Save changes</button>
                </div>
            </form>
</div>
<script>
$(document).on("click", ".edit_lead", function() {
    let lead = $(this).data("lead");

    // parse if JSON string
    if (typeof lead == "string") {
        lead = JSON.parse(lead);
    }

    const panel = $("#editlead");

    // fill inputs
    panel.find("input[name='id']").val(lead.id || "");
    panel.find("input[name='first_name']").val(lead.first_name || "");
    panel.find("input[name='last_name']").val(lead.last_name || "");
    panel.find("input[name='email']").val(lead.email || "");
    panel.find("input[name='phone']").val(lead.phone || "");
    panel.find("input[name='address']").val(lead.address || "");
    panel.find("input[name='proposal_url']").val(lead.proposal_url || "");

    // select values
    panel.find("select[name='assign_rep']").val(lead.get_assign_user_name?.id || "").trigger("change");
    panel.find("select[name='lead_source']").val(lead.lead_source?.id || "").trigger("change");
    panel.find("select[name='roof_type']").val(lead.roof_type || "").trigger("change");
    panel.find("select[name='elogible_for_rebate']").val(lead.elogible_for_rebate || "No").trigger("change");

    // category logic
    let category = lead.category || "";
    panel.find("select[name='category']").val(category);

    // wait for DOM update, then trigger change to show/hide solar_kw / battery_kw
    setTimeout(() => {
        panel.find("select[name='category']").trigger("change");
    }, 100);

    // fill kw fields if present
    panel.find("input[name='solar_kw']").val(lead.solar_kw || "");
    panel.find("input[name='battery_kw']").val(lead.battery_kw || "");
});

document.addEventListener('click', function(event) {
    const trigger = event.target.closest('[data-bs-target="#editlead"]');
    if (trigger && trigger.getAttribute('data-bs-toggle') === 'modal') {
        trigger.setAttribute('data-bs-toggle', 'offcanvas');
        trigger.setAttribute('aria-controls', 'editlead');
    }
}, true);
</script>

<style>
.hide {
    display: none !important;
}

.rk-edit-shell {
    width: min(760px, 100vw) !important;
    overflow: hidden;
    border: 0;
    border-radius: 18px 0 0 18px;
    background:
        radial-gradient(circle at top left, rgba(20, 184, 166, .16), transparent 34%),
        radial-gradient(circle at top right, rgba(56, 168, 255, .14), transparent 30%),
        linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
    box-shadow: 0 28px 80px rgba(15, 23, 42, .28);
    color: #172033;
    font-size: 13px;
}

.rk-edit-form {
    display: flex;
    min-height: 0;
    flex: 1 1 auto;
    flex-direction: column;
}

.rk-edit-header {
    align-items: center;
    padding: 18px 22px;
    border: 0;
    background: linear-gradient(135deg, #0f172a 0%, #164e63 58%, #0f766e 100%);
    color: #fff;
}

.rk-edit-title-wrap {
    display: flex;
    align-items: center;
    gap: 13px;
    min-width: 0;
}

.rk-edit-icon {
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
    font-size: 18px;
    line-height: 1;
}

.rk-edit-kicker {
    display: block;
    margin-bottom: 3px;
    color: rgba(255, 255, 255, .68);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-edit-header .modal-title {
    margin: 0;
    color: #fff;
    font-size: 17px;
    font-weight: 600;
    line-height: 1.25;
}

.rk-edit-close {
    width: 36px;
    height: 36px;
    border-radius: 999px;
    background-color: rgba(255, 255, 255, .86);
    opacity: 1;
}

.rk-edit-body {
    flex: 1 1 auto;
    max-height: none;
    padding: 22px;
    overflow-y: auto;
}

.rk-edit-section {
    display: flex;
    align-items: center;
    margin-bottom: 14px;
}

.rk-edit-section-title {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 11px;
    border: 1px dashed rgba(56, 168, 255, .72);
    border-radius: 999px;
    background: rgba(239, 248, 255, .82);
    color: #0f4f66;
    font-size: 12px;
    font-weight: 600;
}

.rk-edit-section-title::before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 999px;
    background: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, .13);
}

.rk-edit-grid {
    row-gap: 14px;
}

.rk-edit-field {
    margin-bottom: 0;
}

.rk-edit-label {
    display: block;
    margin-bottom: 7px;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
}

.rk-edit-modal .form-control,
.rk-edit-modal select.form-control {
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

.rk-edit-modal .form-control:focus,
.rk-edit-modal select.form-control:focus {
    border-color: #14b8a6;
    background-color: #fff;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, .13);
}

.rk-edit-modal select.form-control {
    cursor: pointer;
}

.rk-edit-field.hide {
    display: none !important;
}

.rk-edit-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 22px 20px;
    border: 0;
    background: linear-gradient(180deg, rgba(248, 251, 255, .65), #fff);
}

.rk-edit-cancel,
.rk-edit-save {
    display: inline-flex;
    min-height: 40px;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 600;
}

.rk-edit-cancel {
    border: 1px solid rgba(100, 116, 139, .28);
    background: #f8fafc;
    color: #475569;
}

.rk-edit-cancel:hover {
    border-color: rgba(100, 116, 139, .46);
    background: #eef2f7;
    color: #334155;
}

.rk-edit-save {
    border: 0;
    background: linear-gradient(135deg, #2563eb, #14b8a6);
    box-shadow: 0 12px 24px rgba(37, 99, 235, .22);
    color: #fff;
}

.rk-edit-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 16px 30px rgba(20, 184, 166, .24);
    color: #fff;
}

@media (max-width: 768px) {
    .rk-edit-header,
    .rk-edit-body,
    .rk-edit-footer {
        padding-left: 16px;
        padding-right: 16px;
    }

    .rk-edit-header .modal-title {
        font-size: 16px;
    }
}
</style>
<script>
$(document).on('change', '.category', function() {
    const category = $(this).val();

    // hide both by default
    $('.solar_kw').addClass('hide');
    $('.battery_kw').addClass('hide');

    // show based on selection
    if (category == 'Solar') {
        $('.solar_kw').removeClass('hide');
    } else if (category == 'Battery') {
        $('.battery_kw').removeClass('hide');
    } else if (category == 'Solar+Battery') {
        $('.solar_kw').removeClass('hide');
        $('.battery_kw').removeClass('hide');
    }
});
</script>
