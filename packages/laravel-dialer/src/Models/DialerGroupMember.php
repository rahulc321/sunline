<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;

class DialerGroupMember extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(DialerGroup::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(config('dialer.user_model'), 'user_id');
    }
}
