<div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="editModel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header py-2">
                <h5 class="modal-title fw-bold" id="addTaskModalLabel">Edit Contract </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.updateContact') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-2">
                        <!-- g-2 gives tighter gap -->
                         <input type="hidden" name="id" >



                        <div class="col-12">
                            <label for="property" class="form-label1 mb-1">Property</label>
                            <select id="property" name="property" class="form-select form-select-sm" required>
                                <option value="">Select Property</option>
                                <option value="1-Story">1-Story</option>
                                <option value="2-Story">2-Story</option>
                                <option value="3-Story">3-Story</option>
                                <option value="4-Story">4-Story</option>
                                <option value="5-Story">5-Story</option>
                                <option value="6-Story">6-Story</option>
                                <option value="7-Story">7-Story</option>
                                <option value="8-Story">8-Story</option>
                                <option value="9-Story">9-Story</option>
                                <option value="10-Story">10-Story</option>
                            </select>
                        </div>


                        <div class="col-12">
                            <label for="phase" class="form-label1 mb-1">Phase</label>
                            <select id="phase" name="phase" class="form-select form-select-sm" required>
                                <option value="">Select Phase</option>
                                <option value="Single Phase">Single Phase</option>
                                <option value="Double Phase">Double Phase</option>
                                <option value="Three Phase">Three Phase</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="switchboard" class="form-label1 mb-1">Switchboard</label>
                            <select id="switchboard" name="switchboard" class="form-select form-select-sm" required>
                                <option value="">Select Switchboard</option>
                                <option value="Old">Old</option>
                                <option value="New">New</option>

                            </select>
                        </div>

                        <div class="col-12">
                            <label for="bill_size" class="form-label1 mb-1">Bill Size</label>
                            <input type="text" id="bill_size" name="bill_size" class="form-control form-control-sm"
                                placeholder="Bill size" required>
                        </div>

                        <div class="col-12">
                            <label for="price" class="form-label1 mb-1">Price</label>
                            <input type="text" id="price" name="price" class="form-control form-control-sm"
                                placeholder="Price" required>
                        </div>

                        <div class="col-12">
                            <label for="property" class="form-label1 mb-1">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="">Select Property</option>
                                <option value="Getting Proposal Ready">Getting Proposal Ready</option>
                                <option value="Proposal Sent">Proposal Sent</option>
                                <option value="Follow Up Scheduled">Follow Up Scheduled</option>
                                <option value="Proposal Accepted">Proposal Accepted</option>
                                <option value="Lost">Lost</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>





                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm bg_s">Update Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* reduce padding globally for this modal */
#addTaskModal .form-label {
    font-size: 0.85rem;
}

#addTaskModal .form-control,
#addTaskModal .form-select,
#addTaskModal textarea {
    padding: 0.35rem 0.5rem;
}
</style>

<script>
$(document).on('click', '.edit_contract', function() {
    // get contract data
    var contractData = $(this).attr('data-contract'); // get raw string
    var contract;

    // parse JSON safely
    try {
        contract = JSON.parse(contractData);
    } catch (e) {
        console.error('Invalid JSON in data-contract:', contractData);
        return;
    }

    console.log('Contract object:', contract);

    // loop through contract object and populate fields by name
    $.each(contract, function(key, value) {
        // find input/textarea/select with name=key
        var $field = $('[name="' + key + '"]');
        if ($field.length) {
            if ($field.is('select')) {
                $field.val(value).change(); // select option and trigger change
            } else {
                $field.val(value); // input or textarea
            }
        }
    });
});
</script>