<div class="offcanvas offcanvas-end rk-contact-offcanvas" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModalLabel">

                <div class="offcanvas-header rk-contact-offcanvas-header">
                    <div>
                        <span class="rk-contact-offcanvas-kicker">Contact pipeline</span>
                        <h5 class="offcanvas-title modal-title" id="addLeadModalLabel">Add Lead</h5>
                    </div>
                    <button type="button" class="btn-close rk-contact-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!-- Start form -->
                <form action="{{route('admin.leadStore')}}" method="post" class="rk-contact-offcanvas-form">
                    @csrf
                    <div class="offcanvas-body rk-contact-offcanvas-body">
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
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Enter email" required>
                            </div>

                            <!-- Phone -->
                            <div class="col-sm-6 mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="Enter phone" required>
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


                        </div>
                    </div>

                    <!-- Footer inside the form -->
                    <div class="rk-contact-offcanvas-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
    </div>
<style>
.rk-contact-offcanvas {
    width: min(820px, 100vw) !important;
    overflow: hidden;
    border: 0;
    border-radius: 18px 0 0 18px;
    background:
        radial-gradient(circle at top left, rgba(20, 184, 166, .16), transparent 34%),
        radial-gradient(circle at top right, rgba(56, 168, 255, .14), transparent 30%),
        linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
    box-shadow: 0 28px 80px rgba(15, 23, 42, .28);
}

.rk-contact-offcanvas-header {
    align-items: flex-start;
    padding: 20px 22px;
    border: 0;
    background: linear-gradient(135deg, #0f172a 0%, #164e63 58%, #0f766e 100%);
    color: #fff;
}

.rk-contact-offcanvas-header .modal-title {
    margin: 0;
    color: #fff;
}

.rk-contact-offcanvas-kicker {
    display: block;
    margin-bottom: 4px;
    color: rgba(255, 255, 255, .68);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-contact-offcanvas-close {
    filter: invert(1) grayscale(1) brightness(2);
    opacity: .9;
}

.rk-contact-offcanvas-form {
    display: flex;
    min-height: 0;
    flex: 1 1 auto;
    flex-direction: column;
}

.rk-contact-offcanvas-body {
    flex: 1 1 auto;
    padding: 22px;
    overflow-y: auto;
}

.rk-contact-offcanvas-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 22px;
    border-top: 1px solid rgba(148, 163, 184, .25);
    background: rgba(248, 250, 252, .88);
}
</style>
