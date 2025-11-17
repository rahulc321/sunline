<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'solar_commission',
        'battery_commission',
        'user_id'
        
    ];
}
