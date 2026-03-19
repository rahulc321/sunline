<div class="modal fade" id="editFriDetails" tabindex="-1" aria-labelledby="editFriDetails" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Edit RFI
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.friUpdate') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <input type="hidden" name="id" value="{{ $fri->id }}">

                    <!-- Basic Information -->
                    <div class="border rounded p-3 mb-3">
                        <h5 class="mb-3">Basic Information</h5>

                        <div class="row">

                            <!-- Leads -->
                            <div class="col-sm-6 mb-3">
                                <label>Leads</label>
                                <select name="lead_id" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}"
                                        {{ $fri->lead_id == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->first_name }} {{ $lead->last_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-sm-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($status as $value)
                                    <option value="{{ $value->name }}"
                                        {{ $fri->status == $value->name ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="col-sm-6 mb-3">
                                <label>Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($category as $value)
                                    <option value="{{ $value->name }}"
                                        {{ $fri->category == $value->name ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Priority -->
                            <div class="col-sm-6 mb-3">
                                <label>Priority</label>
                                <select name="priority" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($priority as $value)
                                    <option value="{{ $value->name }}"
                                        {{ $fri->priority == $value->name ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Due Date -->
                            <div class="col-sm-6 mb-3">
                                <label>Due Date</label>
                                <input type="date"
                                    name="due_date"
                                    class="form-control"
                                    value="{{ $fri->due_date }}"
                                    required>
                            </div>

                            <!-- Assigned Rep -->
                            <div class="col-sm-6 mb-3">
                                <label>Assigned Rep</label>
                                <select name="assigned_to" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($users as $data)
                                    <option value="{{ $data->id }}"
                                        {{ $fri->assigned_to == $data->id ? 'selected' : '' }}>
                                        {{ $data->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- RFI Details -->
                    <div class="border rounded p-3">
                        <h5 class="mb-3">RFI Details</h5>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label>Subject</label>
                            <input type="text"
                                name="subject"
                                class="form-control"
                                value="{{ $fri->subject }}"
                                required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description"
                                class="form-control"
                                rows="4"
                                required>{{ $fri->description }}</textarea>
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