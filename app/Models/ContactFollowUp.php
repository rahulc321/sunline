<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactFollowUp extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',   // 👈 this makes $this->date a Carbon object
    ];

    public function lead()
    {
        return $this->belongsTo(LeadContact::class);
    }

    public function getIsOverdueAttribute()
    {
        return !$this->is_completed && $this->date->isPast();
    }
}
