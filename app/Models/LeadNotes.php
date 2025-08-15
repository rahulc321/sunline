<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadNotes extends Model
{
	use SoftDeletes;
	
	protected $table = 'lead_notes';
	
	protected $fillable = [
        'intake_id',
        'user_id',
        'category_id',
        'is_pinned',
        'notes',
        'attachment'
    ];
	
	protected $casts = [
		'is_pinned' => 'boolean',
	];
	
	public function intake_value()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }
	
	public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
	
	public function category_value()
    {
        return $this->belongsTo(NotesCategory::class, 'category_id');
    }
}
