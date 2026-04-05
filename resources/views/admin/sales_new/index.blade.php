@extends('layouts.admin')

@section('title', "Sales")

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

.badge {
    min-width: calc(var(--badge-padding-y) * 2 + var(--badge-font-size));
    /* box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px; */
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
}

.rk-stage-wrapper {
    display: flex;
    overflow-x: auto;
    background: #dfeceb;
    padding: 10px;
    border-radius: 8px;
}

/* each step */
.rk-stage-item {
    position: relative;
    padding: 10px 22px;
    font-size: 13px;
    color: #2c3e50;
    background: #b7d8d4;
    margin-right: 4px;
    white-space: nowrap;
    clip-path: polygon(0 0,
            calc(100% - 16px) 0,
            100% 50%,
            calc(100% - 16px) 100%,
            0 100%);
    transition: all .15s ease;
}

/* first */
.rk-stage-item:first-child {
    border-radius: 6px 0 0 6px;
}

/* last */
.rk-stage-item:last-child {
    margin-right: 0;
    border-radius: 0 6px 6px 0;
}

/* active stage (like Lost in screenshot) */
.rk-stage-item.active {
    background: #3aa69b;
    color: #fff;
    font-weight: 600;
}

/* clickable hover */
.rk-clickable {
    cursor: pointer;
}

.rk-clickable:hover {
    transform: translateY(-1px);
}

.card.ll {
    margin-left: -20px;
    margin-right: -20px;
}
</style>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex w-100">
            <!-- Title + subtitle stacked -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">Sales Pipeline</h4>
                <p class="mb-0 txt_1">
                    Track closed deals and sales performance</p>
            </div>

            <div class="col-md-3 ms-auto">
                @can('lead_add')
                <!-- <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Add Lead
                </a> -->


                @endcan
            </div>

        </div>
    </div>
    <?php $status = config('fri.lead_status'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="card2">
            <div class="row text-center">

                <!-- Due Today -->
                <div class="col-md-3 col-6">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-success fs-5">₹<span class="totalCommision">0</span></div>
                        <small class="text-muted">Total Commision</small>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="border rounded p-3">
                        <div class="fw-bold text-success fs-5">₹<span class="totalPayout">0</span></div>
                        <small class="text-muted">Total Payout</small>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Main content -->
    <section class="content">

        <div class="card p-3 form_1">
            <form id="leadFilterForm">

                <div class="row g-3">

                    <!-- Lead Source -->
                    <div class="col-md-3">
                        <label class="form-label1">Lead Source</label>
                        <select name="lead_source" id="lead_source" class="form-control">
                            <option value="">Select All</option>
                            @foreach($leadSource as $data)
                            <option value="{{ $data->id }}">{{ $data->source }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sales Rep -->
                    <div class="col-md-3">
                        <label class="form-label1">Sales Rep</label>
                        <select name="assign_rep" id="assign_rep" class="form-control">
                            <option value="">Select All</option>
                            <option value="unassigned">Unassigned</option>
                            @foreach($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-2">
                        <label class="form-label1">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Select All</option>
                            @foreach($status as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="col-md-2">
                        <label class="form-label1">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control">
                    </div>

                    <!-- To Date -->
                    <div class="col-md-2">
                        <label class="form-label1">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control">
                    </div>

                </div>

                <!-- Buttons Row -->
                <div class="row mt-3">
                    <div class="col-md-12 d-flex gap-2">
                        <button type="button" class="btn btn-primary apply">
                            Apply
                        </button>

                        <button type="reset" class="btn btn-outline-secondary reset">
                            Reset
                        </button>

                        <!-- <button type="button" class="btn btn-success exportCsv">
                            Export CSV
                        </button> -->
                    </div>
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


        <div id="leads-container1"></div>

        <!-- <div class="text-center mt-3">
            <button id="load-more" class="btn btn-primary px-4 bg_s">Load More</button>
        </div> -->

        <div class="content pt-0">

            <!-- Dashboard content -->
            <div class="row">
                <div class="col-xl-12">

                    <div class="card ll">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class=" table table-bordered table-striped table-hover datatable datatable-Role text-wrap"
                                    id="leadList">
                                    <thead>
                                        <tr>

                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Lead Name
                                            </th>
                                            <th>
                                                Phone
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Address
                                            </th>
                                            <th>Status</th>
                                            <th>
                                                Lead Sourse
                                            </th>
                                            <th>Sales Rep</th>
                                            <th>Category</th>
                                            <th>Created At</th>
                                            
                                        </tr>
                                    </thead>

                                </table>
                                <div id="no-data-container"></div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>




    </section>

    <style>
    #leadList th,
    #leadList td {
        white-space: nowrap;
    }

    /* enable bottom horizontal scroll for DataTable */
    .dataTables_wrapper {
        width: 100%;
    }
    </style>

    <!--Models -->
    <!-- Add Lead Modal -->
    @include('admin.leads._add_lead_modal')
    @include('admin.leads._edit_modal')
    @include('admin.leads._view_lead_modal')
    @include('admin.leads._followup_lead_modal')
    @include('admin.leads._sync_modal')
    @include('admin.leads._listfollowup_modal', [
    'upcoming' => $upcoming,
    'past' => $past
    ])
    @include('admin.leads._email_modal',['emailTemplates'=>$emailTemplates])

    <!-- Follow-up Modal -->
    <!-- Follow-up Modal -->








    @endsection

    @section('scripts')
    @parent


    <script>
    $(function() {

        let table = $('#leadList').DataTable({
            processing: true,
            serverSide: true,
            // scrollY: '100vh',        // vertical scroll (adjust height)
            // scrollX: true,          // horizontal scroll
            // scrollCollapse: true,
            responsive: false,
            pageLength: 10,
            order: [
                [0, 'desc']
            ],

            ajax: {
                url: "{{ route('admin.getSale') }}",
                data: function(d) {
                    d.lead_source = $('#lead_source').val();
                    d.assign_rep = $('#assign_rep').val();
                    d.status = $('#status').val();
                },
                dataSrc: function(json) {

                    $('.totalCommision').html(json.totalCommision);
                    $('.totalPayout').html(json.totalPayout);

                    return json.data;
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'lead_source',
                    name: 'lead_source'
                },
                {
                    data: 'salesRep',
                    name: 'salesRep'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                } 
            ]
        });

        /* Apply filter */
        let applyBtn = $('.apply');

        $('.apply').on('click', function() {
            applyBtn.text('Applying...');
            table.ajax.reload();
        });

        /* Reset filter */
        $('.reset').on('click', function() {
            applyBtn.text('Applying...');
            $('#leadFilterForm')[0].reset();
            table.ajax.reload();
        });

        /* Restore button text after request */
        table.on('xhr.dt', function() {
            applyBtn.text('Apply');
        });



    });


    $(document).on('click', '.follow_up', function() {
        let leadId = $(this).data('id'); // get lead id from button
        let leadName = $(this).data('name');
        $('.lead_id').val(leadId); // put it in hidden input of form
        $('.leadName').text(leadName);
    });

    $(document).on('click', '.view-lead', function() {
        try {
            let lead = $(this).data('lead'); // get JSON data safely

            if (!lead) {
                console.error("No lead data found on clicked element.");
                return;
            }

            // Fill modal fields with fallbacks
            $('.lead_id').val(lead?.id ?? '');
            $('.follow_up').attr('data-id', lead?.id ?? '');
            $('.follow_up').attr('data-name', [lead.first_name, lead.last_name].filter(Boolean).join(" ") ||
                'N/A');
            $('.name').text(
                [lead.first_name, lead.last_name].filter(Boolean).join(" ") || 'N/A'
            );
            $('#leadName').text(
                [lead.first_name, lead.last_name].filter(Boolean).join(" ") || 'N/A'
            );
            $('.lead_email').text(lead.email ?? 'N/A');
            $('.lead_phone').text(lead.phone ?? 'N/A');
            $('.lead_address').text(lead.address ?? 'N/A');
            $('.lead_status').val(lead.status ?? 'N/A');
            $('.lead_notes').text(lead.notes ?? '');

            $('.rejection_url').html(
                lead.rejection_url ?
                `<a href="${lead.rejection_url}" target="_blank" rel="noopener noreferrer">
                        ${lead.rejection_url}
                    </a>` :
                ' '
            );

            // Handle nested objects safely
            $('.lead_source').text(lead.lead_source?.source ?? 'N/A');
            $('.lead_roof_type').text(lead.roof_type ?? 'N/A');
            $('.lead_rebate').text(lead.elogible_for_rebate ?? 'N/A');
            $('.send_email_view').val(JSON.stringify(lead));

            // Assign user name safely
            $('.lead_assign_rep').text(lead.get_assign_user_name?.name ?? 'Unassigned');


            // attachments
            $('.fileCount').text('');
            $(".fileList").html('');
            let attachHtml = '';
            if (lead.images && lead.images.length) {
                lead.images.forEach(file => {
                    let fileUrl = file.image_path.replace(/^admin\//, '');
                    attachHtml += `<li><a href="/${fileUrl}" target="_blank">${file.image_path}</a>
                         <a href="javascript:void(0)"
                   class="text-danger delete-lead-image"
                   data-id="${file.id}"
                   data-tble="lead_images"
                   title="Delete">
                    <i class="fa fa-trash">Delete</i>
                </a>
                    </li>`;
                });
            }
            $('.fileCount').text(lead.images ? lead.images.length : 0);
            $(".fileList").html(attachHtml);

        } catch (error) {
            console.error("Error filling modal data:", error);
            alert("Something went wrong while loading lead details.");
        }
    });


    function leadCard(lead) {
        const statusColors = {
            "New": "primary",
            "Send Intro Email": "info",
            "1st Attempt": "warning",
            "2nd Attempt": "warning",
            "3rd Attempt": "warning",
            "Under Construction": "secondary",
            "Qualified": "success",
            "Lost": "danger"
        };

        let color = statusColors[lead.status] || "secondary"; // fallback

        return `
    <div class="card shadow-sm rounded-3 p-4 mb-3 form_1" id="lead-${lead.id}">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="mb-2">
                <h5 class="fw-bold mb-1 lead">
                    #${lead.id ?? ''} - ${lead.first_name ?? ''} ${lead.last_name ?? ''}
                    ${lead.project_id ? `<small class="text-warning fst-italic ms-2">Quote created</small>` : ''}
                </h5>
                
                <div class="text-muted mb-1">
                    <i class="ph-phone me-1"></i> ${lead.phone ?? ''} &nbsp;
                    <i class="ph-envelope me-1"></i> ${lead.email ?? ''}
                </div>
                <div class="text-muted mb-2">
                    <i class="ph-map-pin me-1"></i> ${lead.address ?? ''}
                </div>
                <div class="text-muted">
                    Source: <strong class="text-dark">${lead.lead_source?.source ?? ''}</strong> &nbsp;|&nbsp;
                    Follow-ups: <strong class="text-dark">${lead.lead_follow_up_count ?? 0}</strong> &nbsp;|&nbsp;
                    Storeys: <strong class="text-dark">${lead.storeys ?? ''}</strong> &nbsp;|&nbsp;
                    Roof: <strong class="text-dark">${lead.roof_type ?? ''}</strong> &nbsp;|&nbsp;
                    Rebate: <strong class="text-dark">${lead.elogible_for_rebate ?? ''}</strong> &nbsp;|&nbsp;
                    Category: <strong class="text-dark">${lead.category ?? ''}</strong>
                    ${(lead.category === 'Solar' || lead.category === 'Solar+Battery') && lead.solar_kw
                        ? ` &nbsp;|&nbsp; Solar KW: <strong class="text-dark">${lead.solar_kw}</strong>` 
                        : ''}
                    ${(lead.category === 'Battery' || lead.category === 'Solar+Battery') && lead.battery_kw
                        ? ` &nbsp;|&nbsp; Battery KW: <strong class="text-dark">${lead.battery_kw}</strong>` 
                        : ''}  &nbsp;|&nbsp;
                    Assign To: <strong class="text-dark">${lead.get_assign_user_name?.name ?? ''}</strong>
                </div>
            </div>

            <div class="text-end">
                <div class="d-flex align-items-center justify-content-end flex-wrap mb-2 gap-2">
                    <span class="badge text-${color} border border-${color} rounded-pill px-2 py-1">
                        ${lead.status ?? ''}
                    </span>
                     
                </div>

                <div class="d-flex flex-wrap justify-content-end gap-2">
                    @can('lead_email_access')
                        <button class="btn btn-sm btn-warning custom-btn send_email"
                            data-lead='${JSON.stringify(lead)}' 
                            data-bs-toggle="modal" 
                            data-bs-target="#emailModel">
                            <i class="ph-envelope-simple"></i>
                        </button>
                    @endcan

                    <button class="btn btn-sm btn-primary view-lead"
                        data-lead='${JSON.stringify(lead)}' 
                        data-bs-toggle="modal" 
                        data-bs-target="#leadDetailsModal">
                        <i class="ph-eye"></i>
                    </button>

                    @can('lead_edit')
                        <button class="btn btn-sm btn-outline-secondary edit_lead"
                            data-lead='${JSON.stringify(lead)}' 
                            data-bs-toggle="modal" 
                            data-bs-target="#editlead">
                            <i class="ph-pencil-line"></i>
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>`;
    }



    $(document).on('click', '.send_email', function() {
        // parse string value into object
        let lead = $(this).data('lead');

        $('.lead_id').val(lead.id);
        $('.lead_name').text(lead.first_name + ' ' + lead.last_name);
        $('.lead_email').val(lead.email);
    });


    $(document).on('click', '.send_email_inner', function() {
        // parse string value into object
        let lead = JSON.parse($('.send_email_view').val());

        $('.lead_id').val(lead.id);
        $('.lead_name').text(lead.first_name + ' ' + lead.last_name);
        $('.lead_email').val(lead.email);
    });
    </script>

    <script>
    let offset = 0;
    let limit = 25;
    let isLoading = false;
    let hasMore = true;

    function loadLeads_old(reset = false) {
        if (reset) {
            offset = 0;
            hasMore = true;
            $('#leads-container').empty();
            $('#load-more').show();
        }

        if (isLoading || !hasMore) return;

        isLoading = true;
        $('#load-more').prop('disabled', true).text('Loading...');

        $.ajax({
                url: "{{ route('admin.listLeads') }}",
                method: 'GET',
                data: {
                    offset,
                    limit,
                    lead_source: $('select[name="lead_source"]').val(),
                    assign_rep: $('select[name="assign_rep"]').val(),
                    status: $('select[name="status"]').val()
                }
            })
            .done(function(res) {
                const leads = Array.isArray(res) ? res : (res.data || []);

                if (!leads.length) {
                    showNoData();
                    return;
                }

                let html = '';
                leads.forEach(lead => {
                    if (!document.getElementById(`lead-${lead.id}`)) {
                        html += leadCard(lead);
                    }
                });

                $('#leads-container').append(html);
                offset += leads.length;

                if (leads.length < limit) {
                    hasMore = false;
                    $('#load-more').hide();
                }

                $('.totalFollowups').text(res.followupCount || 0);
            })
            .always(function() {
                isLoading = false;
                if (hasMore) $('#load-more').prop('disabled', false).text('Load More');
            });
    }

    function loadLeads1(limit = 10, offset = 0) {

        $.ajax({
            url: "{{ route('admin.listLeads') }}", // 🔴 change to your route
            type: "GET",
            data: {
                limit: limit,
                offset: offset,
                lead_source: $('#lead_source').val() ?? '',
                assign_rep: $('#assign_rep').val() ?? '',
                status: $('#status').val() ?? ''
            },
            success: function(response) {

                let leads = response.data;
                let tbody = '';
                $('#no-data-container').html('');

                if (!leads || leads.length === 0) {
                    showNoData();
                    return;
                }

                $.each(leads, function(index, lead) {

                    tbody += `
                <tr>
                    <td>${offset + index + 1}</td>
                    <td>${lead.name ?? '-'}</td>
                    <td>${lead.phone ?? '-'}</td>
                    <td>${lead.email ?? '-'}</td>
                    <td>${lead.address ?? '-'}</td>
                    <td>${lead.lead_source?.name ?? '-'}</td>
                    <td>
                        <a href="/leads/${lead.id}" class="btn btn-sm btn-info">View</a>
                        <a href="/leads/${lead.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            `;
                });

                $('#jsGrid1 tbody').html(tbody);
            },
            error: function() {
                showNoData();
            }
        });
    }


    function showNoData() {
        $('#leads-container').html(`
        <div style="display:flex; justify-content:center; align-items:center; height:220px; margin:0;">
            <div style="text-align:center; padding:20px; border:1px dashed #ccc; border-radius:12px; background:#fff; max-width:350px; width:100%; margin:0; animation: fadeIn 0.6s;">
                <div style="font-size:48px; color:#f39c12; margin:0 0 10px 0; line-height:1; animation: pulse 1.5s infinite;">
                    ⚠️
                </div>
                <p style="margin:0; font-size:18px; font-weight:600; color:#555;">
                    Warning: No Data Found!
                </p>
            </div>
        </div>
        <style>
            @keyframes fadeIn {
                from {opacity: 0; transform: scale(0.95);}
                to {opacity: 1; transform: scale(1);}
            }
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.15); }
                100% { transform: scale(1); }
            }
        </style>
    `);

        hasMore = false;
        $('#load-more').hide();
    }

    // Apply button
    $(document).on('click', '.apply', function() {
        hasMore = true;
        $('#load-more').show();
        loadLeads(true);
    });

    // Reset button
    $(document).on('click', 'button[type="reset"]', function() {
        $('select').val('');
        hasMore = true;
        $('#load-more').show();
        loadLeads(true);
    });

    // Load More button
    $(document).on('click', '#load-more', function() {
        loadLeads();
    });

    // First load
    $(document).ready(function() {
        loadLeads(true);
    });

    // Export csv logic
    $('.exportCsv').click(function() {

        let lead_source = $('#lead_source').val();
        let assign_rep = $('#assign_rep').val();
        let status = $('#status').val();
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();

        let url = "/admin/exportLead?" +
            "lead_source=" + lead_source +
            "&assign_rep=" + assign_rep +
            "&status=" + status +
            "&from_date=" + from_date +
            "&to_date=" + to_date;

        window.location.href = url;
    });
    </script>


    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection