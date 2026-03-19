@extends('layouts.admin')

@section('title', 'Leads')

@section('content')

@php
error_reporting(0);
$stages = [
'Open',
'In Progress',
'Under Review',
'Closed',
'Cancelled',

];

// example — replace with your real status
$currentStatus = $fri->status ?? 'New';
$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
@endphp

<div class="rk-overview-wrapper">

    <!-- header -->
    <div class="rk-overview-header">
        <h3 class="page-title mb-0 crm_c" style="font-size: 1.875rem">RFI Overview #{{$fri->id}}</h3>

        <div class="rk-action-tabs">


            <button data-lead='@json($lead)' class="btn btn-outline-success edit_rfi" data-lead='@json($fri)'
                data-bs-toggle="modal" data-bs-target="#editFriDetails">

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
                </svg>Edit RFI</button>

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
            <div class="rk-stage {{ $currentStatus == $stage ? 'active' : '' }}"
                onclick="changeLeadStatus('{{ $stage }}')">
                {{ $stage }}
            </div>
            @endforeach
            <form id="statusForm" method="POST" action="{{ route('admin.updateFriStaus') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $fri->id }}">
                <input type="hidden" name="status" id="statusInput">
            </form>
        </div>
    </div>

    <!-- body -->
    <div class="rk-overview-body">

        <!-- left -->
        <div class="rk-summary-card">

            <div class="rk-summary-header">
                <?php
                $class = match($row->priority) {
                    'High' => 'bg-warning',
                    'Medium' => 'bg-info',
                    'Low' => 'bg-success',
                    'Critical' => 'bg-danger',
                    default => 'bg-secondary'
                };
                ?>

                <strong>
                    Summary
                    <span class="badge {{ $class }}">
                        {{ $fri->priority }}
                    </span>
                </strong>

            </div>

            <div class="rk-summary-content">

                <div class="rk-summary-row">

                    <div>
                        <label>Subject</label>
                        <p>{{ $fri->subject }}</p>
                    </div>

                    <div>
                        <label>Category</label>
                        <p>
                            <span class="badge border border-info text-info">
                                {{ $fri->category ?? '-' }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label>Assign To</label>
                        <p>{{ $fri->assigned_user->name.' '.@$fri->assigned_user->last_name ?? '-' }}</p>
                    </div>

                </div>


                <div class="rk-summary-row">

                    <div>
                        <label>Priority</label>
                        <p>{{ $fri->priority ?? 'Normal' }}</p>
                    </div>

                    <div>
                        <label>Type</label>
                        <p>{{ $fri->type ?? 'General' }}</p>
                    </div>

                    <div>
                        <label>Due Date</label>
                        <p>{{ $fri->due_date }}</p>
                    </div>

                </div>


                <div class="rk-summary-row">

                    <div>
                        <label>Created By</label>
                        <p>{{ $fri->createdByName->name ?? 'Unknown' }}</p>
                    </div>

                    <div>
                        <label>Status</label>
                        @php
                        $class = 'bg-secondary';

                        if ($fri->status == 'Open') {
                        $class = 'bg-primary';
                        } elseif ($fri->status == 'In Progress') {
                        $class = 'bg-warning';
                        } elseif ($fri->status == 'Under Review') {
                        $class = 'bg-info';
                        } elseif ($fri->status == 'Closed') {
                        $class = 'bg-success';
                        } elseif ($fri->status == 'Cancelled') {
                        $class = 'bg-danger';
                        }
                        @endphp

                        <div>

                            <p>
                                <span class="badge {{ $class }}">
                                    {{ $fri->status ?? '-' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <label>Created At</label>
                        <p>{{ $fri->created_at->format('d-m-Y') }}</p>
                    </div>

                </div>


                <div class="rk-summary-row">

                    <div style="grid-column: span 3;">
                        <label>Description</label>
                        <p>{{ $fri->description }}</p>
                    </div>

                </div>




            </div>

        </div>



        <!-- right -->
        <div class="rk-notes-card">

            <h6 class="mb-3"><i class="ph-chat-centered-text me-1"></i> Responses</h6>

            <!-- replies container -->
            <div id="repliesContainer" class="rk-notes-list">
                <p class="text-muted">Loading messages...</p>
            </div>

            <!-- reply form -->
            <form id="replyForm" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="ticket_id" value="{{ $fri->id }}">
                <input type="hidden" name="type" value="rfi">

                <textarea id="reply_message" name="message" class="rk-note-input" placeholder="Add a response..."
                    required></textarea>

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <label for="reply_attachment" style="cursor:pointer">
                            <i class="ph-paperclip fs-5 text-secondary"></i>
                        </label>

                        <input type="file" name="attachment" id="reply_attachment" hidden
                            accept="image/*,video/*,.pdf,.doc,.docx">

                        <small id="file_preview" class="text-muted"></small>
                    </div>

                    <button type="submit" class="badge bg-success">
                        Send
                    </button>

                </div>

            </form>

        </div>

        <!-- attachments -->
        <div class="rk-files-card card">

            <div class="rk-files-header">
                <strong>Attachments ({{ $fri->images->count() }})</strong>
                <button id="addFileBtn" class="btn btn-sm btn-outline-primary">+ Add Files</button>
                <input type="file" id="fileInput" hidden>
            </div>

            <ul class="rk-attach-list">

                @forelse($fri->images as $img)

                <li class="rk-attach-item">

                    <a href="{{ asset($img->image_path) }}" target="_blank" class="rk-attach-link">

                        📎 {{ basename($img->image_path) }}

                    </a>

                    <a href="javascript:void(0)" class="text-danger delete-lead-image" data-id="{{ $img->id }}"
                        data-tble="fri_images" title="Delete">
                        <i class="fa fa-trash"></i> Delete
                    </a>

                </li>

                @empty

                <div class="rk-attach-empty">
                    No attachments
                </div>

                @endforelse

            </ul>

        </div>

    </div>


</div>
@include('admin.fri_new._edit_modal', ['users' => $users, 'status' => $status, 'categories' => $categories,'fri' =>
$fri])

 
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

$(function() {
    $('#addFileBtn').on('click', function() {
        $('#fileInput').click();
    });

    $('#fileInput').on('change', function() {
        let friId = "{{$fri->id}}";
        let file = this.files[0];
        let formData = new FormData();
        formData.append('file', file);
        formData.append('fri_id', friId);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("admin.friImages") }}',
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
<script>

const ticketId = "{{ $fri->id }}";
const currentUser = "{{ Auth::id() }}";

function loadReplies() {

    $.ajax({
        url: '/admin/ticketsRepliesList/' + ticketId,
        method: 'GET',
        data: { type: 'rfi' },

        success: function(res) {

            let repliesHtml = '';

            if(res.length){

                res.forEach(r => {

                    let attachmentHtml = '';

                    if(r.attachment){

                        let ext = r.attachment.split('.').pop().toLowerCase();

                        if(['jpg','jpeg','png','gif','webp'].includes(ext)){

                            attachmentHtml = `
                                <a href="/${r.attachment}" target="_blank">
                                    <img src="/${r.attachment}" class="img-fluid rounded mt-1" style="max-width:200px;">
                                </a>
                            `;

                        }else if(['mp4','webm','ogg'].includes(ext)){

                            attachmentHtml = `
                                <video controls class="rounded mt-1" style="max-width:200px;">
                                    <source src="/${r.attachment}">
                                </video>
                            `;

                        }else{

                            attachmentHtml = `
                                <a href="/${r.attachment}" target="_blank" class="d-block mt-1">
                                    <i class="ph-file"></i> Download File
                                </a>
                            `;
                        }
                    }

                    let bubble = `
                        ${r.reply ? `<p class="mb-1">${r.reply}</p>` : ''}
                        ${attachmentHtml}
                        <div class="small mt-1 text-${r.user_id == currentUser ? 'light' : 'muted'}">
                            ${r.created_at_formatted}
                        </div>
                    `;

                    if(r.user_id == currentUser){

                        repliesHtml += `
                            <div class="d-flex justify-content-end mb-2">
                                <div class="p-2 rounded bg-primary text-white small" style="max-width:75%;">
                                    ${bubble}
                                </div>
                            </div>
                        `;

                    }else{

                        repliesHtml += `
                            <div class="d-flex mb-2">
                                <div class="p-2 rounded bg-light small" style="max-width:75%;">
                                    <strong>${r.user?.name}</strong>
                                    ${bubble}
                                </div>
                            </div>
                        `;
                    }

                });

            }else{

                repliesHtml = `<p class="text-muted">No replies yet.</p>`;
            }

            $('#repliesContainer').html(repliesHtml);
            $("#repliesContainer").scrollTop($("#repliesContainer")[0].scrollHeight);

        }

    });

}


// auto load replies
loadReplies();
setInterval(loadReplies, 3000);


// submit reply

$('#replyForm').on('submit', function(e){

    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({

        url: '/admin/ticketsReplies/' + ticketId,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,

        success: function(){

            $('#reply_message').val('');
            $('#reply_attachment').val('');
            $('#file_preview').text('');

            loadReplies();
        }

    });

});


// file preview

$('#reply_attachment').on('change', function(){

    const file = this.files[0];

    if(!file){
        $('#file_preview').text('');
        return;
    }

    $('#file_preview').text("Selected: " + file.name);

});

</script>
@endsection