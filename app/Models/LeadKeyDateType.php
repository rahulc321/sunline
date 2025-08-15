<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadKeyDateType extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
        'slug',
        'title'
    ];
}
