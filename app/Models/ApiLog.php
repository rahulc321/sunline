<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'method','url','request_body','response_body','status_code','webhook_id'
    ];

    protected $casts = [
        'request_body' => 'array',
        'response_body' => 'array',
    ];
}
