<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Auth;

class NewNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected ?string $url;

    public function __construct(string $title, string $message, ?string $url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];  // save in DB + send over websocket
    }

    public function toArray($notifiable): array
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url ?? '#',
            'created_by'    => Auth::Id(),
            'created_by_name'    => Auth::user()?->name ?? 'System',
        ];
    }

    public function toBroadcast($notifiable): array
    {
        return [
            'data' => $this->toArray($notifiable)
        ];
    }

    // define private channel per user
    public function broadcastOn(): array
    {
        return [new PrivateChannel('users.' . $notifiable->id)];
    }
}
