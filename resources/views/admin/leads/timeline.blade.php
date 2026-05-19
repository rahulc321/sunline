@extends('layouts.admin')

@section('content')
@php
    $leadName = trim(($lData->first_name ?? '') . ' ' . ($lData->last_name ?? ''));
    $leadName = $leadName ?: ($lData->name ?? 'Lead');
    $leadEmail = $lData->email ?? '';
@endphp

<div class="content rk-timeline-page pt-0">
    <div class="rk-timeline-shell">
        <section class="rk-timeline-hero">
            <div class="rk-hero-copy">
                <span class="rk-eyebrow"><i class="ph-clock-counter-clockwise"></i> Communication Timeline</span>
                <h1>{{ $leadName }}</h1>
                <p>{{ $leadEmail ?: 'No lead email available' }}</p>
            </div>
            <div class="rk-hero-badge">
                <i class="ph-envelope-simple"></i>
                <span>Email Sync</span>
            </div>
        </section>

        <div class="rk-timeline-card">
            <div class="rk-card-toolbar">
                <div>
                    <h5>Synced Conversations</h5>
                    <span>Gmail threads matched with this lead.</span>
                </div>
                <span class="rk-live-pill"><i class="ph-sparkle"></i> Glossy view</span>
            </div>

            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#sync-contacts">
                        <i class="ph-link-simple"></i> Sync contacts
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="sync-contacts">

                    @php
                    $syncedEmail = auth()->user()->connected_email;
                    $leadEmail = $lData->email ?? '';
                   // dd($leadEmail);
                    $threadIds = DB::table('gmails')
                    ->where('user_id', auth()->id())
                    ->where(function ($q) use ($syncedEmail, $leadEmail) {
                    $q->where(function ($qq) use ($syncedEmail, $leadEmail) {
                    $qq->where('from', 'like', "%$syncedEmail%")
                    ->where('to', 'like', "%$leadEmail%");
                    })
                    ->orWhere(function ($qq) use ($syncedEmail, $leadEmail) {
                    $qq->where('from', 'like', "%$leadEmail%")
                    ->where('to', 'like', "%$syncedEmail%");
                    });
                    })
                    ->pluck('thread_id')
                    ->unique();

                    $conversations = DB::table('gmails')
                    ->where('user_id', auth()->id())
                    ->whereIn('thread_id', $threadIds)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy('thread_id');
                    @endphp

                    @forelse($conversations as $threadId => $messages)
                    @php $firstMail = $messages->first(); @endphp

                    <div class="chat-card mb-4">

                        <div class="chat-header">
                            <div>
                                <strong>{{ $firstMail->subject ?? '(No Subject)' }}</strong>
                                <span>{{ $messages->count() }} {{ \Illuminate\Support\Str::plural('message', $messages->count()) }}</span>
                            </div>
                            <i class="ph-chats-circle"></i>
                        </div>

                        <div class="chat-body">
                            @foreach($messages as $mail)
                            @php $isSent = $mail->folder === 'sent'; @endphp

                            <div class="chat-message {{ $isSent ? 'sent' : '' }}">
                                <div class="chat-avatar">
                                    {{ strtoupper(substr($isSent ? 'You' : $mail->from, 0, 1)) }}
                                </div>

                                <div class="chat-bubble">
                                    <div class="chat-meta">
                                        <strong>{{ $isSent ? 'You' : $mail->from }}</strong>
                                        <span>{{ \Carbon\Carbon::parse($mail->created_at)->format('d M Y h:i A') }}</span>
                                    </div>
                                    <div class="chat-text">{!! $mail->body !!}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="chat-footer">
                            <form class="reply-form" data-thread="{{ $threadId }}" data-editor-id="timeline-editor-{{ $loop->iteration }}">
                                <div class="reply-title">
                                    <div>
                                        <strong>Reply in this conversation</strong>
                                        <span>Your message will stay in the same Gmail thread.</span>
                                    </div>
                                    <i class="ph-paper-plane-tilt"></i>
                                </div>
                                <textarea class="form-control timeline-editor" id="timeline-editor-{{ $loop->iteration }}"
                                    placeholder="Type your reply..."></textarea>

                                <div class="reply-actions">
                                    <button type="submit" class="reply-link">
                                        <i class="ph-paper-plane-right"></i> Send Reply
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- <div class="reply-box d-none" id="reply-box-{{ $threadId }}">
                            <textarea class="form-control mb-2" rows="3" id="reply-text-{{ $threadId }}"
                                placeholder="Type your reply..."></textarea>

                            <div class="text-end">
                                <button class="btn btn-success btn-sm send-reply" data-thread="{{ $threadId }}">
                                    Send
                                </button>
                            </div>
                        </div> -->

                    </div>
                    @empty
                    <div class="rk-empty-state">
                        <i class="ph-envelope-open"></i>
                        <h5>No conversations found</h5>
                        <p>No synced Gmail conversation has been matched with this lead yet.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rk-timeline-page {
    --rk-ink: #142033;
    --rk-muted: #667085;
    --rk-blue: #2563eb;
    --rk-sky: #38a8ff;
    --rk-green: #16a34a;
    --rk-line: rgba(56, 168, 255, 0.64);
    padding-left: 0 !important;
    padding-right: 0 !important;
    color: var(--rk-ink);
    font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif;
}

.rk-timeline-shell {
    position: relative;
    overflow: hidden;
    padding: 18px;
    background:
        radial-gradient(circle at 12% 8%, rgba(56, 168, 255, 0.24), transparent 30%),
        radial-gradient(circle at 88% 4%, rgba(245, 158, 11, 0.16), transparent 28%),
        linear-gradient(180deg, #f7fbff 0%, #edf6ff 48%, #ffffff 100%);
    border-top: 1px solid rgba(219, 227, 239, 0.88);
    border-bottom: 1px solid rgba(219, 227, 239, 0.88);
    box-shadow: 0 20px 55px rgba(21, 32, 51, 0.08);
}

.rk-timeline-shell:before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background:
        linear-gradient(115deg, rgba(255, 255, 255, 0.52), transparent 28%, transparent 72%, rgba(255, 255, 255, 0.42)),
        repeating-linear-gradient(90deg, rgba(37, 99, 235, 0.05) 0 1px, transparent 1px 42px);
}

.rk-timeline-shell > * {
    position: relative;
    z-index: 1;
}

.rk-timeline-hero {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    min-height: 156px;
    padding: 24px;
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 18px;
    background:
        radial-gradient(circle at 14% 24%, rgba(125, 211, 252, 0.38), transparent 28%),
        radial-gradient(circle at 86% 0%, rgba(255, 255, 255, 0.24), transparent 34%),
        linear-gradient(135deg, rgba(18, 34, 68, 0.98), rgba(37, 99, 235, 0.92) 58%, rgba(14, 116, 144, 0.9));
    box-shadow:
        0 24px 55px rgba(23, 37, 84, 0.24),
        inset 0 1px 0 rgba(255, 255, 255, 0.30);
}

.rk-timeline-hero:before {
    content: "";
    position: absolute;
    inset: 0 auto 0 -42%;
    width: 32%;
    transform: skewX(-18deg);
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.34), transparent);
    animation: rk-timeline-sheen 6.5s ease-in-out infinite;
    pointer-events: none;
}

.rk-hero-copy,
.rk-hero-badge {
    position: relative;
    z-index: 1;
}

.rk-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    color: rgba(255, 255, 255, 0.88);
    border: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.12);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.rk-hero-copy h1 {
    margin: 15px 0 6px;
    color: #ffffff;
    font-size: clamp(25px, 3vw, 36px);
    line-height: 1.12;
    font-weight: 850;
}

.rk-hero-copy p {
    margin: 0;
    color: rgba(255, 255, 255, 0.78);
    font-size: 14px;
}

.rk-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 12px 15px;
    border: 1px dashed rgba(255, 255, 255, 0.34);
    border-radius: 14px;
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.20), rgba(255, 255, 255, 0.08));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.32);
    font-weight: 800;
}

.rk-hero-badge i {
    font-size: 22px;
}

.rk-timeline-card {
    position: relative;
    overflow: hidden;
    margin-top: 16px;
    padding: 18px;
    border: 1px dashed var(--rk-line);
    border-radius: 18px;
    background:
        linear-gradient(145deg, rgba(255, 255, 255, 0.94), rgba(248, 251, 255, 0.76)),
        rgba(255, 255, 255, 0.88);
    box-shadow:
        0 18px 42px rgba(21, 32, 51, 0.10),
        inset 0 1px 0 rgba(255, 255, 255, 0.74);
    backdrop-filter: blur(14px);
}

.rk-timeline-card:before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(120deg, rgba(255, 255, 255, 0.68), transparent 34%),
        radial-gradient(circle at 100% 0%, rgba(56, 168, 255, 0.12), transparent 34%);
    pointer-events: none;
}

.rk-timeline-card > * {
    position: relative;
    z-index: 1;
}

.rk-card-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 15px;
}

.rk-card-toolbar h5 {
    margin: 0;
    color: var(--rk-ink);
    font-size: 17px;
    font-weight: 850;
}

.rk-card-toolbar span {
    color: var(--rk-muted);
    font-size: 13px;
}

.rk-live-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    flex: 0 0 auto;
    padding: 8px 12px;
    border: 1px solid rgba(56, 168, 255, 0.28);
    border-radius: 999px;
    background: #eef7ff;
    color: #0b5ed7 !important;
    font-weight: 800;
}

.rk-timeline-card .nav-tabs {
    border-bottom-color: rgba(56, 168, 255, 0.20);
}

.rk-timeline-card .nav-tabs .nav-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--rk-muted);
    border: 0;
    border-radius: 10px;
    font-weight: 800;
}

.rk-timeline-card .nav-tabs .nav-link.active {
    color: #ffffff;
    background: linear-gradient(135deg, var(--rk-blue), var(--rk-sky));
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.18), inset 0 1px 0 rgba(255, 255, 255, 0.28);
}

.chat-card {
    position: relative;
    overflow: hidden;
    border: 1px dashed rgba(56, 168, 255, 0.62);
    border-radius: 16px;
    background:
        linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(248, 251, 255, 0.82));
    box-shadow: 0 16px 34px rgba(21, 32, 51, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.78);
}

.chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 16px;
    background:
        linear-gradient(135deg, rgba(37, 99, 235, 0.10), rgba(56, 168, 255, 0.06)),
        rgba(255, 255, 255, 0.72);
    border-bottom: 1px solid rgba(56, 168, 255, 0.16);
}

.chat-header strong {
    display: block;
    color: var(--rk-ink);
    font-size: 15px;
    font-weight: 850;
}

.chat-header span {
    display: block;
    margin-top: 3px;
    color: var(--rk-muted);
    font-size: 12px;
    font-weight: 700;
}

.chat-header > i {
    color: var(--rk-blue);
    font-size: 24px;
}

.chat-body {
    padding: 18px;
    max-height: 430px;
    overflow-y: auto;
    background:
        radial-gradient(circle at 0% 0%, rgba(56, 168, 255, 0.08), transparent 28%),
        linear-gradient(180deg, rgba(255, 255, 255, 0.62), rgba(248, 251, 255, 0.42));
    scrollbar-width: thin;
    scrollbar-color: rgba(56, 168, 255, 0.60) rgba(226, 232, 240, 0.72);
}

.chat-message {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 16px;
}

.chat-message.sent {
    flex-direction: row-reverse;
}

.chat-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 38px;
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, var(--rk-blue), var(--rk-sky));
    color: #fff;
    border-radius: 50%;
    font-weight: 850;
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.20), inset 0 1px 0 rgba(255, 255, 255, 0.34);
}

.chat-message.sent .chat-avatar {
    background: linear-gradient(135deg, var(--rk-green), #14b8a6);
    box-shadow: 0 10px 20px rgba(22, 163, 74, 0.18), inset 0 1px 0 rgba(255, 255, 255, 0.34);
}

.chat-bubble {
    max-width: min(74%, 780px);
    padding: 12px 14px;
    border: 1px solid rgba(226, 232, 240, 0.92);
    border-radius: 14px;
    background:
        linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(241, 245, 249, 0.86));
    box-shadow: 0 12px 26px rgba(21, 32, 51, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.78);
}

.chat-message.sent .chat-bubble {
    border-color: rgba(22, 163, 74, 0.22);
    background:
        linear-gradient(145deg, rgba(240, 253, 244, 0.98), rgba(220, 252, 231, 0.84));
}

.chat-meta {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 7px;
    color: var(--rk-muted);
    font-size: 12px;
}

.chat-meta strong {
    color: var(--rk-ink);
    word-break: break-word;
}

.chat-meta span {
    flex: 0 0 auto;
}

.chat-text {
    color: #344054;
    font-size: 13px;
    line-height: 1.55;
    word-break: break-word;
}

.chat-text img,
.chat-text table {
    max-width: 100%;
    height: auto;
}

.chat-footer {
    padding: 14px 16px;
    border-top: 1px solid rgba(56, 168, 255, 0.16);
    background: rgba(255, 255, 255, 0.70);
}

.reply-form {
    display: grid;
    gap: 10px;
}

.reply-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    color: var(--rk-ink);
}

.reply-title strong {
    display: block;
    font-size: 13px;
    font-weight: 850;
}

.reply-title span {
    display: block;
    margin-top: 2px;
    color: var(--rk-muted);
    font-size: 12px;
}

.reply-title > i {
    color: var(--rk-blue);
    font-size: 22px;
}

.reply-actions {
    text-align: right;
}

.reply-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 36px;
    padding: 0 14px;
    color: #ffffff;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--rk-blue), var(--rk-sky));
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.18), inset 0 1px 0 rgba(255, 255, 255, 0.28);
    font-weight: 800;
    text-decoration: none;
}

.reply-link:hover {
    color: #ffffff;
    background: linear-gradient(135deg, #0b5ed7, #1f8fff);
}

.reply-form .ck.ck-editor {
    border-radius: 14px;
}

.reply-form .ck.ck-toolbar {
    border-color: rgba(56, 168, 255, 0.24);
    border-radius: 12px 12px 0 0 !important;
    background:
        linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(56, 168, 255, 0.05)),
        rgba(255, 255, 255, 0.88);
}

.reply-form .ck.ck-editor__main > .ck-editor__editable {
    min-height: 128px;
    border-color: rgba(56, 168, 255, 0.24);
    border-radius: 0 0 12px 12px !important;
    background:
        linear-gradient(145deg, rgba(255, 255, 255, 0.98), rgba(248, 251, 255, 0.82));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.74);
}

.reply-form .ck.ck-editor__editable.ck-focused {
    border-color: rgba(37, 99, 235, 0.55) !important;
    box-shadow: 0 0 0 .18rem rgba(37, 99, 235, .12) !important;
}

.reply-box {
    padding: 12px;
    border-top: 1px solid #e5e7eb;
    background: #fafafa
}

.rk-empty-state {
    display: grid;
    place-items: center;
    min-height: 260px;
    padding: 36px 18px;
    text-align: center;
    border: 1px dashed rgba(56, 168, 255, 0.56);
    border-radius: 16px;
    background:
        linear-gradient(145deg, rgba(255, 255, 255, 0.94), rgba(248, 251, 255, 0.74));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.74);
}

.rk-empty-state i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    margin-bottom: 12px;
    color: #ffffff;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--rk-blue), var(--rk-sky));
    box-shadow: 0 14px 28px rgba(37, 99, 235, 0.20), inset 0 1px 0 rgba(255, 255, 255, 0.28);
    font-size: 26px;
}

.rk-empty-state h5 {
    margin: 0 0 6px;
    color: var(--rk-ink);
    font-weight: 850;
}

.rk-empty-state p {
    margin: 0;
    color: var(--rk-muted);
}

@keyframes rk-timeline-sheen {
    0%,
    54% {
        left: -42%;
    }
    100% {
        left: 118%;
    }
}

@media (prefers-reduced-motion: reduce) {
    .rk-timeline-hero:before {
        animation: none;
    }
}

@media (max-width: 767.98px) {
    .rk-timeline-shell {
        padding: 12px;
    }

    .rk-timeline-hero,
    .rk-card-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .rk-timeline-hero {
        padding: 20px;
    }

    .chat-bubble {
        max-width: calc(100vw - 112px);
    }

    .chat-meta {
        flex-direction: column;
        gap: 3px;
    }
}
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
let timelineEditors = {};

document.querySelectorAll('.timeline-editor').forEach(el => {
    ClassicEditor.create(el)
        .then(editor => {
            timelineEditors[el.id] = editor;
        })
        .catch(err => console.error(err));
});

document.addEventListener('submit', function(e) {
    if (!e.target.classList.contains('reply-form')) return;

    e.preventDefault();

    const form = e.target;
    const threadId = form.dataset.thread;
    const editorId = form.dataset.editorId;
    const editor = timelineEditors[editorId];
    const message = editor ? editor.getData() : '';
    const button = form.querySelector('button[type="submit"]');

    if (!message.trim()) {
        alert('Message is empty');
        return;
    }

    if (button) {
        button.disabled = true;
        button.innerHTML = '<i class="ph-spinner-gap"></i> Sending...';
    }

    fetch("{{ route('admin.gmailReply') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                thread_id: threadId,
                message: message
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.status) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reply sent',
                        text: res.message || 'Email sent successfully.',
                        timer: 1600,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    alert(res.message || 'Email sent successfully.');
                    location.reload();
                }
            } else {
                alert(res.message || 'Failed to send reply');
                if (res.reconnect_url && confirm('Do you want to reconnect Gmail now?')) {
                    window.location.href = res.reconnect_url;
                    return;
                }
                if (button) {
                    button.disabled = false;
                    button.innerHTML = '<i class="ph-paper-plane-right"></i> Send Reply';
                }
            }
        })
        .catch(() => {
            alert('Failed to send reply. Please reconnect Gmail if your Google session has expired.');
            if (button) {
                button.disabled = false;
                button.innerHTML = '<i class="ph-paper-plane-right"></i> Send Reply';
            }
        });
});
</script>
@endsection
