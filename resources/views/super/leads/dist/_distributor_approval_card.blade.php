<div class="rk-dist-approval-card">
    <div class="rk-dist-approval-header">
        <div>
            <h4 class="rk-dist-approval-title">Distributor Approval - Job #{{ $lead->id }}</h4>
            <p class="rk-dist-approval-subtitle">{{ trim(($lead->first_name ?? '').' '.($lead->last_name ?? '')) ?: 'Customer' }}</p>
        </div>
    </div>

    <div class="rk-dist-approval-steps">
        <button type="button"
            class="rk-dist-step {{ $defaultApprovalPane === 'apply' ? 'active' : '' }} {{ $canApplyApproval ? '' : 'disabled' }}"
            data-target="apply" {{ $canApplyApproval ? '' : 'disabled' }}>Apply</button>
        <button type="button"
            class="rk-dist-step {{ $defaultApprovalPane === 'upload' ? 'active' : '' }} {{ $canUploadApproval ? '' : 'disabled' }}"
            data-target="upload" {{ $canUploadApproval ? '' : 'disabled' }}>Upload Approval</button>
    </div>

    <div class="rk-dist-approval-body">
        <div class="rk-dist-pane {{ $defaultApprovalPane === 'apply' ? 'active' : '' }}" data-pane="apply">
            <div class="rk-dist-approval-info">
                <div class="rk-dist-approval-icon">i</div>
                <div>
                    <h5>Apply for Distributor Approval</h5>
                    <p>Complete this form to check if distributor approval is required and gather necessary information.</p>
                </div>
            </div>

            <form class="rk-dist-approval-form" onsubmit="return false;">
                <div class="rk-dist-form-grid">
                    <div class="rk-dist-field rk-dist-field-compact">
                        <label for="approvalRequired">Is Distributor Approval Required?</label>
                        <select id="approvalRequired" class="form-select">
                            <option value="Yes" {{ $approvalRequiredValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $approvalRequiredValue === 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="rk-dist-field rk-dist-field-compact" id="distributorField">
                        <label for="distributorName">Who is the Distributor?</label>
                        <select id="distributorName" class="form-select">
                            <option value="" disabled {{ $distributorNameValue === '' ? 'selected' : '' }}>Select distributor</option>
                            <option value="Origin Energy" {{ $distributorNameValue === 'Origin Energy' ? 'selected' : '' }}>Origin Energy</option>
                            <option value="AGL" {{ $distributorNameValue === 'AGL' ? 'selected' : '' }}>AGL</option>
                            <option value="EnergyAustralia" {{ $distributorNameValue === 'EnergyAustralia' ? 'selected' : '' }}>EnergyAustralia</option>
                        </select>
                    </div>

                    <div class="rk-dist-field rk-dist-field-compact">
                        <label for="existingSystem">Does Customer Have an Existing System?</label>
                        <select id="existingSystem" class="form-select">
                            <option value="" disabled {{ $existingSystemValue === '' ? 'selected' : '' }}>Select Yes or No</option>
                            <option value="Yes" {{ $existingSystemValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $existingSystemValue === 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <div id="distributorDetailsPanel" class="rk-dist-detail-panel"
                    style="{{ $approvalRequiredValue === 'Yes' && $distributorNameValue !== '' ? '' : 'display: none;' }}">
                    <div class="rk-dist-detail-header">
                        <h6>Distributor Details</h6>
                        <p>Capture the key site details in a cleaner premium card layout.</p>
                    </div>

                    <div class="rk-dist-detail-grid">
                        <div class="rk-dist-field rk-dist-field-card">
                            <label for="meterNumber">Meter Number</label>
                            <input type="text" id="meterNumber" class="form-control" placeholder="Enter meter number" value="{{ $meterNumberValue }}">
                        </div>

                        <div class="rk-dist-field rk-dist-field-card">
                            <label for="nmiNumber">NMI Number</label>
                            <input type="text" id="nmiNumber" class="form-control" placeholder="Enter NMI number" value="{{ $nmiNumberValue }}">
                        </div>

                        <div class="rk-dist-field rk-dist-field-card">
                            <label for="photosRequired">Are Photos Required?</label>
                            <select id="photosRequired" class="form-select">
                                <option value="" disabled {{ $photosRequiredValue === '' ? 'selected' : '' }}>Select Yes or No</option>
                                <option value="Yes" {{ $photosRequiredValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $photosRequiredValue === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <button type="button" id="applyApprovalBtn" class="rk-dist-approve-btn"
                {{ $canApplyApproval ? '' : 'disabled' }}>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 12 2 2 4-4"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                </svg>
                Mark as Approved & Move to Solar VIC Rebate
            </button>
        </div>

        <div class="rk-dist-pane {{ $defaultApprovalPane === 'upload' ? 'active' : '' }}" data-pane="upload">
            <div class="rk-dist-approval-info">
                <div class="rk-dist-approval-icon">i</div>
                <div>
                    <h5>Upload Distributor Approval</h5>
                    <p>Once you receive approval from the distributor, upload the approval document here.</p>
                </div>
            </div>

            <div class="rk-dist-upload-box">
                <input type="file" id="approvalFileInput" class="d-none" accept=".pdf,.png,.jpg,.jpeg"
                    {{ $canUploadApproval ? '' : 'disabled' }}>
                <div class="rk-dist-upload-dropzone">
                    <div class="rk-dist-upload-graphic">
                        <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 16V4"></path>
                            <path d="m7 9 5-5 5 5"></path>
                            <path d="M20 16.5V19a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2.5"></path>
                        </svg>
                    </div>
                    <h6>Upload Approval Document</h6>
                    <p>PDF, PNG, JPG up to 10MB</p>
                    <button type="button" id="chooseApprovalFileBtn" class="rk-dist-upload-trigger"
                        {{ $canUploadApproval ? '' : 'disabled' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 16V4"></path>
                            <path d="m7 9 5-5 5 5"></path>
                            <path d="M20 16.5V19a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2.5"></path>
                        </svg>
                        Choose File
                    </button>
                    <div id="approvalFileName" class="rk-dist-upload-name">{{ $approvalFileName }}</div>
                    @if($approvalFileUrl)
                    <a href="{{ $approvalFileUrl }}" target="_blank" class="rk-approval-file-link">View saved approval file</a>
                    @endif
                </div>
                <button type="button" id="uploadApprovalBtn" class="rk-dist-approve-btn"
                    {{ $canUploadApproval ? '' : 'disabled' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 12 2 2 4-4"></path>
                        <circle cx="12" cy="12" r="9"></circle>
                    </svg>
                    Mark as Approved & Move to Solar VIC Rebate
                </button>
            </div>
        </div>
    </div>
</div>
