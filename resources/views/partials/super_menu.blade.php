<style>
.navbar {
    --navbar-bg: rgb(255 255 255);
    height: 3.5rem;
    border-bottom: 1px solid #d1d5db;
}

h6 {
    margin-top: 12px;
    color: rgb(49, 62, 74);

}

.page-content {

    background: white;
}

.sidebar-content {

    border-right: 1px solid #d1d5db;
}

.sidebar-logo {
    border-bottom: 1px solid #d1d5db;
    border-right: 1px solid #d1d5db;
    background: white;
}

.fw-bold {
    font-size: 16px;
}

.fw-bold.text-dark {
    margin-bottom: -7px;
}

.logo_text {
    margin-right: 8px;
    background: linear-gradient(135deg, hsl(214 84% 56%), hsl(214 84% 76%));
}

.crm_c {
    /* color: hsl(214 84% 56%) !important; */
    /* font-size: 1.875rem; */
    /* font-size: 21px; */
    line-height: 2.25rem;


    line-height: 2.25rem;
    background: linear-gradient(135deg, hsl(214 84% 56%) 0%, hsl(142 76% 36%) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    /* for Firefox */
    color: transparent;

}

.txt_1 {
    margin-bottom: 25px !important;
    color: hsl(215 16% 47%);
    margin-top: -22px !important;
    font-size: 16px;
}

.txt_2 {
    color: hsl(215 16% 47%);
}

.bg_s,
.select-all,
.deselect-all,
input[value="Save"] {
    background: linear-gradient(135deg, hsl(214 84% 56%), hsl(214 84% 76%)) !important;
}

.rounded {
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}

.form_1,
.card {
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    border: 1px solid #d1d5db;
}

.table> :not(caption)>*>* {

    padding: 8px !important;
}

.table>thead {
    vertical-align: middle;
    /* background: #fddef2; */
    color: #f7f7f7;
    background: linear-gradient(135deg, hsl(214deg 38.04% 68.23%), hsl(214 84% 76%)) !important;
}

td {
    color: hsl(215, 16%, 47%) !important;
}

td {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
    font-size: 15px;
    font-weight: 300;
}

svg.lucide.lucide-circle-alert.h-5.w-5.text-destructive {
    color: red;
}

.fwb {
    font-size: 21px;
}

select[name="jsGrid1_length"] {
    width: 94px !important;
}

div#jsGrid1_filter {
    float: right;
}

.dataTables_paginate {
    margin-bottom: var(--dt-spacer-y);
    float: right;
}

.lead {

    font-size: 1.125rem !important;
    ;
    line-height: 1.75rem !important;
    ;
}

.btn {

    cursor: pointer;
    height: 2.25rem;
    font-weight: 500;
}

.custom-btn {
    background-color: white !important;
    color: black !important;
    border: 1px solid #ccc;
    /* optional border */
}

.custom-btn i {
    color: #ff3b00 !important;
    /* icon color */

}

/* color all sidebar icons */
.sidebar-content .nav-link i {
    background: linear-gradient(135deg, hsl(214 84% 56%) 0%, hsl(142 76% 36%) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
    /* fallback for Firefox */
    font-size: 18px;
    margin-right: 6px;
    transition: transform 0.2s ease, filter 0.2s ease;
}

/* slightly enlarge and brighten icon when active or hovered */
.sidebar-content .nav-link:hover i,
.sidebar-content .nav-link.active i {
    transform: scale(1.1);
    filter: brightness(1.2);
}

.rk-notes-card,
.rk-summary-card,
.rk-files-card,
.rk-lifecycle-box {
    border: 1px dashed #2ca5e4;
}

.card {

    border: 1px dashed #2ca5e4 !important;
}

.rounded {

    border: 1px dashed #2ca5e4 !important;
}

/* sidebar refresh */
.sidebar-content {
    border-right: 0;
    background: linear-gradient(180deg, #162344 0%, #223b8f 100%);
    padding: 10px 10px 18px;
}

.sidebar-section {
    font-family: "Inter", "Segoe UI", sans-serif;
}

.sidebar-user-block {
    padding: 8px 12px 16px;
    margin-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.sidebar-user-block .hello {
    font-size: 14px;
    color: #b8c6ea;
    line-height: 1.4;
}

.sidebar-user-block strong {
    color: #ffffff;
    font-weight: 700;
}

.sidebar-content .nav-item-header {
    padding: 10px 12px 6px;
    margin-top: 8px;
}

.sidebar-content .nav-item-header .sidebar-section-title {
    font-size: 10px;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: #8da2db;
    font-weight: 700;
}

.sidebar-content .nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    min-height: 42px;
    margin: 2px 0;
    padding: 10px 12px;
    border-radius: 10px;
    color: #e7eeff;
    font-size: 14px;
    font-weight: 500;
    transition: background .18s ease, color .18s ease;
}

.sidebar-content .nav-link i {
    width: 18px;
    min-width: 18px;
    margin-right: 0;
    font-size: 15px;
    color: #8fb3ff;
    background: none;
    -webkit-text-fill-color: initial;
    transform: none !important;
    filter: none !important;
}

.sidebar-content .nav-link:hover {
    background: rgba(255, 255, 255, 0.06);
    color: #ffffff;
}

.sidebar-content .nav-link.active {
    background: rgba(108, 154, 255, 0.22);
    color: #ffffff;
}

.sidebar-content .nav-group-sub {
    margin-left: 16px;
    padding-left: 10px;
    border-left: 1px solid rgba(255, 255, 255, 0.08);
}

.sidebar-content .nav-group-sub .nav-link {
    min-height: 36px;
    font-size: 13px;
    padding: 8px 10px;
}

.sidebar-content .nav-item-submenu > .nav-link::after {
    color: #97aadd;
}
</style>
<!-- Sidebar content -->
<div class="sidebar-content">

    <!-- Main navigation -->
    <div class="sidebar-section">
        <div class="sidebar-user-block sidebar-resize-hide">
            <div class="hello">Hi, <strong>{{ auth('superadmin')->user()->name ?? 'Admin' }}</strong></div>
        </div>
        <ul class="nav nav-sidebar" data-nav-type="accordion">

            <!-- Main -->
            <li class="nav-item-header">
                <div class="sidebar-section-title sidebar-resize-hide">Dashboards</div>
            </li>
            <!-- For dashboard -->
            <li class="nav-item">
                <a href="/superadmin/dashboard" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                    <i class="ph-house"></i>
                    <span>
                        {{ trans('dashboard.dashboard') }}
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.sales') }}"
                    class="nav-link {{ request()->is('superadmin/sales') ? 'active' : '' }}">
                    <i class="ph-trend-up"></i><span>Sales Pipeline</span>
                </a>
            </li>

            <li class="nav-item-header">
                <div class="sidebar-section-title sidebar-resize-hide">Workflow</div>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.distributorApproval') }}"
                    class="nav-link {{ request()->is('superadmin/distributorApproval') ? 'active' : '' }}">
                    <i class="ph-shield"></i><span>Distributor Approval</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.vicRebate') }}"
                    class="nav-link {{ request()->is('superadmin/vicRebate') ? 'active' : '' }}">
                    <i class="ph-sun"></i><span>Solar VIC Rebate</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.complianceCheck') }}"
                    class="nav-link {{ request()->is('superadmin/complianceCheck') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Compliance Check</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.bookInstallation') }}"
                    class="nav-link {{ request()->is('superadmin/bookInstallation') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Book Installation</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.customerPayment') }}"
                    class="nav-link {{ request()->is('superadmin/customerPayment') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Customer Payment</span>
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('superadmin.coES') }}"
                    class="nav-link {{ request()->is('superadmin/coES') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Awaiting CoES</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.vicPayment') }}"
                    class="nav-link {{ request()->is('superadmin/vicPayment') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Solar VIC Payment</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.stcPayment') }}"
                    class="nav-link {{ request()->is('superadmin/stcPayment') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>STCs Payment</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.connectionPaperwork') }}"
                    class="nav-link {{ request()->is('superadmin/connectionPaperwork') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Connection Paperwork</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.supplierPayment') }}"
                    class="nav-link {{ request()->is('superadmin/supplierPayment') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Supplier Payment</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.installerPayment') }}"
                    class="nav-link {{ request()->is('superadmin/installerPayment') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Installer Payment</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('superadmin.salesRepPayment') }}"
                    class="nav-link {{ request()->is('superadmin/salesRepPayment') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Sales Rep Payment</span>
                </a>
            </li>

            <li class="nav-item-header">
                <div class="sidebar-section-title sidebar-resize-hide">Manage Modules</div>
            </li>
            @can('RFI_access')
            <li class="nav-item">
                <a href="{{route('admin.fri.index')}}"
                    class="nav-link {{ request()->is('admin/fri') ? 'active' : '' }}">
                    <i class="ph-file-text"></i><span>RFI</span>
                </a>
            </li>
            @endcan

            @can('automation_access')
            <li class="nav-item">
                <a href="{{route('admin.emailTemplate.index')}}"
                    class="nav-link {{ request()->is('admin/emailTemplate') ? 'active' : '' }}">
                    <i class="ph-lightning"></i><span>Automation</span>
                </a>
            </li>
            @endcan

            @can('task_access')
            <!-- <li class="nav-item">
                <a href="{{route('admin.taskList')}}"
                    class="nav-link {{ request()->is('admin/taskList') ? 'active' : '' }}">
                    <i class="ph-list-checks"></i><span>Tasks</span>
                </a>
            </li> -->
            @endcan
            @can('ticket_access')
            <li class="nav-item">
                <a href="{{route('admin.ticket.index')}}"
                    class="nav-link {{ request()->is('admin/ticket') || request()->is('admin/ticket/*') ? 'active' : '' }}">
                    <i class="ph-ticket"></i><span>Tickets</span>
                </a>
            </li>
            @endcan
            @can('leadSource_access')
            <li class="nav-item">
                <a href="{{route('admin.leadSource.index')}}"
                    class="nav-link {{ request()->is('admin/leadSource') || request()->is('admin/leadSource/*') ? 'active' : '' }}">
                    <i class="ph-globe"></i><span>Lead Source</span>
                </a>
            </li>
            @endif
            @can('webhook_access')
            <li class="nav-item">
                <a href="{{route('admin.webhook')}}"
                    class="nav-link {{ request()->is('admin/webhook') ? 'active' : '' }}">
                    <i class="ph-arrows-clockwise"></i><span>Webhook</span>
                </a>
            </li>
            @endif

            <!-- <li class="nav-item">
                <a href="{{route('admin.tier.index')}}"
                    class="nav-link {{ request()->is('admin/tier') ? 'active' : '' }}">
                    <i class="ph-trophy"></i><span>Tier</span>

                </a>
            </li> -->
            @can('tier_access')
            <li
                class="nav-item nav-item-submenu {{ request()->is('admin/tier*') ? 'nav-item-expanded nav-item-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="ph-trophy"></i>
                    <span>Tier</span>
                </a>

                <ul class="nav-group-sub collapse {{ request()->is('admin/tier*') ? 'show' : '' }}">

                    <li class="nav-item">
                        <a href="{{ route('admin.tier.index', ['type' => 'solar']) }}"
                            class="nav-link {{ request()->get('type') == 'solar' ? 'active' : '' }}">
                            <i class="ph-sun text-warning me-1"></i>
                            Solar Tier
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.tier.index', ['type' => 'battery']) }}"
                            class="nav-link {{ request()->get('type') == 'battery' ? 'active' : '' }}">
                            <i class="ph-battery-charging text-success me-1"></i>
                            Battery Tier
                        </a>
                    </li>

                </ul>
            </li>
            @endif
            @can('settings')
            <li class="nav-item">
                <a href="{{route('admin.settings.index')}}"
                    class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                    <i class="ph-gear"></i><span>Settings</span>

                </a>
            </li>
            @endif

            <li class="nav-item">
                <a href="{{route('admin.bulkEmail')}}"
                    class="nav-link {{ request()->is('admin/bulkEmail') ? 'active' : '' }}">
                    <i class="ph-paper-plane-tilt"></i><span>Bulk Email</span>


                </a>
            </li>

        </ul>
    </div>
    <!-- /main navigation -->

</div>
<!-- /sidebar content -->
