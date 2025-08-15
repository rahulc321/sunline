<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTypeRule extends Model
{	
	use SoftDeletes;
	
	protected $fillable = [
        'event_type_id',
        'lead_status_id',
        'appointment_reminders'
    ];
	
	public function event_type()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }
	
	public function lead_status()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }
}
