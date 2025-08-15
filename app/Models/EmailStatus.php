<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailStatus extends Model
{
	use SoftDeletes;
	
	protected $table = 'email_status';
	
	protected $fillable = [
        'title'
    ];
}
