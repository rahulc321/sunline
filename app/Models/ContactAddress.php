<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactAddress extends Model
{
	protected $table = 'contact_address';
	public $timestamps = false;
    protected $fillable = [
        'contact_id',
        'address_id'
    ];
}
