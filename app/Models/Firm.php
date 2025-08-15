<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firm extends Model
{	
	use SoftDeletes;
	
	protected $fillable = [
        'name',
        'firm_type_id',
        'firm_percentage'
    ];
}
