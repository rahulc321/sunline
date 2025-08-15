<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{	
	use SoftDeletes;
	
	protected $fillable = [
        'title',
        'event_type_color_id'
    ];
	
	public function event_type_color()
    {
        return $this->belongsTo(EventTypeColor::class, 'event_type_color_id');
    }
}
