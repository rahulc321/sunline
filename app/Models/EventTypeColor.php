<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTypeColor extends Model
{	
	use SoftDeletes;
	
	protected $fillable = [
        'title',
        'color_code'
    ];
}
