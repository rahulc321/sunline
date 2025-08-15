<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarShareUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'shared_user_id',
        'permission_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
