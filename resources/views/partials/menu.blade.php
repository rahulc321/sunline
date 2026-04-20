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
    border-right: 0;
    background: linear-gradient(145deg, #0f172a 0%, #092575 55%, #0b38b6 100%);
    padding: 0 10px 16px;
    color: #e8efff;
    box-shadow: inset -1px 0 0 rgba(255, 255, 255, 0.08);
}

.sidebar-section {
    font-family: inherit;
}

.sidebar-user-block {
    padding: 14px 12px 12px;
    margin: 0 -10px 8px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.10);
    background: rgba(4, 14, 42, 0.18);
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
    padding: 0;
}

.sidebar-content .nav-item-header {
    padding: 13px 2px 6px;
    margin: 0;
}

.sidebar-content .nav-item-header .sidebar-section-title {
    color: rgba(190, 205, 255, 0.62);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .18em;
    line-height: 1.2;
    text-transform: uppercase;
}

.sidebar-content .nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    min-height: 36px;
    margin: 2px 0;
    padding: 9px 10px;
    border-radius: 8px;
    color: rgba(237, 243, 255, 0.86);
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0;
    transition: background .18s ease, color .18s ease, box-shadow .18s ease;
}

.sidebar-content .nav-link span {
    min-width: 0;
}

.sidebar-content .nav-link i {
    width: 17px;
    min-width: 17px;
    margin-right: 0;
    color: #7cc7ff;
    background: none;
    -webkit-text-fill-color: initial;
    font-size: 15px;
    transform: none !important;
    filter: none !important;
}

.sidebar-content .nav-link:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.08);
}

.sidebar-content .nav-link.active {
    color: #ffffff;
    background: rgba(50, 103, 223, 0.72);
    box-shadow: inset 3px 0 0 #26a8ff, 0 8px 22px rgba(2, 13, 40, 0.20);
}

.sidebar-content .nav-link.active i,
.sidebar-content .nav-link:hover i {
    color: #a9dcff;
}

.sidebar-content .nav-group-sub {
    margin: 2px 0 6px 15px;
    padding: 3px 0 3px 9px;
    border-left: 1px solid rgba(255, 255, 255, 0.11);
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
