@extends('layouts.super')

@section('title', 'Leads')

@section('content')

@php
$stages = [
'New',
'Send Intro Email',
'1st Attempt',
'2nd Attempt',
'3rd Attempt',
'Under Construction',
'Qualified',
'Sold',
'Lost'
];

// example — replace with your real status
$currentStatus = $lead->status ?? 'New';
$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
$leadName = trim(($lead->first_name ?? '').' '.($lead->last_name ?? '')) ?: 'Lead';
$leadInitial = strtoupper(substr(trim($lead->first_name ?: $lead->last_name ?: $leadName), 0, 1));
@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <div class="rk-overview-title-wrap">
            <span class="rk-lead-avatar">{{ $leadInitial }}</span>
            <div>
                <span class="rk-overview-kicker"><i class="ph ph-sparkle"></i> Lead workspace</span>
                <h3 class="rk-overview-title">Overview #{{$lead->id}}</h3>
                <p class="rk-overview-subtitle">{{ $leadName }} · {{ $lead->leadSource->source ?? 'Direct lead' }}</p>
            </div>
        </div>
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
            <span class="rk-lifecycle-label"><i class="ph ph-chart-line-up"></i> Life-cycle stage</span>
            <span class="rk-lifecycle-value"><i class="ph ph-circle-wavy-check"></i> {{ $currentStatus }}</span>
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

        <!-- left -->
        <div class="rk-summary-card">
            <div class="rk-summary-header">
                <strong><i class="ph ph-user-circle"></i> Summary</strong>

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
            <div class="rk-notes-header">
                <strong><i class="ph ph-note-pencil"></i> Notes</strong>
                <span>{{ $lead->leadNotes->count() }} entries</span>
            </div>

            <form method="POST" action="{{ route('superadmin.noteStore') }}">
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
                <h6 class="mb-0"><strong><i class="ph ph-paperclip"></i> Attachments ({{$lead->images->count()}})</strong></h6>

                <button id="addFileBtn" class="btn btn-sm btn-outline-primary">
                    <i class="ph ph-upload-simple"></i> Add Files
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
                        <i class="ph ph-file"></i> {{ basename($file->image_path) }}
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
@include('super.leads._email_modal',['emailTemplates'=>$emailTemplates])
@include('super.leads._edit_modal')
@include('super.leads.call_logs')
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

/* ===== premium glossy detail refresh ===== */
.content-inner {
    background:
        radial-gradient(circle at 10% 0%, rgba(81, 183, 216, 0.18), transparent 28%),
        radial-gradient(circle at 92% 10%, rgba(54, 179, 126, 0.16), transparent 24%),
        linear-gradient(180deg, rgba(23, 105, 170, 0.05), transparent 260px),
        #f4f8fb;
    padding: 12px !important;
    max-height: calc(100vh - 3.75rem);
    overflow-x: hidden;
    overflow-y: auto !important;
    scroll-behavior: smooth;
}

.content-wrapper {
    min-height: 0;
    overflow: hidden;
}

.rk-overview-wrapper {
    position: relative;
    overflow: visible;
    padding: 0 0 18px;
    background: transparent;
    color: #102033;
}

.rk-overview-wrapper::before {
    content: "";
    position: absolute;
    top: -80px;
    right: 5%;
    width: 300px;
    height: 160px;
    background: url("{{ asset('logo.png') }}") center/contain no-repeat;
    opacity: 0.055;
    filter: drop-shadow(0 0 34px rgba(23, 105, 170, 0.42));
    pointer-events: none;
}

.rk-overview-header,
.rk-lifecycle-box,
.rk-summary-card,
.rk-notes-card,
.rk-files-card {
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(23, 105, 170, 0.14);
    border-radius: 8px;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 252, 255, 0.98)),
        radial-gradient(circle at 0% 0%, rgba(81, 183, 216, 0.18), transparent 30%),
        radial-gradient(circle at 100% 8%, rgba(246, 180, 69, 0.12), transparent 24%);
    box-shadow: 0 18px 44px rgba(16, 32, 51, 0.09), inset 0 1px 0 rgba(255, 255, 255, 0.95);
}

.rk-overview-header::before,
.rk-lifecycle-box::before,
.rk-summary-card::before,
.rk-notes-card::before,
.rk-files-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto;
    height: 3px;
    background: linear-gradient(90deg, #1769aa, #36b37e, #f6b445, #db2777);
    z-index: 1;
}

.rk-overview-header {
    min-height: 96px;
    margin-bottom: 12px;
    padding: 18px;
    background:
        linear-gradient(135deg, rgba(16, 32, 51, 0.97), rgba(23, 105, 170, 0.92) 48%, rgba(54, 179, 126, 0.9)),
        url("{{ asset('vendor/images/demo/cover3.jpg') }}") center/cover no-repeat;
    color: #ffffff;
}

.rk-overview-header::after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 78% 48%, rgba(255, 255, 255, 0.34), transparent 24%),
        linear-gradient(90deg, rgba(255,255,255,0.08), transparent 44%, rgba(255,255,255,0.16));
    pointer-events: none;
}

.rk-overview-header > * {
    position: relative;
    z-index: 2;
}

.rk-overview-title-wrap {
    display: flex;
    align-items: center;
    gap: 13px;
    min-width: 0;
}

.rk-lead-avatar {
    display: inline-flex;
    width: 52px;
    height: 52px;
    min-width: 52px;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #ffffff;
    background: linear-gradient(135deg, #36b37e, #51b7d8);
    border: 2px solid rgba(255, 255, 255, 0.55);
    font-size: 20px;
    font-weight: 900;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.38), 0 16px 30px rgba(4, 18, 32, 0.28);
}

.rk-overview-kicker {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 3px;
    color: rgba(255, 255, 255, 0.78);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.rk-overview-kicker i {
    color: #f6b445;
}

.rk-overview-title {
    color: #ffffff;
    font-size: 26px;
    font-weight: 900;
    letter-spacing: 0;
}

.rk-overview-subtitle {
    margin: 4px 0 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 13px;
    font-weight: 650;
}

.rk-action-tabs {
    justify-content: flex-end;
    margin: 0;
}

.rk-action-tabs .btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    min-height: 36px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.28) !important;
    background: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
    font-size: 12px;
    font-weight: 850;
    backdrop-filter: blur(8px);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.26), 0 10px 22px rgba(4, 18, 32, 0.16);
}

.rk-action-tabs .btn svg {
    width: 16px;
    height: 16px;
    margin-right: 0 !important;
}

.rk-action-tabs .btn:hover {
    transform: translateY(-1px);
    background: rgba(255, 255, 255, 0.2) !important;
}

.rk-lifecycle-box {
    margin-bottom: 12px;
    padding: 14px;
}

.rk-lifecycle-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 11px;
}

.rk-lifecycle-label,
.rk-lifecycle-value {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-weight: 850;
}

.rk-lifecycle-label {
    color: #52667c;
    font-size: 12px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.rk-lifecycle-label i {
    color: #1769aa;
    font-size: 17px;
}

.rk-lifecycle-value {
    min-height: 30px;
    padding: 5px 10px;
    border-radius: 999px;
    border: 1px solid rgba(54, 179, 126, 0.22);
    background: linear-gradient(180deg, #ffffff, #f1fbf7);
    color: #268765;
    font-size: 12px;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.92), 0 9px 20px rgba(54, 179, 126, 0.12);
}

.rk-pipeline {
    gap: 7px;
    padding: 7px;
    background: rgba(232, 242, 249, 0.76);
    border: 1px solid rgba(23, 105, 170, 0.1);
}

.rk-stage {
    border-radius: 8px;
    padding: 9px 13px;
    background: linear-gradient(180deg, #ffffff, #edf7fa);
    color: #52667c;
    border: 1px solid rgba(23, 105, 170, 0.12);
    font-weight: 800;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.92), 0 8px 18px rgba(16, 32, 51, 0.05);
}

.rk-stage::after {
    display: none;
}

.rk-stage:not(:first-child) {
    margin-left: 0;
}

.rk-stage.active {
    background: linear-gradient(135deg, #1769aa, #36b37e);
    color: #ffffff;
    border-color: transparent;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.34), 0 12px 26px rgba(23, 105, 170, 0.2);
}

.rk-overview-body {
    gap: 12px;
}

.rk-summary-card {
    overflow: hidden;
}

.rk-summary-header,
.rk-notes-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px 14px;
    border-bottom: 1px solid rgba(216, 227, 237, 0.82);
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.88), rgba(246, 250, 253, 0.92));
}

.rk-summary-header strong,
.rk-notes-header strong,
.rk-files-header strong {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #102033;
    font-size: 14px;
    font-weight: 900;
}

.rk-summary-header i,
.rk-notes-header strong i,
.rk-files-header strong i {
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #ffffff;
    background: linear-gradient(135deg, #1769aa, #36b37e);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.36), 0 10px 20px rgba(23, 105, 170, 0.18);
}

.rk-notes-header span {
    color: #65758b;
    font-size: 12px;
    font-weight: 800;
}

.rk-summary-content {
    padding: 14px;
}

.rk-summary-row {
    gap: 10px;
    margin-bottom: 10px;
}

.rk-summary-row > div {
    position: relative;
    min-height: 72px;
    padding: 11px 12px;
    border: 1px solid rgba(220, 230, 239, 0.88);
    border-radius: 8px;
    background: linear-gradient(180deg, #ffffff, #f8fcfd);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 8px 20px rgba(16, 32, 51, 0.035);
}

.rk-summary-row > div::before {
    content: "";
    position: absolute;
    left: 0;
    top: 12px;
    bottom: 12px;
    width: 3px;
    border-radius: 0 999px 999px 0;
    background: #1769aa;
}

.rk-summary-row > div:nth-child(2n)::before { background: #36b37e; }
.rk-summary-row > div:nth-child(3n)::before { background: #f6b445; }
.rk-summary-row > div:nth-child(4n)::before { background: #db2777; }

.rk-summary-row label {
    color: #65758b;
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.rk-summary-row p {
    color: #102033;
    font-size: 13px;
    font-weight: 750;
    line-height: 1.35;
    white-space: normal;
    overflow-wrap: anywhere;
}

.rk-notes-card {
    padding: 0;
}

.rk-notes-card form {
    padding: 14px;
    border-bottom: 1px solid rgba(220, 230, 239, 0.8);
}

.rk-note-input {
    height: 88px;
    border: 1px solid rgba(216, 227, 237, 0.96);
    border-radius: 8px;
    background: linear-gradient(180deg, #ffffff, #f7fbfd);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.92), 0 8px 18px rgba(16, 32, 51, 0.04);
}

.rk-notes-card .badge.bg-success {
    border: 0;
    border-radius: 8px;
    padding: 8px 14px;
    background: linear-gradient(135deg, #1769aa, #36b37e) !important;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.35), 0 10px 20px rgba(54, 179, 126, 0.18);
}

.rk-notes-list {
    height: 250px;
    max-height: 250px;
    overflow-y: auto;
    padding: 10px 14px 14px;
}

.rk-note-item {
    margin-bottom: 8px;
    padding: 10px 11px;
    border: 1px solid rgba(220, 230, 239, 0.82);
    border-radius: 8px;
    background: linear-gradient(180deg, #ffffff, #f8fcfd);
    box-shadow: 0 8px 18px rgba(16, 32, 51, 0.035);
}

.rk-note-item p {
    margin-bottom: 5px;
    color: #263d55;
    font-weight: 650;
}

.rk-files-card {
    grid-column: 1 / -1;
    margin-top: 0;
    padding: 0;
}

.rk-files-header {
    padding: 12px 14px;
    border-bottom: 1px solid rgba(216, 227, 237, 0.82);
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.88), rgba(246, 250, 253, 0.92));
}

.rk-files-header .btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border-radius: 8px;
    border-color: rgba(23, 105, 170, 0.2);
    background: linear-gradient(180deg, #ffffff, #f4faf9);
    color: #1769aa;
    font-size: 12px;
    font-weight: 850;
    box-shadow: 0 9px 20px rgba(23, 105, 170, 0.08);
}

.rk-attach-list {
    padding: 12px 14px;
    max-height: 280px;
    overflow-y: auto;
}

.content-inner::-webkit-scrollbar,
.rk-notes-list::-webkit-scrollbar,
.rk-attach-list::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.content-inner::-webkit-scrollbar-track,
.rk-notes-list::-webkit-scrollbar-track,
.rk-attach-list::-webkit-scrollbar-track {
    background: rgba(220, 230, 239, 0.55);
    border-radius: 999px;
}

.content-inner::-webkit-scrollbar-thumb,
.rk-notes-list::-webkit-scrollbar-thumb,
.rk-attach-list::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #1769aa, #36b37e);
    border-radius: 999px;
}

.rk-attach-item {
    margin-bottom: 8px;
    padding: 10px 11px;
    border: 1px solid rgba(220, 230, 239, 0.82);
    border-radius: 8px;
    background: linear-gradient(180deg, #ffffff, #f8fcfd);
    box-shadow: 0 8px 18px rgba(16, 32, 51, 0.035);
}

.rk-attach-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #1769aa;
    font-weight: 800;
}

.rk-attach-link i {
    color: #36b37e;
    font-size: 16px;
}

.delete-lead-image {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-weight: 800;
}

@media (max-width: 991.98px) {
    .rk-overview-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .rk-action-tabs {
        justify-content: flex-start;
    }
}

@media (max-width: 575.98px) {
    .content-inner {
        padding: 8px !important;
    }

    .rk-overview-title {
        font-size: 22px;
    }

    .rk-lead-avatar {
        width: 44px;
        height: 44px;
        min-width: 44px;
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
    document.getElementById('statusForm').submit();
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
