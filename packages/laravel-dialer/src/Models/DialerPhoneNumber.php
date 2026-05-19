<?php

namespace PowerDialer\Dialer\Models;

use Illuminate\Database\Eloquent\Model;

class DialerPhoneNumber extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active'    => 'boolean',
        'purchased_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(DialerGroup::class, 'group_id');
    }

    public function getFormattedAttribute(): string
    {
        $n = preg_replace('/\D/', '', $this->phone_number);
        if (strlen($n) === 11 && $n[0] === '1') $n = substr($n, 1);
        return strlen($n) === 10
            ? '(' . substr($n, 0, 3) . ') ' . substr($n, 3, 3) . '-' . substr($n, 6)
            : $this->phone_number;
    }
}
