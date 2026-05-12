<style>
:root {
    --sunline-ink: #102033;
    --sunline-muted: #8ea0b4;
    --sunline-blue: #1769aa;
    --sunline-blue-dark: #0b2f52;
    --sunline-green: #36b37e;
    --sunline-line: rgba(255, 255, 255, 0.12);
    --sunline-soft: rgba(255, 255, 255, 0.08);
}

.navbar {
    --navbar-bg: #ffffff;
    min-height: 3.75rem;
    border-bottom: 1px solid #dce6ef;
    box-shadow: 0 10px 30px rgba(16, 32, 51, 0.05) !important;
}

h6 {
    margin-top: 12px;
    color: var(--sunline-ink);
}

.page-content {
    background: #f4f8fb;
}

.sidebar-light,
.sidebar-content,
.sidebar-logo {
    background: linear-gradient(180deg, #071a2f 0%, #0d3d67 54%, #17695c 100%) !important;
}

.sidebar-main {
    box-shadow: 18px 0 45px rgba(7, 26, 47, 0.18);
}

.sidebar-content {
    border-right: 0;
    padding: 12px 10px 18px;
    position: relative;
    overflow: hidden;
}

.sidebar-content::before {
    content: "";
    position: absolute;
    top: 72px;
    left: 50%;
    width: 220px;
    height: 120px;
    background: url("{{ asset('logo.png') }}") center/contain no-repeat;
    opacity: 0.09;
    filter: brightness(0) invert(1) drop-shadow(0 0 34px rgba(255, 255, 255, 0.9));
    transform: translateX(-50%);
    pointer-events: none;
}

.sidebar-content::after {
    content: "";
    position: absolute;
    top: 34px;
    left: -55px;
    width: 190px;
    height: 190px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.22), rgba(81, 183, 216, 0.14) 34%, transparent 68%);
    pointer-events: none;
}

.sidebar-section {
    position: relative;
    z-index: 1;
}

.sidebar-logo {
    min-height: 4.25rem;
    border: 0 !important;
    border-bottom: 1px solid var(--sunline-line) !important;
    position: relative;
}

.sidebar-logo img {
    max-width: 158px;
    height: auto;
    filter: drop-shadow(0 8px 18px rgba(0, 0, 0, 0.28));
}

.logo_text {
    margin-right: 8px;
    background: linear-gradient(135deg, var(--sunline-blue), var(--sunline-green));
}

.crm_c {
    line-height: 2.25rem;
    background: linear-gradient(135deg, var(--sunline-blue) 0%, var(--sunline-green) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
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
    background: linear-gradient(135deg, var(--sunline-blue), var(--sunline-green)) !important;
    border-color: transparent !important;
    color: #ffffff !important;
}

.form_1,
.card {
    box-shadow: 0 14px 36px rgba(16, 32, 51, 0.07);
    border: 1px solid #dce6ef;
    border-radius: 8px;
}

.table > :not(caption) > * > * {
    padding: 8px !important;
}

.table > thead {
    vertical-align: middle;
    color: #ffffff;
    background: linear-gradient(135deg, var(--sunline-blue), var(--sunline-green)) !important;
}

td {
    color: hsl(215, 16%, 47%) !important;
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
    line-height: 1.75rem !important;
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
}

.custom-btn i {
    color: #ff3b00 !important;
}

.rk-notes-card,
.rk-summary-card,
.rk-files-card,
.rk-lifecycle-box {
    border: 1px dashed #2ca5e4;
}

.rounded {
    box-shadow: 0 8px 24px rgba(16, 32, 51, 0.08);
}

.sidebar-section {
    font-family: "Inter", "Segoe UI", sans-serif;
}

.sidebar-user-block {
    padding: 10px 12px 16px;
    margin: 2px 2px 12px;
    border: 1px solid var(--sunline-line);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.08);
}

.sidebar-user-block .hello {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.72);
    line-height: 1.4;
}

.sidebar-user-block strong {
    color: #ffffff;
    font-weight: 800;
}

.sidebar-content .nav-item-header {
    padding: 12px 12px 6px;
    margin-top: 8px;
}

.sidebar-content .nav-item-header .sidebar-section-title {
    font-size: 10px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.52);
    font-weight: 800;
}

.sidebar-content .nav-link {
    display: flex;
    align-items: center;
    gap: 11px;
    min-height: 42px;
    margin: 3px 0;
    padding: 10px 12px;
    border: 1px solid transparent;
    border-radius: 8px;
    color: rgba(255, 255, 255, 0.78);
    font-size: 14px;
    font-weight: 600;
    transition: background 0.18s ease, color 0.18s ease, border-color 0.18s ease, transform 0.18s ease;
}

.sidebar-content .nav-link i {
    width: 20px;
    min-width: 20px;
    margin-right: 0;
    font-size: 18px;
    color: #7bd9b1;
    background: none;
    -webkit-text-fill-color: initial;
    transform: none !important;
    filter: none !important;
    transition: color 0.18s ease;
}

.sidebar-content .nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.13);
    color: #ffffff;
    transform: translateX(2px);
}

.sidebar-content .nav-link:hover i {
    color: #ffffff;
}

.sidebar-content .nav-link.active {
    background: linear-gradient(135deg, rgba(23, 105, 170, 0.95), rgba(54, 179, 126, 0.95));
    border-color: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    box-shadow: 0 12px 26px rgba(4, 18, 32, 0.26);
}

.sidebar-content .nav-link.active i {
    color: #ffffff;
}

.sidebar-content .nav-group-sub {
    margin: 4px 0 8px 20px;
    padding-left: 10px;
    border-left: 1px solid var(--sunline-line);
}

.sidebar-content .nav-group-sub .nav-link {
    min-height: 36px;
    font-size: 13px;
    padding: 8px 10px;
}

.sidebar-content .nav-item-submenu > .nav-link::after {
    color: rgba(255, 255, 255, 0.58);
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
                <a href="/superadmin/dashboard" class="nav-link {{ request()->is('superadmin/dashboard') ? 'active' : '' }}">
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
