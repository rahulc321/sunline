<div class="offcanvas offcanvas-end rk-edit-offcanvas" id="editlead" tabindex="-1" aria-labelledby="editleadLabel">
    <div class="rk-edit-gloss"></div>
    <div class="offcanvas-header rk-edit-header">
        <div>
            <span class="rk-edit-kicker"><i class="ph ph-pencil-simple-line"></i> Lead profile</span>
            <h5 class="offcanvas-title" id="editleadLabel">Edit Lead</h5>
            <p>Update customer details, system size, and assignment information.</p>
        </div>
        <button type="button" class="btn-close rk-edit-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <form action="{{route('superadmin.updateStore')}}" method="post" class="rk-edit-form">
        @csrf
        <div class="offcanvas-body rk-edit-body">
            <div class="rk-edit-section">
                <div class="rk-edit-section-title">
                    <i class="ph ph-user-circle"></i>
                    <span>Customer details</span>
                </div>

                <div class="row g-3">
                    <input type="hidden" name="id">
                        <div class="col-sm-6">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="first_name" class="form-control"
                                placeholder="Enter first name" required>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="form-control"
                                placeholder="Enter last name" required>
                        </div>

                        <div class="col-sm-6">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                                required>
                        </div>

                        <div class="col-sm-6">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone"
                                required>
                        </div>

                        <div class="col-sm-12">
                            <label for="phone">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter Address">
                        </div>
                </div>
            </div>

            <div class="rk-edit-section">
                <div class="rk-edit-section-title">
                    <i class="ph ph-users-three"></i>
                    <span>Ownership and source</span>
                </div>

                <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="phone">Assigned Rep</label>

                            <select name="assign_rep" class="form-control">
                                <option value="">Select</option>
                                @foreach($users as $data)
                                <option value="{{@$data->id}}">{{@$data['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="phone">Lead Source</label>
                            <select name="lead_source" class="form-control">
                                <option value="">Select</option>
                                @foreach($leadSource as $data)
                                <option value="{{@$data->id}}">{{@$data['source']}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
            </div>

            <div class="rk-edit-section">
                <div class="rk-edit-section-title">
                    <i class="ph ph-solar-panel"></i>
                    <span>Solar requirements</span>
                </div>

                <div class="row g-3">
                        <div class="col-sm-6">
                            @php
                            $roofTypes = ['Flat', 'Pitched', 'Hipped', 'Gabled', 'Mansard', 'Shed'];
                            @endphp

                            <label for="roof_type">Roof Type</label>
                            <select id="roof_type" name="roof_type" class="form-control">
                                <option value="">-- Select Roof Type --</option>
                                @foreach($roofTypes as $type)
                                <option value="{{ strtolower($type) }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="phone">Eligible for Rebate</label>
                            <select name="elogible_for_rebate" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>

                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="phone">Category</label>
                            <select name="category" class="form-control category">
                                <option value="">--Select--</option>
                                <option value="Solar">Solar</option>
                                <option value="Battery">Battery</option>
                                <option value="Solar+Battery">Solar+Battery</option>
                                <option value="Heat Pump">Heat Pump</option>
                                <option value="AirCon">AirCon</option>
                            </select>
                        </div>

                        <div class="col-sm-6 hide solar_kw">
                            <label for="phone">Solar KW</label>
                            <input type="text" name="solar_kw" class="form-control" placeholder="Solar KW">
                        </div>

                        <div class="col-sm-6 hide battery_kw">
                            <label for="phone">Battery KW</label>
                            <input type="text" name="battery_kw" class="form-control" placeholder="Battery KW">
                        </div>

                        <div class="col-sm-12">
                            <label for="phone">Proposal Url</label>
                            <input type="text" name="proposal_url" class="form-control" placeholder="Proposal Url" value="{{@$lead->proposal_url}}">
                        </div>

                </div>
            </div>
        </div>

        <div class="rk-edit-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Close</button>
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
.rk-edit-offcanvas {
    width: min(720px, 100vw) !important;
    border: 0;
    color: #102033;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(247, 252, 255, 0.96)),
        radial-gradient(circle at 12% 0%, rgba(45, 133, 255, 0.18), transparent 28%);
    box-shadow: -24px 0 70px rgba(13, 44, 82, 0.24);
}

.rk-edit-gloss {
    position: absolute;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 12% 4%, rgba(255, 255, 255, 0.92), transparent 16%),
        radial-gradient(circle at 90% 12%, rgba(43, 130, 255, 0.2), transparent 24%),
        linear-gradient(135deg, rgba(22, 105, 170, 0.08), rgba(54, 179, 126, 0.08));
}

.rk-edit-header {
    position: relative;
    align-items: flex-start;
    padding: 28px 30px 24px;
    color: #fff;
    background: linear-gradient(135deg, #0b376d 0%, #1769aa 48%, #16a085 100%);
    box-shadow: 0 16px 34px rgba(23, 105, 170, 0.22);
}

.rk-edit-header:after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(120deg, rgba(255, 255, 255, 0.22), transparent 34%),
        radial-gradient(circle at 88% 18%, rgba(255, 214, 102, 0.28), transparent 24%);
    pointer-events: none;
}

.rk-edit-header > * {
    position: relative;
    z-index: 1;
}

.rk-edit-kicker {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 10px;
    color: rgba(255, 255, 255, 0.78);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.rk-edit-header h5 {
    margin: 0;
    color: #fff;
    font-size: 24px;
    font-weight: 800;
}

.rk-edit-header p {
    margin: 7px 0 0;
    max-width: 440px;
    color: rgba(255, 255, 255, 0.76);
    font-size: 13px;
}

.rk-edit-close {
    filter: invert(1) grayscale(1) brightness(2);
    opacity: 0.9;
}

.rk-edit-form {
    position: relative;
    z-index: 1;
    display: flex;
    min-height: calc(100% - 126px);
    flex-direction: column;
}

.rk-edit-body {
    flex: 1 1 auto;
    padding: 24px 30px;
}

.rk-edit-section {
    margin-bottom: 18px;
    padding: 18px;
    border: 1px solid rgba(23, 105, 170, 0.12);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.74);
    box-shadow: 0 14px 34px rgba(17, 55, 91, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
}

.rk-edit-section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
    color: #0b376d;
    font-size: 13px;
    font-weight: 800;
}

.rk-edit-section label {
    margin-bottom: 6px;
    color: #34455a;
    font-size: 12px;
    font-weight: 800;
}

.rk-edit-section .form-control {
    min-height: 42px;
    border: 1px solid rgba(16, 32, 51, 0.12);
    border-radius: 8px;
    background-color: rgba(248, 251, 253, 0.92);
    color: #102033;
    box-shadow: none;
}

.rk-edit-section .form-control:focus {
    border-color: rgba(23, 105, 170, 0.6);
    background-color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(23, 105, 170, 0.12);
}

.rk-edit-footer {
    position: sticky;
    bottom: 0;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 30px;
    border-top: 1px solid rgba(23, 105, 170, 0.12);
    background: rgba(255, 255, 255, 0.88);
    box-shadow: 0 -12px 28px rgba(17, 55, 91, 0.08);
    backdrop-filter: blur(12px);
}

.rk-edit-save {
    border: 0;
    color: #fff;
    background: linear-gradient(135deg, #1769aa, #16a085);
    box-shadow: 0 12px 24px rgba(23, 105, 170, 0.22);
}

.rk-edit-save:hover,
.rk-edit-save:focus {
    color: #fff;
    background: linear-gradient(135deg, #0b5d99, #128a72);
}

.hide {
    display: none !important;
}

@media (max-width: 575.98px) {
    .rk-edit-header,
    .rk-edit-body,
    .rk-edit-footer {
        padding-left: 18px;
        padding-right: 18px;
    }

    .rk-edit-section {
        padding: 15px;
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
