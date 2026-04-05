@extends('layouts.super')

@section('title', 'Leads')

@section('content')

@php


$lead->status = $lead->status == 'Sold' ? 'Not Applied' : $lead->status;

// example — replace with your real status
$currentStatus = $lead->status ?? 'New';
$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
$canApplyApproval = $currentStatus === 'Not Applied';
$canUploadApproval = $currentStatus === 'Awaiting Approval';
$defaultApprovalPane = $canUploadApproval ? 'upload' : 'apply';
$approvalRequiredValue = $leadMeta['distributor_approval_required'] ?? 'Yes';
$distributorNameValue = $leadMeta['distributor_name'] ?? '';
$existingSystemValue = $leadMeta['existing_system'] ?? '';
$meterNumberValue = $leadMeta['meter_number'] ?? '';
$nmiNumberValue = $leadMeta['nmi_number'] ?? '';
$photosRequiredValue = $leadMeta['photos_required'] ?? '';
$approvalFileUrl = $leadMeta['distributor_approval_file'] ?? '';
$approvalFileName = $approvalFileUrl ? basename(parse_url($approvalFileUrl, PHP_URL_PATH)) : 'No file selected';
@endphp

@php
$stages = [
    'Not Applied',
    'Awaiting Approval',
    $currentStatus
];
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


            <button data-lead='@json($lead)' class="btn btn-outline-danger edit_lead" data-lead='@json($lead)'
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
            <span class="rk-lifecycle-value"> ▼</span>
        </div>

        <!-- ✅ HUBSPOT PIPELINE -->
        <div class="rk-pipeline">
            @foreach($stages as $stage)
            <div class="rk-stage {{ $currentStatus == $stage ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stage }}')">
                {{ $stage }}
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
    <div class="rk-overview-body">

        <div class="rk-column-stack">
            <!-- left -->
            <div class="rk-summary-card">
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

            <div class="rk-files-card card">

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
            </div>
        </div>

        <!-- right -->
        <div class="rk-column-stack">
            <div class="rk-notes-card">

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
            {{-- ================= ATTACHMENTS ================= --}}
            <div class="rk-files-card card rk-attachments-card">
            <div class="rk-files-header">
                <h6 class="mb-0"><strong>Attachments ({{$lead->images->count()}})</strong></h6>

                <button id="addFileBtn" class="btn btn-sm btn-outline-primary">
                    + Add Files
                </button>

                <input type="file" id="fileInput" hidden>
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

.rk-column-stack {
    display: grid;
    gap: 15px;
    align-content: start;
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

    .rk-dist-approval-header {
        flex-direction: column;
    }

    .rk-dist-approval-steps {
        grid-template-columns: 1fr 1fr;
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

.rk-dist-approval-card {
    border: 1px solid #e6eceb;
    border-radius: 16px;
    padding: 18px;
    background: #fff;
    margin-bottom: 18px;
}

.rk-dist-approval-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 16px;
}

.rk-dist-approval-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 4px;
    color: #1f2937;
}

.rk-dist-approval-subtitle {
    margin: 0;
    color: #64748b;
    font-size: 15px;
}

.rk-dist-field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}

.rk-dist-approval-steps {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    background: #e9eef6;
    border-radius: 10px;
    padding: 4px;
    margin-bottom: 16px;
}

.rk-dist-step {
    border: 0;
    background: transparent;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
}

.rk-dist-step.active {
    background: #fff;
    color: #1f2937;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
}

.rk-dist-step.disabled {
    opacity: .55;
    cursor: not-allowed;
}

.rk-dist-pane {
    display: none;
}

.rk-dist-pane.active {
    display: block;
}

.rk-dist-approval-info {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #f6f9ff;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 22px;
}

.rk-dist-approval-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #1d4ed8;
    color: #1d4ed8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    flex-shrink: 0;
}

.rk-dist-approval-info h5 {
    margin: 0 0 4px;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.rk-dist-approval-info p {
    margin: 0;
    color: #64748b;
}

.rk-dist-approval-form {
    display: grid;
    gap: 22px;
}

.rk-dist-form-grid {
    display: grid;
    gap: 18px;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    width: 100%;
}

.rk-dist-form-grid > * {
    min-width: 0;
}

.rk-dist-field {
    padding-bottom: 22px;
    border-bottom: 1px solid #e2e8f0;
}

.rk-dist-field-compact {
    padding: 0;
    border-bottom: 0;
}

.rk-dist-detail-panel {
    border: 1px solid #dbe4f0;
    border-radius: 18px;
    padding: 22px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    box-shadow: 0 16px 38px rgba(15, 23, 42, 0.06);
    width: 100%;
    overflow: hidden;
}

.rk-dist-detail-grid {
    display: grid;
    gap: 16px;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    align-items: stretch;
    width: 100%;
}

.rk-dist-detail-grid > * {
    min-width: 0;
}

.rk-dist-detail-header {
    margin-bottom: 16px;
}

.rk-dist-detail-header h6 {
    margin: 0 0 6px;
    font-size: 19px;
    font-weight: 700;
    color: #1f2937;
}

.rk-dist-detail-header p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.rk-dist-field-card {
    height: 100%;
    padding: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
    min-width: 0;
}

.rk-dist-field-card label {
    margin-bottom: 10px;
}

.rk-dist-field .form-control,
.rk-dist-field .form-select,
.rk-dist-field-card .form-control,
.rk-dist-field-card .form-select {
    width: 100%;
    min-width: 0;
}

.rk-dist-field:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}

@media (max-width: 991.98px) {
    .rk-dist-form-grid {
        grid-template-columns: 1fr;
    }

    .rk-dist-detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 575.98px) {
    .rk-dist-detail-panel {
        padding: 18px;
    }

    .rk-dist-field-card {
        padding: 14px;
    }
}

.rk-dist-upload-box {
    display: grid;
    gap: 16px;
}

.rk-dist-upload-dropzone {
    border: 2px dashed #d9e3f0;
    border-radius: 14px;
    padding: 34px 20px 28px;
    text-align: center;
    background: #fff;
}

.rk-dist-upload-graphic {
    color: #64748b;
    margin-bottom: 14px;
}

.rk-dist-upload-dropzone h6 {
    font-size: 17px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 6px;
}

.rk-dist-upload-dropzone p {
    font-size: 14px;
    color: #64748b;
    margin: 0 0 18px;
}

.rk-dist-upload-trigger,
.rk-dist-approve-btn {
    border: 0;
    border-radius: 8px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: opacity .2s ease;
}

.rk-dist-upload-trigger {
    background: #143f78;
    color: #fff;
    padding: 11px 20px;
}

.rk-dist-upload-name {
    font-size: 13px;
    color: #64748b;
    margin-top: 14px;
    word-break: break-word;
}

.rk-approval-file-link {
    display: inline-block;
    margin-top: 8px;
    font-size: 13px;
    color: #143f78;
    text-decoration: none;
}

.rk-approval-file-link:hover {
    text-decoration: underline;
}

.rk-dist-approve-btn {
    width: 100%;
    background: #143f78;
    color: #fff;
    padding: 14px 18px;
}

.rk-dist-approve-btn:disabled {
    opacity: .6;
    cursor: not-allowed;
}

.rk-dist-upload-trigger:hover,
.rk-dist-approve-btn:hover {
    opacity: .92;
}

.rk-dist-upload-trigger:disabled,
.rk-dist-approve-btn:disabled {
    opacity: .6;
    cursor: not-allowed;
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


$(function() {
    const applyButtonHtml = $('#applyApprovalBtn').html();
    const uploadButtonHtml = $('#uploadApprovalBtn').html();

    function saveDistributorApprovalMeta(options) {
        return $.ajax({
            url: '{{ route("superadmin.saveDistributorApprovalMeta") }}',
            type: 'POST',
            data: options.formData,
            processData: false,
            contentType: false
        });
    }

    $('.rk-dist-step').on('click', function() {
        if ($(this).is(':disabled')) {
            return;
        }

        const target = $(this).data('target');

        $('.rk-dist-step').removeClass('active');
        $(this).addClass('active');

        $('.rk-dist-pane').removeClass('active');
        $('.rk-dist-pane[data-pane="' + target + '"]').addClass('active');
    });

    function toggleDistributorField() {
        if ($('#approvalRequired').val() === 'Yes') {
            $('#distributorField').show();
        } else {
            $('#distributorField').hide();
            $('#distributorName').val('');
        }

        toggleDistributorDetailsPanel();
    }

    function toggleDistributorDetailsPanel() {
        const shouldShow = $('#approvalRequired').val() === 'Yes' && !!$('#distributorName').val();

        if (shouldShow) {
            $('#distributorDetailsPanel').stop(true, true).slideDown(180);
        } else {
            $('#distributorDetailsPanel').stop(true, true).slideUp(180);
            $('#meterNumber').val('');
            $('#nmiNumber').val('');
            $('#photosRequired').val('');
        }
    }

    toggleDistributorField();

    $('#approvalRequired').on('change', function() {
        toggleDistributorField();
    });

    $('#distributorName').on('change', function() {
        toggleDistributorDetailsPanel();
    });

    $('#applyApprovalBtn').on('click', function() {
        if ($(this).is(':disabled')) {
            return;
        }

        if ($('#approvalRequired').val() === 'Yes' && !$('#distributorName').val()) {
            alert('Please select distributor.');
            return;
        }

        if (!$('#existingSystem').val()) {
            alert('Please select existing system option.');
            return;
        }

        if ($('#approvalRequired').val() === 'Yes' && $('#distributorName').val()) {
            if (!$('#meterNumber').val().trim()) {
                alert('Please enter meter number.');
                return;
            }

            if (!$('#nmiNumber').val().trim()) {
                alert('Please enter NMI number.');
                return;
            }

            if (!$('#photosRequired').val()) {
                alert('Please select if photos are required.');
                return;
            }
        }

        const nextStatus = $('#approvalRequired').val() === 'No'
            ? 'VIC REBATE NOT APPLIED'
            : 'Awaiting Approval';

        let formData = new FormData();
        formData.append('lead_id', leadId);
        formData.append('approval_required', $('#approvalRequired').val());
        formData.append('distributor_name', $('#distributorName').val() || '');
        formData.append('existing_system', $('#existingSystem').val());
        formData.append('meter_number', $('#meterNumber').val().trim());
        formData.append('nmi_number', $('#nmiNumber').val().trim());
        formData.append('photos_required', $('#photosRequired').val() || '');
        formData.append('status', nextStatus);
        formData.append('_token', '{{ csrf_token() }}');

        $('#applyApprovalBtn').prop('disabled', true).text('Saving...');

        saveDistributorApprovalMeta({ formData: formData })
            .done(function() {
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to save distributor approval data.');
                $('#applyApprovalBtn').prop('disabled', false).html(applyButtonHtml);
            });
    });

    $('#chooseApprovalFileBtn').on('click', function() {
        $('#approvalFileInput').click();
    });

    $('#approvalFileInput').on('change', function() {
        const fileName = this.files && this.files[0] ? this.files[0].name : 'No file selected';
        $('#approvalFileName').text(fileName);
    });

    $('#uploadApprovalBtn').on('click', function() {
        let file = $('#approvalFileInput')[0].files[0];

        if (!file) {
            alert('Please select a file first.');
            return;
        }

        const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Only PDF, PNG, and JPG files are allowed.');
            return;
        }

        if (file.size > 10 * 1024 * 1024) {
            alert('File size must be 10MB or less.');
            return;
        }

        if (!$('#existingSystem').val()) {
            alert('Please select existing system option.');
            return;
        }

        if ($('#approvalRequired').val() === 'Yes' && !$('#distributorName').val()) {
            alert('Please select distributor.');
            return;
        }

        $('#uploadApprovalBtn').prop('disabled', true).text('Uploading...');

        let formData = new FormData();
        formData.append('approval_file', file);
        formData.append('lead_id', leadId);
        formData.append('approval_required', $('#approvalRequired').val());
        formData.append('distributor_name', $('#distributorName').val() || '');
        formData.append('existing_system', $('#existingSystem').val());
        formData.append('meter_number', $('#meterNumber').val().trim());
        formData.append('nmi_number', $('#nmiNumber').val().trim());
        formData.append('photos_required', $('#photosRequired').val() || '');
        formData.append('status', 'VIC REBATE NOT APPLIED');
        formData.append('_token', '{{ csrf_token() }}');

        saveDistributorApprovalMeta({ formData: formData })
            .done(function() {
                location.reload();
            })
            .fail(function(xhr) {
                alert(xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Approval upload failed!');
                $('#uploadApprovalBtn').prop('disabled', false).html(uploadButtonHtml);
            });
    });

    $('#addFileBtn').on('click', function() {
        $('#fileInput').click();
    });

    $('#fileInput').on('change', function() {
        let file = this.files[0];
        let formData = new FormData();
        formData.append('file', file);
        formData.append('lead_id', leadId);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("superadmin.leadImages") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                location.reload();
            },
            error: function(err) {
                alert('Upload failed!');
            }
        });
    });
});
</script>
@endsection
