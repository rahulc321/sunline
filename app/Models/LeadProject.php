<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadProject extends Model
{
    use HasFactory;

    protected $table = 'lead_project';

    protected $fillable = [
        'lead_id',
        'data',
        'status',
        'created_at',
        'updated_at',
    ];
}
