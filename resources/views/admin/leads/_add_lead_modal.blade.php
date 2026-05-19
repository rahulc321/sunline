<div class="offcanvas offcanvas-end rk-lead-form-offcanvas rk-add-lead-offcanvas" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModalLabel">

            <div class="offcanvas-header rk-lead-form-header">
                <div>
                    <span class="rk-lead-form-kicker">Lead profile</span>
                    <h5 class="offcanvas-title modal-title" id="addLeadModalLabel">Add Lead</h5>
                </div>
                <button type="button" class="btn-close rk-lead-form-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <!-- Start form -->
            <form action="{{route('admin.leadStore')}}" method="post" class="rk-lead-form">
                @csrf
                <div class="offcanvas-body rk-lead-form-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-sm-6 mb-3">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="first_name" class="form-control"
                                placeholder="Enter first name" required>
                        </div>

                        <!-- Right Column -->
                        <div class="col-sm-6 mb-3">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="form-control"
                                placeholder="Enter last name" required>
                        </div>

                        <!-- Email -->
                        <div class="col-sm-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email"
                                required>
                        </div>

                        <!-- Phone -->
                        <div class="col-sm-6 mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone"
                                required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="phone">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter Address">
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="phone">Assigned Rep</label>

                            <select name="assign_rep" class="form-control">
                                <option value="">Select</option>
                                @foreach($users as $data)
                                <option value="{{@$data->id}}">{{@$data['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="phone">Lead Source</label>
                            <select name="lead_source" class="form-control">
                                <option value="">Select</option>
                                @foreach($leadSource as $data)
                                <option value="{{@$data->id}}">{{@$data['source']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-3 mb-3">
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

                        <div class="col-sm-3 mb-3">
                            <label for="phone">Eligible for Rebate</label>
                            <select name="elogible_for_rebate" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>

                            </select>
                        </div>

                        <div class="col-sm-3 mb-3">
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

                        <div class="col-sm-3 mb-3 hide solar_kw">
                            <label for="phone">Solar KW</label>
                            <input type="text" name="solar_kw" class="form-control" placeholder="Solar KW">
                        </div>

                        <div class="col-sm-3 mb-3 hide battery_kw">
                            <label for="phone">Battery KW</label>
                            <input type="text" name="battery_kw" class="form-control" placeholder="Battery KW">
                        </div>


                    </div>
                </div>

                <!-- Footer inside the form -->
                <div class="rk-lead-form-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
</div>
<style>
.hide {
    display: none !important;
}

.rk-lead-form-offcanvas {
    width: min(760px, 100vw) !important;
    overflow: hidden;
    border: 0;
    border-radius: 18px 0 0 18px;
    background:
        radial-gradient(circle at top left, rgba(20, 184, 166, .16), transparent 34%),
        radial-gradient(circle at top right, rgba(56, 168, 255, .14), transparent 30%),
        linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
    box-shadow: 0 28px 80px rgba(15, 23, 42, .28);
}

.rk-lead-form-header {
    align-items: flex-start;
    padding: 20px 22px;
    border: 0;
    background: linear-gradient(135deg, #0f172a 0%, #164e63 58%, #0f766e 100%);
    color: #fff;
}

.rk-lead-form-header .modal-title {
    margin: 0;
    color: #fff;
}

.rk-lead-form-kicker {
    display: block;
    margin-bottom: 4px;
    color: rgba(255, 255, 255, .68);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-lead-form-close {
    filter: invert(1) grayscale(1) brightness(2);
    opacity: .9;
}

.rk-lead-form {
    display: flex;
    min-height: 0;
    flex: 1 1 auto;
    flex-direction: column;
}

.rk-lead-form-body {
    flex: 1 1 auto;
    padding: 22px;
    overflow-y: auto;
}

.rk-lead-form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 22px;
    border-top: 1px solid rgba(148, 163, 184, .25);
    background: rgba(248, 250, 252, .88);
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
