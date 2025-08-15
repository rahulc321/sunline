<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadKeyDate extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'intake_id',
        'key_date_id',
		'key_date'
    ];
	
	public function key_date_value()
    {
        return $this->belongsTo(LeadKeyDateType::class, 'key_date_id');
    }
}
