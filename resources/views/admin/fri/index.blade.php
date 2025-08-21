@extends('layouts.admin')

@section('title', "FRI")

@section('content')
<style>
.d-flex.justify-content-between {
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
</style>

<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">RFI Management</h4>
                <p class="mb-0 txt_1">Manage requests for information and project communications</p>
            </div>

            <div class="col-md-3 ms-auto">
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Create Fri
                </a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="card p-2 form_1">
            <form class="d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex gap-4 flex-wrap"></div>
                <div>
                    <a href="#" class="btn btn-outline-danger d-flex align-items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor"
                            stroke-width="2" class="lucide lucide-circle-alert h-4 w-4 mr-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" x2="12" y1="8" y2="12"></line>
                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                        </svg>
                        View Follow-ups Due
                    </a>
                </div>
            </form>
        </div>

        <div class="card p-3 form_1">
            <form class="row align-items-end">
                <div class="col-md-4">
                    <label>Search</label>
                    <input type="text" class="form-control" placeholder="Search here...">
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select class="form-select">
                        <option value="">Select</option>
                        @foreach($status as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Priorities</label>
                    <select class="form-select">
                        <option value="">Select</option>
                        @foreach($priority as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>All Category</label>
                    <select class="form-select">
                        <option value="">Select</option>
                        @foreach($category as $value)
                        <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary bg_s">Apply</button>
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
            </form>
        </div>

        <!-- Leads will append here -->
        <div id="leads-container"></div>

        <div class="text-center mt-3">
            <button id="load-more" class="btn btn-primary px-4 bg_s">Load More</button>
        </div>
    </section>

    <!-- Modals -->
    @include('admin.fri._add_modal', ['users' => $users, 'status' => $status, 'categories' => $categories])
    @include('admin.fri._edit_modal', ['users' => $users, 'status' => $status, 'categories' => $categories])
    @include('admin.fri._view_modal',['status' => $status])

    @endsection

    @section('scripts')
    @parent
    <script>
    const statusColors = {
        "Open": "bg-info",
        "In Progress": "bg-warning text-dark",
        "Under Review": "bg-info text-dark",
        "Closed": "bg-success",
        "Cancelled": "bg-danger"
    };

    const priorityColors = {
        "Low": "bg-secondary",
        "Medium": "bg-primary",
        "High": "bg-danger",
        "Critical": "bg-dark"
    };

    function viewFri(fri) {
        if (typeof fri === "string") fri = JSON.parse(fri);

        // main fields
        $(".fri_id").text(fri.id.toString().padStart(4, '0'));
        $('.fri_id1').val(fri.id);
        $("#fri_code").text(fri.code || '');
        $("#fri_title").text(fri.title || '');
        $("#project").text(fri.project || '');
        $("#client").text(fri.client || '');
        $(".created_by").text(fri.created_by_name.name || '');
        $(".due_date").text(fri.due_date || '');
        $(".description").text(fri.description || '');
        $('.fri_status').val(fri.status);
        $('.fri_status').attr('data-id', fri.id);

        $('.fri_data').val(JSON.stringify(fri));


        // badges
        $("#fri_badges").html(generateFriBadges(fri));

        // attachments
        let attachHtml = '';
        if (fri.attachments && fri.attachments.length) {
            fri.attachments.forEach(file => {
                attachHtml += `<li><a href="${file.url}" target="_blank">${file.name}</a></li>`;
            });
        }
        $("#fri_attachments").html(attachHtml);

        // responses
        let responseHtml = '';
        if (fri.responses && fri.responses.length) {
            fri.responses.forEach(r => {
                responseHtml += `
            <div class="border rounded p-2 mb-2">
                <p class="mb-1"><strong>${r.author}</strong> <small class="text-muted">${r.date}</small></p>
                <p class="text-muted small mb-1">${r.message}</p>
                ${r.file ? `<a href="${r.file.url}" target="_blank">${r.file.name}</a>` : ''}
            </div>`;
            });
        }
        $("#fri_responses").html(responseHtml);
    }

    function generateFriBadges(fri) {
        const statusColors = {
            "Open": "bg-info",
            "In Progress": "bg-warning text-dark",
            "Under Review": "bg-info text-dark",
            "Closed": "bg-success",
            "Cancelled": "bg-danger"
        };

        const priorityColors = {
            "Low": "bg-secondary",
            "Medium": "bg-primary",
            "High": "bg-danger",
            "Critical": "bg-dark"
        };

        let badgesHtml = '';

        if (fri.status) {
            const statusClass = statusColors[fri.status] || "bg-secondary";
            badgesHtml += `<span class="badge ${statusClass}">${fri.status}</span>`;
        }

        if (fri.priority) {
            const priorityClass = priorityColors[fri.priority] || "bg-secondary";
            badgesHtml += `<span class="badge ${priorityClass}">${fri.priority}</span>`;
        }

        if (fri.category) {
            badgesHtml += `<span class="badge bg-secondary">${fri.category}</span>`;
        }

        const today = new Date();
        const dueDate = fri.due_date ? new Date(fri.due_date) : null;
        if (dueDate && dueDate < today) {
            badgesHtml += `<span class="badge bg-danger">
                           <i class="bi bi-exclamation-circle me-1"></i> Overdue
                       </span>`;
        }

        return badgesHtml;
    }



    $(document).on("click", ".view-fri", function() {
        let fri = $(this).data("fri");
        viewFri(fri); // call your function
    });

    let offset = 0;
    const limit = 25;
    let isLoading = false;
    let hasMore = true;

    function friCard(fri) {
        const statusColors = {
            "Open": "bg-info",
            "In Progress": "bg-warning text-dark",
            "Under Review": "bg-info text-dark",
            "Closed": "bg-success",
            "Cancelled": "bg-danger"
        };

        // Map priority to bootstrap badge classes
        const priorityColors = {
            "Low": "bg-secondary",
            "Medium": "bg-primary",
            "High": "bg-danger",
            "Critical": "bg-dark"
        };

        const statusClass = statusColors[fri.status] || "bg-secondary";
        const priorityClass = priorityColors[fri.priority] || "bg-primary";

        return `
    <div class="card shadow-sm rounded-3 mb-3" id="fri-${fri.id}">
        <div class="card-body p-3">
            
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    <!-- Info Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        width="18" height="18" 
                        viewBox="0 0 24 24" 
                        fill="none" 
                        stroke="currentColor" 
                        stroke-width="2" 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        class="me-2 text-primary"
                        style="flex-shrink:0;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" x2="12" y1="8" y2="12"></line>
                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                    </svg>

                    <!-- RFI ID -->
                    <h6 class="fw-bold mb-0 me-2">
                        RFI-${fri.id.toString().padStart(4, '0')}
                    </h6>

                    <!-- Status & Priority -->
                    <span class="badge ${statusClass} me-1">${fri.status ?? 'Pending'}</span>
                    <span class="badge ${priorityClass}">${fri.priority ?? 'Normal'}</span>
                </div>

                <!-- View Button -->
                <a href="javascript:;" class="btn btn-outline-primary btn-sm view-fri"
                    data-fri='${JSON.stringify(fri)}'
                    data-bs-toggle="modal" data-bs-target="#rfiDetails">
                    View Details
                </a>
            </div>

            <!-- Title & Description -->
            <h6 class="fw-semibold mb-1">${fri.subject ?? ''}</h6>
            <p class="text-muted small mb-3">${fri.description ?? ''}</p>

            <!-- Meta Info -->
            <div class="small text-muted mb-2">
                <span class="me-3"><i class="ph-briefcase me-1"></i> Project: <strong>${fri.project ?? ''}</strong></span>
                <span class="me-3"><i class="ph-user me-1"></i> Client: <strong>${fri.client ?? ''}</strong></span>
                <span class="me-3"><i class="ph-calendar me-1"></i> Due: <strong>${fri.due_date ?? ''}</strong></span>
                <span><i class="ph-chat-centered-text me-1"></i> Responses: <strong>${fri.responses_count ?? 0}</strong></span>
            </div>

            <!-- Attachments -->
            <div class="small text-muted">
                <i class="ph-paperclip me-1"></i> Attachments: <strong>${fri.attachments_count ?? 0}</strong>
            </div>
        </div>
    </div>`;
    }




    function loadFri() {
        if (isLoading || !hasMore) return;
        isLoading = true;
        $('#load-more').prop('disabled', true).text('Loading...');

        $.ajax({
                url: "{{ route('admin.listFri') }}",
                method: 'GET',
                data: {
                    offset,
                    limit
                }
            })
            .done(function(res) {
                const leads = Array.isArray(res) ? res : (res.data || []);
                if (!leads.length) {
                    hasMore = false;
                    $('#load-more').hide();
                    return;
                }

                leads.forEach(lead => {
                    if (!document.getElementById(`lead-${lead.id}`)) {
                        $('#leads-container').append(friCard(lead));
                    }
                });

                offset += leads.length;
                if (leads.length < limit) {
                    hasMore = false;
                    $('#load-more').hide();
                }

                if (res.followupCount !== undefined) {
                    $('.totalFollowups').text(res.followupCount);
                }
            })
            .always(function() {
                isLoading = false;
                if (hasMore) $('#load-more').prop('disabled', false).text('Load More');
            });
    }

    $(function() {
        $('#load-more').on('click', loadFri);
        loadFri();
    });


    $(document).on("change", ".fri_status", function() {
        const newStatus = $(this).val();
        const friId = $(this).attr('data-id'); // get RFI id

        if (confirm("Are you sure you want to change the status?")) {
            // update badge dynamically
            let fri = $(".modal-content").data('fri');
            if (fri && fri.id.toString() === friId.toString()) {
                fri.status = newStatus;
                $("#fri_badges").html(generateFriBadges(fri));
            }

            // optional: send AJAX to update status in backend
            $.ajax({
                url: "{{route('admin.updateFriStaus')}}", // your backend endpoint
                method: "POST",
                data: {
                    id: friId,
                    status: newStatus
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {


                    location.reload();
                },
                error: function(err) {
                    console.error("Failed to update status");
                }
            });
        } else {
            // reset select to previous status if cancelled
            let fri = $(".modal-content").data('fri');
            if (fri && fri.id.toString() === friId.toString()) {
                $(this).val(fri.status);
            }
        }
    });


    // when clicking Edit Fri
    $(document).on('click', '.editFri', function() {
        let fri = $('.fri_data').val();

        if (typeof fri === 'string') {
            fri = JSON.parse(fri); // if stored as JSON string
        }

        let modal = $('#editFriDetails');

        // reset form every time
        modal.find('form')[0].reset();
        modal.find('select').val('').trigger('change');

        // fill values
        modal.find('input[name="id"]').val(fri.id);
        modal.find('input[name="subject"]').val(fri.subject);
        modal.find('textarea[name="description"]').val(fri.description);
        modal.find('select[name="project"]').val(fri.project).trigger('change');
        modal.find('select[name="client"]').val(fri.client).trigger('change');
        modal.find('select[name="status"]').val(fri.status).trigger('change');
        modal.find('select[name="priority"]').val(fri.priority).trigger('change');
        modal.find('select[name="category"]').val(fri.category).trigger('change');
        modal.find('select[name="assigned_to"]').val(fri.assigned_to).trigger('change');

        modal.find('input[name="due_date"]').val(fri.due_date);

        // finally show modal
        modal.modal('show');
    });
    </script>

    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection