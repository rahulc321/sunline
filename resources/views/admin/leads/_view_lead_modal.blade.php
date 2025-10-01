<div class="modal fade" id="leadDetailsModal" tabindex="-1" aria-labelledby="leadDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="leadDetailsLabel">Lead Details - <span id="leadName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <input type="hidden" name="lead_id" class="lead_id">
            <input type="hidden" name="send_email_view" class="send_email_view">
            <!-- Body -->
            <div class="modal-body">
                <!-- Contact Info -->
                <div class="mb-0 position-relative">
                    <!-- Contact Info -->
                    <div class="pe-5">
                        <!-- padding-right so text doesn't clash with dropdown -->
                        <!-- Name -->
                        <div class="d-flex align-items-center mb-1 epf" id="leadFullName" style="gap:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-user text-muted-foreground">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <strong><span class="name"></span></strong>
                        </div>

                        <!-- Phone -->
                        <div class="d-flex align-items-center mb-1 epf" id="leadPhone" style="gap:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-phone text-muted-foreground">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            <span class="lead_phone"></span>
                        </div>

                        <!-- Email -->
                        <div class="d-flex align-items-center mb-1 epf" id="leadEmail" style="gap:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-mail text-muted-foreground">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <a href="mailto:abc@yopmail.com"><span class="lead_email">abc@yopmail.com</span></a>
                        </div>

                        <!-- Address -->
                        <div class="d-flex align-items-center epf" id="leadAddress" style="gap:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-map-pin text-muted-foreground">
                                <path
                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                </path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span class="lead_address"></span>
                        </div>
                    </div>

                    <!-- Status Dropdown (top-right) -->
                    <div class="d-flex align-items-center gap-2" style="position: absolute; top: 0; right: 0;">
                        <!-- Sync button -->
                        @can('lead_sync_data')
                        <button class="btn btn-sm btn-warning px-3 py-2 sync" data-bs-toggle="modal"
                            data-bs-target="#syncModel">
                            SYNC
                        </button>
                        @endcan

                        <!-- Status dropdown -->
                        <?php $status = config('fri.lead_status'); ?>
                        <select class="form-select form-select-sm lead_status" style="min-width: 180px;">
                            <option value="">Select Status</option>
                            @foreach($status as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>





                <hr>
                <div class="row">
                    <!-- Lead Information -->
                    <!-- Lead Information -->
                    <div class="col-md-6">
                        <div class="border p-3 rounded">
                            <h6 class="fw-bold">Lead Information</h6>
                            <div class="d-flex justify-content-between epf">
                                <strong>Assigned Rep:</strong> <span class="lead_assign_rep">Vinod Sharma</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Lead Source:</strong> <span class="lead_source">Solar Choice</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Follow-ups:</strong> <span>0</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Last Contacted:</strong> <span>Never</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Quote Sent:</strong> <span>2</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Status:</strong> <span>New</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Shadows:</strong> <span>3</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Roof Type:</strong> <span class="lead_roof_type">Tile</span>
                            </div>
                            <div class="d-flex justify-content-between epf">
                                <strong>Eligible for Rebates:</strong> <span class="lead_rebate">Yes</span>
                            </div>
                        </div>
                    </div>


                    <!-- Call Logs -->
                    <div class="col-md-6">
                        <div class="border p-3 rounded">
                            <h6 class="fw-bold">Call Logs</h6>
                            <!-- <ul class="list-unstyled">
                                <li class="log-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="me-2 text-success">📞</span>
                                            <strong>02 Aug 2025</strong> • 3:12 min
                                            <div class="text-muted small">Contacted</div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-primary">🎵 Recording</button>
                                    </div>
                                </li>

                                <li class="log-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="me-2 text-warning">📞</span>
                                            <strong>04 Aug 2025</strong> • 2:05 min
                                            <div class="text-muted small">Voicemail</div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-primary">🎵 Recording</button>
                                    </div>
                                </li>

                                <li class="log-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="me-2 text-danger">📞</span>
                                            <strong>06 Aug 2025</strong> • 0:08 min
                                            <div class="text-muted small">Rejected</div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary">No Recording</button>
                                    </div>
                                </li>
                            </ul> -->

                            <div class="call-logs"></div>

                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-3">
                    <label class="fw-bold">Notes</label>
                    <textarea class="form-control" placeholder="Add notes about this lead..."></textarea>
                </div>

                <!-- AI Summary -->
                <div class="mt-3 p-2 border rounded bg-light">
                    <strong>AI Summary</strong>
                    <p class="text-muted">AI summary will be generated based on interactions and actions...</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
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

                @can('lead_create_follow_up')
                <button class="btn btn-outline-secondary follow_up" data-bs-toggle="modal"
                    data-bs-target="#createFollowUpModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-plus h-4 w-4 mr-2"
                        data-lov-id="src/components/leads/LeadDetailModal.tsx:230:14" data-lov-name="Plus"
                        data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="230"
                        data-component-file="LeadDetailModal.tsx" data-component-name="Plus"
                        data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg> Create Follow-up</button>
                @endcan
                @can('lead_raise_ticket')
                <button class="btn btn-outline-info d-none"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket h-4 w-4 mr-2"
                        data-lov-id="src/components/leads/LeadDetailModal.tsx:234:14" data-lov-name="Ticket"
                        data-component-path="src/components/leads/LeadDetailModal.tsx" data-component-line="234"
                        data-component-file="LeadDetailModal.tsx" data-component-name="Ticket"
                        data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
                        <path
                            d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z">
                        </path>
                        <path d="M13 5v2"></path>
                        <path d="M13 17v2"></path>
                        <path d="M13 11v2"></path>
                    </svg> Raise Ticket</button>
                @endcan
                @can('lead_call_log')
                <button class="btn btn-outline-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-phone h-4 w-4 mr-2"
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
                @endcan

                @can('lead_delete')
                <button class="btn btn-outline-danger deleteLead">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash-2 h-4 w-4 mr-2">
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    Delete
                </button>
                @endcan
            </div>
        </div>
    </div>
</div>
<style>
.call-logs {
    max-height: 400px;
    /* adjust height as needed */
    overflow-y: auto;
    padding: 0;
    /* remove default padding if any */
    margin: 0;
    /* remove default margin if any */
}

.call-logs ul {
    padding-left: 0;
    /* remove bullet spacing */
    margin: 0;
}
</style>

<script>
$(document).on('change', '.lead_status', function() {
    let leadId = $('.lead_id').val();
    let status = $(this).val();
    // alert(leadId);
    if (!status) return;

    if (!confirm("Are you sure you want to update the status?")) {
        $(this).val($(this).data('old')); // revert back
        return;
    }

    $.ajax({
        url: "{{ route('admin.updateLeadStatus') }}", // define route
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: leadId,
            status: status
        },
        success: function(res) {
            if (res.success) {
                location.reload();
            } else {
                alert("Failed to update status");
            }
        },
        error: function() {
            alert("Something went wrong!");
        }
    });
});

// Delete lead
$(document).on('click', '.deleteLead', function() {
    let leadId = $('.lead_id').val();
    // if hidden input is inside table row
    //alert(leadId); return;
    if (confirm("Are you sure you want to delete this lead?")) {
        let url = "{{ route('admin.deleteLead', ':id') }}";
        url = url.replace(':id', leadId);

        window.location.href = url;
    }
});

// Generate Quote
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


// when the modal is shown
$('#leadDetailsModal').on('shown.bs.modal', function() {
    let leadId = $('.lead_id').val(); // get lead ID from hidden input
    //alert(leadId);

    // show loading message
    $(".call-logs").html('<li class="text-info">Loading call logs...</li>');

    $.ajax({
        url: '/admin/zoomRecordings/' + leadId,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                renderCallLogs(response.logs);
            } else {
                $(".call-logs").html('<li class="text-danger">No call logs found.</li>');
            }
        },
        error: function() {
            $(".call-logs").html('<li class="text-danger">Error fetching logs.</li>');
        }
    });
});


// Render logs into the <ul>
function renderCallLogs(logs) {
    if (logs.length === 0) {
        $(".call-logs").html('<li class="text-muted">No call logs available</li>');
        return;
    }
    // alert(logs.length);
    let html = '';
    logs.forEach(log => {
        // status color based on call duration or type
        let statusClass = 'text-muted';
        if (log.duration > 0) statusClass = 'text-success'; // example: contacted
        else statusClass = 'text-warning';

        // direction: already provided by API
        let direction = log.direction.charAt(0).toUpperCase() + log.direction.slice(1); // Inbound/Outbound

        // show other party number
        let phoneNumber = direction === 'Inbound' ? log.caller_number : log.callee_number;

        // convert duration from seconds to minutes:seconds
        let minutes = Math.floor(log.duration / 60);
        let seconds = log.duration % 60;
        let durationFormatted = `${minutes}:${seconds.toString().padStart(2,'0')} min`;

        // recording button
        let btn = log.download_url ?
        `<div class="audio-item">
            <button class="btn btn-sm btn-outline-primary play-btn"
                    onclick="playRecording('${log.download_url}', '${log.recording_id}', this)">
                🎵 Play
            </button>
            <audio class="zoom-player" controls style="display:none;"></audio>
        </div>` :
        `<div class="audio-item">
            <button class="btn btn-sm btn-outline-secondary" disabled>
                No Recording
            </button>
            <audio class="zoom-player" controls style="display:none;"></audio>
        </div>`;
        
        html += `
        <li class="log-item" style="list-style: none;">
            <div class="d-flex justify-content-between align-items-center">
               <div class="small">
                    <span class="me-2 ${statusClass}">📞</span>
                    <strong>${new Date(log.start_time).toLocaleString()}</strong> ${durationFormatted}
                    <div class="text-info">${direction} • ${phoneNumber}</div>
                </div>
                ${btn}
            </div>
        </li>
    `;
    });


    $(".call-logs").html(html);
}


// create the audio player only once
if (!document.getElementById('zoom-player')) {
    const audio = document.createElement('audio');
    audio.id = 'zoom-player';
    audio.controls = true;
    audio.style.display = 'none';
    audio.style.marginTop = '10px';
    document.body.appendChild(audio);
}

// function to play recording
function playRecording(fullUrl, recording_id, button) {
    const btn = $(button); // the clicked button
    const container = btn.closest('.audio-item'); // wrapper div for this audio
    const player = container.find('.zoom-player')[0];

    // show loading state
    const originalText = btn.text();
    btn.text('Loading...');
    btn.prop('disabled', true);

    // pause all other players
    $('.zoom-player').each(function() {
        if (this !== player) {
            this.pause();
            $(this).hide();
            $(this).closest('.audio-item').find('.play-btn').show().text('🎵 Play').prop('disabled', false);
        }
    });

    $.ajax({
        url: "{{route('admin.audioUrl')}}",
        type: 'POST',
        data: {
            full_url: fullUrl,
            recording_id: recording_id
        },
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            btn.prop('disabled', false);
            if (response.url) {
                btn.hide();
                player.src = response.url;
                player.style.display = 'inline-block';
                player.play().catch(err => console.error("Playback error:", err));
            } else {
                alert('Recording not available');
                btn.text(originalText);
            }
        },
        error: function() {
            alert('Failed to fetch recording.');
            btn.text(originalText);
            btn.prop('disabled', false);
        }
    });
}

</script>