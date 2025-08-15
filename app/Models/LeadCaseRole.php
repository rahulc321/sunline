<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCaseRole extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'intake_id',
        'case_role_id'
    ];
	
	public function intake_value()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }
	
	public function case_role_value()
    {
        return $this->belongsTo(CaseRole::class, 'case_role_id');
    }	
	
}
