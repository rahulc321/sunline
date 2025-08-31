@extends('layouts.admin')

@section('title', "Support Tickets")

@section('content')
<style>
.d-flex.justify-content-between {
    color: color: hsl(215, 16%, 47%);
    color: hsl(215, 16%, 47%);
    font-size: 16px;

}

.epf {
    font-weight: 500;
    padding: 2px;
}

b,
strong {
    font-weight: 500;
}

.d-flex.justify-content-between.epf {
    border-bottom: 1px solid #f3f3f3;
}

.log-item {
    background: #e8edf9;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

i.ph-user {
    /* background: #0c83ff; */
    color: #6889f3;
}


.ph-calendar:before {
    content: "\f301";
    color: green;
}

.ph-clock:before {
    content: "\f351";
    color: red;
}

.ph-chat-circle-text:before {
    content: "\f335";
    color: #0f33ff;
}
</style>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle stacked -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">Support Tickets</h4>
                <p class="mb-0 txt_1">Manage support requests and GM communications</p>
            </div>

            <div class="col-md-3 ms-auto">
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addTaskModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Raise Ticket
                </a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="card2">
            <div class="row text-center">

                <!-- Due Today -->
                <div class="col-md-3 col-6 mb-2">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-primary fs-5">{{$ticket->where('status','open')->count()}}</div>
                        <small class="text-muted">Open Tickets</small>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="col-md-3 col-6 mb-2">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-danger fs-5">{{$ticket->where('status','responded')->count()}}</div>
                        <small class="text-muted">Responded</small>
                    </div>
                </div>

                <!-- Completed -->
                <div class="col-md-3 col-6 mb-2">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-success fs-5">{{$ticket->where('status','closed')->count()}}</div>
                        <small class="text-muted">Closed</small>
                    </div>
                </div>

                <!-- Pending -->
                <div class="col-md-3 col-6 mb-2">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-warning fs-5">{{$ticket->count()}}</div>
                        <small class="text-muted">Total Tickets</small>
                    </div>
                </div>

            </div>
        </div>


        <div class="card p-3 form_1">
            <form class="row align-items-end">

                <!-- Title -->


                <!-- From Date -->
                <div class="col-md-2">

                    <select class="form-select form-select-sm filter-select">
                        <option>All Tasks</option>
                        <option>Task 1</option>
                        <option>Task 2</option>
                    </select>
                </div>

                <!-- To Date -->
                <div class="col-md-2">
                    <select class="form-select form-select-sm filter-select">
                        <option>All Reps</option>
                        <option>Rep 1</option>
                        <option>Rep 2</option>
                    </select>
                </div>

                <!-- Sales Rep -->
                <div class="col-md-3">
                    <select class="form-select form-select-sm filter-select">
                        <option>All Priorities</option>
                        <option>High</option>
                        <option>Low</option>
                    </select>
                </div>

                <!-- Lead Source -->
                <div class="col-md-3">
                    <select class="form-select form-select-sm filter-select active-filter">
                        <option>Task Type</option>
                        <option>Call</option>
                        <option>Meeting</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary bg_s">Apply</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>

            </form>
        </div>

        <!-- List leads -->
        <div class="card shadow-sm rounded-3 p-4 mb-3 form_1 d-none">
            <div class="d-flex justify-content-between align-items-start">

                <!-- Left: Name & Details -->
                <div>
                    <h5 class="fw-bold mb-1 lead">John Mitchell</h5>
                    <div class="text-muted  mb-1">
                        <i class="ph-phone me-1"></i> +61 2 9876 5432 &nbsp;
                        <i class="ph-envelope me-1 "></i> john.mitchell@email.com
                    </div>
                    <div class="text-muted  mb-2">
                        <i class="ph-map-pin me-1"></i> 123 Solar Street, Sydney NSW 2000
                    </div>
                    <div class=" text-muted">
                        Source: <strong class="text-dark">Solar Choice</strong> &nbsp;|&nbsp;
                        Follow-ups: <strong class="text-dark">0</strong> &nbsp;|&nbsp;
                        Storeys: <strong class="text-dark">2</strong> &nbsp;|&nbsp;
                        Roof: <strong class="text-dark">Tile</strong> &nbsp;|&nbsp;
                        Rebate: <strong class="text-dark">Yes</strong>
                    </div>
                </div>


                <!-- Right: Status & Actions -->
                <div class="d-flex flex-column align-items-center justify-content-center text-center">
                    <span class="badge bg-primary rounded-pill px-3 py-1 mb-2">New</span>
                    <div class="mb-2">
                        <small class="text-muted">Assigned to:</small><br>
                        <strong class="text-dark">Vinod Sharma</strong>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-warning me-1 custom-btn">
                            <i class="ph-envelope-simple"></i>&nbsp; Email
                        </button>
                        <button class="btn btn-sm btn-primary bg_s px-4 py-2">
                            View
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <div id="leads-container"></div>

        <div class="text-center mt-3">
            <button id="load-more" class="btn btn-primary px-4 bg_s">Load More</button>
        </div>




    </section>

    <!--Models -->
    <!-- Add Lead Modal -->
    @include('admin.ticket._add_modal',['leads'=>$leads])
    @include('admin.ticket._reply_modal')
    @include('admin.ticket._edit_modal',['leads'=>$leads])
    @include('admin.ticket._view_modal')


    @endsection

    @section('scripts')
    @parent


    <script>
    let offset = 0;
    const limit = 25;
    let isLoading = false;
    let hasMore = true;

    function ticketCard(ticket) {
        // map urgency to bootstrap classes
        const urgencyMap = {
            low: {
                border: "border-success",
                badge: "bg-light text-success border border-success"
            },
            medium: {
                border: "border-warning",
                badge: "bg-light text-warning border border-warning"
            },
            high: {
                border: "border-danger",
                badge: "bg-light text-danger border border-danger"
            }
        };

        let urgency = (ticket.urgency_label || "low").toLowerCase();
        let urgencyClasses = urgencyMap[urgency] || urgencyMap.low;

        let statusColors = {
            open: "danger", // gray
            closed: "success", // red
            responded: "secondary", // green
            pending: "warning", // yellow
        };

        let status = ticket.status?.toLowerCase() ?? "open";
        let color = statusColors[status] || "secondary";
        let hiddenClass = ticket.status == 'closed' ? 'd-none' : '';



        return `
<div class="card rounded-3 mb-2 shadow-sm border-0 border-start border-2 ${urgencyClasses.border}" id="lead-${ticket.id}">
    <div class="d-flex justify-content-between p-3">
        
        <!-- Left content -->
        <div class="flex-grow-1 pe-3">
            <h6 class="fw-bold mb-1">
                #${ticket.id} - ${ticket.subject ?? 'No subject'}
            </h6>
            <p class="text-muted mb-2 small">
                ${ticket.description ?? ''}
            </p>
        </div>

        <!-- Right content -->
        <div class="text-end" style="white-space:nowrap;">
           <span class="badge bg-light text-${color} border border-${color} rounded-pill px-2 py-1 me-1">
            ${status}
        </span>
            <span class="badge ${urgencyClasses.badge} rounded-pill px-2 py-1 me-2">
                ${ticket.urgency_label ?? 'normal'}
            </span>
        </div>
    </div>

    <!-- Full width gray section -->
    <div class="bg-light text-muted small rounded px-3 py-2 mx-3">
        <div class="row">
            <div class="col-md-3">
                <strong>Submitted By</strong><br>
                User #${ticket.submited.name} 
            </div>
            <div class="col-md-3">
                <strong>Assigned To</strong><br>
                ${ticket.assign_to ? 'Agent #' + ticket.get_assign_user_name.name : 'Unassigned'}
            </div>
            <div class="col-md-3">
                <strong>Category</strong><br>
                ${ticket.category ?? 'General'}
            </div>
            <div class="col-md-3">
                <strong>Submitted</strong><br>
                ${new Date(ticket.created_at).toLocaleString()}
            </div>
        </div>
    </div>

    <!-- Footer actions -->
    <div class="d-flex justify-content-between align-items-center border-top px-3 py-2">
        <div class="text-muted small">
            <i class="ph-chat-circle-dots me-1"></i> 
            Last response: ${ticket.updated_at ? new Date(ticket.updated_at).toLocaleString() : 'N/A'}

            <span class="ms-2 ${ticket.status === 'closed' ? 'text-success' : 'd-none'}">
               <i class="ph-check-circle me-1"></i>${ticket.status === 'closed' ? 'Resolved' : ''}
            </span>

            </div>
        <div class="d-flex align-items-center">
            <button class="btn btn-sm btn-outline-secondary me-2 reply" data-id="${ticket.id}" data-bs-toggle="modal" data-bs-target="#replyModel">
                <i class="ph-chat-centered-text me-1"></i> Reply
            </button>

            <div class="d-flex align-items-center">
            <button class="btn btn-sm btn-outline-secondary me-2 edit_ticket" data-ticket='${JSON.stringify(ticket)}' data-bs-toggle="modal" data-bs-target="#editModel">
                <i class="ph-pencil-line me-1"></i> Edit
            </button>

           <a href="/admin/closeTicket/${ticket.id}"
            class="btn btn-sm btn-outline-danger me-2 ${hiddenClass}"
            onclick="return confirm('Are you sure you want to close this ticket?')">
            <i class="ph-x-circle me-1"></i> Close
            </a>
            <button class="btn btn-sm btn-primary bg_s view_ticket" data-ticket='${JSON.stringify(ticket)}' data-bs-toggle="modal" data-bs-target="#viewModel">
                <i class="ph-ticket me-1"></i> View Details
            </button>
        </div>
    </div>
</div>
`;
    }



    function loadLeads() {
        if (isLoading || !hasMore) return;

        isLoading = true;
        $('#load-more').prop('disabled', true).text('Loading...');

        $.ajax({
                url: "{{ route('admin.getTicket') }}",
                method: 'GET',
                data: {
                    offset,
                    limit
                },
            })
            .done(function(res) {
                // Support either {data:[...]} or just [...]
                const leads = Array.isArray(res) ? res : (res.data || []);
                if (!leads.length) {
                    hasMore = false;
                    $('#load-more').hide();
                    return;
                }

                let appended = 0;
                leads.forEach(lead => {
                    if (!document.getElementById(`lead-${lead.id}`)) {
                        $('#leads-container').append(ticketCard(lead));
                        appended++;
                    }
                });

                // Advance by what server returned (safer on last page)
                offset += leads.length;

                // If fewer than limit came back, no more pages
                if (leads.length < limit) {
                    hasMore = false;
                    $('#load-more').hide();
                }


                $('.totalFollowups').text(res.followupCount);


            })
            .always(function() {
                isLoading = false;
                if (hasMore) $('#load-more').prop('disabled', false).text('Load More');
            });
    }

    // first load
    $(function() {
        $('#load-more').on('click', loadLeads);
        loadLeads();
    });


    // function to fetch and render replies
    // load replies
    function loadReplies(ticketId) {
        var currentUser = "{{Auth::id()}}";
        $.ajax({
            url: '/admin/ticketsRepliesList/' + ticketId,
            method: 'GET',
            data:{'type':'ticket'},
            success: function(res) {
                let repliesHtml = '';

                if (res.length) {
                    res.forEach(r => {
                        let attachmentHtml = '';

                        if (r.attachment) {
                            let ext = r.attachment.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                // image clickable
                                attachmentHtml = `
                                                    <a href="/${r.attachment}" target="_blank">
                                                        <img src="/${r.attachment}" class="img-fluid rounded mt-1" style="max-width:200px;">
                                                    </a>
                                                `;
                            } else if (['mp4', 'webm', 'ogg'].includes(ext)) {
                                // video
                                attachmentHtml = `
                                                    <video controls class="rounded mt-1" style="max-width:200px;">
                                                        <source src="/${r.attachment}" type="video/${ext}">
                                                    </video>
                                                `;
                            } else if (['pdf'].includes(ext)) {
                                attachmentHtml = `
                                                    <a href="/${r.attachment}" target="_blank" class="d-block mt-1">
                                                        <i class="ph-file-pdf me-1"></i> View PDF
                                                    </a>
                                                `;
                            } else {
                                attachmentHtml = `
                                                    <a href="/${r.attachment}" target="_blank" class="d-block mt-1">
                                                        <i class="ph-file me-1"></i> Download File
                                                    </a>
                                                `;
                            }
                        }


                        // bubble HTML
                        let bubbleHtml = `
                        ${r.reply ? `<p class="mb-1">${r.reply}</p>` : ''}
                        ${attachmentHtml}
                        <div class="small mt-1 text-${r.user_id == currentUser ? 'light' : 'muted'}">
                            ${r.created_at_formatted}
                        </div>
                    `;

                        if (r.user_id == currentUser) {
                            repliesHtml += `
                            <div class="d-flex justify-content-end mb-2">
                                <div class="p-2 rounded bg-primary text-white small bg_s" style="max-width:75%;">
                                    ${bubbleHtml}
                                </div>
                            </div>
                        `;
                        } else {
                            repliesHtml += `
                            <div class="d-flex mb-2">
                                <div class="p-2 rounded bg-light text-dark small" style="max-width:75%;">
                                    <strong><i class="ph-user me-2"></i>${r.user?.name}</strong>
                                    ${bubbleHtml}
                                </div>
                            </div>
                        `;
                        }
                    });
                } else {
                    repliesHtml = `<p class="text-muted">No replies yet.</p>`;
                }

                $('#repliesContainer').html(repliesHtml);
                $("#repliesContainer").scrollTop($("#repliesContainer")[0].scrollHeight);
            }
        });
    }


    // open modal + load replies
    $(document).on('click', '.reply', function() {
        let ticketId = $(this).data('id');
        $('#reply_ticket_id').val(ticketId);
        loadReplies(ticketId);
    });

    // submit reply
    $('#replyForm').on('submit', function(e) {
        e.preventDefault();

        let ticketId = $('#reply_ticket_id').val();
        let formData = new FormData(this); // includes message + attachment + CSRF token

        $.ajax({
            url: '/admin/ticketsReplies/' + ticketId,
            method: 'POST',
            data: formData,
            contentType: false, // important for file upload
            processData: false, // important for file upload
            success: function(res) {
                $('#reply_message').val(''); // clear textarea
                $('#reply_attachment').val(''); // clear file input
                loadReplies(ticketId); // reload replies
            },
            error: function(err) {
                console.error(err);
                alert('Failed to send reply');
            }
        });
    });

    // Edit tickects
    $(document).on('click', '.edit_ticket', function() {
        let ticket = $(this).data('ticket');
        console.log(ticket);
        // populate modal fields using name attribute
        $('#editModel [name="subject"]').val(ticket.subject);
        $('#editModel [name="category"]').val(ticket.category);
        $('#editModel [name="urgency_label"]').val(ticket.urgency_label);
        $('#editModel [name="assign_to"]').val(ticket.assign_to);
        $('#editModel [name="description"]').val(ticket.description);
        $('#editModel [name="status"]').val(ticket.status);

        // optional: change modal title or submit button text
        $('#editModel .modal-title').text('Edit Ticket');
        // optional: set form action dynamically
        $('#editModel form').attr('action', '/admin/ticketUpdate/' + ticket.id);
    });

    $(document).on("click", ".view_ticket", function() {
        let ticket = $(this).data("ticket");
        console.log(ticket.get_assign_user_name.name);
        $("#ticket_subject").text(ticket.subject);
        $("#ticket_status").text(ticket.status);
        $("#ticket_user").text(ticket.submited?.name ?? "N/A");

        $("#assign_to1").text(ticket.get_assign_user_name.name ?? "N/A");
        
        $("#categoryv").text(ticket.category);
        $("#ticket_description").text(ticket.description);
    });
    </script>

    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection