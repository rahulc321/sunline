<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;

class DialerAgentStatus extends Model
{
    protected $table = 'dialer_agent_status';
    protected $guarded = [];

    protected $casts = [
        'status_changed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(config('dialer.user_model'));
    }

    public static function forUser(int $userId): self
    {
        return static::firstOrCreate(
            ['user_id' => $userId],
            ['status' => 'offline', 'status_changed_at' => now()]
        );
    }

    public function setStatus(string $status): void
    {
        $this->update(['status' => $status, 'status_changed_at' => now()]);
    }
}
