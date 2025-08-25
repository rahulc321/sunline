@extends('layouts.admin')

@section('title', "Task")

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
</style>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle stacked -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">Tasks & Follow-ups</h4>
                <p class="mb-0 txt_1">Manage follow-up activities and task scheduling</p>
            </div>

            <div class="col-md-3 ms-auto">
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Add Lead
                </a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="card p-2 form_1">
            <form class="d-flex align-items-center justify-content-between flex-wrap">

                <!-- Left stats -->
                <div class="d-flex gap-4 flex-wrap">

                    <!-- New Leads -->
                    <div class="d-flex align-items-center">
                        <div class="rounded p-2 d-flex align-items-center justify-content-center"
                            style="background-color: #eef4ff; width: 40px; height: 40px;">
                            <!-- icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-users h-5 w-5 text-primary">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <small class="text-muted">New Leads</small>
                            <div class="fw-bold fwb">{{$leads->where('status', 'New')->count()}}</div>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="d-flex align-items-center">
                        <div class="rounded p-2 d-flex align-items-center justify-content-center"
                            style="background-color: #e9f9ee; width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-clock h-5 w-5 text-secondary">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <small class="text-muted">Under Construction</small>
                            <div class="fw-bold fwb">{{$leads->where('status', 'Under Construction')->count()}}</div>
                        </div>
                    </div>

                    <!-- Follow-ups Due -->
                    <div class="d-flex align-items-center">
                        <div class="rounded p-2 d-flex align-items-center justify-content-center"
                            style="background-color: #fdecec; width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-circle-alert h-5 w-5 text-destructive">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#followUpModal"><small
                                    class="text-muted">Follow-ups Due</small></a>
                            <div class="fw-bold fwb totalFollowups">7</div>
                        </div>
                    </div>
                </div>

                <!-- Right button -->
                <div>
                    <a href="#" class="btn btn-outline-danger d-flex align-items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-alert h-4 w-4 mr-2"
                            data-lov-id="src/components/leads/LeadsSummaryBar.tsx:62:12" data-lov-name="AlertCircle"
                            data-component-path="src/components/leads/LeadsSummaryBar.tsx" data-component-line="62"
                            data-component-file="LeadsSummaryBar.tsx" data-component-name="AlertCircle"
                            data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-2%22%7D">
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

                <!-- Title -->
                <div class="col-12">
                    <h6 class="mb-3">
                        <i class="bi bi-funnel"></i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-filter h-5 w-5 text-primary"
                            data-lov-id="src/components/dashboard/DashboardFilters.tsx:67:8" data-lov-name="Filter"
                            data-component-path="src/components/dashboard/DashboardFilters.tsx" data-component-line="67"
                            data-component-file="DashboardFilters.tsx" data-component-name="Filter"
                            data-component-content="%7B%22className%22%3A%22h-5%20w-5%20text-primary%22%7D">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg> Dashboard Filters
                    </h6>
                </div>

                <!-- From Date -->
                <div class="col-md-2">
                    <label>From Date</label>
                    <input type="date" class="form-control">
                </div>

                <!-- To Date -->
                <div class="col-md-2">
                    <label>To Date</label>
                    <input type="date" class="form-control">
                </div>

                <!-- Sales Rep -->
                <div class="col-md-3">
                    <label>Sales Rep</label>
                    <select class="form-select">
                        <option>All Sales Reps</option>
                        <option>Rep 1</option>
                        <option>Rep 2</option>
                    </select>
                </div>

                <!-- Lead Source -->
                <div class="col-md-3">
                    <label>Lead Source</label>
                    <select class="form-select">
                        <option>All Sources</option>
                        <option>Source 1</option>
                        <option>Source 2</option>
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
    @include('admin.tasks._add_modal')
    @include('admin.tasks._view_modal')


    @include('admin.leads._email_modal',['emailTemplates'=>$emailTemplates])

    <!-- Follow-up Modal -->
    <!-- Follow-up Modal -->








    @endsection

    @section('scripts')
    @parent


    <script>
    let offset = 0;
    const limit = 25;
    let isLoading = false;
    let hasMore = true;

    function leadCard(lead) {
        const statusColors = {
            "pending": "warning",
            "overdue": "danger",
            "upcoming": "primary",
            "completed": "success"
        };

        let status = lead.status?.toLowerCase() ?? 'pending';
        let color = statusColors[status] || "secondary";

        return `
    <div class="card shadow-sm rounded-3 mb-3 border-start border-4 border-${color}" id="lead-${lead.id}">
        <div class="d-flex justify-content-between align-items-start p-3">
            
            <!-- Left content -->
            <div>
                <h6 class="fw-bold mb-1">Rahul Chauhan</h6>
                <p class="text-muted mb-2">${lead.notes ?? 'Follow up on quote sent last week'}</p>
                <div class="text-muted small mb-1">
                    <i class="ph-user me-1"></i> ${lead.get_assign_user_name?.name ?? 'Unassigned'}
                </div>
                <div class="text-muted small">
                    <i class="ph-calendar me-1"></i> 08/02/2024 &nbsp;
                    <i class="ph-clock me-1"></i> 10:00 AM &nbsp;
                    <i class="ph-chat-circle-text me-1"></i> follow-up
                </div>
            </div>

            <!-- Right content -->
            <div class="text-end">
                <div class="mb-2">
                    <span class="badge bg-light text-${color} border border-${color} rounded-pill px-2 py-1 me-1">
                        ${status}
                    </span>
                    <span class="badge bg-light text-danger border border-danger rounded-pill px-2 py-1">
                        high
                    </span>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-outline-secondary me-2">Edit</button>
                    <button class="btn btn-sm btn-success">Complete</button>
                </div>
            </div>

        </div>
    </div>`;
    }




    function loadLeads() {
        if (isLoading || !hasMore) return;

        isLoading = true;
        $('#load-more').prop('disabled', true).text('Loading...');

        $.ajax({
                url: "{{ route('admin.getTask') }}",
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
                        $('#leads-container').append(leadCard(lead));
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
    </script>

    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection