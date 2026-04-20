@extends('layouts.admin')

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
'Lost'
];

$stageIcons = [
'New' => ['icon' => '', 'label' => '✦', 'class' => 'rk-stage-icon-new'],
'Send Intro Email' => ['icon' => '', 'label' => '✈', 'class' => 'rk-stage-icon-email'],
'1st Attempt' => ['icon' => '', 'label' => '1', 'class' => 'rk-stage-icon-attempt-one'],
'2nd Attempt' => ['icon' => '', 'label' => '2', 'class' => 'rk-stage-icon-attempt-two'],
'3rd Attempt' => ['icon' => '', 'label' => '3', 'class' => 'rk-stage-icon-attempt-three'],
'Under Construction' => ['icon' => '', 'label' => '⚒', 'class' => 'rk-stage-icon-construction'],
'Qualified' => ['icon' => '', 'label' => '✓', 'class' => 'rk-stage-icon-qualified'],
'Lost' => ['icon' => '', 'label' => '×', 'class' => 'rk-stage-icon-lost']
];

// example — replace with your real status
$currentStatus = $lead->status ?? 'New';
$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
$leadName = trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? '')) ?: 'Lead';
$leadInitials = strtoupper(substr($lead->first_name ?? 'L', 0, 1) . substr($lead->last_name ?? '', 0, 1));
@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <div class="rk-lead-hero">
            <div class="rk-lead-avatar">{{ $leadInitials ?: 'L' }}</div>
            <div>
                <span class="rk-page-kicker">Lead overview</span>
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
            @can('lead_generate_quote')
            @if(!$lead->project_id)
            <button class="btn btn-outline-success rk-action-btn generateQuote"><svg xmlns="http://www.w3.org/2000/svg" width="24"
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


            <button data-lead='@json($lead)' class="btn btn-outline-danger rk-action-btn edit_lead"
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
                </svg> Edit Lead</button>

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
            <span class="rk-lifecycle-label">Life-cycle stage {{ $currentStatus }} ▼</span>
        </div>

        <!-- ✅ HUBSPOT PIPELINE -->
        <div class="rk-pipeline">
            @foreach($stages as $stage)
            @php($stageIcon = $stageIcons[$stage] ?? ['icon' => 'fa-circle-o', 'label' => '', 'class' => 'rk-stage-icon-default'])
            <div class="rk-stage {{ $currentStatus == $stage ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stage }}')">
                <span class="rk-stage-icon {{ $stageIcon['class'] }}">
                    @if(!empty($stageIcon['icon']))
                    <i class="fa {{ $stageIcon['icon'] }}"></i>
                    @endif
                    @if(!empty($stageIcon['label']))
                    <em>{{ $stageIcon['label'] }}</em>
                    @endif
                </span>
                <span class="rk-stage-text">{{ $stage }}</span>
            </div>
            @endforeach
            <form id="statusForm" method="POST" action="{{ route('admin.updateLeadStatusNew') }}">
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
            <div class="rk-card-title">
                <div>
                    <span class="rk-section-kicker">Activity</span>
                    <strong>Notes</strong>
                </div>
                <span class="rk-soft-count">{{ $lead->leadNotes->count() }}</span>
            </div>

            <form method="POST" action="{{ route('admin.noteStore') }}">
                @csrf
                <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                <textarea name="note" class="rk-note-input" placeholder="Add a note..." required></textarea>
                <button type="submit" class="rk-save-note-btn">Save Note</button>
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
                <div>
                    <span class="rk-section-kicker">Documents</span>
                    <h6 class="mb-0"><strong>Attachments</strong> <span>{{$lead->images->count()}}</span></h6>
                </div>

                <button id="addFileBtn" class="btn btn-sm btn-outline-primary rk-add-file-btn">
                    <i class="fa fa-plus"></i> Add Files
                </button>

                <input type="file" id="fileInput" hidden>
            </div>

            <ul class="rk-attach-list">

                @forelse($lead->images as $file)

                <li class="rk-attach-item">

                    {{-- file link --}}
                    <a href="{{ asset(preg_replace('/^admin\//', '', $file->image_path ?? '')) }}" target="_blank" class="rk-attach-link">
                        <i class="fa fa-paperclip"></i> {{ basename($file->image_path ?? '') }}
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
.rk-overview-wrapper {
    min-height: calc(100vh - 120px);
    padding: 24px;
    overflow-x: hidden;
    border-radius: 0;
    background:
        radial-gradient(circle at top left, rgba(16, 185, 129, .14), transparent 34%),
        radial-gradient(circle at top right, rgba(37, 99, 235, .12), transparent 30%),
        linear-gradient(180deg, #f8fbff 0%, #eef4f8 100%);
    color: #172033;
    font-family: Inter, "Segoe UI", sans-serif;
}

.rk-overview-wrapper,
.rk-overview-wrapper * {
    font-family: inherit;
}

.rk-overview-wrapper {
    font-size: 14px;
    font-weight: 500;
}

.rk-overview-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 18px;
    padding: 22px;
    border: 1px solid rgba(148, 163, 184, .22);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(15, 23, 42, .96), rgba(30, 64, 175, .90)),
        #172033;
    box-shadow: 0 18px 45px rgba(15, 23, 42, .13);
    color: #fff;
}

.rk-lead-hero {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 0;
}

.rk-lead-avatar {
    display: inline-flex;
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, .28);
    border-radius: 8px;
    background: linear-gradient(135deg, #14b8a6, #f59e0b);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .35), 0 14px 30px rgba(0, 0, 0, .22);
    color: #fff;
    font-size: 20px;
    font-weight: 600;
}

.rk-page-kicker,
.rk-section-kicker {
    display: block;
    margin-bottom: 3px;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0;
    text-transform: uppercase;
}

.rk-page-kicker {
    color: rgba(255, 255, 255, .72);
}

.rk-overview-title {
    margin: 0;
    color: #fff;
    font-size: 26px;
    font-weight: 600;
    line-height: 1.18;
}

.rk-overview-title span {
    color: rgba(255, 255, 255, .62);
    font-size: 17px;
    font-weight: 500;
}

.rk-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}

.rk-hero-meta span {
    display: inline-flex;
    max-width: 290px;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, .15);
    border-radius: 999px;
    background: rgba(255, 255, 255, .10);
    color: rgba(255, 255, 255, .88);
    font-size: 12px;
    font-weight: 600;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.rk-action-tabs {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 8px;
    margin: 0;
}

.rk-overview-wrapper .rk-action-btn {
    display: inline-flex;
    min-height: 40px;
    align-items: center;
    gap: 7px;
    border-width: 0;
    border-radius: 8px;
    background: rgba(255, 255, 255, .94);
    box-shadow: 0 10px 22px rgba(15, 23, 42, .14);
    color: #172033;
    font-size: 13px;
    font-weight: 600;
}

.rk-overview-wrapper .rk-action-btn svg {
    width: 16px;
    height: 16px;
}

.rk-overview-wrapper .rk-action-btn:hover {
    transform: translateY(-1px);
    background: #fff;
    color: #0f766e;
}

.rk-lifecycle-box {
    margin-bottom: 18px;
    padding: 16px;
    border: 1px dashed rgba(56, 168, 255, .9);
    border-radius: 10px;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, .94), rgba(246, 252, 255, .88)),
        radial-gradient(circle at top right, rgba(56, 168, 255, .14), transparent 34%);
    box-shadow: 0 12px 28px rgba(15, 23, 42, .05), inset 0 1px 0 rgba(255, 255, 255, .86);
}

.rk-lifecycle-top {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 10px;
}

.rk-lifecycle-label {
    color: #0f2f3d;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: .01em;
}

.rk-pipeline {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    padding: 6px;
    overflow: visible;
    border-radius: 9px;
    background: linear-gradient(180deg, rgba(229, 246, 244, .88), rgba(215, 238, 235, .78));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .92), inset 0 -1px 0 rgba(15, 118, 110, .08);
}

.rk-pipeline #statusForm {
    display: none;
}

.rk-stage {
    position: relative;
    display: inline-flex;
    flex: 1 1 128px;
    min-height: 42px;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-right: -20px;
    padding: 0 34px 0 24px;
    border: 0;
    border-radius: 0;
    background: linear-gradient(180deg, #cdeee8 0%, #bfe5de 100%);
    box-shadow: none;
    clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%, 20px 50%);
    color: #123d48;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .01em;
    line-height: 1;
    white-space: nowrap;
    text-shadow: 0 1px 0 rgba(255, 255, 255, .5);
    transition: background .2s ease, color .2s ease, filter .2s ease, transform .2s ease;
    z-index: 1;
}

.rk-stage::after {
    content: "";
    position: absolute;
    inset: 1px 21px 1px 1px;
    background: linear-gradient(180deg, rgba(255, 255, 255, .30), transparent 58%);
    clip-path: inherit;
    pointer-events: none;
}

.rk-stage span {
    position: relative;
    z-index: 1;
}

.rk-stage-icon {
    display: inline-flex;
    width: 22px;
    height: 22px;
    flex: 0 0 22px;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--rk-status-icon-border, rgba(15, 23, 42, .12));
    border-radius: 999px;
    background: var(--rk-status-icon-bg, rgba(255, 255, 255, .72));
    box-shadow: inset 0 0 0 2px rgba(255, 255, 255, .46);
    color: var(--rk-status-icon-color, #0f766e);
    font-size: 12px;
    line-height: 1;
    text-shadow: none;
}

.rk-stage-icon i,
.rk-stage-icon em {
    line-height: 1;
}

.rk-stage-icon em {
    color: inherit;
    font-size: 12px;
    font-style: normal;
    font-weight: 700;
}

.rk-stage-icon-new {
    --rk-status-icon-bg: #eef0ff;
    --rk-status-icon-border: rgba(99, 102, 241, .28);
    --rk-status-icon-color: #6366f1;
}

.rk-stage-icon-email {
    --rk-status-icon-bg: #ddf7ff;
    --rk-status-icon-border: rgba(6, 182, 212, .28);
    --rk-status-icon-color: #0891b2;
}

.rk-stage-icon-email em {
    font-size: 13px;
    transform: translateX(-1px);
}

.rk-stage-icon-attempt-one {
    --rk-status-icon-bg: #fff4e8;
    --rk-status-icon-border: rgba(249, 115, 22, .36);
    --rk-status-icon-color: #f97316;
}

.rk-stage-icon-attempt-two {
    --rk-status-icon-bg: #fff0ef;
    --rk-status-icon-border: rgba(239, 68, 68, .30);
    --rk-status-icon-color: #ef4444;
}

.rk-stage-icon-attempt-three {
    --rk-status-icon-bg: #fff7e6;
    --rk-status-icon-border: rgba(245, 158, 11, .38);
    --rk-status-icon-color: #d97706;
}

.rk-stage-icon-construction {
    --rk-status-icon-bg: #f0eaff;
    --rk-status-icon-border: rgba(139, 92, 246, .32);
    --rk-status-icon-color: #8b5cf6;
}

.rk-stage-icon-construction em {
    font-size: 13px;
}

.rk-stage-icon-qualified {
    --rk-status-icon-bg: #e8fff3;
    --rk-status-icon-border: rgba(22, 163, 74, .30);
    --rk-status-icon-color: #16a34a;
}

.rk-stage-icon-qualified em,
.rk-stage-icon-lost em {
    font-size: 14px;
}

.rk-stage-icon-lost {
    --rk-status-icon-bg: #fff1f2;
    --rk-status-icon-border: rgba(220, 38, 38, .30);
    --rk-status-icon-color: #dc2626;
}

.rk-stage-icon-default {
    --rk-status-icon-bg: #e6fffb;
    --rk-status-icon-border: rgba(15, 118, 110, .28);
    --rk-status-icon-color: #0f766e;
}

.rk-stage.active .rk-stage-icon {
    border-color: rgba(255, 255, 255, .45);
    background: rgba(255, 255, 255, .92);
    box-shadow: inset 0 0 0 2px rgba(255, 255, 255, .4), 0 4px 10px rgba(6, 78, 70, .18);
}

.rk-stage:first-of-type {
    padding-left: 24px;
    border-radius: 6px 0 0 6px;
    clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 50%, calc(100% - 20px) 100%, 0 100%);
}

.rk-stage:last-of-type {
    margin-right: 0;
    padding-right: 24px;
    border-radius: 0 6px 6px 0;
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%, 20px 50%);
}

.rk-stage:hover {
    filter: brightness(.98) saturate(1.08);
    transform: translateY(-1px);
}

.rk-stage.active {
    background: linear-gradient(180deg, #35c4b7 0%, #16a59a 100%);
    box-shadow: 0 9px 20px rgba(20, 184, 166, .26), inset 0 1px 0 rgba(255, 255, 255, .28);
    color: #fff;
    text-shadow: 0 1px 1px rgba(6, 78, 70, .28);
    z-index: 2;
}

.rk-stage.active::after {
    background: linear-gradient(180deg, rgba(255, 255, 255, .26), transparent 62%);
}

.rk-overview-body {
    display: grid;
    grid-template-columns: minmax(0, 1.8fr) minmax(320px, .9fr);
    gap: 18px;
    align-items: start;
}

.rk-summary-card,
.rk-notes-card,
.rk-files-card {
    position: relative;
    background: #fff;
    border: 0;
    border-radius: 8px;
    box-shadow: 0 16px 35px rgba(15, 23, 42, .07);
}

.rk-summary-card::before,
.rk-notes-card::before,
.rk-files-card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background:
        repeating-linear-gradient(90deg, #38a8ff 0 4px, transparent 4px 8px) top left / 100% 1px no-repeat,
        repeating-linear-gradient(90deg, #38a8ff 0 4px, transparent 4px 8px) bottom left / 100% 1px no-repeat,
        repeating-linear-gradient(180deg, #38a8ff 0 4px, transparent 4px 8px) top left / 1px 100% no-repeat,
        repeating-linear-gradient(180deg, #38a8ff 0 4px, transparent 4px 8px) top right / 1px 100% no-repeat;
    pointer-events: none;
}

.rk-summary-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px;
    border-bottom: 1px solid #eef2f7;
    background: linear-gradient(180deg, #ffffff, #f8fafc);
    color: #0f172a;
    font-size: 15px;
}

.rk-summary-content {
    padding: 18px;
}

.rk-summary-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 12px;
}

.rk-summary-row:last-child {
    margin-bottom: 0;
}

.rk-summary-row > div {
    min-width: 0;
    padding: 14px;
    border: 1px solid #eef2f7;
    border-radius: 8px;
    background: #fbfdff;
}

.rk-summary-row label {
    display: block;
    margin-bottom: 6px;
    color: #64748b;
    font-size: 12px;
    font-weight: 500;
}

.rk-summary-row p {
    margin: 0;
    overflow-wrap: anywhere;
    color: #172033;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.4;
}

.rk-link {
    color: #dc2626 !important;
    cursor: pointer;
    font-weight: 600;
}

.rk-notes-card {
    padding: 16px;
}

.rk-card-title,
.rk-files-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 14px;
}

.rk-card-title strong {
    display: block;
    color: #0f172a;
    font-size: 17px;
}

.rk-soft-count,
.rk-files-header h6 span {
    display: inline-flex;
    min-width: 30px;
    height: 28px;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: #eef6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 600;
}

.rk-note-input {
    width: 100%;
    min-height: 104px;
    margin-bottom: 10px;
    padding: 12px;
    border: 1px solid #dbe4ef;
    border-radius: 8px;
    background: #fbfdff;
    color: #172033;
    font-size: 13px;
    resize: vertical;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.rk-note-input:focus {
    outline: none;
    border-color: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, .12);
}

.rk-save-note-btn,
.rk-add-file-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 36px;
    padding: 8px 13px;
    border: 0;
    border-radius: 8px;
    background: linear-gradient(135deg, #0f766e, #14b8a6);
    box-shadow: 0 10px 20px rgba(20, 184, 166, .20);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
}

.rk-save-note-btn:hover,
.rk-add-file-btn:hover {
    background: linear-gradient(135deg, #115e59, #0f766e);
    color: #fff;
}

.rk-notes-list {
    height: 270px;
    margin-top: 14px;
    padding-right: 4px;
    overflow-y: auto;
}

.rk-note-item {
    margin-bottom: 10px;
    padding: 12px;
    border: 1px solid #eef2f7;
    border-radius: 8px;
    background: linear-gradient(180deg, #fff, #fbfdff);
}

.rk-note-item p {
    margin: 0 0 8px;
    color: #172033;
    font-size: 13px;
    line-height: 1.45;
}

.rk-note-item span {
    color: #64748b;
    font-size: 11px;
    font-weight: 500;
}

.rk-note-empty,
.rk-attach-empty {
    padding: 22px 12px;
    border: 1px dashed #cbd5e1;
    border-radius: 8px;
    background: #fbfdff;
    color: #64748b;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
}

.rk-note-empty p {
    margin: 0;
}

.rk-files-card {
    grid-column: 1 / -1;
    padding: 16px;
}

.rk-attach-list {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 260px;
    overflow-y: auto;
}

.rk-attach-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    padding: 11px 12px;
    border: 1px solid #eef2f7;
    border-radius: 8px;
    background: #fbfdff;
    font-size: 13px;
}

.rk-attach-item + .rk-attach-item {
    margin-top: 8px;
}

.rk-attach-link {
    display: inline-flex;
    min-width: 0;
    align-items: center;
    gap: 8px;
    overflow-wrap: anywhere;
    color: #172033;
    font-weight: 500;
    text-decoration: none;
}

.rk-attach-link:hover {
    color: #0f766e;
}

.rk-attach-item .delete-lead-image {
    flex: 0 0 auto;
    font-size: 12px;
    font-weight: 500;
}

@media (max-width: 1199px) {
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

    .rk-overview-header {
        padding: 18px;
    }

    .rk-lead-hero {
        align-items: flex-start;
    }

    .rk-lead-avatar {
        width: 48px;
        height: 48px;
        flex-basis: 48px;
        font-size: 17px;
    }

    .rk-overview-title {
        font-size: 21px;
    }

    .rk-hero-meta span {
        max-width: 100%;
    }

    .rk-summary-row {
        grid-template-columns: 1fr;
    }

    .rk-card-title,
    .rk-files-header,
    .rk-attach-item {
        align-items: flex-start;
        flex-direction: column;
    }

    .rk-notes-list {
        height: 230px;
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
