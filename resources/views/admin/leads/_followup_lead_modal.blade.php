<div class="offcanvas offcanvas-end rk-lead-form-offcanvas" id="createFollowUpModal" tabindex="-1" aria-labelledby="followUpManagementLabel">

                <!-- Header -->
                <div class="offcanvas-header rk-lead-form-header">
                    <div>
                        <span class="rk-lead-form-kicker">Lead activity</span>
                        <h5 class="offcanvas-title modal-title fw-bold" id="followUpManagementLabel">
                            <span class="leadName"></span> - Follow-ups
                        </h5>
                    </div>
                    <button type="button" class="btn-close rk-lead-form-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <form id="followUpForm" action="{{route('admin.leadFollowUps')}}" method="post" class="rk-lead-form">
                    @csrf
                    <!-- ✅ single form -->
                    <div class="offcanvas-body rk-lead-form-body">
                        <h6 class="fw-bold mb-3">Follow-up Management</h6>
                        <input type="hidden" name="lead_id" class="lead_id">

                        <!-- New Follow-up -->
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">New Follow-up</h6>
                                <div class="row g-3">
                                    <!-- Type -->
                                    <div class="col-md-6">
                                        <label for="followUpType"  >Type</label>
                                        <select class="form-select" id="followUpType" name="type" required>
                                            <option value="">Select type</option>
                                            <option value="call">Call</option>
                                            <option value="meeting">Meeting</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </div>

                                    <!-- Date -->
                                    <div class="col-md-6">
                                        <label for="followUpDate"  >Date</label>
                                        <input type="date" class="form-control" id="followUpDate" name="date" required>
                                    </div>

                                    <!-- Time -->
                                    <div class="col-md-6">
                                        <label for="followUpTime"  >Time</label>
                                        <input type="time" class="form-control" id="followUpTime" name="time" required>
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-12">
                                        <label for="followUpNotes"  >Notes</label>
                                        <textarea class="form-control" id="followUpNotes" name="notes" rows="3"
                                            placeholder="Add notes for this follow-up..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="rk-lead-form-footer">
                        <button type="submit" class="btn btn-primary bg_s">Save Follow-up</button>
                        <button type="button" class="btn btn-secondary bg_s" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>

    </div>
