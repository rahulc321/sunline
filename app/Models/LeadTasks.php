<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadTasks extends Model
{
	use SoftDeletes;
	
	protected $table = 'lead_tasks';
	
	protected $fillable = [
        'intake_id',
        'type_id',
        'category_id',
        'subject',
        'assigned_to',
        'assigned_by',
        'assigned_date',
        'due_date',
        'priority',
        'activity',
        'billable_to_client',
        'notify_assignee',
        'add_calander_event',
        'calander_event',
        'appointment_reminder',
        'status',
        'description'
    ];
	
	public function assigned_by_value()
    {
        return $this->belongsTo(\App\User::class, 'assigned_by');
    }
	
	public function assigned_to_value()
    {
        return $this->belongsTo(\App\User::class, 'assigned_to');
    }
	
	public function category_value()
    {
        return $this->belongsTo(TasksCategory::class, 'category_id');
    }
	
	public function task_value()
    {
        return $this->belongsTo(TaskType::class, 'type_id');
    }
}
