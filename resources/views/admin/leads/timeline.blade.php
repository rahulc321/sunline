@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">

            <!-- TOP TABS -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#connect-email" role="tab">
                        Connect email
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#sync-contacts" role="tab">
                        Sync contacts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#calendar" role="tab">
                        Calendar and Conferencing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#email" role="tab">
                        Email
                    </a>
                </li>
            </ul>

            <!-- TAB CONTENT -->
            <div class="tab-content">

                <!-- CONNECT EMAIL TAB -->
                <div class="tab-pane fade show active" id="connect-email" role="tabpanel">

                    <div class="mb-3 text-muted">
                        Once you connect your email to the CRM, you can
                    </div>

                    <ul class="list-unstyled mb-4">
                        <li>
                            <i class="ph-check-circle text-success me-2"></i>
                            Send and receive emails
                        </li>
                        <li>
                            <i class="ph-check-circle text-success me-2"></i>
                            Track your emails live for opens and clicks
                        </li>
                    </ul>

                    <h6 class="mb-3">Select your email provider:</h6>

                    <div class="row g-3">
                        <!-- GMAIL CARD -->
                        <div class="col-12 col-md-4">
                            <a href="{{route('admin.gmailConnect',[$lead->id])}}"><button
                                    class="provider-card selected w-100 p-3 text-start">
                                    <div class="d-flex align-items-center">
                                        <img src="https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png"
                                            alt="Gmail" height="36" class="me-3">
                                        <div>
                                            <div class="fw-bold">Gmail</div>
                                            <small class="text-muted">

                                                We recommend this provider.
                                            </small>
                                        </div>
                                    </div>
                                </button>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- SYNC CONTACTS TAB -->
                <div class="tab-pane fade" id="sync-contacts" role="tabpanel">
                    <p class="text-muted">Contacts sync settings will appear here.</p>
                </div>

                <!-- CALENDAR TAB -->
                <div class="tab-pane fade" id="calendar" role="tabpanel">
                    <p class="text-muted">Calendar integration settings will appear here.</p>
                </div>

                <!-- EMAIL TAB -->
                <div class="tab-pane fade" id="email" role="tabpanel">
                    <p class="text-muted">Email preferences will appear here.</p>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- INLINE STYLES (ALL IN SAME FILE) -->
<style>
.provider-card {
    border: 1px solid #e9eef6;
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    transition: .2s ease;
}

.provider-card:hover {
    box-shadow: 0 6px 18px rgba(16, 24, 40, .08);
}

.provider-card.selected {
    border-color: #1f6feb;
    box-shadow: 0 6px 18px rgba(31, 111, 235, .15);
}

.nav-tabs .nav-link {
    color: #3b4a6b;
}
</style>
@endsection