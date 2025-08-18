@extends('layouts.admin')

@section('title', "Leads")

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
    @include('admin.fri._view_lead_modal')
    @include('admin.fri._followup_lead_modal')
    @endsection

    @section('scripts')
    @parent
    <script>
    $(document).on('click', '.follow_up', function() {
        let leadId = $(this).data('id');
        let leadName = $(this).data('name');
        $('.lead_id').val(leadId);
        $('.leadName').text(leadName);
    });

    $(document).on('click', '.view-lead', function() {
        try {
            let lead = $(this).data('lead');
            if (!lead) return;

            $('.follow_up').attr('data-id', lead?.id ?? '');
            $('.follow_up').attr('data-name', [lead.first_name, lead.last_name].filter(Boolean).join(" ") ||
                'N/A');
            $('.name').text([lead.first_name, lead.last_name].filter(Boolean).join(" ") || 'N/A');
            $('.lead_email').text(lead.email ?? 'N/A');
            $('.lead_phone').text(lead.phone ?? 'N/A');
            $('.lead_address').text(lead.address ?? 'N/A');
            $('.lead_source').text(lead.lead_source?.source ?? 'N/A');
            $('.lead_roof_type').text(lead.roof_type ?? 'N/A');
            $('.lead_rebate').text(lead.elogible_for_rebate ?? 'N/A');
            $('.lead_assign_rep').text(lead.get_assign_user_name?.name ?? 'Unassigned');
        } catch (error) {
            console.error("Error filling modal data:", error);
            alert("Something went wrong while loading lead details.");
        }
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
                <a href="{{url('admin/viewFri')}}/${fri.id}" class="btn btn-outline-primary btn-sm view-fri"
                    data-fri='${JSON.stringify(fri)}'
                    >
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
    </script>

    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection