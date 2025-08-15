<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeContact extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'intake_id',
        'contact_id'
    ];
	
	public function contact_value()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
	
	public function intake_value()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }
}
