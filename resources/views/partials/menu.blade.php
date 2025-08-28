<style>
.navbar {
    --navbar-bg: rgb(255 255 255);
	height: 3.5rem;
	border-bottom: 1px solid #d1d5db;
}
 h6{
    margin-top: 12px;
	color: rgb(49, 62, 74);

}
.page-content {
  
    background: white;
}

.sidebar-content {
 
    border-right: 1px solid #d1d5db;
}
.sidebar-logo{
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

.logo_text{
	margin-right: 8px;
	background: linear-gradient(135deg, hsl(214 84% 56%), hsl(214 84% 76%));
}
.crm_c{
	/* color: hsl(214 84% 56%) !important; */
	/* font-size: 1.875rem; */
	/* font-size: 21px; */
    line-height: 2.25rem;

	 
    line-height: 2.25rem;
    background: linear-gradient(135deg, hsl(214 84% 56%) 0%, hsl(142 76% 36%) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text; /* for Firefox */
    color: transparent;

}
.txt_1 {
    margin-bottom: 25px !important;
    color: hsl(215 16% 47%);
    margin-top: -22px !important;
    font-size: 16px;
}

.txt_2{
	color: hsl(215 16% 47%);
}
.bg_s, .select-all, .deselect-all, input[value="Save"]{
	background: linear-gradient(135deg, hsl(214 84% 56%), hsl(214 84% 76%)) !important;
}

.rounded{
	box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
}

.form_1, .card{
	box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
	border: 1px solid #d1d5db;
}
.table > :not(caption) > * > * {
     
    padding: 8px !important;
}

.table > thead {
    vertical-align: middle;
    /* background: #fddef2; */
    color: #f7f7f7;
    background: linear-gradient(135deg, hsl(214deg 38.04% 68.23%), hsl(214 84% 76%)) !important;
}
td {
    color: hsl(215, 16%, 47%) !important;
}

td{
    border-color: inherit;
    border-style: solid;
    border-width: 0;
    font-size: 15px;
    font-weight: 300;
}
svg.lucide.lucide-circle-alert.h-5.w-5.text-destructive {
    color: red;
}

.fwb{
	font-size: 21px;
}

select[name="jsGrid1_length"]{
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
    
    font-size: 1.125rem !important;;
    line-height: 1.75rem !important;;
}
.btn{

    cursor: pointer;
    height: 2.25rem;
	font-weight: 500;
}

.custom-btn {
    background-color: white !important;
    color: black !important;
    border: 1px solid #ccc; /* optional border */
}

.custom-btn i {
    color: #ff3b00 !important; /* icon color */
	 
}
 
</style>
<!-- Sidebar content -->
<div class="sidebar-content">

    <!-- Main navigation -->
    <div class="sidebar-section">
        <ul class="nav nav-sidebar" data-nav-type="accordion">

            <!-- Main -->
            <li class="nav-item-header">
                <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide white">
                </div>

            </li>

            <li class="nav-item">
                <a href="/" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
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

                </ul>
            </li>
            @endcan

			@can('lead_access')
            <li class="nav-item">
                <a href="{{ route('admin.lead-inbox.index') }}"
                    class="nav-link {{ (request()->is('admin/lead-inbox') && request()->query('mode') =='') || request()->is('admin/lead-inbox/*') ? 'active' : '' }}">
                    <i class="ph-users"></i><span>Leads</span>
                </a>
            </li>
			@endcan


            <li class="nav-item">
                <a href="{{ route('admin.lead-inbox.index') }}?mode=agenda"
                    class="nav-link {{ request()->is('admin/lead-inbox') && request()->query('mode') == 'agenda' ? 'active' : '' }}">
                    <i class="ph-user"></i><span>Contacts</span>
                </a>
            </li>



            <li class="nav-item">
                <a href="#"
                    class="nav-link {{ request()->is('admin/intakes/create') ? 'active' : '' }}">
                    <i class="ph-currency-dollar"></i><span>Sales</span>
                </a>
            </li>



            <li class="nav-item">
                <a href="{{route('admin.fri.index')}}"
                    class="nav-link {{ request()->is('admin/fri') ? 'active' : '' }}">
                    <i class="ph-file-text"></i><span>FRI</span>
                </a>
            </li>



            <li class="nav-item">
                <a href="{{route('admin.emailTemplate.index')}}"
                    class="nav-link {{ request()->is('admin/emailTemplate') ? 'active' : '' }}">
                    <i class="ph-lightning"></i><span>Automation</span>
                </a>
            </li>


            <li class="nav-item">
                <a href="{{route('admin.taskList')}}"
                    class="nav-link {{ request()->is('admin/taskList') ? 'active' : '' }}">
                    <i class="ph-list-checks"></i><span>Tasks</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.ticket.index')}}"
                    class="nav-link {{ request()->is('admin/ticket') || request()->is('admin/ticket/*') ? 'active' : '' }}">
                    <i class="ph-ticket"></i><span>Tickets</span>
                </a>
            </li>
			@can('leadSource_access')
			<li class="nav-item">
                <a href="{{route('admin.leadSource.index')}}"
                    class="nav-link {{ request()->is('admin/leadSource') || request()->is('admin/leadSource/*') ? 'active' : '' }}">
                    <i class="ph-globe"></i><span>Lead Source</span>
                </a>
            </li>
			@endif

        </ul>
    </div>
    <!-- /main navigation -->

</div>
<!-- /sidebar content -->