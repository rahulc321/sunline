<!-- Modal -->
<div class="modal fade" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addLeadModalLabel">
                    Create New Email Template
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.emailTemplate.store') }}" method="post">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="body" id="editorBody" class="form-control" rows="5" placeholder="Enter description"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label>Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Welcome">Welcome</option>
                                <option value="Follow-up">Follow-up</option>
                                <option value="Proposal">Proposal</option>
                                <option value="Thank You">Thank You</option>
                            </select>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Active">Active</option>
                                <option value="Draft">Draft</option>
                                <option value="Archived">Archived</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('styles')
<style>
    /* make sure CKEditor dialogs stay above Bootstrap modal */
    .cke_dialog { z-index: 20000 !important; }
    .cke { z-index: 15000 !important; }
</style>
@endpush

@push('scripts')

@endpush
