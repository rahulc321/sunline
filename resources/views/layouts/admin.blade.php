<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌞</text></svg>">

    <title>Sunline Energy - @yield('title', 'Sunline Energy')</title>
    <link href="{{ asset('vendor/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/css/cs_new.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('vendor/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('vendor/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('vendor/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/js/vendor/tables/datatables/extensions/responsive.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('vendor/demo/pages/datatables_extension_responsive.js') }}"></script>
    <script src="{{ asset('vendor/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/js/vendor/notifications/sweetalert2@11.js') }}"></script>


    <script>
    $(document).ready(function() {




        // Initialize Select2
        $('.select2').select2();

        // Select All
        $('.select-all').click(function() {
            let allOptions = [];
            $('.select2 option').each(function() {
                allOptions.push($(this).val());
            });
            $('.select2').val(allOptions).trigger('change');
        });

        // Deselect All
        $('.deselect-all').click(function() {
            $('.select2').val(null).trigger('change');
        });
    });

    function validateInputs(selectorId = null) {
        if (!selectorId) {
            return false;
        }

        let isValid = true;
        const inputs = document.querySelectorAll('#' + selectorId + ' [data-required="true"]');
        let errors = [];

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                let cleanName = input.name.replace(/a_/g, ' ').replace(/_/g, ' ').toLowerCase();

                if (input.id) {
                    let safeId = CSS.escape(input.id); // Escape any special characters
                    $('#' + safeId).after('<div class="error-message text-danger">The ' + cleanName +
                        ' field is required.</div>');
                } else {
                    // Fallback: append error message to parent or input's container
                    $(input).after('<div class="error-message text-danger">The ' + cleanName +
                        ' field is required.</div>');
                }
            }
        });

        return isValid;
    }
    </script>

    @yield('styles')
</head>

<body>
    <!-- Page content -->
    <div class="page-content">

        <div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

            <!-- Expand button -->
            <button type="button" class="btn btn-sidebar-expand sidebar-control sidebar-main-toggle h-100">
                <i class="ph-caret-right"></i>
            </button>
            <!-- /expand button -->


            <!-- Sidebar header -->
            <div class="sidebar-section bg-black bg-opacity-10 border-bottom border-bottom-white border-opacity-10">
                <div class="sidebar-logo d-flex justify-content-center align-items-center">
                    <!-- <a href="/" class="d-inline-flex align-items-center py-2">
                        <img src="{{ asset('vendor/images/logo_icon.svg') }}" class="sidebar-logo-icon" alt="">
                        <img src="{{ asset('vendor/images/logo_text_light.svg') }}" class="sidebar-resize-hide ms-3" height="14" alt="">
                    </a> -->

                    <div class="d-flex align-items-center lh-sm">
                        <!-- Blue icon -->
                        <div class="logo_text d-none"
                            style="padding: 6px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-building2 h-4 w-4">
                                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                <path d="M10 6h4"></path>
                                <path d="M10 10h4"></path>
                                <path d="M10 14h4"></path>
                                <path d="M10 18h4"></path>
                            </svg>
                        </div>


                        <!-- Text block -->
                        <div>
                            <!-- <div class="fw-bold text-dark">Sunline Energy</div>
                            <small class="text-muted">CRM Platform</small> -->

                            <img src="{{ url('/') }}/logo.png" style=" 
    left: 42%;
    width: 71%;
    position: absolute;
    transform: translate(-50%, -50%);" alt="Logo">
                        </div>
                    </div>


                    <div class="sidebar-resize-hide ms-auto">
                        <button type="button"
                            class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-toggle d-none d-lg-inline-flex">
                            <i class="ph-arrows-left-right"></i>
                        </button>

                        <button type="button"
                            class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                            <i class="ph-x"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /sidebar header -->
            @include('not')
            @if(request()->is('admin/intakes/*/edit'))
            @include('partials.lead-menu')
            @else
            @include('partials.menu')
            @endif

        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Main navbar -->
            <div class="navbar navbar-expand-lg navbar-static shadow">
                <div class="container-fluid">
                    <div class="d-flex d-lg-none me-2">
                        <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                            <i class="ph-list"></i>
                        </button>
                    </div>

                    <div class="navbar-collapse flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
                        <div class="navbar-search flex-fill dropdown mt-2 mt-lg-0">
                            <div class="form-control-feedback form-control-feedback-start flex-grow-1">
                                <h6 style="margin-bottom: calc(var(--spacer) * -0.25);">🌞 Salses CRM</h6>
                                <small>{{env('TAG_LINE')}}</small>


                                <div class="dropdown-menu w-100">
                                    <button type="button" class="dropdown-item">
                                        <div class="text-center w-32px me-3">
                                            <i class="ph-magnifying-glass"></i>
                                        </div>
                                        <span>Search <span class="fw-bold">"in"</span> everywhere</span>
                                    </button>

                                    <div class="dropdown-divider"></div>

                                    <div class="dropdown-menu-scrollable-lg">
                                        <div class="dropdown-header">
                                            Contacts
                                            <a href="#" class="float-end">
                                                See all
                                                <i class="ph-arrow-circle-right ms-1"></i>
                                            </a>
                                        </div>

                                        <div class="dropdown-item cursor-pointer">
                                            <div class="me-3">
                                                <img src="{{ asset('vendor/images/demo/users/face3.jpg') }}"
                                                    class="w-32px h-32px rounded-pill" alt="">
                                            </div>

                                            <div class="d-flex flex-column flex-grow-1">
                                                <div class="fw-semibold">Christ<mark>in</mark>e Johnson</div>
                                                <span class="fs-sm text-muted">c.johnson@awesomecorp.com</span>
                                            </div>

                                            <div class="d-inline-flex">
                                                <a href="#" class="text-body ms-2">
                                                    <i class="ph-user-circle"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="dropdown-item cursor-pointer">
                                            <div class="me-3">
                                                <img src="{{ asset('vendor/images/demo/users/face24.jpg') }}"
                                                    class="w-32px h-32px rounded-pill" alt="">
                                            </div>

                                            <div class="d-flex flex-column flex-grow-1">
                                                <div class="fw-semibold">Cl<mark>in</mark>ton Sparks</div>
                                                <span class="fs-sm text-muted">c.sparks@awesomecorp.com</span>
                                            </div>

                                            <div class="d-inline-flex">
                                                <a href="#" class="text-body ms-2">
                                                    <i class="ph-user-circle"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="dropdown-divider"></div>

                                        <div class="dropdown-header">
                                            Clients
                                            <a href="#" class="float-end">
                                                See all
                                                <i class="ph-arrow-circle-right ms-1"></i>
                                            </a>
                                        </div>

                                        <div class="dropdown-item cursor-pointer">
                                            <div class="me-3">
                                                <img src="{{ asset('vendor/images/brands/adobe.svg') }}"
                                                    class="w-32px h-32px rounded-pill" alt="">
                                            </div>

                                            <div class="d-flex flex-column flex-grow-1">
                                                <div class="fw-semibold">Adobe <mark>In</mark>c.</div>
                                                <span class="fs-sm text-muted">Enterprise license</span>
                                            </div>

                                            <div class="d-inline-flex">
                                                <a href="#" class="text-body ms-2">
                                                    <i class="ph-briefcase"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="dropdown-item cursor-pointer">
                                            <div class="me-3">
                                                <img src="{{ asset('vendor/images/brands/holiday-inn.svg') }}"
                                                    class="w-32px h-32px rounded-pill" alt="">
                                            </div>

                                            <div class="d-flex flex-column flex-grow-1">
                                                <div class="fw-semibold">Holiday-<mark>In</mark>n</div>
                                                <span class="fs-sm text-muted">On-premise license</span>
                                            </div>

                                            <div class="d-inline-flex">
                                                <a href="#" class="text-body ms-2">
                                                    <i class="ph-briefcase"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="dropdown-item cursor-pointer">
                                            <div class="me-3">
                                                <img src="{{ asset('vendor/images/brands/ing.svg') }}"
                                                    class="w-32px h-32px rounded-pill" alt="">
                                            </div>

                                            <div class="d-flex flex-column flex-grow-1">
                                                <div class="fw-semibold"><mark>IN</mark>G Group</div>
                                                <span class="fs-sm text-muted">Perpetual license</span>
                                            </div>

                                            <div class="d-inline-flex">
                                                <a href="#" class="text-body ms-2">
                                                    <i class="ph-briefcase"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="position-static">
                                <a href="#"
                                    class="navbar-nav-link align-items-center justify-content-center w-40px h-32px position-absolute end-0 top-50 translate-middle-y p-0 me-1"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <i class="ph-faders-horizontal"></i>
                                </a>

                                <div class="dropdown-menu w-100 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <h6 class="mb-0">Search options</h6>
                                        <a href="#" class="text-body rounded-pill ms-auto">
                                            <i class="ph-clock-counter-clockwise"></i>
                                        </a>
                                    </div>

                                    <div class="mb-3">
                                        <label class="d-block form-label">Category</label>
                                        <label class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" checked>
                                            <span class="form-check-label">Invoices</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input">
                                            <span class="form-check-label">Files</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input">
                                            <span class="form-check-label">Users</span>
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Addition</label>
                                        <div class="input-group">
                                            <select class="form-select w-auto flex-grow-0">
                                                <option value="1" selected>has</option>
                                                <option value="2">has not</option>
                                            </select>
                                            <input type="text" class="form-control" placeholder="Enter the word(s)">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="input-group">
                                            <select class="form-select w-auto flex-grow-0">
                                                <option value="1" selected>is</option>
                                                <option value="2">is not</option>
                                            </select>
                                            <select class="form-select">
                                                <option value="1" selected>Active</option>
                                                <option value="2">Inactive</option>
                                                <option value="3">New</option>
                                                <option value="4">Expired</option>
                                                <option value="5">Pending</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <button type="button" class="btn btn-light">Reset</button>

                                        <div class="ms-auto">
                                            <button type="button" class="btn btn-light">Cancel</button>
                                            <button type="button" class="btn btn-primary ms-2">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav hstack gap-sm-1 flex-row justify-content-end order-1 order-lg-2">
                        <li class="nav-item d-lg-none">
                            <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                                data-bs-toggle="collapse">
                                <i class="ph-magnifying-glass"></i>
                            </a>
                        </li>
                        <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2  d-none">
                            <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                                data-bs-toggle="dropdown">
                                <i class="ph-squares-four"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-scrollable-sm wmin-lg-600 p-0">
                                <div class="d-flex align-items-center border-bottom p-3">
                                    <h6 class="mb-0">Browse apps</h6>
                                    <a href="#" class="ms-auto">
                                        View all
                                        <i class="ph-arrow-circle-right ms-1"></i>
                                    </a>
                                </div>

                                <div class="row row-cols-1 row-cols-sm-2 g-0">
                                    <div class="col">
                                        <button type="button"
                                            class="dropdown-item text-wrap h-100 align-items-start border-end-sm border-bottom p-3">
                                            <div>
                                                <img src="{{ asset('vendor/images/demo/logos/1.svg') }}"
                                                    class="h-40px mb-2" alt="">
                                                <div class="fw-semibold my-1">Customer data platform</div>
                                                <div class="text-muted">Unify customer data from multiple sources</div>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="col">
                                        <button type="button"
                                            class="dropdown-item text-wrap h-100 align-items-start border-bottom p-3">
                                            <div>
                                                <img src="{{ asset('vendor/images/demo/logos/2.svg') }}"
                                                    class="h-40px mb-2" alt="">
                                                <div class="fw-semibold my-1">Data catalog</div>
                                                <div class="text-muted">Discover, inventory, and organize data assets
                                                </div>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="col">
                                        <button type="button"
                                            class="dropdown-item text-wrap h-100 align-items-start border-end-sm border-bottom border-bottom-sm-0 rounded-bottom-start p-3">
                                            <div>
                                                <img src="{{ asset('vendor/images/demo/logos/3.svg') }}"
                                                    class="h-40px mb-2" alt="">
                                                <div class="fw-semibold my-1">Data governance</div>
                                                <div class="text-muted">The collaboration hub and data marketplace</div>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="col">
                                        <button type="button"
                                            class="dropdown-item text-wrap h-100 align-items-start rounded-bottom-end p-3">
                                            <div>
                                                <img src="{{ asset('vendor/images/demo/logos/4.svg') }}"
                                                    class="h-40px mb-2" alt="">
                                                <div class="fw-semibold my-1">Data privacy</div>
                                                <div class="text-muted">Automated provisioning of non-production
                                                    datasets</div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2  d-none1">
                            <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <i class="ph-bell"></i>
                                <span
                                    class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1 notification">{{ auth()->user()->unreadNotifications->count() }}</span>
                            </a>

                            <div class="dropdown-menu wmin-lg-400 p-0">

                                <div class="d-flex align-items-center p-3">
                                    <h6 class="mb-0">Notifications</h6>
                                    <div class="ms-auto">
                                        <a href="{{ route('admin.notifications.markAllRead') }}" class="text-body">
                                            <i class="ph-checks"></i>
                                        </a>
                                        <a href="#search_notifications" class="collapsed text-body ms-2"
                                            data-bs-toggle="collapse">
                                            <i class="ph-magnifying-glass"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="collapse" id="search_notifications">
                                    <div class="px-3 mb-2">
                                        <div class="form-control-feedback form-control-feedback-start">
                                            <input type="text" class="form-control" placeholder="Search notifications"
                                                id="searchNotificationInput">
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-magnifying-glass"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                .dropdown-menu[data-bs-popper] {
                                    top: 100%;
                                    left: -175px !important;
                                    margin-top: var(--dropdown-spacer);

                                }

                                a.navbar-nav-link.navbar-nav-link-icon.rounded-pill {
                                    color: var(--navbar-active-color);
                                    background-color: var(--navbar-active-bg);
                                }
                                </style>
                                <?php $notifications = auth()->user()->unreadNotifications()->latest()->get(); ?>
                                <div class="dropdown-menu-scrollable pb-2" id="notificationsList">
                                    @include('partials.notifications_list', ['notifications' => $notifications])
                                </div>

                                <div class="d-flex border-top py-2 px-3">
                                    <a href="{{ route('admin.notifications.markAllRead') }}" class="text-body">
                                        <i class="ph-checks me-1"></i> Dismiss all
                                    </a>
                                    <a href="{{ route('admin.notifications.index') }}" class="text-body ms-auto">
                                        View all
                                        <i class="ph-arrow-circle-right ms-1"></i>
                                    </a>
                                </div>
                            </div>

                        </li>

                        <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                            <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1 bg_s"
                                data-bs-toggle="dropdown">
                                <div class="media me-2 media-danger">
                                    @php
                                    $firstLetter = strtoupper(substr(\Auth::user()->name, 0, 1));
                                    @endphp
                                    {{$firstLetter}}
                                </div>
                                <span class="d-none d-lg-inline-block">Hi, <span>{{@\Auth::user()->name}} </span></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{route('admin.profile')}}" class="dropdown-item">
                                    <i class="ph-user-circle me-2"></i>
                                    My profile
                                </a>
                                <a href="#" class="dropdown-item d-none">
                                    <i class="ph-currency-circle-dollar me-2"></i>
                                    My subscription
                                </a>
                                <a href="#" class="dropdown-item d-none">
                                    <i class="ph-shopping-cart me-2"></i>
                                    My orders
                                </a>
                                <a href="#" class="dropdown-item d-none">
                                    <i class="ph-envelope-open me-2"></i>
                                    My inbox
                                    <span class="badge bg-primary rounded-pill ms-auto">26</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item d-none">
                                    <i class="ph-gear me-2"></i>
                                    Account settings
                                </a>
                                <a href="{{route('admin.logout')}}" class="dropdown-item">
                                    <i class="ph-sign-out me-2"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /main navbar -->


            <!-- Inner content -->
            <div class="content-inner">

                @if(session('message'))
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    </div>
                </div>
                @endif
                @if($errors->count() > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @yield('content')




            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    @yield('scripts')
</body>
<script>
$('#jsGrid1').DataTable({
    responsive: true,
    pageLength: 10,
    order: [
        [0, 'asc']
    ],
    dom: "<'row mb-3 d-flex justify-content-between'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>"
});
</script>

<button id="notifyBtn" onclick="sendNotification()" style="display:none">Send Notification</button>
@if(auth()->check() && auth()->user()->unreadNotifications->count() > 0 && !session('notif_shown'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    // auto trigger notification
    document.getElementById("notifyBtn").click();
});
</script>

@php
// mark it as shown in Laravel session
session(['notif_shown' => true]);
@endphp
@endif
<script>
function sendNotification(count = {{auth()->user()-> unreadNotifications->count() }}) {
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }

    if (Notification.permission === "granted") {
        let notif = new Notification("Sunline Energy", {
            body: "You have " + count + " new notification(s).",
            icon: "data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌞</text></svg>" // replace with your ticket/task icon
        });

        // optional: play sound
        let audio = new Audio("{{url('/')}}/not.mp3");
        audio.play();

        notif.onclick = function() {
            window.location.href = "{{ url('/admin/notifications') }}";
        };
    }
}
</script>

<script>
function fetchNotifications() {
    $.ajax({
        url: "{{ route('admin.fetchNotification') }}",
        type: "GET",
        success: function(data) {
            // update count
            $('.notification').text(data.count);

            // update notifications list
            $('#notificationsList').html(data.html);


        },
        error: function() {
            console.error('Failed to fetch notifications.');
        }
    });
}

// run every 10 seconds
setInterval(fetchNotifications, 10000);

// initial load
fetchNotifications();
</script>


</html>