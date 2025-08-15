<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactPrefixes extends Model
{
	use SoftDeletes;
	
	protected $table = 'contact_prefixes';
	
	protected $fillable = [
        'title',
		'order'
    ];
}
