<div class="modal fade" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="popupFormLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-file-text h-6 w-6">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                        <path d="M10 9H8"></path>
                        <path d="M16 13H8"></path>
                        <path d="M16 17H8"></path>
                    </svg>
                    &nbsp;Create New RFI
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Start form -->
            <form action="{{ route('admin.fri.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <!-- Basic Information -->
                    <div class="border rounded p-3 mb-3">
                        <h5 class="mb-3">Basic Information</h5>
                        <div class="row">
                            <!-- Project -->
                            <div class="col-sm-6 mb-3">
                                <label>Project</label>
                                <select name="project" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Project 1">Project 1</option>
                                    <option value="Project 2">Project 2</option>
                                </select>
                            </div>

                            <!-- Client -->
                            <div class="col-sm-6 mb-3">
                                <label>Client</label>
                                <select name="client" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Client 1">Client 1</option>
                                    <option value="Client 2">Client 2</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($status as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="col-sm-6 mb-3">
                                <label>Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($category as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Priority -->
                            <div class="col-sm-6 mb-3">
                                <label>Priority</label>
                                <select name="priority" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($priority as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Due Date -->
                            <div class="col-sm-6 mb-3">
                                <label>Due Date</label>
                                <input type="date" name="due_date" class="form-control" required>
                            </div>

                            <!-- Assigned Rep -->
                            <div class="col-sm-6 mb-3">
                                <label>Assigned Rep</label>
                                <select name="assigned_to" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($users as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                            <label for="rfiSubject"  >Subject  </label>
                            <input type="text" name="subject" id="rfiSubject" class="form-control"
                                placeholder="Enter RFI subject..." required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="rfiDescription"  >Description  </label>
                            <textarea name="description" id="rfiDescription" class="form-control" rows="4"
                                placeholder="Provide detailed description of the information request..."
                                required></textarea>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-3">
                            <label  >Attachments</label>
                            <input type="file" name="attachments[]" class="form-control" multiple>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary bs_s">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>