<div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="editModel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header py-2">
                <h5 class="modal-title fw-bold" id="addTaskModalLabel">Edit Ticket </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.ticket.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="row g-2">
                        <!-- g-2 gives tighter gap -->



                        <div class="col-12">
                            <label for="subject" class="form-label1 mb-1">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control form-control-sm"
                                required placeholder="Brief description of the issue">
                        </div>


                        <div class="col-12">
                            <label for="category" class="form-label1 mb-1">Category</label>
                            <select id="category" name="category" class="form-select form-select-sm" required>
                                option value="">Select category</option>
                                <option value="Pricing/Quote">Pricing/Quote</option>
                                <option value="Product Question">Product Question</option>
                                <option value="Technical Issue">Technical Issue</option>
                                <option value="Scheduling">Scheduling</option>
                                <option value="Commission">Commission</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="urgency_label" class="form-label1 mb-1">Urgency Lebel</label>
                            <select id="urgency_label" name="urgency_label" class="form-select form-select-sm" required>
                                 
                                <option value="Low">Low - General inquiry</option>
                                <option value="Medium">Medium - Needs response within 24h</option>
                                <option value="High">High - Urgent customer issue</option>
                                 
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="assign_to" class="form-label1 mb-1">Assigned Rep</label>
                            <select id="assign_to" name="assign_to" class="form-select form-select-sm" required>
                                <option value="">Select rep</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-12">
                            <label for="description" class="form-label1 mb-1">Detailed Description</label>
                            <textarea id="description" name="description" class="form-control form-control-sm"
                                rows="4" placeholder="Provide detailed information about the issue, including customer details if relevant..." required></textarea>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm bg_s">Update Ticket</button>
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