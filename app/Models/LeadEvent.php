<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class LeadEvent extends Model
{	
	use SoftDeletes;
	
	protected $fillable = [
        'intake_id',
        'event_type_id',
        'event_title',
        'location',
        'address',
        'description',
        'event_date',
        'event_start_datetime',
        'event_end_datetime',
        'owner_id',
        'event_status_id',
        'all_day'
    ];
	
	public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
	
	public function event_status()
    {
        return $this->belongsTo(EventStatusType::class, 'event_status_id');
    }
	
	public function event_type()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }
}
