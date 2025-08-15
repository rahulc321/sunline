<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentSettings extends Model
{
	use SoftDeletes;
	
	protected $table = 'appointment_settings';
	
	protected $fillable = [
        'appointlet_switch',
		'remind_lead_assignee',
		'remind_lead_owner',
		'remind_lead',
		'remind_loggedin_user',
		'remind_instant_ics',
		
		'cancellation_change_status',
		'cancellation_email_subject',
		'cancellation_email_body',
		'cancellation_notification',
    ];
}
