@extends('layouts.super')

@section('title', 'Leads')

@section('content')

@php


$lead->status = $lead->status == 'Sold' ? 'Not Applied' : $lead->status;

// example — replace with your real status
$currentStatus = $lead->status ?? 'New';
$approvalRequiredValue = $leadMeta['distributor_approval_required'] ?? 'Yes';
$distributorNameValue = $leadMeta['distributor_name'] ?? '';
$existingSystemValue = $leadMeta['existing_system'] ?? '';
$meterNumberValue = $leadMeta['meter_number'] ?? '';
$nmiNumberValue = $leadMeta['nmi_number'] ?? '';
$photosRequiredValue = $leadMeta['photos_required'] ?? '';
$approvalFileUrl = $leadMeta['distributor_approval_file'] ?? '';
$approvalFileName = $approvalFileUrl ? basename(parse_url($approvalFileUrl, PHP_URL_PATH)) : 'No file selected';
$hasPreviousDistributorData = $approvalRequiredValue !== '' || $distributorNameValue !== '' || $existingSystemValue !== '' || $meterNumberValue !== '' || $nmiNumberValue !== '' || $photosRequiredValue !== '' || $approvalFileUrl !== '';
$complianceJobTypeValue = $leadMeta['compliance_job_type'] ?? ($lead->category === 'Solar+Battery' ? 'Solar + Battery' : ($lead->category === 'Battery' ? 'Battery Only' : 'Solar Only'));
$complianceBillCopyValue = $leadMeta['compliance_bill_copy_received'] ?? '';
$compliancePhaseTypeValue = $leadMeta['compliance_phase_type'] ?? '';
$complianceCouplingTypeValue = $leadMeta['compliance_coupling_type'] ?? '';
$complianceBatteryAccessValue = $leadMeta['compliance_battery_access_photo'] ?? '';
$compliancePivotSlabValue = $leadMeta['compliance_pivot_slab_required'] ?? '';
$complianceBatteryInstallValue = $leadMeta['compliance_battery_install_photo'] ?? '';
$complianceBackupValue = $leadMeta['compliance_backup_requirement'] ?? '';
$compliancePlanViewValue = $leadMeta['compliance_plan_view_photo'] ?? '';
$complianceStoreyValue = $leadMeta['compliance_storey_type'] ?? '';
$complianceNotesValue = $leadMeta['compliance_notes'] ?? '';
$complianceRfiMessageValue = $leadMeta['compliance_rfi_message'] ?? '';
$complianceDocumentIds = json_decode($leadMeta['compliance_document_ids'] ?? '[]', true);
$complianceDocumentIds = is_array($complianceDocumentIds) ? $complianceDocumentIds : [];
$complianceDocuments = $lead->images->whereIn('id', $complianceDocumentIds);
$hasComplianceData = $complianceJobTypeValue !== '' || $complianceBillCopyValue !== '' || $compliancePhaseTypeValue !== '' || $complianceCouplingTypeValue !== '' || $complianceBatteryAccessValue !== '' || $compliancePivotSlabValue !== '' || $complianceBatteryInstallValue !== '' || $complianceBackupValue !== '' || $compliancePlanViewValue !== '' || $complianceStoreyValue !== '' || $complianceNotesValue !== '' || $complianceRfiMessageValue !== '';
$vicWorkflowStatuses = [
    'BOOK INSTALLATION' => 'Book Installation',
    'INSTALLATION BOOKED' => 'Installation Booked',
    'STOCK ORDERING' => 'Stock Ordering',
];

if (!empty($lead->status) && !array_key_exists($lead->status, $vicWorkflowStatuses)) {
    $vicWorkflowStatuses[$lead->status] = ucwords(strtolower(str_replace('_', ' ', $lead->status)));
}

$currentVicWorkflowStatus = !empty($lead->status)
    ? $lead->status
    : 'BOOK INSTALLATION';
$activeVicPane = 'checklist';
@endphp

@php
$stages = $vicWorkflowStatuses;

@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <h3 class="rk-overview-title">Overview #{{$lead->id}}</h3>
        <div class="rk-action-tabs">

            @can('lead_email_access')
            <button class="btn btn-outline-primary send_email_inner" data-bs-toggle="modal"
                data-bs-target="#emailModel"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-mail h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:226:14" data-lov-name="Mail"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="226"
                    data-component-file="LeadDetailModal.tsx" data-component-name="Mail"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg> Send Email</button>

            @endcan

            @can('lead_call_log')
            <button class="btn btn-outline-warning view-lead" data-bs-toggle="modal" data-bs-target="#leadDetailsModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-phone h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:238:14" data-lov-name="Phone"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="238"
                    data-component-file="LeadDetailModal.tsx" data-component-name="Phone"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                    </path>
                </svg> Log Call</button>
            @endcan
            @can('lead_generate_quote')
            @if(!$lead->project_id)
            <button class="btn btn-outline-success generateQuote"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:245:14" data-lov-name="FileText"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="245"
                    data-component-file="LeadDetailModal.tsx" data-component-name="FileText"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                    <path d="M10 9H8"></path>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                </svg> Generate Quote</button>
            @endif
            @endcan
            <button data-lead='@json($lead)' class="btn btn-outline-danger edit_lead"
                data-bs-toggle="modal" data-bs-target="#editlead">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-file-text h-4 w-4 mr-2"
                    data-lov-id="src/components/leads/LeadDetailModal.tsx:245:14" data-lov-name="FileText"
                    data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="245"
                    data-component-file="LeadDetailModal.tsx" data-component-name="FileText"
                    data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                    <path d="M10 9H8"></path>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                </svg>Edit Lead</button>

            <button type="button" class="btn btn-outline-primary vic-workflow-trigger"
                data-bs-toggle="modal" data-bs-target="#vicWorkflowModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-git-branch h-4 w-4 mr-2">
                    <path d="M6 3v12"></path>
                    <path d="M18 9a3 3 0 1 0-3-3"></path>
                    <path d="M6 15a3 3 0 1 0 3 3"></path>
                    <path d="M18 6V5"></path>
                    <path d="M6 15c0-3 2-5 5-5h7"></path>
                </svg>Move Step</button>

            <!-- <div class="rk-action-tab">
                <a href="javascript:;" class="edit_lead" data-lead='@json($lead)' data-bs-toggle="modal"
                    data-bs-target="#editlead">Edit Lead</a>
            </div> -->

            <!-- <div class="rk-action-tab">
                <a href="javascript:;" class="edit_lead" data-lead='@json($lead)' data-bs-toggle="modal"
                    data-bs-target="#editlead">Generate Quote</a>
            </div> -->
        </div>
    </div>

    <!-- lifecycle -->
    <div class="rk-lifecycle-box">
        <div class="rk-lifecycle-top">
            <span class="rk-lifecycle-label">Life-cycle stage</span>
            <span class="rk-lifecycle-value">{{ $vicWorkflowStatuses[$currentVicWorkflowStatus] ?? $currentStatus }} ▼</span>
        </div>

        <!-- ✅ HUBSPOT PIPELINE -->
        <div class="rk-pipeline">
            @foreach($stages as $stageValue => $stageLabel)
            <div class="rk-stage {{ $currentVicWorkflowStatus == $stageValue ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stageValue }}')">
                {{ $stageLabel }}
            </div>
            @endforeach
            <form id="statusForm" method="POST" action="{{ route('superadmin.updateLeadStatusNew') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $lead->id }}">
                <input type="hidden" name="status" id="statusInput">
            </form>
        </div>
    </div>

    <!-- body -->
    <div class="rk-overview-body rk-overview-body-comp">

        <div class="rk-column-stack rk-column-stack-full">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="rk-summary-card h-100">
                <div class="rk-summary-header">
                    <strong>Summary</strong>

                </div>

                <div class="rk-summary-content">
                    <div class="rk-summary-row">
                        <div>
                            <label>Name</label>
                            <p>{{ $lead->first_name.' '.$lead->last_name}}</p>
                        </div>


                        <div>
                            <label>Email</label>
                            <p>{{ $lead->email ?? '—' }}</p>
                        </div>

                        <div>
                            <label>Mobile</label>
                            <p>{{ $lead->phone ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Address</label>
                            <p>{{ trim(implode(', ', array_filter([
    					$lead->address,
    					$lead->suburb,
    					$lead->state ? $lead->state . ' ' . $lead->postcode : $lead->postcode,
    				]))); }}</p>
                        </div>


                        <div>
                            <label>Roof Type</label>
                            <p>{{ $lead->roof_type ?? '-' }}</p>
                            <!-- <p class="rk-link">Click to add</p> -->
                        </div>

                        <div>
                            <label>Eligible for Rebate</label>
                            <p>{{ $lead->elogible_for_rebate ?? '-' }}</p>
                            <!-- <p class="rk-link">Click to add</p> -->
                        </div>

                        <div>
                            <label>Source</label>
                            <p>{{ $lead->leadSource->source ?? '-' }}</p>
                        </div>

                        <div>
                            <label>Category</label>
                            <?php
                            $html = '<strong class="text-dark">'.($lead->category ?? '').'</strong>';
    			
                            // Solar KW condition
                            if (
                                in_array($lead->category, ['Solar', 'Solar+Battery']) &&
                                !empty($lead->solar_kw)
                            ) {
                                $html .= ' &nbsp;|&nbsp; Solar KW: 
                                    <strong class="text-dark">'.$lead->solar_kw.'</strong>';
                            }
                        
                            // Battery KW condition
                            if (
                                in_array($lead->category, ['Battery', 'Solar+Battery']) &&
                                !empty($lead->battery_kw)
                            ) {
                                $html .= ' &nbsp;|&nbsp; Battery KW: 
                                    <strong class="text-dark">'.$lead->battery_kw.'</strong>';
                            }

                            ?>
                            <p>{!! $html ?? '-' !!}</p>
                        </div>


                        <div>
                            <label>Rejection Url</label>

                            @if(!empty($lead->rejection_url))
                            <a href="{{ $lead->rejection_url }}" target="_blank" onclick="return confirm('Are you sure?');">
                                <p class="rk-link" style="color:red">Rejection Url</p>
                            </a>
                            @else
                            <p class="text-muted">—</p>
                            @endif
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Sales owner</label>
                            <p>{{ $lead->getAssignUserName->name ?? 'Not Assign Yet' }}</p>
                        </div>

                        <div>
                            <label>Created At</label>
                            <p>{{ $lead->created_at}}</p>
                        </div>
                    </div>


                </div>
                    </div>
                </div>

                @if($hasPreviousDistributorData)
                <div class="col-sm-6">
                    <div class="rk-summary-card h-100">
                <div class="rk-summary-header">
                    <strong>Distributor Details</strong>
                </div>

                <div class="rk-summary-content">
                    <div class="rk-summary-row">
                        <div>
                            <label>Approval Required</label>
                            <p>{{ $approvalRequiredValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Distributor</label>
                            <p>{{ $distributorNameValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Existing System</label>
                            <p>{{ $existingSystemValue ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Meter Number</label>
                            <p>{{ $meterNumberValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>NMI Number</label>
                            <p>{{ $nmiNumberValue ?: '-' }}</p>
                        </div>

                        <!-- <div>
                            <label>Photos Required</label>
                            <p>{{ $photosRequiredValue ?: '-' }}</p>
                        </div> -->
                    </div>

                    <div class="rk-summary-row">
                        <!-- <div>
                            <label>Distributor Step</label>
                            <p>Applied</p>
                        </div> -->

                        <div>
                            <label>Approval File</label>
                            @if($approvalFileUrl)
                            <a href="{{ $approvalFileUrl }}" target="_blank" class="rk-link">{{ $approvalFileName }}</a>
                            @else
                            <p>—</p>
                            @endif
                        </div>
                    </div>

                </div>
                    </div>
                </div>
                @endif

                @if($hasComplianceData)
                <div class="col-sm-6">
                    <div class="rk-summary-card h-100">
                <div class="rk-summary-header">
                    <strong>Compliance Details</strong>
                </div>

                <div class="rk-summary-content">
                    <div class="rk-summary-row">
                        <div>
                            <label>Job Type</label>
                            <p>{{ $complianceJobTypeValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Bill Copy / NMI Received</label>
                            <p>{{ $complianceBillCopyValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Phase Type</label>
                            <p>{{ $compliancePhaseTypeValue ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Coupling Type</label>
                            <p>{{ $complianceCouplingTypeValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Battery Access Photo</label>
                            <p>{{ $complianceBatteryAccessValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Pivot Slab Required</label>
                            <p>{{ $compliancePivotSlabValue ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Battery Install Photo</label>
                            <p>{{ $complianceBatteryInstallValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Backup Requirement</label>
                            <p>{{ $complianceBackupValue ?: '-' }}</p>
                        </div>

                        <div>
                            <label>Plan View Photo</label>
                            <p>{{ $compliancePlanViewValue ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div>
                            <label>Storey Type</label>
                            <p>{{ $complianceStoreyValue ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div style="width: 100%;">
                            <label>Compliance Notes</label>
                            <p>{{ $complianceNotesValue ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="rk-summary-row">
                        <div style="width: 100%;">
                            <label>RFI Message</label>
                            <p>{{ $complianceRfiMessageValue ?: '-' }}</p>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
                @endif

                @if($complianceDocuments->count())
                <div class="col-sm-6">
                    <div class="rk-summary-card h-100">
                <div class="rk-summary-header">
                    <strong>Compliance Documents</strong>
                </div>

                <div class="rk-summary-content">
                    <ul class="rk-attach-list mb-0">
                        @foreach($complianceDocuments as $file)
                        @php
                        $fileUrl = preg_replace('/^admin\//', '', $file->image_path);
                        $fullUrl = asset($fileUrl);
                        @endphp
                        <li class="rk-attach-item">
                            <a href="{{ $fullUrl }}" target="_blank" class="rk-attach-link">
                                📎 {{ basename($file->image_path) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                    </div>
                </div>
                @endif

                <div class="col-sm-6">
                    <div class="rk-notes-card h-100">

                    <form method="POST" action="{{ route('admin.noteStore') }}">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                        <textarea name="note" class="rk-note-input" placeholder="Add a note..." required></textarea>
                        <button type="submit" class="badge bg-success me-1">Save</button>
                    </form>

                    <div class="rk-notes-list">


                        @forelse($lead->leadNotes as $note)
                        <div class="rk-note-item">
                            <p>{{ $note->note }}</p>
                            <span>
                                {{ @$note->creator->name ?? 'System' }} ·
                                {{ optional($note->created_at)->format('D d M, Y') }}
                            </span>
                        </div>
                        @empty
                        <div class="rk-note-empty">
                            <p>No notes found</p>
                        </div>
                        @endforelse





                    </div>
                    </div>
                </div>
            </div>

            {{-- ================= ATTACHMENTS ================= --}}
            <div class="col-sm-6">
            <div class="rk-files-card card rk-attachments-card h-100">
            <div class="rk-files-header">
                <h6 class="mb-0"><strong>Attachments ({{$lead->images->count()}})</strong></h6>

                <div class="d-flex align-items-center gap-2">
                    <button id="addFileBtn" type="button" class="btn btn-sm btn-outline-primary">
                        + Add Files
                    </button>
                </div>

                <input type="file" id="fileInput" hidden>
            </div>
            <div class="px-3 pt-2">
                <small class="text-muted selected-file-name">No file selected</small>
            </div>

            <ul class="rk-attach-list">

                @forelse($lead->images as $file)

                @php
                // remove admin/ from path if exists
                $fileUrl = preg_replace('/^admin\//', '', $file->image_path);

                // final URL (adjust if using storage)
                $fullUrl = asset($fileUrl);
                @endphp

                <li class="rk-attach-item">

                    {{-- file link --}}
                    <a href="{{ $fullUrl }}" target="_blank" class="rk-attach-link">
                        📎 {{ basename($file->image_path) }}
                    </a>

                    {{-- delete button --}}
                    <a href="javascript:void(0)" class="text-danger delete-lead-image" data-id="{{ $file->id }}"
                        data-tble="lead_images" title="Delete">
                        <i class="fa fa-trash"></i> Delete
                    </a>

                </li>

                @empty

                <li class="rk-attach-empty">
                    No attachments found
                </li>

                @endforelse

            </ul>
            </div>
            </div>
        </div>
    </div>


</div>
<div class="modal fade" id="vicWorkflowModal" tabindex="-1" aria-labelledby="vicWorkflowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rk-vic-modal">
            <div class="modal-header rk-vic-modal-header">
                <div>
                    <h4 class="modal-title" id="vicWorkflowModalLabel">Compliance Check - Job #{{ $lead->id }}</h4>
                    <p>{{ trim(($lead->first_name ?? '').' '.($lead->last_name ?? '')) ?: 'Customer' }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body rk-vic-modal-body">
                <div class="rk-vic-modal-top">
                    <div class="rk-vic-steps">
                        <button type="button" class="rk-vic-step {{ $activeVicPane === 'checklist' ? 'active' : '' }}" data-step="checklist">Checklist</button>
                        <button type="button" class="rk-vic-step {{ $activeVicPane === 'documents' ? 'active' : '' }}" data-step="documents">Documents</button>
                        <button type="button" class="rk-vic-step {{ $activeVicPane === 'rfi' ? 'active' : '' }}" data-step="rfi">RFI</button>
                    </div>
                </div>

                <div class="rk-vic-pane {{ $activeVicPane === 'checklist' ? 'active' : '' }}" data-pane="checklist">
                    <div class="rk-vic-info-card">
                        <div class="rk-vic-info-icon">!</div>
                        <div>
                            <h5>Compliance Check</h5>
                            <p>Review the key job details captured in the preview popup and mark this lead ready for compliance processing.</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="rk-vic-field-group mb-0">
                                <label for="complianceJobType">Job Type *</label>
                                <select id="complianceJobType" class="form-select rk-vic-select-focus">
                                    <option value="Solar Only" {{ $complianceJobTypeValue === 'Solar Only' ? 'selected' : '' }}>Solar Only</option>
                                    <option value="Battery Only" {{ $complianceJobTypeValue === 'Battery Only' ? 'selected' : '' }}>Battery Only</option>
                                    <option value="Solar + Battery" {{ $complianceJobTypeValue === 'Solar + Battery' ? 'selected' : '' }}>Solar + Battery</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-common-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="complianceBillCopy">Electricity Bill Copy or NMI received?</label>
                                <select id="complianceBillCopy" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ $complianceBillCopyValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $complianceBillCopyValue === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-common-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="compliancePhaseType">Single Phase or Three Phase *</label>
                                <select id="compliancePhaseType" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Single Phase" {{ $compliancePhaseTypeValue === 'Single Phase' ? 'selected' : '' }}>Single Phase</option>
                                    <option value="Three Phase" {{ $compliancePhaseTypeValue === 'Three Phase' ? 'selected' : '' }}>Three Phase</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-battery-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="complianceCouplingType">Job is AC Couple or DC Couple *</label>
                                <select id="complianceCouplingType" class="form-select">
                                    <option value="">Select</option>
                                    <option value="AC Couple" {{ $complianceCouplingTypeValue === 'AC Couple' ? 'selected' : '' }}>AC Couple</option>
                                    <option value="DC Couple" {{ $complianceCouplingTypeValue === 'DC Couple' ? 'selected' : '' }}>DC Couple</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-battery-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="complianceBatteryAccess">Photo of area showing clear access to battery location</label>
                                <select id="complianceBatteryAccess" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ $complianceBatteryAccessValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $complianceBatteryAccessValue === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-battery-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="compliancePivotSlab">Pivot Slab required? *</label>
                                <select id="compliancePivotSlab" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ $compliancePivotSlabValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $compliancePivotSlabValue === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-battery-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="complianceBatteryInstall">Photo of area where battery is going to be installed</label>
                                <select id="complianceBatteryInstall" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ $complianceBatteryInstallValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $complianceBatteryInstallValue === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-battery-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="complianceBackupRequirement">What backup they require? *</label>
                                <input type="text" id="complianceBackupRequirement" class="form-control" value="{{ $complianceBackupValue }}" placeholder="Enter backup requirement">
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-common-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="compliancePlanView">Photo of a plan view (from above)</label>
                                <select id="compliancePlanView" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ $compliancePlanViewValue === 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ $compliancePlanViewValue === 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 rk-compliance-field rk-compliance-common-field">
                            <div class="rk-vic-field-group mb-0">
                                <label for="complianceStoreyType">Single Storey or Double Storey *</label>
                                <select id="complianceStoreyType" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Single Storey" {{ $complianceStoreyValue === 'Single Storey' ? 'selected' : '' }}>Single Storey</option>
                                    <option value="Double Storey" {{ $complianceStoreyValue === 'Double Storey' ? 'selected' : '' }}>Double Storey</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="rk-compliance-dynamic-hint" id="complianceJobTypeHint"></div>

                    <div class="rk-vic-field-group">
                        <label for="complianceNotes">Notes</label>
                        <textarea id="complianceNotes" class="form-control rk-vic-textarea" rows="4" placeholder="Add any compliance notes for this job">{{ $complianceNotesValue }}</textarea>
                    </div>
                </div>

                <div class="rk-vic-pane {{ $activeVicPane === 'documents' ? 'active' : '' }}" data-pane="documents">
                    <div class="rk-vic-doc-card">
                        <div>
                            <h5>Upload Documents</h5>
                            <p>Use the same lead attachments area for compliance files like plans, photos, electricity bills, and supporting paperwork.</p>
                            <small class="text-muted selected-file-name d-block">No file selected</small>
                        </div>
                        <button type="button" class="rk-vic-primary-btn rk-vic-inline-btn" id="complianceUploadBtn">Upload Documents</button>
                    </div>

                    <div class="rk-vic-doc-grid">
                        <div class="rk-vic-action-card">
                            <div>
                                <strong>Uploaded Documents</strong>
                                <p>{{ $lead->images->count() }} file(s) currently attached to this lead.</p>
                            </div>
                            <span class="badge bg-light text-dark">{{ $lead->images->count() }} files</span>
                        </div>

                        <div class="rk-vic-action-card">
                            <div>
                                <strong>Suggested Uploads</strong>
                                <p>Electricity bill, plan view, battery area photos, switchboard photos, and any installer notes.</p>
                            </div>
                            <span class="badge bg-light text-dark">Checklist</span>
                        </div>
                    </div>
                </div>

                <div class="rk-vic-pane {{ $activeVicPane === 'rfi' ? 'active' : '' }}" data-pane="rfi">
                    <div class="rk-vic-info-card rk-vic-rfi-card">
                        <div class="rk-vic-info-icon">!</div>
                        <div>
                            <h5>Request For Information</h5>
                            <p>Send a Request for Information (RFI) to the sales rep if any documents or information is missing.</p>
                        </div>
                    </div>

                    <div class="rk-vic-field-group">
                        <label for="complianceRfiMessage">RFI Message</label>
                        <textarea id="complianceRfiMessage" class="form-control rk-vic-textarea" rows="6" placeholder="Describe the missing information or documents">{{ $complianceRfiMessageValue }}</textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer rk-vic-modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveVicWorkflowBtn">Mark as Complete</button>
            </div>
        </div>
    </div>
</div>
@include('admin.leads._email_modal',['emailTemplates'=>$emailTemplates])
@include('admin.leads._edit_modal')
@include('admin.leads.call_logs')
<style>
.rk-notes-list {
    height: 250px;
    overflow-y: auto;
}

/* ===== base stage ===== */
.rk-stage {
    cursor: pointer;
    transition: background .25s ease, color .25s ease;

}

/* ===== active stage premium ===== */


/* ✨ premium shine effect */
.rk-stage.active::before {
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 60%;
    height: 100%;
    background: linear-gradient(120deg,
            transparent,
            rgba(255, 255, 255, 0.45),
            transparent);
    animation: rkShine 2.5s infinite;
}

/* smooth shine animation */
@keyframes rkShine {
    0% {
        left: -120%;
    }

    100% {
        left: 130%;
    }
}

.rk-stage {
    cursor: pointer;
}

/* wrapper */
.rk-overview-wrapper {
    font-family: Inter, sans-serif;
    background: #f6f8fb;
    padding: 20px;
}

/* header */
.rk-overview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.rk-overview-title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.rk-overview-customize {
    background: #eef2f7;
    border: 1px solid #d0d7e2;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
}

/* lifecycle */
.rk-lifecycle-box {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

/* ================= HUBSPOT PIPELINE ================= */

.rk-pipeline {
    display: flex;
    overflow-x: auto;
    background: #e9f5f2;
    padding: 8px;
    border-radius: 8px;
}

.rk-stage {
    position: relative;
    padding: 10px 28px 10px 22px;
    background: #bfe8df;
    color: #2d3748;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
}

.rk-stage::after {
    content: "";
    position: absolute;
    top: 0;
    right: -18px;
    width: 0;
    height: 0;
    border-top: 19px solid transparent;
    border-bottom: 19px solid transparent;
    border-left: 18px solid #bfe8df;
    z-index: 2;
}

.rk-stage:not(:first-child) {
    margin-left: 18px;
}

.rk-stage.active {
    background: #2ec4b6;
    color: #fff;
    font-weight: 600;
}

.rk-stage.active::after {
    border-left-color: #2ec4b6;
}

.rk-stage:last-child::after {
    display: none;
}

/* body layout */
.rk-overview-body {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 15px;
}

.rk-overview-body-comp {
    grid-template-columns: 1fr;
}

.rk-column-stack {
    display: grid;
    gap: 15px;
    align-content: start;
}

.rk-column-stack-full {
    width: 100%;
}

/* summary */
.rk-summary-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}

.rk-summary-header {
    background: #eaf0f7;
    padding: 12px 15px;
}

.rk-summary-content {
    padding: 15px;
}

.rk-summary-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 15px;
}

.rk-summary-row label {
    font-size: 12px;
    color: #6b7280;
}

.rk-summary-row p {
    margin: 3px 0 0;
    font-weight: 500;
}

.rk-summary-row.mb-0 {
    margin-bottom: 0;
}

.rk-mini-bordered-box {
    margin-top: 8px;
    padding: 14px;
    border: 1px solid #dbe4f0;
    border-radius: 10px;
}

.rk-mini-bordered-title {
    margin-bottom: 12px;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
}

.rk-link {
    color: #3b82f6;
    cursor: pointer;
}

/* notes */
.rk-notes-card {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
}

.rk-note-input {
    width: 100%;
    height: 80px;
    border: 1px solid #e1e5eb;
    border-radius: 6px;
    padding: 10px;
    margin-bottom: 15px;
}

.rk-note-item {
    border-bottom: 1px solid #eef2f7;
    padding: 8px 0;
}

.rk-note-item span {
    font-size: 11px;
    color: #6b7280;
}

.rk-view-all {
    text-align: right;
    color: #3b82f6;
    font-size: 13px;
    cursor: pointer;
    margin-top: 10px;
}

/* mobile */
@media (max-width: 768px) {
    .rk-overview-body {
        grid-template-columns: 1fr;
    }

    .rk-summary-row {
        grid-template-columns: 1fr;
    }
}

/* ===== added action tabs (non-breaking) ===== */
.rk-action-tabs {
    display: flex;
    gap: 8px;
    margin: 10px 0 14px;
    flex-wrap: wrap;
}

.rk-action-tab {
    padding: 6px 14px;
    background: #fff;
    border: 1px solid #d0d7e2;
    border-radius: 20px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    transition: all .2s ease;
}

.rk-action-tab:hover {
    background: #f3f6fa;
}

.rk-action-tab.active {
    background: #2ec4b6;
    color: #fff;
    border-color: #2ec4b6;
    font-weight: 600;
}

.rk-note-empty {
    text-align: center;
    padding: 20px 10px;
    color: #6b7280;
    font-size: 13px;
}

/* card */
.rk-files-card {
    margin-top: 16px;
    padding: 14px;
    border: 1px solid #e6eceb;
    border-radius: 10px;
    background: #fff;
}

.rk-column-stack > .rk-files-card {
    margin-top: 0;
}

.rk-attachments-card {
    margin-top: 0;
}

/* list */
.rk-attach-list {
    list-style: none;
    padding-left: 0;
    margin: 0;
    max-height: 220px;
    overflow-y: auto;
}

/* item */
.rk-attach-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    border-bottom: 1px dashed #eee;
    font-size: 13px;
}

/* link */
.rk-attach-link {
    text-decoration: none;
    color: #2c3e50;
}

.rk-attach-link:hover {
    text-decoration: underline;
}

/* empty */
.rk-attach-empty {
    font-size: 12px;
    color: #999;
    padding: 8px 0;
}
.rk-files-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.rk-vic-modal {
    border: 0;
    border-radius: 18px;
    overflow: hidden;
}

.rk-vic-modal-header {
    padding: 24px 28px 10px;
    border-bottom: 0;
    align-items: flex-start;
}

.rk-vic-modal-header h4 {
    margin: 0 0 4px;
    font-size: 19px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-modal-header p {
    margin: 0;
    font-size: 14px;
    color: #64748b;
}

.rk-vic-modal-body {
    padding: 10px 28px 24px;
}

.rk-vic-modal-top {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    align-items: end;
    margin-bottom: 22px;
}

.rk-vic-steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 4px;
    padding: 4px;
    border-radius: 12px;
    background: #eef2f7;
}

.rk-vic-step {
    border: 0;
    background: transparent;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 15px;
    font-weight: 700;
    color: #64748b;
}

.rk-vic-step.active {
    background: #fff;
    color: #1f2937;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
}

.rk-vic-pane {
    display: none;
}

.rk-vic-pane.active {
    display: block;
}

.rk-vic-info-card {
    margin-bottom: 18px;
    padding: 18px;
    border-radius: 14px;
    background: #f8fbff;
    border: 1px solid #dbeafe;
    display: flex;
    gap: 14px;
    align-items: flex-start;
}

.rk-vic-info-card h5 {
    margin: 0 0 8px;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-info-card p {
    margin: 0;
    color: #64748b;
}

.rk-vic-info-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #1d4ed8;
    color: #1d4ed8;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.rk-vic-field-group {
    margin-bottom: 20px;
}

.rk-vic-field-group label {
    display: block;
    margin-bottom: 10px;
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-field-group small {
    display: block;
    margin-top: 8px;
    color: #64748b;
    font-size: 13px;
}

.rk-vic-select-focus {
    border-color: #1d4ed8;
    box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.08);
}

.rk-vic-divider {
    height: 1px;
    background: #dbe4f0;
    margin: 20px 0;
}

.rk-vic-portal-card {
    padding: 16px;
    border: 1px solid #bfd3ff;
    border-radius: 12px;
    background: #eef4ff;
}

.rk-vic-portal-card h5,
.rk-vic-followup h5 {
    margin: 0 0 8px;
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-portal-card p,
.rk-vic-followup p {
    margin: 0 0 14px;
    color: #64748b;
}

.rk-vic-doc-card {
    margin-bottom: 18px;
    padding: 18px;
    border: 1px solid #dbe4f0;
    border-radius: 14px;
    background: #f8fafc;
    display: flex;
    justify-content: space-between;
    gap: 16px;
    align-items: center;
}

.rk-vic-doc-card h5 {
    margin: 0 0 8px;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.rk-vic-doc-card p {
    margin: 0;
    color: #64748b;
}

.rk-vic-doc-grid {
    display: grid;
    gap: 14px;
}

.rk-vic-secondary-btn,
.rk-vic-primary-btn {
    width: 100%;
    border-radius: 8px;
    padding: 12px 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 700;
    border: 1px solid #d7e0ef;
    margin-bottom: 12px;
    background: #fff;
    color: #1f2937;
}

.rk-vic-primary-btn {
    background: #143f78;
    border-color: #143f78;
    color: #fff;
    margin-bottom: 0;
}

.rk-vic-inline-btn {
    width: auto;
    min-width: 180px;
    margin-bottom: 0;
}

.rk-vic-followup {
    margin-bottom: 20px;
}

.rk-vic-quick-bar {
    display: flex;
    justify-content: flex-end;
}

.rk-vic-action-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 18px;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #fff;
}

.rk-vic-action-card strong {
    display: block;
    margin-bottom: 6px;
    font-size: 15px;
    color: #1f2937;
}

.rk-vic-action-card p {
    margin: 0;
    color: #64748b;
}

.rk-vic-textarea {
    min-height: 120px;
}

.rk-vic-rfi-card {
    margin-bottom: 20px;
}

.rk-compliance-field.is-hidden {
    display: none;
}

.rk-compliance-dynamic-hint {
    margin-top: 14px;
    margin-bottom: 20px;
    padding: 12px 14px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid #dbe4f0;
    color: #475569;
    font-size: 13px;
}

.rk-compliance-dynamic-hint:empty {
    display: none;
}

.rk-vic-modal-footer {
    border-top: 0;
    padding: 0 28px 24px;
}

@media (max-width: 767.98px) {
    .rk-vic-steps {
        grid-template-columns: 1fr;
    }

    .rk-vic-action-card {
        flex-direction: column;
        align-items: flex-start;
    }

    .rk-vic-doc-card {
        flex-direction: column;
        align-items: flex-start;
    }
}

</style>

@endsection

@section('scripts')
@parent
<script>
const leadId = '{{ $lead->id }}';

function submitLeadStatus(status, withConfirmation = true) {
    if (withConfirmation && !confirm('Are you sure you want to change the status?')) {
        return;
    }

    document.getElementById('statusInput').value = status;
    document.getElementById('statusForm').submit();
}

function changeLeadStatus(status) {
    submitLeadStatus(status, true);
}

$(document).on('click', '.generateQuote', function() {
    if (confirm("Are you sure you want to generate this quote?")) {
        let url = "{{ route('admin.generateQuote', ':id') }}";
        url = url.replace(':id', leadId);

        window.location.href = url;
    }
});

let pendingFile = null;

function resetPendingFileState() {
    pendingFile = null;
    $('#fileInput').val('');
    $('.selected-file-name').text('No file selected');
}

function setPendingFileState(file) {
    pendingFile = file || null;
    const fileName = pendingFile ? pendingFile.name : 'No file selected';
    $('.selected-file-name').text(fileName);
}

$(function() {
    function getComplianceJobTypeConfig(jobType) {
        const isBatteryJob = jobType === 'Battery Only' || jobType === 'Solar + Battery';

        return {
            isBatteryJob: isBatteryJob,
            hint: isBatteryJob
                ? 'Battery-related fields are required for this job type and will be saved in lead meta.'
                : 'Battery-related fields are hidden for Solar Only jobs and will be cleared from lead meta when you save.'
        };
    }

    function clearComplianceBatteryFields() {
        $('#complianceCouplingType').val('');
        $('#complianceBatteryAccess').val('');
        $('#compliancePivotSlab').val('');
        $('#complianceBatteryInstall').val('');
        $('#complianceBackupRequirement').val('');
    }

    function syncComplianceJobTypeFields(resetHiddenFields = false) {
        const jobType = $('#complianceJobType').val();
        const config = getComplianceJobTypeConfig(jobType);

        $('.rk-compliance-battery-field').toggleClass('is-hidden', !config.isBatteryJob);
        $('#complianceJobTypeHint').text(config.hint);

        $('#complianceCouplingType, #complianceBatteryAccess, #compliancePivotSlab, #complianceBatteryInstall, #complianceBackupRequirement')
            .prop('disabled', !config.isBatteryJob);

        if (!config.isBatteryJob && resetHiddenFields) {
            clearComplianceBatteryFields();
        }
    }

    function updateComplianceActionLabel(targetStep) {
        const label = targetStep === 'rfi' ? 'Save RFI' : 'Mark as Complete';
        $('#saveVicWorkflowBtn').text(label);
    }

    function activateVicPane(targetStep) {
        $('.rk-vic-step').removeClass('active');
        $('.rk-vic-step[data-step="' + targetStep + '"]').addClass('active');
        $('.rk-vic-pane').removeClass('active');
        $('.rk-vic-pane[data-pane="' + targetStep + '"]').addClass('active');
        updateComplianceActionLabel(targetStep);
    }

    function syncVicWorkflowStep(status) {
        const targetStep = status === 'COMPLIANCE AWAITING APPROVAL' ? 'documents' : 'checklist';
        activateVicPane(targetStep);
    }

    syncVicWorkflowStep('{{ $currentVicWorkflowStatus }}');
    syncComplianceJobTypeFields(false);

    $('.rk-vic-step').on('click', function() {
        const step = $(this).data('step');
        activateVicPane(step);
    });

    $('#complianceJobType').on('change', function() {
        syncComplianceJobTypeFields(true);
    });

    $('#saveVicWorkflowBtn').on('click', function() {
        const activePane = $('.rk-vic-pane.active').data('pane');
        const status = activePane === 'checklist' ? 'COMPLIANCE AWAITING APPROVAL' : '{{ $currentVicWorkflowStatus }}';
        const $btn = $(this);
        const complianceJobType = $('#complianceJobType').val();
        const complianceConfig = getComplianceJobTypeConfig(complianceJobType);
        const uploadSelectedFile = function() {
            let formData = new FormData();
            formData.append('file', pendingFile);
            formData.append('lead_id', leadId);
            formData.append('status', 'BOOK INSTALLATION');
            formData.append('_token', '{{ csrf_token() }}');

            $btn.prop('disabled', true).text('Uploading...');

            $.ajax({
                url: '{{ route("superadmin.leadImages") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    resetPendingFileState();
                    location.reload();
                },
                error: function() {
                    $btn.prop('disabled', false).text('Mark as Complete');
                    alert('Upload failed!');
                }
            });
        };

        if (activePane === 'documents' && !pendingFile) {
            alert('Please select a file first.');
            return;
        }

        $btn.prop('disabled', true).text(activePane === 'rfi' ? 'Saving RFI...' : 'Saving...');

        $.ajax({
            url: '{{ route("superadmin.saveComplianceMeta") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                lead_id: leadId,
                status: status,
                job_type: complianceJobType,
                bill_copy_received: $('#complianceBillCopy').val(),
                phase_type: $('#compliancePhaseType').val(),
                coupling_type: complianceConfig.isBatteryJob ? $('#complianceCouplingType').val() : '',
                battery_access_photo: complianceConfig.isBatteryJob ? $('#complianceBatteryAccess').val() : '',
                pivot_slab_required: complianceConfig.isBatteryJob ? $('#compliancePivotSlab').val() : '',
                battery_install_photo: complianceConfig.isBatteryJob ? $('#complianceBatteryInstall').val() : '',
                backup_requirement: complianceConfig.isBatteryJob ? $('#complianceBackupRequirement').val() : '',
                plan_view_photo: $('#compliancePlanView').val(),
                storey_type: $('#complianceStoreyType').val(),
                notes: $('#complianceNotes').val(),
                rfi_message: $('#complianceRfiMessage').val()
            },
            success: function() {
                if (activePane === 'documents') {
                    uploadSelectedFile();
                    return;
                }

                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to save compliance check.');
                updateComplianceActionLabel(activePane);
                $btn.prop('disabled', false);
            }
        });
    });
});


$(function() {
    $('#addFileBtn').on('click', function() {
        $('#fileInput').click();
    });

    $('#complianceUploadBtn').on('click', function() {
        $('#fileInput').click();
    });

    $('#fileInput').on('change', function() {
        setPendingFileState(this.files[0]);
    });
});
</script>
@endsection
