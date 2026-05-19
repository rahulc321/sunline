<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;

class DialerCall extends Model
{
    protected $table = 'dialer_calls';
    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function queue()
    {
        return $this->belongsTo(DialerQueue::class, 'queue_id');
    }

    public function caseIntake()
    {
        return $this->belongsTo(config('dialer.contact_model'), 'case_id');
    }

    public function agent()
    {
        return $this->belongsTo(config('dialer.user_model'), 'agent_id');
    }
}
