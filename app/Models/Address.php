<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
	protected $table = 'address';
	
	protected $fillable = [
        'address_type',
        'address_1',
        'address_2',
        'city',
        'country',
        'zip',
        'state_id',
        'country_id',
        'is_primary'
    ];
	
	public function address_type_value()
    {
        return $this->belongsTo(AddressType::class, 'address_type');
    }
	
	public function contacts()
	{
		return $this->belongsToMany(Contact::class, 'contact_address');
	}
}
