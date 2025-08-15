<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
        'nature',
        'type',
        'prefix',
        'first_name',
        'middle_name',
        'last_name',
        'display_name',
        'suffix',
        'gender',
		'email',
		'contact_preference',
        'phone',
        'whentocontact',
        'language',
        'alias',
        'marital_status',
        'company_name',
        'job_title',
        'ssn',
        'work_phone',
        'home_phone',
        'fax',
        'secondary_email',
        'drivers_license',
        'dob',
        'dodeath',
        'dobankruptcy',
        'notes',
        
    ];
	
	public function contact_type()
    {
        return $this->belongsTo(ContactType::class, 'type');
    }
	
	public function language_value()
    {
        return $this->belongsTo(Language::class, 'language');
    }
	
	public function addresses()
    {
        return $this->belongsToMany(Address::class, ContactAddress::class, 'contact_id', 'address_id');
    }
	
	public function contactAddresses()
	{
		return $this->hasMany(ContactAddress::class);
	}
}
