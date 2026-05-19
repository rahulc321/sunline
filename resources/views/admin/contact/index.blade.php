@extends('layouts.admin')

@section('title', "Contacts")

@section('content')
<style>
.rk-contact-page {
    min-height: calc(100vh - 120px);
    padding: 24px;
    overflow-x: hidden;
    border-radius: 0;
    background:
        radial-gradient(circle at top left, rgba(16, 185, 129, .14), transparent 34%),
        radial-gradient(circle at top right, rgba(37, 99, 235, .12), transparent 30%),
        linear-gradient(180deg, #f8fbff 0%, #eef4f8 100%);
    color: #172033;
    font-family: Inter, "Segoe UI", sans-serif;
    font-size: 14px;
    font-weight: 500;
}

.rk-contact-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 18px;
    padding: 22px;
    border: 1px solid rgba(148, 163, 184, .22);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(15, 23, 42, .96), rgba(30, 64, 175, .90)),
        #172033;
    box-shadow: 0 18px 45px rgba(15, 23, 42, .13);
    color: #fff;
}

.rk-contact-hero-main {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 0;
}

.rk-contact-hero-icon {
    display: inline-flex;
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, .28);
    border-radius: 8px;
    background: linear-gradient(135deg, #14b8a6, #f59e0b);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .35), 0 14px 30px rgba(0, 0, 0, .22);
    color: #fff;
    font-size: 20px;
}

.rk-contact-kicker {
    display: block;
    margin-bottom: 4px;
    color: rgba(255, 255, 255, .70);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-contact-title {
    margin: 0;
    color: #fff;
    font-size: 26px;
    font-weight: 600;
    line-height: 1.18;
}

.rk-contact-subtitle {
    margin: 8px 0 0;
    color: rgba(255, 255, 255, .78);
    font-size: 13px;
}

.rk-contact-filter-card {
    margin-bottom: 18px;
    padding: 16px;
    border: 1px solid rgba(148, 163, 184, .24);
    border-radius: 8px;
    background: rgba(255, 255, 255, .86);
    box-shadow: 0 16px 35px rgba(15, 23, 42, .07);
    backdrop-filter: blur(10px);
}

.rk-contact-filter-card label {
    display: block;
    margin-bottom: 7px;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
}

.rk-contact-filter-card .form-control {
    min-height: 42px;
    border: 1px solid #d9e4ef;
    border-radius: 8px;
    background-color: rgba(255, 255, 255, .88);
    color: #172033;
    font-size: 13px;
    font-weight: 500;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .7);
}

.rk-contact-filter-card .form-control:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, .13);
}

.rk-contact-filter-actions {
    align-items: end;
}

.rk-contact-apply,
.rk-contact-load {
    border: 0;
    border-radius: 8px;
    background: linear-gradient(135deg, #2563eb, #14b8a6);
    box-shadow: 0 10px 20px rgba(37, 99, 235, .18);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
}

.rk-contact-apply:hover,
.rk-contact-load:hover {
    transform: translateY(-1px);
    color: #fff;
}

.rk-contact-reset {
    border: 1px solid rgba(100, 116, 139, .28);
    border-radius: 8px;
    background: #fff;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
}

.rk-contact-card {
    position: relative;
    margin-bottom: 16px;
    overflow: hidden;
    border: 0;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 16px 35px rgba(15, 23, 42, .07);
}

.rk-contact-card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background:
        repeating-linear-gradient(90deg, #38a8ff 0 4px, transparent 4px 8px) top left / 100% 1px no-repeat,
        repeating-linear-gradient(90deg, #38a8ff 0 4px, transparent 4px 8px) bottom left / 100% 1px no-repeat,
        repeating-linear-gradient(180deg, #38a8ff 0 4px, transparent 4px 8px) top left / 1px 100% no-repeat,
        repeating-linear-gradient(180deg, #38a8ff 0 4px, transparent 4px 8px) top right / 1px 100% no-repeat;
    opacity: .82;
    pointer-events: none;
}

.rk-contact-card-inner {
    position: relative;
    z-index: 1;
    padding: 18px;
}

.rk-contact-card-top {
    display: flex;
    justify-content: space-between;
    gap: 18px;
}

.rk-contact-person {
    display: flex;
    gap: 13px;
    min-width: 0;
}

.rk-contact-avatar {
    display: inline-flex;
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: linear-gradient(135deg, #14b8a6, #f59e0b);
    color: #fff;
    font-size: 18px;
    font-weight: 700;
}

.rk-contact-name {
    margin: 0 0 9px;
    color: #0f172a;
    font-size: 18px;
    font-weight: 600;
}

.rk-contact-meta,
.rk-contact-footnote {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    color: #64748b;
    font-size: 12px;
}

.rk-contact-meta span,
.rk-contact-footnote span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 28px;
    padding: 6px 9px;
    border-radius: 999px;
    background: #f8fbff;
    color: #475569;
}

.rk-contact-side {
    display: flex;
    flex: 0 0 230px;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
}

.rk-contact-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 999px;
    background: #e9fbf7;
    color: #0f766e;
    font-size: 12px;
    font-weight: 600;
}

.rk-contact-owner {
    text-align: right;
    color: #64748b;
    font-size: 12px;
}

.rk-contact-owner strong {
    display: block;
    margin-top: 2px;
    color: #172033;
    font-weight: 600;
}

.rk-contact-specs {
    margin-top: 16px;
    padding: 14px;
    border: 1px solid #eef2f7;
    border-radius: 8px;
    background: #fbfdff;
}

.rk-contact-specs .row {
    row-gap: 12px;
}

.rk-contact-spec-label {
    display: block;
    margin-bottom: 4px;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.rk-contact-spec-value {
    color: #172033;
    font-size: 13px;
    font-weight: 500;
}

.rk-contact-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 16px;
}

.rk-contact-actions .btn {
    display: inline-flex;
    min-height: 34px;
    align-items: center;
    gap: 6px;
    border-radius: 8px;
    border: 1px solid rgba(148, 163, 184, .28);
    background: #fff;
    box-shadow: 0 8px 18px rgba(15, 23, 42, .05);
    color: #172033;
    font-size: 12px;
    font-weight: 600;
}

.rk-contact-actions .btn:hover {
    transform: translateY(-1px);
    border-color: rgba(20, 184, 166, .45);
    color: #0f766e;
}

.rk-contact-empty {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 220px;
}

.rk-contact-empty-card {
    max-width: 380px;
    width: 100%;
    padding: 28px;
    border: 1px dashed rgba(56, 168, 255, .72);
    border-radius: 8px;
    background: rgba(255, 255, 255, .92);
    box-shadow: 0 14px 30px rgba(15, 23, 42, .07);
    color: #475569;
    text-align: center;
}

.rk-contact-empty-icon {
    display: inline-flex;
    width: 56px;
    height: 56px;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    border-radius: 8px;
    background: #fff7ed;
    color: #f97316;
    font-size: 26px;
}

.log-item {
    background: #e8edf9;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

@media (max-width: 991px) {
    .rk-contact-page {
        padding: 16px;
    }

    .rk-contact-hero,
    .rk-contact-card-top {
        flex-direction: column;
    }

    .rk-contact-side {
        flex: 0 0 auto;
        align-items: flex-start;
    }

    .rk-contact-owner {
        text-align: left;
    }
}

@media (max-width: 576px) {
    .rk-contact-title {
        font-size: 22px;
    }

    .rk-contact-actions {
        justify-content: flex-start;
    }
}
</style>
<!-- Page header -->
<div class="page-header rk-contact-page">
    <div class="page-header-content d-lg-flex">
        <div class="rk-contact-hero w-100">
            <!-- Title + subtitle stacked -->
            <div class="rk-contact-hero-main">
                <span class="rk-contact-hero-icon"><i class="ph-address-book"></i></span>
                <div>
                    <span class="rk-contact-kicker">Contact pipeline</span>
                    <h4 class="page-title rk-contact-title">Qualified Contacts</h4>
                    <p class="rk-contact-subtitle">Manage qualified leads and track proposal engagement</p>
                </div>
            </div>

            <div class="col-md-3 ms-auto d-none">
                <a class="btn btn-primary bg_s mt-5" data-bs-toggle="offcanvas" data-bs-target="#addLeadModal" aria-controls="addLeadModal"
                    style="float:right">
                    <i class="ph-plus"></i>&nbsp;&nbsp;Add Lead
                </a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">


        <div class="card form_1 rk-contact-filter-card">
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
                <div class="col-md-2 d-flex gap-2 rk-contact-filter-actions">
                    <button type="button" class="btn rk-contact-apply apply">Apply</button>
                    <button type="reset" class="btn rk-contact-reset">Reset</button>
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
            <button id="load-more" class="btn rk-contact-load px-4">Load More</button>
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

    </div>

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
        const name = `${lead.first_name ?? ''} ${lead.last_name ?? ''}`.trim();
        const initials = `${(lead.first_name ?? 'C').charAt(0)}${(lead.last_name ?? '').charAt(0)}`.toUpperCase();
        const address = [lead.address, lead.suburb, [lead.state, lead.postcode].filter(Boolean).join(' ')].filter(Boolean).join(', ');


        return `
<div class="card form_1 rk-contact-card" id="lead-${lead.id}">
    <div class="rk-contact-card-inner">
        <div class="rk-contact-card-top">
            <div class="rk-contact-person">
                <span class="rk-contact-avatar">${initials || 'C'}</span>
                <div class="flex-grow-1">
                    <h5 class="rk-contact-name lead">
                        #${contract.id ?? ''} - ${name || 'Unnamed Contact'}
                    </h5>
                    <div class="rk-contact-meta">
                        <span><i class="ph-phone"></i> ${lead.phone ?? 'No phone'}</span>
                        <span><i class="ph-envelope"></i> ${lead.email ?? 'No email'}</span>
                        <span><i class="ph-map-pin"></i> ${address || 'No address'}</span>
                        <span><i class="ph-calendar"></i> Created: ${lead.created_at ?? '-'}</span>
                    </div>
                </div>
            </div>
            <div class="rk-contact-side">
                <span class="rk-contact-status text-${color}">
                    <i class="ph-check-circle"></i> ${contract.status ?? 'No status'}
                </span>
                <div class="rk-contact-owner">
                    <span>Assigned to</span>
                    <strong>${lead.get_assign_user_name?.name ?? 'Unassigned'}</strong>
                </div>
                <button class="btn btn-sm btn-warning me-1 custom-btn send_email1 d-none"
                    data-lead='${JSON.stringify(lead)}'
                    data-bs-toggle="offcanvas" data-bs-target="#emailModel" aria-controls="emailModel">
                    <i class="ph-envelope-simple"></i> Email
                </button>

                

                <button class="btn btn-sm btn-primary bg_s px-4 py-2 view-lead1 d-none"
                    data-lead='${JSON.stringify(lead)}'
                    data-bs-toggle="offcanvas" data-bs-target="#leadDetailsModal" aria-controls="leadDetailsModal">
                    View
                </button>
            </div>
        </div>

        <!-- FULL WIDTH SECTION -->
        <div class="rk-contact-specs">
        <div class="row">
            <div class="col-md-3">
                    <span class="rk-contact-spec-label">Property</span>
                    <span class="rk-contact-spec-value">${contract.property ?? '-'}</span>
            </div>
            <div class="col-md-3">
                    <span class="rk-contact-spec-label">Phases</span>
                    <span class="rk-contact-spec-value">${contract.phase ?? '-'}</span>
            </div>
            <div class="col-md-3">
                    <span class="rk-contact-spec-label">Switchboard</span>
                    <span class="rk-contact-spec-value">${contract.switchboard ?? '-'}</span>
            </div>
            <div class="col-md-3">
                    <span class="rk-contact-spec-label">Bill Size</span>
                    <span class="rk-contact-spec-value">${contract.bill_size ?? '-'}</span>
            </div>
        </div>
        </div>

        <div class="rk-contact-footnote mt-3">
            <span>Source: <strong>${lead.lead_source?.source ?? '-'}</strong></span>
            <span>Follow-ups: <strong>${contract.follow_up_count ?? 0}</strong></span>
            <span>Storeys: <strong>${lead.storeys ?? '-'}</strong></span>
            <span>Roof: <strong>${lead.roof_type ?? '-'}</strong></span>
            <span>Category: <strong>${lead.category ?? '-'}</strong>
                    ${(lead.category === 'Solar' || lead.category === 'Solar+Battery') && lead.solar_kw
                        ? ` | Solar KW: <strong>${lead.solar_kw}</strong>` 
                        : ''}
                    ${(lead.category === 'Battery' || lead.category === 'Solar+Battery') && lead.battery_kw
                        ? ` | Battery KW: <strong>${lead.battery_kw}</strong>` 
                        : ''}</span>
            <span>Rebate: <strong>${lead.elogible_for_rebate ?? '-'}</strong></span>
        </div>

        <!-- BUTTONS AT BOTTOM RIGHT -->
        <div class="rk-contact-actions">
        @can('contact_proposal')
        <a  href="${lead.project_id ? `https://app.opensolar.com/projects/${lead.project_id}/design` : '#'}"
 target="_blank" class="btn btn-outline-secondary btn-sm me-2 view_proposal" data-contract='${JSON.stringify(contract)}'>
            <i class="ph-eye me-1"></i> View Proposal
        </a>
        @endcan

        @can('contact_send_email')
        <button class="btn btn-warning btn-sm me-2 send_email" data-lead='${JSON.stringify(lead)}'
            data-bs-toggle="offcanvas" data-bs-target="#emailModel" aria-controls="emailModel">
            <i class="ph-envelope-simple me-1"></i> Send Email
        </button>
        @endcan
        @can('contact_follow_up')
        <button class="btn btn-info btn-sm me-2 follow_up" data-contract='${JSON.stringify(contract)}' data-lead='${JSON.stringify(lead)}' data-bs-toggle="offcanvas" data-bs-target="#fUP" aria-controls="fUP">
            <i class="ph-repeat me-1"></i> Follow-up
        </button>
        @endcan
        @can('contact_details')
        <button class="btn btn-primary btn-sm view-lead" data-lead='${JSON.stringify(lead)}'
            data-bs-toggle="offcanvas" data-bs-target="#leadDetailsModal" aria-controls="leadDetailsModal">
            <i class="ph-list me-1"></i> Details
        </button>
        @endcan
        @can('contact_edit')
        &nbsp;&nbsp;
        <button class="btn btn-sm btn-outline-secondary me-2 edit_contract" data-contract='${JSON.stringify(contract)}' data-bs-toggle="offcanvas" data-bs-target="#editModel" aria-controls="editModel">
                    <i class="ph-pencil-line me-1"></i> Edit
                </button>
        @endcan
        </div>
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
        <div class="rk-contact-empty">
            <div class="rk-contact-empty-card">
                <span class="rk-contact-empty-icon">⌕</span>
                <h5 class="mb-1">No contacts found</h5>
                <p class="mb-0">Try adjusting the search, sales rep, or lead source filters.</p>
            </div>
        </div>
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
