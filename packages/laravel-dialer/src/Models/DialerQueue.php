<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;

class DialerQueue extends Model
{
    protected $table = 'dialer_queue';
    protected $guarded = [];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'called_at'    => 'datetime',
    ];

    public function caseIntake()
    {
        return $this->belongsTo(config('dialer.contact_model'), 'case_id');
    }

    public function agent()
    {
        return $this->belongsTo(config('dialer.user_model'), 'assigned_agent_id');
    }

    public function calls()
    {
        return $this->hasMany(DialerCall::class, 'queue_id');
    }
}
