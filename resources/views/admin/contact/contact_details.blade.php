@extends('layouts.admin')

@section('title', 'Leads')

@section('content')

@php
$stages = [
'Pending',
'Getting Proposal Ready',
'Proposal Sent',
'Follow Up Scheduled',
'Proposal Accepted',
'Lost',

];

// example — replace with your real status
$currentStatus = $lead->contact->status ?? '';
$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
$leadName = trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? '')) ?: 'Contact';
$leadInitials = strtoupper(substr($lead->first_name ?? 'C', 0, 1) . substr($lead->last_name ?? '', 0, 1));
$leadInitials = $leadInitials ?: 'C';
$leadAddress = trim(implode(', ', array_filter([
    $lead->address,
    $lead->suburb,
    $lead->state ? $lead->state . ' ' . $lead->postcode : $lead->postcode,
])));
$stageIcons = [
    'Pending' => ['label' => 'P', 'class' => 'rk-contact-stage-pending'],
    'Getting Proposal Ready' => ['label' => 'G', 'class' => 'rk-contact-stage-ready'],
    'Proposal Sent' => ['label' => 'S', 'class' => 'rk-contact-stage-sent'],
    'Follow Up Scheduled' => ['label' => 'F', 'class' => 'rk-contact-stage-follow'],
    'Proposal Accepted' => ['label' => 'A', 'class' => 'rk-contact-stage-accepted'],
    'Lost' => ['label' => 'L', 'class' => 'rk-contact-stage-lost'],
];

@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <div class="rk-contact-hero">
            <div class="rk-contact-avatar">{{ $leadInitials }}</div>
            <div class="rk-contact-hero-copy">
                <span class="rk-page-kicker">Contact dossier</span>
                <h3 class="rk-overview-title">{{ $leadName }} <span>#{{$lead->id}}</span></h3>
                <div class="rk-hero-meta">
                    <span><i class="fa fa-envelope-o"></i>{{ $lead->email ?? 'No email' }}</span>
                    <span><i class="fa fa-phone"></i>{{ $lead->phone ?? 'No mobile' }}</span>
                    <span><i class="fa fa-user-o"></i>{{ $lead->getAssignUserName->name ?? 'Not Assign Yet' }}</span>
                </div>
            </div>
        </div>
        <div class="rk-action-tabs">

            @can('lead_email_access')
            <button class="btn btn-outline-primary rk-action-btn send_email_inner" data-bs-toggle="modal"
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
            <button class="btn btn-outline-warning rk-action-btn view-lead" data-bs-toggle="modal" data-bs-target="#leadDetailsModal">
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

            <button data-lead='@json($lead)' class="btn btn-outline-danger rk-action-btn edit_lead" data-lead='@json($lead)'
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

                <?php 
                    if($lead->proposal_url){
                        $link = $lead->proposal_url;
                    }else{
                        $link = "https://app.opensolar.com/projects/{$lead->project_id}/design";

                    }
                ?>

                <a href="{{$link}}" target="_blank">
                 <button data-lead='@json($lead)' class="btn btn-outline-success rk-action-btn"  >

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
                </svg>View Proposal</button></a>

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
            <span class="rk-lifecycle-value">{{ $currentStatus }} ▼</span>
        </div>

        <!-- ✅ HUBSPOT PIPELINE -->
        <div class="rk-pipeline">
            @foreach($stages as $stage)
            @php($stageIcon = $stageIcons[$stage] ?? ['label' => '', 'class' => 'rk-contact-stage-default'])
            <div class="rk-stage {{ strtolower($currentStatus) == strtolower($stage) ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stage }}')">
                <span class="rk-stage-icon {{ $stageIcon['class'] }}">{{ $stageIcon['label'] }}</span>
                <span class="rk-stage-text">{{ $stage }}</span>
            </div>
            @endforeach
            <form id="statusFormContact" method="POST" action="{{ route('admin.updateContactStatus1') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $lead->contact->id }}">
                <input type="hidden" name="status" id="statusInput">
            </form>
        </div>
    </div>

    <!-- body -->
    <div class="rk-overview-body">
        <input type="hidden" class="lead_id" value="{{ $lead->id }}">

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

        <!-- right -->
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
        <div class="rk-files-card">

            <div class="rk-files-header">
                <h6 class="mb-0"><strong>Attachments ({{$lead->images->count()}})</strong></h6>

                <button id="addFileBtn" class="btn btn-sm btn-outline-primary">
                    + Add Files
                </button>

                <input type="file" id="fileInput" hidden>
            </div>

            <ul class="rk-attach-list">

                @forelse($lead->images as $file)

                <li class="rk-attach-item">

                    {{-- file link --}}
                    <a href="{{ asset(preg_replace('/^admin\//', '', $file->image_path ?? '')) }}" target="_blank" class="rk-attach-link">
                        📎 {{ basename($file->image_path ?? '') }}
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

/* ===== Classic contact details redesign ===== */
.rk-overview-wrapper {
    min-height: calc(100vh - 120px);
    padding: 22px;
    background:
        linear-gradient(180deg, rgba(250, 247, 241, .94), rgba(240, 244, 248, .96)),
        #f7f4ee;
    color: #1f2933;
    font-family: Georgia, "Times New Roman", serif;
}

.rk-overview-header {
    display: flex;
    align-items: stretch;
    justify-content: space-between;
    gap: 18px;
    margin-bottom: 16px;
    padding: 22px;
    border: 1px solid rgba(146, 117, 79, .20);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(15, 23, 42, .96), rgba(30, 64, 175, .90)),
        #172033;
    box-shadow: 0 18px 42px rgba(31, 41, 51, .16);
    color: #fff;
}

.rk-contact-hero {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 0;
}

.rk-contact-avatar {
    display: inline-flex;
    width: 64px;
    height: 64px;
    flex: 0 0 64px;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, .35);
    border-radius: 50%;
    background: linear-gradient(135deg, #14b8a6 0%, #f59e0b 100%);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .38), 0 12px 28px rgba(0, 0, 0, .28);
    color: #fffdf7;
    font-family: "Segoe UI", sans-serif;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: .05em;
}

.rk-contact-hero-copy {
    min-width: 0;
}

.rk-page-kicker {
    display: block;
    margin-bottom: 5px;
    color: rgba(255, 255, 255, .68);
    font-family: "Segoe UI", sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
}

.rk-overview-title {
    margin: 0;
    color: #fff;
    font-size: 28px;
    font-weight: 600;
    line-height: 1.15;
}

.rk-overview-title span {
    color: #bfdbfe;
    font-size: 18px;
    font-weight: 500;
}

.rk-hero-meta {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
    font-family: "Segoe UI", sans-serif;
}

.rk-hero-meta span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 10px;
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 999px;
    background: rgba(255, 255, 255, .08);
    color: rgba(255, 255, 255, .82);
    font-size: 12px;
}

.rk-action-tabs {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    margin: 0;
    flex-wrap: wrap;
}

.rk-action-tabs a {
    text-decoration: none;
}

.rk-action-btn {
    display: inline-flex;
    min-height: 38px;
    align-items: center;
    gap: 7px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .96);
    font-family: "Segoe UI", sans-serif;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 10px 22px rgba(0, 0, 0, .14);
}

.rk-action-btn svg {
    width: 16px;
    height: 16px;
}

.rk-lifecycle-box,
.rk-summary-card,
.rk-notes-card,
.rk-files-card {
    border: 1px solid rgba(146, 117, 79, .18);
    border-radius: 8px;
    background: rgba(255, 255, 255, .96);
    box-shadow: 0 14px 32px rgba(31, 41, 51, .07);
}

.rk-lifecycle-box {
    padding: 16px;
    margin-bottom: 16px;
}

.rk-lifecycle-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.rk-lifecycle-label {
    color: #7c5f36;
    font-family: "Segoe UI", sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.rk-lifecycle-value {
    color: #1f2933;
    font-family: "Segoe UI", sans-serif;
    font-size: 12px;
    font-weight: 700;
}

.rk-pipeline {
    display: flex;
    overflow-x: auto;
    padding: 8px;
    border: 1px solid rgba(214, 173, 96, .24);
    border-radius: 8px;
    background: linear-gradient(180deg, #fbf7ee, #f1f6f7);
}

.rk-stage {
    display: inline-flex;
    position: relative;
    min-height: 40px;
    align-items: center;
    gap: 8px;
    padding: 9px 26px 9px 14px;
    background: #d9ebe7;
    color: #1f3b3a;
    font-family: "Segoe UI", sans-serif;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.rk-stage::after {
    border-top-width: 20px;
    border-bottom-width: 20px;
    border-left-color: #d9ebe7;
}

.rk-stage.active {
    background: #245b57;
    color: #fff;
}

.rk-stage.active::before {
    display: none;
}

.rk-stage.active::after {
    border-left-color: #245b57;
}

.rk-stage-icon {
    display: inline-flex;
    width: 22px;
    height: 22px;
    flex: 0 0 22px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, .64);
    color: #245b57;
    font-size: 11px;
    font-weight: 800;
}

.rk-stage.active .rk-stage-icon {
    background: rgba(255, 255, 255, .18);
    color: #fff;
}

.rk-overview-body {
    display: grid;
    grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
    gap: 16px;
}

.rk-summary-card {
    overflow: hidden;
}

.rk-summary-header {
    padding: 14px 18px;
    border-bottom: 1px solid #eadfce;
    background: linear-gradient(180deg, #fbf7ef, #f5efe4);
    color: #27323a;
    font-family: "Segoe UI", sans-serif;
    letter-spacing: .02em;
}

.rk-summary-content {
    padding: 18px;
}

.rk-summary-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 14px;
}

.rk-summary-row > div {
    min-height: 72px;
    padding: 12px;
    border: 1px solid #edf0f2;
    border-radius: 8px;
    background: #fff;
}

.rk-summary-row label {
    display: block;
    margin-bottom: 5px;
    color: #7b8794;
    font-family: "Segoe UI", sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .07em;
    text-transform: uppercase;
}

.rk-summary-row p {
    margin: 0;
    color: #263238;
    font-family: "Segoe UI", sans-serif;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.45;
    word-break: break-word;
}

.rk-link {
    color: #8b5e34 !important;
    font-weight: 700 !important;
}

.rk-notes-card {
    padding: 16px;
}

.rk-note-input {
    width: 100%;
    height: 96px;
    border: 1px solid #d8e0e7;
    border-radius: 8px;
    background: #fbfdff;
    color: #1f2933;
    font-family: "Segoe UI", sans-serif;
    font-size: 13px;
    padding: 12px;
    margin-bottom: 10px;
    resize: vertical;
}

.rk-notes-card .badge {
    border: 0;
    border-radius: 999px;
    padding: 8px 16px;
    font-family: "Segoe UI", sans-serif;
    font-size: 12px;
}

.rk-notes-list {
    height: 265px;
    margin-top: 14px;
    padding-right: 4px;
    overflow-y: auto;
}

.rk-note-item {
    padding: 12px;
    border: 1px solid #edf0f2;
    border-radius: 8px;
    background: #fff;
    margin-bottom: 10px;
}

.rk-note-item p {
    margin: 0 0 8px;
    color: #263238;
    font-family: "Segoe UI", sans-serif;
    font-size: 13px;
    line-height: 1.45;
}

.rk-note-item span {
    color: #7b8794;
    font-family: "Segoe UI", sans-serif;
    font-size: 11px;
    font-weight: 600;
}

.rk-note-empty {
    border: 1px dashed #d8e0e7;
    border-radius: 8px;
    background: #fbfdff;
}

.rk-files-card {
    margin-top: 16px;
    padding: 16px;
}

.rk-files-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #edf0f2;
    margin-bottom: 12px;
}

.rk-files-header h6 {
    color: #27323a;
    font-family: "Segoe UI", sans-serif;
}

.rk-files-header .btn {
    border-radius: 999px;
    font-family: "Segoe UI", sans-serif;
    font-size: 12px;
    font-weight: 700;
}

.rk-attach-list {
    max-height: 250px;
    padding: 0;
}

.rk-attach-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px dashed #d8e0e7;
    font-family: "Segoe UI", sans-serif;
}

.rk-attach-link {
    color: #245b57;
    font-weight: 700;
}

.rk-attach-empty {
    padding: 14px;
    border: 1px dashed #d8e0e7;
    border-radius: 8px;
    color: #7b8794;
    font-family: "Segoe UI", sans-serif;
}

@media (max-width: 1100px) {
    .rk-overview-header,
    .rk-overview-body {
        grid-template-columns: 1fr;
    }

    .rk-overview-header {
        flex-direction: column;
    }

    .rk-action-tabs {
        justify-content: flex-start;
    }
}

@media (max-width: 768px) {
    .rk-overview-wrapper {
        padding: 14px;
    }

    .rk-contact-hero {
        align-items: flex-start;
    }

    .rk-overview-title {
        font-size: 22px;
    }

    .rk-summary-row {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection

@section('scripts')
@parent
<script>
function changeLeadStatus(status) {
    if (!confirm('Are you sure you want to change the status?')) {
        return;
    }
    document.getElementById('statusInput').value = status;
    document.getElementById('statusFormContact').submit();
}

$(document).on('click', '.generateQuote', function() {
    let leadId = $('.lead_id').val();
    // if hidden input is inside table row
    //alert(leadId); return;
    if (confirm("Are you sure you want to generate this quote?")) {
        let url = "{{ route('admin.generateQuote', ':id') }}";
        url = url.replace(':id', leadId);

        window.location.href = url;
    }
});


$(function() {
    $('#addFileBtn').on('click', function() {
        $('#fileInput').click();
    });

    $('#fileInput').on('change', function() {
        let leadId = $('.lead_id').val();
        let file = this.files[0];
        let formData = new FormData();
        formData.append('file', file);
        formData.append('lead_id', leadId);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("admin.leadImages") }}',
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
