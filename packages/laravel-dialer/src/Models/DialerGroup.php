<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;

class DialerGroup extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active'          => 'boolean',
        'voicemail_enabled'  => 'boolean',
        'missed_call_notify' => 'boolean',
    ];

    public function members()
    {
        return $this->hasMany(DialerGroupMember::class, 'group_id');
    }

    public function activeMembers()
    {
        return $this->members()->where('is_active', true)->with('user');
    }

    public function phoneNumber()
    {
        return $this->hasOne(DialerPhoneNumber::class, 'group_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(config('dialer.user_model'), 'supervisor_id');
    }

    public function availableAgents()
    {
        return $this->activeMembers()
            ->whereHas('user.dialerAgentStatus', fn($q) => $q->where('status', 'available'));
    }
}
