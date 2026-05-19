@extends('layouts.admin')

@section('title', "Contacts")

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
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem">Qualified Contacts</h4>
                <p class="mb-0 txt_1">Manage qualified leads and track proposal engagement</p>
            </div>

            <div class="col-md-3 ms-auto d-none">
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="modal" data-bs-target="#addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Add Lead
                </a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">


        <div class="card p-3 form_1">
            <form class="row align-items-end">

                <!-- From Date -->
                <div class="col-md-4">
                    <label>Search</label>
                    <input type="text" class="form-control" name="search_key" placeholder="Type Here.....">
                </div>

                <!-- Sales Rep -->
                <div class="col-md-3">
                    <label>Sales Rep</label>
                    <select name="assign_rep" class="form-control ">
                        <option value="">Select All</option>
                        @foreach($users as $data)
                        <option value="{{@$data->id}}">{{@$data['name']}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Lead Source -->
                <div class="col-md-3">
                    <label>Lead Source</label>
                    <select name="lead_source" class="form-control">
                        <option value="">Select All</option>
                        @foreach($leadSource as $data)
                        <option value="{{@$data->id}}">{{@$data['source']}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="button" class="btn btn-primary bg_s apply">Apply</button>
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
    @include('admin.contact._add_lead_modal')
    @include('admin.contact._edit_modal')
    @include('admin.contact._view_lead_modal')
    @include('admin.contact._followup_lead_modal')

    @include('admin.contact._email_modal',['emailTemplates'=>$emailTemplates])

    <!-- Follow-up Modal -->
    <!-- Follow-up Modal -->

    @endsection

    @section('scripts')
    @parent


    <script>
    $(document).on('click', '.follow_up', function() {
        let leadId = $(this).data('id'); // get lead id from button
        let leadName = $(this).data('lead');
        let cont = $(this).data('contract');

        $('.lead_id').val(cont.id); // put it in hidden input of form
        $('.leadName').text(leadName.first_name + ' ' + leadName.last_name);
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

            $('#leadName').text([lead.first_name, lead.last_name].filter(Boolean).join(" ") ||
                'N/A');
            $('.name').text(
                [lead.first_name, lead.last_name].filter(Boolean).join(" ") || 'N/A'
            );
            $('.lead_email').text(lead.email ?? 'N/A');
            $('.lead_phone').text(lead.phone ?? 'N/A');
            $('.lead_address').text(lead.address ?? 'N/A');
            $('.lead_status').val(lead.status ?? 'N/A');

            $('.rejection_url').html(
                lead.rejection_url
                    ? `<a href="${lead.rejection_url}" target="_blank" rel="noopener noreferrer">
                        ${lead.rejection_url}
                    </a>`
                    : ''
            );

            // Handle nested objects safely
            $('.lead_source').text(lead.lead_source?.source ?? 'N/A');
            $('.lead_roof_type').text(lead.roof_type ?? 'N/A');
            $('.lead_rebate').text(lead.elogible_for_rebate ?? 'N/A');
            $('.send_email_view').val(JSON.stringify(lead));

            // Assign user name safely
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

    function leadCard(contract, lead) {
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

        let color = statusColors[contract.status] || "secondary"; // fallback


        return `
<div class="card shadow-sm rounded-3 p-4 mb-3 form_1" id="lead-${lead.id}">
    <div class="d-flex justify-content-between align-items-start">
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-1 lead">
                #${contract.id ?? ''} - ${lead.first_name ?? ''} ${lead.last_name ?? ''}
            </h5>
            <div class="text-muted mb-1">
                <i class="ph-phone me-1"></i> ${lead.phone ?? ''} &nbsp;
                <i class="ph-envelope me-1"></i> ${lead.email ?? ''}
            </div>
            <div class="text-muted mb-2">
                <i class="ph-map-pin me-1"></i> ${lead.address ?? ''}
            </div>

            <div class="text-muted mb-2">
                Created At :
                 ${lead.created_at ?? ''}
            </div>
        </div>
        <div class="d-flex flex-column align-items-end">
            <div class="d-flex align-items-center mb-2">
                <span class="badge text-${color} border border-${color} rounded-pill px-1 py-1 me-2">
                    ${contract.status ?? ''}
                </span>
                <div class="text-end">
                    <small class="text-muted">Assigned to:</small><br>
                    <strong class="text-dark">${lead.get_assign_user_name?.name ?? ''}</strong>
                </div>
            </div>
            <div>
                <button class="btn btn-sm btn-warning me-1 custom-btn send_email1 d-none"
                    data-lead='${JSON.stringify(lead)}'
                    data-bs-toggle="modal" data-bs-target="#emailModel">
                    <i class="ph-envelope-simple"></i> Email
                </button>

                

                <button class="btn btn-sm btn-primary bg_s px-4 py-2 view-lead1 d-none"
                    data-lead='${JSON.stringify(lead)}'
                    data-bs-toggle="modal" data-bs-target="#leadDetailsModal">
                    View
                </button>
            </div>
        </div>
    </div>

    <!-- FULL WIDTH SECTION -->
    <div class="bg-light text-muted small rounded px-3 py-3 mt-3">
        <div class="row">
            <div class="col-md-3">
                <strong>Property</strong><br>
                ${contract.property ?? ''}
            </div>
            <div class="col-md-3">
                <strong>Phases</strong><br>
               ${contract.phase ?? ''}
            </div>
            <div class="col-md-3">
                <strong>Switchboard</strong><br>
                ${contract.switchboard ?? ''}
            </div>
            <div class="col-md-3">
                <strong>Bill Size</strong><br>
                 ${contract.bill_size ?? ''}
            </div>
        </div>
    </div>

    <div class="text-muted mt-2">
        Source: <strong class="text-dark">${lead.lead_source?.source ?? ''}</strong> &nbsp;|&nbsp;
        Follow-ups: <strong class="text-dark">${contract.follow_up_count ?? 0}</strong> &nbsp;|&nbsp;
        Storeys: <strong class="text-dark">${lead.storeys ?? ''}</strong> &nbsp;|&nbsp;
        Roof: <strong class="text-dark">${lead.roof_type ?? ''}</strong> &nbsp;|&nbsp;
         Category: <strong class="text-dark">${lead.category ?? ''}</strong>
                    ${(lead.category === 'Solar' || lead.category === 'Solar+Battery') && lead.solar_kw
                        ? ` &nbsp;|&nbsp; Solar KW: <strong class="text-dark">${lead.solar_kw}</strong>` 
                        : ''}
                    ${(lead.category === 'Battery' || lead.category === 'Solar+Battery') && lead.battery_kw
                        ? ` &nbsp;|&nbsp; Battery KW: <strong class="text-dark">${lead.battery_kw}</strong>` 
                        : ''}  &nbsp;|&nbsp;
        Rebate: <strong class="text-dark">${lead.elogible_for_rebate ?? ''}</strong>
    </div>

    <!-- BUTTONS AT BOTTOM RIGHT -->
    <div class="d-flex justify-content-end mt-3">
        @can('contact_proposal')
        <a  href="${lead.project_id ? `https://app.opensolar.com/projects/${lead.project_id}/design` : '#'}"
 target="_blank" class="btn btn-outline-secondary btn-sm me-2 view_proposal" data-contract='${JSON.stringify(contract)}'>
            <i class="ph-eye me-1"></i> View Proposal
        </a>
        @endcan

        @can('contact_send_email')
        <button class="btn btn-warning btn-sm me-2 send_email" data-lead='${JSON.stringify(lead)}'
            data-bs-toggle="modal" data-bs-target="#emailModel">
            <i class="ph-envelope-simple me-1"></i> Send Email
        </button>
        @endcan
        @can('contact_follow_up')
        <button class="btn btn-info btn-sm me-2 follow_up" data-contract='${JSON.stringify(contract)}' data-lead='${JSON.stringify(lead)}' data-bs-toggle="modal" data-bs-target="#fUP">
            <i class="ph-repeat me-1"></i> Follow-up
        </button>
        @endcan
        @can('contact_details')
        <button class="btn btn-primary btn-sm view-lead" data-lead='${JSON.stringify(lead)}'
            data-bs-toggle="modal" data-bs-target="#leadDetailsModal">
            <i class="ph-list me-1"></i> Details
        </button>
        @endcan
        @can('contact_edit')
        &nbsp;&nbsp;
        <button class="btn btn-sm btn-outline-secondary me-2 edit_contract" data-contract='${JSON.stringify(contract)}' data-bs-toggle="modal" data-bs-target="#editModel">
                    <i class="ph-pencil-line me-1"></i> Edit
                </button>
        @endcan
    </div>
</div>`;

    }


    function loadLeads(reset = false) {
        if (isLoading || (!hasMore && !reset)) return;

        if (reset) {
            offset = 0;
            hasMore = true;
            $('#leads-container').empty();
            $('#load-more').show();
        }

        isLoading = true;
        $('#load-more').prop('disabled', true).text('Loading...');

        // get filter values
        let search_key = $('input[name="search_key"]').val();
        let assign_rep = $('select[name="assign_rep"]').val();
        let lead_source = $('select[name="lead_source"]').val();

        $.ajax({
                url: "{{ route('admin.listContact') }}",
                method: 'GET',
                data: {
                    offset,
                    limit,
                    search_key,
                    assign_rep,
                    lead_source
                },
            })
            .done(function(res) {
                console.log('>>>>>>>>>>', res);

                const leads = Array.isArray(res) ? res : (res.data || []);
                if (!leads.length && offset == 0) {
                    showNoData()
                    $('#load-more').hide();
                    return;
                }

                if (!leads.length) {
                    hasMore = false;
                    $('#load-more').hide();
                    return;
                }

                leads.forEach(lead => {
                    if (!document.getElementById(`lead-${lead.id}`)) {
                        $('#leads-container').append(leadCard(lead, lead.lead));
                    }
                });

                offset += leads.length;

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


    // first load
    $(function() {
        // load more pagination
        $('#load-more').on('click', function() {
            loadLeads();
        });

        // first load
        loadLeads();

        // apply filter
        $('.apply').on('click', function() {
            loadLeads(true); // reset list and apply filters
        });

        // reset filter
        $('button[type="reset"]').on('click', function() {
            $('form')[0].reset(); // reset form inputs
            loadLeads(true); // reload without filters
        });
    });


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

    <script src="{{asset('js/lead/edit-lead.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-notes.js')}}"></script>
    <script src="{{asset('js/lead/edit-lead-tasks.js')}}"></script>
    @endsection