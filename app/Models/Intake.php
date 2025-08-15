<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Intake extends Model
{
	use SoftDeletes;
	
    protected $fillable = [];
	
	protected $guarded = ['id'];
	
	/*
	*
	* Function which filter request inputs according to table columns.
	*
	*/
	public static function getFilteredFormData($data)
	{
		$columns = Schema::getColumnListing((new Intake)->getTable()); // List all column name array from table
		$filterInputData = array_intersect_key($data, array_flip($columns));  // filter form inputs according to table columns 
		
		return $filterInputData;
	}
	
	public function case_roles()
	{
		return $this->belongsToMany(CaseRole::class, LeadCaseRole::class, 'intake_id', 'case_role_id'); 
	}
	
	public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
	
	public function status_value()
    {
        return $this->belongsTo(LeadStatus::class, 'status');
    }
	
	public function case_role_value()
    {
        return $this->belongsTo(CaseRole::class, 'case_role');
    }
	
	public function case_type_value()
    {
        return $this->belongsTo(CaseType::class, 'case_type');
    }
	
	public function marketing_source_value()
    {
        return $this->belongsTo(IntakeValues::class, 'marketing_source');
    }
	
	public function assignee_value()
    {
        return $this->belongsTo(\App\User::class, 'assignee');
    }
	
	public function owner_value()
    {
        return $this->belongsTo(\App\User::class, 'owner');
    }
	
	public function ad_campaign_value()
    {
        return $this->belongsTo(IntakeValues::class, 'ad_campaign');
    }
	
	public function call_outcomes_value()
    {
        return $this->belongsTo(LeadCallOutcome::class, 'call_outcomes');
    }
	
	public function question_answer()
	{
		return $this->hasMany(FormQuestionAnswer::class, 'intake_id');; 
	}
}
