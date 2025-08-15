<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TextsStatus extends Model
{
	use SoftDeletes;
	
	protected $table = 'texts_status';
	
	protected $fillable = [
        'title'
    ];
}
