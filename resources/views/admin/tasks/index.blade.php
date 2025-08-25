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
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addTaskModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Add Task
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
                        <div class="fw-bold text-primary fs-5">{{$today}}</div>
                        <small class="text-muted">Due Today</small>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="col-md-3 col-6 mb-2">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-danger fs-5">{{$overdue}}</div>
                        <small class="text-muted">Overdue</small>
                    </div>
                </div>

                <!-- Completed -->
                <div class="col-md-3 col-6 mb-2">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-success fs-5">{{$completed}}</div>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>

                <!-- Pending -->
                <div class="col-md-3 col-6 mb-2">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-warning fs-5">{{$pending}}</div>
                        <small class="text-muted">Pending</small>
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
    @include('admin.tasks._add_modal',['leads'=>$leads])
    @include('admin.tasks._edit_modal',['leads'=>$leads])


    @endsection

    @section('scripts')
    @parent


    <script>
    let offset = 0;
    const limit = 25;
    let isLoading = false;
    let hasMore = true;

    function leadCard(task) {
        const statusColors = {
            "pending": "warning",
            "overdue": "danger",
            "upcoming": "primary",
            "completed": "success"
        };

        const priorityColors = {
            "high": "danger",
            "medium": "warning",
            "low": "success"
        };

        // default values
        let status = task.status?.toLowerCase() ?? 'pending';
        let priority = task.priority?.toLowerCase() ?? 'medium';

        // check due date against today
        if (task.due_date_only) {
            let dueDate = new Date(task.due_date_only);
            let today = new Date();

            // normalize to compare only dates (ignore time)
            dueDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);

            if (dueDate < today) {
                status = "overdue";
            } else if (dueDate > today) {
                status = "upcoming";
            }
            // if equal → keep original (pending/completed)
        }

        let statusColor = statusColors[status] || "secondary";
        let priorityColor = priorityColors[priority] || "secondary";

        return `
<div class="card rounded-3 mb-2 shadow-sm border-0 border-start border-2 border-${statusColor}" id="lead-${task.id}">
    <div class="d-flex justify-content-between align-items-center p-2">
        
        <!-- Left content -->
        <div>
            <h6 class="fw-bold mb-1">${task.lead_name?.first_name ?? 'Sunline'} ${task.lead_name?.last_name ?? 'Sunline'}</h6>
            <p class="text-muted mb-1 small">${task.description ?? 'Follow up on quote sent last week'}</p>
            <div class="text-muted small">
                <i class="ph-user me-1"></i> ${task.get_assign_user_name?.name ?? 'Unassigned'} &nbsp;
                <i class="ph-calendar me-1"></i> ${task.due_date_only ?? ''} &nbsp;
                <i class="ph-clock me-1"></i> ${task.due_time_only ?? ''} &nbsp;
                <i class="ph-chat-circle-text me-1"></i> ${task.task_type ?? ''}
            </div>
        </div>

        <!-- Right content -->
        <div class="text-end">
            <span class="badge bg-light text-${statusColor} border border-${statusColor} rounded-pill px-2 py-1 me-1">
                ${status}
            </span>
            <span class="badge bg-light text-${priorityColor} border border-${priorityColor} rounded-pill px-2 py-1 me-2">
                ${priority}
            </span>
            <button class="btn btn-sm btn-outline-secondary me-1 edit_task" data-rel='${JSON.stringify(task)}' data-bs-toggle="modal" data-bs-target="#editTaskModal">Edit</button>
            <button class="btn btn-sm btn-outline-success d-none">Complete</button>
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



    // on edit button click
    $(document).on("click", ".edit_task", function() {
        let task = $(this).data("rel");
        console.log(task.lead);
        //Fill values in modal fields by name
        $("#editTaskModal [name='id']").val(task.id);
        $("#editTaskModal [name='lead']").val(task.lead);
        $("#editTaskModal [name='assigned_to']").val(task.assigned_to);
        $("#editTaskModal [name='description']").val(task.description);

        // split date & time
        if (task.due_date) {
            let date = task.due_date_only ?? task.due_date.split(" ")[0];
            let time = task.due_time_only1;

            $("#editTaskModal [name='due_date']").val(date);
            $("#editTaskModal [name='due_time']").val(time);
        }

        $("#editTaskModal [name='priority']").val(task.priority);
        $("#editTaskModal [name='task_type']").val(task.task_type);
        $("#editTaskModal [name='status']").val(task.status);
    });
    </script>

    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection