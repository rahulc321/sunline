@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">

            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#sync-contacts">
                        Sync contacts
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="sync-contacts">

                    @php
                    $syncedEmail = auth()->user()->connected_email;
                    $leadEmail = $lData->email;
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
                            <strong>{{ $firstMail->subject ?? '(No Subject)' }}</strong>
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
                            <!-- <button class="btn btn-sm btn-primary reply-btn" data-thread="{{ $threadId }}">
                                Reply
                            </button> -->

                            <a href="{{route('admin.gmailReplyPage',[$threadId])}}">Reply</a>
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
                    <p class="text-muted text-center">No conversations found</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-card {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden
}

.chat-header {
    padding: 12px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb
}

.chat-body {
    padding: 15px;
    max-height: 350px;
    overflow-y: auto
}

.chat-message {
    display: flex;
    margin-bottom: 15px
}

.chat-message.sent {
    flex-direction: row-reverse
}

.chat-avatar {
    width: 36px;
    height: 36px;
    background: #1f6feb;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin: 0 10px
}

.chat-message.sent .chat-avatar {
    background: #00a06a
}

.chat-bubble {
    background: #f1f5f9;
    border-radius: 10px;
    padding: 10px;
    max-width: 70%
}

.chat-message.sent .chat-bubble {
    background: #dcfce7
}

.chat-meta {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 4px;
    display: flex;
    justify-content: space-between
}

.chat-footer {
    padding: 10px;
    border-top: 1px solid #e5e7eb;
    text-align: right
}

.reply-box {
    padding: 12px;
    border-top: 1px solid #e5e7eb;
    background: #fafafa
}
</style>

<script>
document.addEventListener('click', function(e) {

    if (e.target.classList.contains('reply-btn')) {
        const id = e.target.dataset.thread;
        document.getElementById('reply-box-' + id).classList.toggle('d-none');
    }

    if (e.target.classList.contains('send-reply')) {
        const id = e.target.dataset.thread;
        const text = document.getElementById('reply-text-' + id).value;

        if (!text.trim()) {
            alert('Message is empty');
            return;
        }

        fetch("{{ route('admin.gmailReply') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    thread_id: id,
                    message: text
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    location.reload();
                } else {
                    alert(res.message);
                }
            });
    }
});
</script>
@endsection