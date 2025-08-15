<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostType extends Model
{	
	use SoftDeletes;
	
	protected $fillable = [
        'title',
        'show_in_filter',
        'show_on_form',
    ];
}
