@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap">
            <!-- Title + subtitle stacked -->
            <div class="d-flex flex-column">
                <h4 class="page-title mb-0 crm_c" style="font-size: 1.875rem;">Sales Dashboard</h4>
                <p class="mb-0 txt_1">Track performance and monitor lead pipeline</p>
            </div>

            <!-- Punch buttons aligned right -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <form action="{{ route('admin.attendance.punchin') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="ph-arrow-circle-right me-1"></i> Punch In
                    </button>
                </form>

                <form action="{{ route('admin.attendance.punchout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                        <i class="ph-arrow-circle-left me-1"></i> Punch Out
                    </button>
                </form>
            </div>
        </div>



    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content pt-0">

    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">

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
                                data-component-path="src/components/dashboard/DashboardFilters.tsx"
                                data-component-line="67" data-component-file="DashboardFilters.tsx"
                                data-component-name="Filter"
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

            <div class="row g-3">
                <!-- Example Box with icon on right like screenshot -->
                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Total Leads Assigned</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-users h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">{{$assign_lead->count() ?? 0}}</h4>
                        <small class="text-success">+12% from last month</small>
                    </div>
                </div>

                <!-- Box 2 -->

                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Leads Contacted</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-phone h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">{{$contacts->count() ?? 0}}</h4>
                        <small class="text-success">82% contact rate</small>
                    </div>
                </div>

                <!-- Box 3 -->

                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Quotes Sent</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-file-text h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                    <path d="M10 9H8"></path>
                                    <path d="M16 13H8"></path>
                                    <path d="M16 17H8"></path>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">33</h4>
                        <small class="text-success">+8% from last month</small>
                    </div>
                </div>

                <!-- Box 4 -->
                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Sales Closed</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-dollar-sign h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <line x1="12" x2="12" y1="2" y2="22"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">{{$closed_sale->count() ?? 0}}</h4>
                        <small class="text-success">25.8% conversion rate</small>
                    </div>
                </div>


                <!-- Box 5 -->
                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Products Sold</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-package h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <path
                                        d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z">
                                    </path>
                                    <path d="M12 22V12"></path>
                                    <path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path>
                                    <path d="m7.5 4.27 9 5.15"></path>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">156</h4>
                        <small class="text-success">Battery: 40, Solar+Battery: 60, Heat Pump: 20, Aircon:
                            14</small>
                    </div>
                </div>

                <!-- Box 6 -->
                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Total Conversion %</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-target h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="12" r="6"></circle>
                                    <circle cx="12" cy="12" r="2"></circle>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">25.8%</h4>
                        <small class="text-success">+2.3% from last month</small>
                    </div>
                </div>

                <!-- Box 7 -->
                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Total Conversation %</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-zap h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <path
                                        d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">87.6%</h4>
                        <small class="text-success">Contact rate from calls/meetings</small>
                    </div>
                </div>


                <!-- Box 8 -->
                <div class="col-md-3 col-sm-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="txt_2">Lead Cost Spend</span>
                            <div class="bg_s d-flex align-items-center justify-content-center"
                                style="width:46px;height:46px;background:hsl(215, 16%, 47%);border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-dollar-sign h-6 w-6 text-white"
                                    data-lov-id="src/components/dashboard/KPICard.tsx:34:10" data-lov-name="Icon"
                                    data-component-path="src/components/dashboard/KPICard.tsx" data-component-line="34"
                                    data-component-file="KPICard.tsx" data-component-name="Icon"
                                    data-component-content="%7B%22className%22%3A%22h-6%20w-6%20text-white%22%7D">
                                    <line x1="12" x2="12" y1="2" y2="22"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                        </div>
                        <h4 class="mb-0 txt_2">$12,485</h4>
                        <small class="text-success">Based on source costs × volumes</small>
                    </div>
                </div>


            </div>






        </div>


    </div>
    <!-- /dashboard content -->

</div>
<!-- /content area -->
@endsection
@section('scripts')
@parent
<script src="{{ asset('vendor/demo/pages/dashboard.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/donuts.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/bars.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/progress.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
<script src="{{ asset('vendor/demo/charts/pages/dashboard/pies.js') }}"></script>

@endsection