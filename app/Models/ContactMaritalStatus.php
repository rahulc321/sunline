<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMaritalStatus extends Model
{
	use SoftDeletes;
	
	protected $table = 'contact_marital_status';
	
	protected $fillable = [
        'title',
		'order'
    ];
}
