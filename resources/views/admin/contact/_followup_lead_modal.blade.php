<div class="offcanvas offcanvas-end rk-contact-offcanvas" id="fUP" tabindex="-1" aria-labelledby="followUpManagementLabel">

                <!-- Header -->
                <div class="offcanvas-header rk-contact-offcanvas-header">
                    <div>
                        <span class="rk-contact-offcanvas-kicker">Contact activity</span>
                        <h5 class="offcanvas-title modal-title fw-bold" id="followUpManagementLabel">
                            <span class="leadName"></span> - Follow-ups
                        </h5>
                    </div>
                    <button type="button" class="btn-close rk-contact-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <form id="followUpForm" action="{{route('admin.leadFollowUps')}}" method="post" class="rk-contact-offcanvas-form">
                    @csrf
                    <!-- ✅ single form -->
                    <div class="offcanvas-body rk-contact-offcanvas-body">
                        <h6 class="fw-bold mb-3">Follow-up Management</h6>
                        <input type="hidden" name="lead_id" class="lead_id">
                        <input type="hidden" name="ftype" value="contact">

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
                    <div class="rk-contact-offcanvas-footer">
                        <button type="submit" class="btn btn-primary bg_s">Save Follow-up</button>
                        <button type="button" class="btn btn-secondary bg_s" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
                <hr>
                <div id="followUpResult" class="px-3 pb-3"></div>
    </div>
    <script>
    $(document).on('click', '.follow_up', function() {
        let cont = $(this).data('contract'); // get lead id from button
        $.ajax({
            url: "/admin/contactFollowUp/" + cont.id,
            type: "GET",
            success: function (res) {
                 
                $("#followUpResult").html(res.html);
            }
        });
    });

    $(document).on('click', '.mark_complete', function() {
    let followUpId = $(this).data('id');

    if (!confirm("Are you sure you want to mark this follow-up as complete?")) {
        return;
    }

    $.ajax({
            url: "{{ route('admin.followupComplete') }}", // create this route
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: followUpId,
                c_type:"fup",
            },
            success: function(res) {
                if (res.success) {
                    // update UI (for example change button to Completed)
                    $(`button.mark_complete[data-id="${followUpId}"]`)
                        .replaceWith('<span class="badge bg-success">Completed</span>');
                } else {
                    alert("Something went wrong.");
                }
            },
            error: function() {
                alert("Server error, please try again.");
            }
        });
    });
    </script>
