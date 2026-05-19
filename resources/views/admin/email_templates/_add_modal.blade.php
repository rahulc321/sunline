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
                        <label>Template Name</label>
                        <input type="text" name="template_name" class="form-control" placeholder="Enter Template Name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="subject" class="form-control" placeholder="Enter subject" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-outline-primary insert-tag"
                                data-tag="{name}">Name</button>
                            <button type="button" class="btn btn-sm btn-outline-primary insert-tag"
                                data-tag="{phone}">Phone</button>
                            <button type="button" class="btn btn-sm btn-outline-primary insert-tag"
                                data-tag="{email}">Email</button>
                            <button type="button" class="btn btn-sm btn-outline-primary insert-tag"
                                data-tag="{link}">Link</button>
                            <button type="button" class="btn btn-sm btn-outline-primary insert-tag"
                                data-tag="{address}">Address</button>
                            <button type="button" class="btn btn-sm btn-outline-primary insert-tag"
                                data-tag="{owner}">Owner</button>
                        </div>
                        <textarea name="body" id="editorBody" class="form-control editorBody" rows="5"
                            placeholder="Enter description"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label>Category</label>
                            <select name="category" class="form-select" required>
                                @foreach($category as $value)
                                <option value="{{ $value->name }}">{{ $value->name }}</option>
                                @endforeach
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

                        <div class="col-sm-6 mb-3">
                            <label>Lead Status<small style="color: red;"> ( For individual email templates, please leave
                                    this empty )</small></label>
                            <?php $status = config('fri.lead_status'); ?>
                            <select class="form-select lead_status" name="lead_status">
                                <option value="">Select</option>
                                @foreach($status as $value)
                                <option value="{{ $value }}">{{ $value }}</option>
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


<style>
/* make sure CKEditor dialogs stay above Bootstrap modal */
.cke_dialog {
    z-index: 20000 !important;
}

.cke {
    z-index: 15000 !important;
}
</style>