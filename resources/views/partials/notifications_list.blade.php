@forelse($notifications as $notification)
    <a href="{{ route('admin.notifications.read', $notification->id) }}"
       class="dropdown-item align-items-start text-wrap py-2 {{ $notification->read_at ? '' : 'bg-light' }}">
        <div class="status-indicator-container me-3">
            <img src="https://themes.kopyov.com/limitless/demo/template/assets/images/demo/users/face1.jpg"
                 class="w-40px h-40px rounded-pill" alt="">
            <span class="status-indicator {{ $notification->read_at ? 'bg-grey' : 'bg-warning' }}"></span>
        </div>
        <div class="flex-1">
            <span class="fw-semibold">{{ $notification->data['title'] ?? 'Notification' }}</span>
            <span class="text-muted float-end fs-sm">{{ $notification->created_at->diffForHumans() }}</span>
            <div class="text-muted">{{ $notification->data['message'] ?? '' }}</div>
        </div>
    </a>
@empty
    <span class="dropdown-item text-muted">No new notifications</span>
@endforelse
