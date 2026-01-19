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
                        <div class="col-12 col-md-6">

                            @if($lead->is_email_connected && $lead->email_provider === 'gmail')

                            <!-- CONNECTED STATE -->
                            <div class="provider-card selected w-100 p-3 text-start">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png"
                                            alt="Gmail" height="36" class="me-3">

                                        <div>
                                            <div class="fw-bold">Gmail</div>
                                            <small class="text-muted">
                                                {{ $lead->connected_email }}
                                            </small>
                                        </div>
                                    </div>

                                    <span class="badge bg-success d-flex align-items-center">
                                        <span class="pulse-dot me-2"></span>
                                        Connected
                                    </span>
                                </div>

                                <div class="mt-3 text-end">


                                    <a href="{{ route('admin.gmailDisconnect', $lead->id) }}"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to disconnect this Gmail account?');">
                                        Disconnect
                                    </a>
                                </div>
                            </div>

                            @else

                            <!-- NOT CONNECTED STATE -->
                            <a href="{{ route('admin.gmailConnect', [$lead->id]) }}" class="text-decoration-none">
                                <div class="provider-card w-100 p-3 text-start">
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
                                </div>
                            </a>

                            @endif

                        </div>
                    </div>

                </div>

                <!-- SYNC CONTACTS TAB -->
                <div class="tab-pane fade" id="sync-contacts" role="tabpanel">
                    <?php
                   $email = 'rahulidcsoftwares@gmail.com';

                   $threadIds = \DB::table('gmails')
                       ->where('user_id', auth()->id())
                       ->where(function ($q) use ($email) {
                           $q->where('from', 'like', "%$email%")
                             ->orWhere('to', 'like', "%$email%");
                       })
                       ->pluck('thread_id')
                       ->unique();

                    $conversations = \DB::table('gmails')
                       ->where('user_id', auth()->id())
                       ->whereIn('thread_id', $threadIds)
                       ->orderBy('thread_id')
                       ->orderBy('created_at', 'desc')
                       ->get()
                       ->groupBy('thread_id');
                    ?>


                    @foreach($conversations as $threadId => $messages)
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>Conversation</strong> (Thread: {{ $threadId }})
                        </div>

                        <div class="card-body">
                            @foreach($messages as $mail)
                            <div class="mb-3 p-2 {{ $mail->folder === 'sent' ? 'text-end bg-light' : '' }}">
                                <p class="mb-1">
                                    <strong>From:</strong> {{ $mail->from }} <br>
                                    <strong>To:</strong> {{ $mail->to }}
                                </p>

                                <div class="border p-2">
                                {!! str_replace('"', ' &quot;', $mail->body) !!}
                                </div>

                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($mail->created_at)->format('d M Y, h:i A') }}
                                </small>
                            </div>
                            @endforeach

                            <!-- Reply button -->
                            <a href="#" class="btn btn-sm btn-primary">
                                Reply
                            </a>
                        </div>
                    </div>
                    @endforeach

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

<!-- INLINE STYLES -->
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

/* CONNECTED ANIMATION */
.pulse-dot {
    width: 8px;
    height: 8px;
    background: #ffffff;
    border-radius: 50%;
    animation: pulse 1.4s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }

    70% {
        transform: scale(2);
        opacity: 0;
    }

    100% {
        transform: scale(1);
        opacity: 0;
    }
}

.provider-card.selected {
    border-color: #00a06a !important;
    /* box-shadow: 0 6px 18px rgba(31, 111, 235, .15); */
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
}

.provider-card {
    border: 1px solid #df0d0d;
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    transition: .2s ease;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
}
</style>
@endsection