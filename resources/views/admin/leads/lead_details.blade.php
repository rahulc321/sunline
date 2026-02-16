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

// example — replace with your real status
$currentStatus = $lead->status ?? 'New';
$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <h3 class="rk-overview-title">Overview #{{$lead->id}}</h3>
        <div class="rk-action-tabs">
            <div class="rk-action-tab"><a href="javascript:;" data-lead='@json($lead)' data-bs-toggle="modal"
                    data-bs-target="#emailModel">Send Email</a></div>
            <div class="rk-action-tab">
                <a href="javascript:;" class="edit_lead" data-lead='@json($lead)' data-bs-toggle="modal"
                    data-bs-target="#editlead">Edit Lead</a>
            </div>
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
            <div class="rk-stage {{ $currentStatus == $stage ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stage }}')">
                {{ $stage }}
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
                        <a href="{{ $lead->rejection_url }}" target="_blank"
                            onclick="return confirm('Are you sure?');">
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


    </div>


</div>
@include('admin.leads._email_modal',['emailTemplates'=>$emailTemplates])
@include('admin.leads._edit_modal')
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
</script>
@endsection