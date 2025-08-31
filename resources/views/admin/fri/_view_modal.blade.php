<div class="modal fade" id="rfiDetails" tabindex="-1" aria-labelledby="rfiDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header border-0">
                <div class="w-100 d-flex justify-content-between align-items-start">
                    <input type="hidden" class="fri_id1" name="fri_id">
                    <input type="hidden" class="fri_data" name="fri_data">
                    <!-- LEFT: Title + Badges + Meta -->
                    <div>
                        <!-- Title -->
                        <h5 class="modal-title fw-bold mb-2" id="rfiDetailsLabel">
                            <i class="bi bi-file-earmark-text me-1"></i>
                            RFI-<span class="fri_id"></span>
                        </h5>

                        <!-- Badges -->
                        <div class="d-flex flex-wrap gap-2 mb-3" id="fri_badges"></div>

                        <!-- Meta Info -->
                        <div class="row g-2">
                            <div class="col-md-6 d-flex align-items-center">
                                <i class="bi bi-diagram-3 me-2"></i>
                                <span><strong>Lead:</strong> <span id="lead_id"> </span></span>
                            </div>
                            <!-- <div class="col-md-6 d-flex align-items-center">
                                <i class="bi bi-person me-2"></i>
                                <span><strong>Client:</strong> <span id="client">Sarah Henderson</span></span>
                            </div> -->
                            <div class="col-md-6 d-flex align-items-center">
                                <i class="bi bi-person-badge me-2"></i>
                                <span><strong>Created By:</strong> <span class="created_by"></span></span>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <i class="bi bi-calendar-event me-2"></i>
                                <span><strong>Due:</strong> <span class="text-danger due_date">2025-08-15</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Actions -->
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm editFri" data-bs-toggle="modal"
                            data-bs-target="#editFriDetails">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>


                        <select class="form-select fri_status">
                            <option value="">Select</option>
                            @foreach($status as $value)
                            <option value="{{$value->name}}">{{$value->name}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <!-- Close Button -->
                <button type="button" class="btn-close ms-3" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body border-top">
                <div class="row">

                    <!-- LEFT PANEL -->
                    <div class="col-md-12">

                        <!-- Description -->
                        <div class="border rounded p-3 mb-3">
                            <strong>Description</strong>
                            <p class="text-muted mb-0 description">
                                Need structural engineer report for tile roof installation.
                            </p>
                        </div>

                        <!-- Attachments -->
                        <div class="border rounded p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Attachments (3)</strong>
                                <button class="btn btn-sm btn-outline-primary">+ Add Files</button>
                            </div>
                            <ul class="list-unstyled mt-2 mb-0">
                                <li><a href="#">site_photos.zip</a></li>
                                <li><a href="#">roof_layout.pdf</a></li>
                                <li><a href="#">specifications.docx</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- RIGHT PANEL -->
                    <div class="col-md-6 d-none">
                        <div class="border rounded p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Responses (2)</strong>
                                <button class="btn btn-sm btn-outline-primary">+ Add Response</button>
                            </div>

                            <!-- Response Item -->
                            <div class="border rounded p-2 mb-2">
                                <p class="mb-1"><strong>John Smith</strong> <small class="text-muted">15 Aug
                                        2025</small></p>
                                <p class="text-muted small mb-0">
                                    I've reviewed the roof structure and we'll need a structural engineer’s assessment
                                    before proceeding.
                                </p>
                            </div>

                            <!-- Response Item -->
                            <div class="border rounded p-2">
                                <p class="mb-1"><strong>Sarah Miller (Structural Engineer)</strong> <small
                                        class="text-muted">16 Aug 2025</small></p>
                                <p class="text-muted small mb-1">
                                    Structural assessment completed. The existing roof structure can support the
                                    proposed 8kW solar...
                                </p>
                                <a href="#">assessment_report.pdf</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>