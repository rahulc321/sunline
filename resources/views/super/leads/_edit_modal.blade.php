<div class="modal fade" id="editlead" tabindex="-1" aria-labelledby="editlead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="popupFormLabel">Edit Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Start form -->
            <form action="{{route('admin.updateStore')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bg_s" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary bg_s">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).on("click", ".edit_lead", function() {
    let lead = $(this).data("lead");

    // parse if JSON string
    if (typeof lead == "string") {
        lead = JSON.parse(lead);
    }

    // fill inputs
    $("input[name='id']").val(lead.id || "");
    $("input[name='first_name']").val(lead.first_name || "");
    $("input[name='last_name']").val(lead.last_name || "");
    $("input[name='email']").val(lead.email || "");
    $("input[name='phone']").val(lead.phone || "");
    $("input[name='address']").val(lead.address || "");

    // select values
    $("select[name='assign_rep']").val(lead.get_assign_user_name?.id || "").trigger("change");
    $("select[name='lead_source']").val(lead.lead_source?.id || "").trigger("change");
    $("select[name='roof_type']").val(lead.roof_type || "").trigger("change");
    $("select[name='elogible_for_rebate']").val(lead.elogible_for_rebate || "No").trigger("change");

    // category logic
    let category = lead.category || "";
    $("select[name='category']").val(category);

    // wait for DOM update, then trigger change to show/hide solar_kw / battery_kw
    setTimeout(() => {
        $("select[name='category']").trigger("change");
    }, 100);

    // fill kw fields if present
    $("input[name='solar_kw']").val(lead.solar_kw || "");
    $("input[name='battery_kw']").val(lead.battery_kw || "");
});
</script>

<style>
.hide {
    display: none !important;
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