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

.sidebar-content {
    position: relative;
    z-index: 0;
    border-right: 0;
    background:
        radial-gradient(circle at 0% 0%, rgba(96, 165, 250, .34) 0%, rgba(34, 211, 238, .13) 22%, transparent 46%),
        linear-gradient(180deg, #081426 0%, #0b2349 45%, #0c3670 100%);
    padding: 0 12px 18px;
    color: #f4f8ff;
    box-shadow:
        inset -1px 0 0 rgba(255, 255, 255, 0.13),
        14px 0 36px rgba(9, 29, 77, .16);
    max-height: calc(100vh - 4.5rem);
    overflow-x: hidden;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(96, 165, 250, .62) rgba(255, 255, 255, .08);
}

.sidebar-content::-webkit-scrollbar {
    width: 6px;
}

.sidebar-content::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, .06);
}

.sidebar-content::-webkit-scrollbar-thumb {
    border-radius: 999px;
    background: linear-gradient(180deg, rgba(125, 211, 252, .78), rgba(96, 165, 250, .62));
}

.sidebar-content::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, rgba(165, 243, 252, .90), rgba(147, 197, 253, .78));
}

.sidebar-content::before {
    content: "";
    position: absolute;
    inset: 0;
    z-index: -1;
    pointer-events: none;
    background:
        linear-gradient(130deg, rgba(255, 255, 255, .16) 0%, transparent 28%),
        linear-gradient(180deg, rgba(255, 255, 255, .07), transparent 34%);
}

.sidebar-content::after {
    content: "";
    position: absolute;
    top: -90px;
    left: -80px;
    width: 230px;
    height: 230px;
    z-index: -1;
    pointer-events: none;
    background: radial-gradient(circle, rgba(96, 165, 250, .68) 0%, rgba(34, 211, 238, .20) 38%, transparent 70%);
    filter: blur(8px);
}

.sidebar-main {
    background: linear-gradient(180deg, #0b1832 0%, #0d55b8 100%);
}

.sidebar-logo {
    position: relative;
    overflow: hidden;
    border-right: 0;
    border-bottom: 1px solid rgba(255, 255, 255, .12);
    background:
        radial-gradient(circle at 0% 0%, rgba(96, 165, 250, .34), transparent 44%),
        linear-gradient(180deg, #071223 0%, #0b2349 100%) !important;
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .15),
        inset 0 -1px 0 rgba(255, 255, 255, .08);
}

.sidebar-logo::after {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: linear-gradient(112deg, transparent 0 20%, rgba(255, 255, 255, .14) 21%, transparent 38%);
}

.sidebar-logo .btn {
    border: 1px solid rgba(255, 255, 255, .16) !important;
    background: rgba(255, 255, 255, .12) !important;
    color: #fff !important;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .18);
}

.sidebar-section {
    font-family: inherit;
}

.sidebar-user-block {
    padding: 14px 12px 12px;
    margin: 0 -12px 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.10);
    background:
        linear-gradient(135deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .03)),
        rgba(4, 14, 42, 0.12);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .10);
}

.sidebar-user-block .hello {
    color: rgba(232, 239, 255, 0.68);
    font-size: 14px;
    line-height: 1.35;
}

.sidebar-user-block strong {
    color: #ffffff;
    font-weight: 700;
}

.sidebar-content .nav-sidebar {
    padding: 2px 0 14px;
}

.sidebar-content .nav-item-header {
    padding: 15px 4px 7px;
    margin: 0;
}

.sidebar-content .nav-item-header .sidebar-section-title {
    color: rgba(191, 219, 254, 0.74);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .18em;
    line-height: 1.2;
    text-transform: uppercase;
}

.sidebar-content .nav-link {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 11px;
    min-height: 38px;
    margin: 3px 0;
    padding: 9px 11px;
    border-radius: 8px;
    border: 1px solid transparent;
    color: rgba(244, 248, 255, 0.82);
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0;
    text-shadow: 0 1px 1px rgba(3, 10, 28, .28);
    transition: background .18s ease, color .18s ease, box-shadow .18s ease, transform .18s ease, border-color .18s ease;
}

.sidebar-content .nav-link::before {
    content: "";
    position: absolute;
    inset: 1px;
    border-radius: 7px;
    background: linear-gradient(145deg, rgba(255, 255, 255, .12), transparent 46%);
    opacity: 0;
    pointer-events: none;
    transition: opacity .18s ease;
}

.sidebar-content .nav-item:not(.nav-item-submenu) > .nav-link::after,
.sidebar-content .nav-group-sub .nav-link::after {
    content: "";
    position: absolute;
    top: -55%;
    left: -42%;
    width: 38%;
    height: 210%;
    background: linear-gradient(105deg, transparent, rgba(255, 255, 255, .24), transparent);
    transform: rotate(12deg);
    opacity: 0;
    pointer-events: none;
    transition: left .35s ease, opacity .22s ease;
}

.sidebar-content .nav-link span {
    min-width: 0;
}

.sidebar-content .nav-link i {
    width: 17px;
    min-width: 17px;
    margin-right: 0;
    color: #7dd3fc;
    background: none;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 15px;
    transform: none !important;
    filter: none !important;
}

.sidebar-content .nav-sidebar > .nav-item:nth-of-type(6n+1) > .nav-link i,
.sidebar-content .nav-group-sub > .nav-item:nth-of-type(6n+1) > .nav-link i {
    background-image: linear-gradient(135deg, #38bdf8, #2563eb);
}

.sidebar-content .nav-sidebar > .nav-item:nth-of-type(6n+2) > .nav-link i,
.sidebar-content .nav-group-sub > .nav-item:nth-of-type(6n+2) > .nav-link i {
    background-image: linear-gradient(135deg, #22c55e, #14b8a6);
}

.sidebar-content .nav-sidebar > .nav-item:nth-of-type(6n+3) > .nav-link i,
.sidebar-content .nav-group-sub > .nav-item:nth-of-type(6n+3) > .nav-link i {
    background-image: linear-gradient(135deg, #f97316, #ef4444);
}

.sidebar-content .nav-sidebar > .nav-item:nth-of-type(6n+4) > .nav-link i,
.sidebar-content .nav-group-sub > .nav-item:nth-of-type(6n+4) > .nav-link i {
    background-image: linear-gradient(135deg, #a855f7, #ec4899);
}

.sidebar-content .nav-sidebar > .nav-item:nth-of-type(6n+5) > .nav-link i,
.sidebar-content .nav-group-sub > .nav-item:nth-of-type(6n+5) > .nav-link i {
    background-image: linear-gradient(135deg, #06b6d4, #6366f1);
}

.sidebar-content .nav-sidebar > .nav-item:nth-of-type(6n+6) > .nav-link i,
.sidebar-content .nav-group-sub > .nav-item:nth-of-type(6n+6) > .nav-link i {
    background-image: linear-gradient(135deg, #84cc16, #0ea5e9);
}

.sidebar-content .nav-link:hover {
    color: #ffffff;
    border-color: transparent;
    background:
        linear-gradient(135deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .03)),
        rgba(255, 255, 255, 0.06);
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .12),
        0 6px 14px rgba(2, 13, 40, 0.13);
    transform: translateX(1px);
}

.sidebar-content .nav-link:hover::before {
    opacity: 1;
}

.sidebar-content .nav-item:not(.nav-item-submenu) > .nav-link:hover::after,
.sidebar-content .nav-group-sub .nav-link:hover::after {
    left: 105%;
    opacity: 1;
}

.sidebar-content .nav-link.active {
    color: #ffffff;
    border-color: rgba(125, 211, 252, .62);
    background:
        linear-gradient(135deg, rgba(56, 189, 248, .28), rgba(67, 145, 255, .24)),
        rgba(255, 255, 255, 0.09);
    box-shadow:
        inset 3px 0 0 #38bdf8,
        inset 0 1px 0 rgba(255, 255, 255, .22),
        0 10px 22px rgba(2, 13, 40, 0.22),
        0 0 18px rgba(56, 189, 248, .16);
}

.sidebar-content .nav-link.active::before {
    opacity: 1;
}

.sidebar-content .nav-link.active i,
.sidebar-content .nav-link:hover i {
    filter: brightness(1.18) saturate(1.18) !important;
}

.sidebar-content .nav-group-sub {
    margin: 3px 0 7px 15px;
    padding: 3px 0 3px 10px;
    border-left: 1px solid rgba(125, 211, 252, 0.18);
}

.sidebar-content .nav-group-sub .nav-link {
    min-height: 32px;
    padding: 7px 9px;
    color: rgba(232, 239, 255, 0.76);
    font-size: 12px;
}

.sidebar-content .nav-item-submenu > .nav-link::after {
    color: rgba(205, 220, 255, 0.70);
}

 
</style>
<!-- Sidebar content -->
<div class="sidebar-content">

    <!-- Main navigation -->
    <div class="sidebar-section">
        <div class="sidebar-user-block sidebar-resize-hide">
            <div class="hello">Hi, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong></div>
        </div>

        <ul class="nav nav-sidebar" data-nav-type="accordion">

            <!-- Main -->
            <li class="nav-item-header">
                <div class="sidebar-section-title sidebar-resize-hide">Dashboards</div>
            </li>


            <!-- For dashboard -->
            <li class="nav-item">
                <a href="/admin" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                    <i class="ph-house"></i>
                    <span>
                        {{ trans('dashboard.dashboard') }}
                    </span>
                </a>
            </li>
            @can('user_management_access')
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-user-circle"></i>
                    <span> {{ trans('cruds.userManagement.title') }}</span>
                </a>
                <ul class="nav-group-sub collapse">

                    @can('permission_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}"
                            class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('cruds.permission.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('role_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}"
                            class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('cruds.role.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('user_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}"
                            class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon">

                            </i>
                            {{ trans('cruds.user.title') }}
                        </a>
                    </li>
                    @endcan

                    <li class="nav-item">
                        <a href="{{ route("admin.attendance.index") }}"
                            class="nav-link {{ request()->is('admin/attendance') || request()->is('admin/attendance/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon">

                            </i>
                            Attendance
                        </a>
                    </li>

                </ul>
            </li>
            @endcan

            <li class="nav-item-header">
                <div class="sidebar-section-title sidebar-resize-hide">CRM Modules</div>
            </li>

            @can('lead_access')
            <li class="nav-item">
                <a href="{{ route('admin.lead-inbox.index') }}"
                    class="nav-link {{ (request()->is('admin/lead-inbox') && request()->query('mode') =='') || request()->is('admin/lead-inbox/*') ? 'active' : '' }}">
                    <i class="ph-users"></i><span>Leads</span>
                </a>
            </li>
            @endcan

            @can('contact_access')
            <li class="nav-item">
                <a href="{{ route('admin.contacts') }}"
                    class="nav-link {{ request()->is('admin/contacts') ? 'active' : '' }}">
                    <i class="ph-user"></i><span>Contacts</span>
                </a>
            </li>
            @endcan

           

            @can('sale_access')
            <li class="nav-item">
                <a href="{{ route('admin.sales') }}"
                    class="nav-link {{ request()->is('admin/sales') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Sales</span>
                </a>
            </li>
            @endcan


            @can('RFI_access')
            <li class="nav-item">
                <a href="{{route('admin.fri.index')}}"
                    class="nav-link {{ request()->is('admin/fri') ? 'active' : '' }}">
                    <i class="ph-file-text"></i><span>RFI</span>
                </a>
            </li>
            @endcan

            @can('automation_access')
            <!-- <li class="nav-item">
                <a href="{{route('admin.emailTemplate.index')}}"
                    class="nav-link {{ request()->is('admin/emailTemplate') ? 'active' : '' }}">
                    <i class="ph-lightning"></i><span>Automation</span>
                </a>
            </li> -->

            <li
                class="nav-item nav-item-submenu 
{{ request()->is('admin/emailTemplate*') || request()->is('admin/email-category*') ? 'nav-item-expanded nav-item-open' : '' }}">

                <a href="#" class="nav-link">
                    <i class="ph-envelope"></i>
                    <span>Email Templates</span>
                </a>

                <ul class="nav-group-sub collapse 
    {{ request()->is('admin/emailTemplate*') || request()->is('admin/email-category*') ? 'show' : '' }}">

                    <!-- Automation -->
                    <li class="nav-item">
                        <a href="{{ route('admin.emailTemplate.index') }}"
                            class="nav-link {{ request()->is('admin/emailTemplate*') ? 'active' : '' }}">
                            <i class="ph-lightning text-warning me-1"></i>
                            Automation
                        </a>
                    </li>

                    <!-- Email Category -->
                    <li class="nav-item">
                        <a href="{{ route('admin.category.index') }}"
                            class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                            <i class="ph-tag text-info me-1"></i>
                            Email Category
                        </a>
                    </li>

                </ul>

            </li>
            @endcan

            @can('task_access')
            <li class="nav-item">
                <a href="{{route('admin.taskList')}}"
                    class="nav-link {{ request()->is('admin/taskList') ? 'active' : '' }}">
                    <i class="ph-list-checks"></i><span>Tasks</span>
                </a>
            </li>
            @endcan
            @can('ticket_access')
            <li class="nav-item">
                <a href="{{route('admin.ticket.index')}}"
                    class="nav-link {{ request()->is('admin/ticket') || request()->is('admin/ticket/*') ? 'active' : '' }}">
                    <i class="ph-ticket"></i><span>Tickets</span>
                </a>
            </li>
            @endcan

            <li class="nav-item-header">
                <div class="sidebar-section-title sidebar-resize-hide">Settings</div>
            </li>

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
