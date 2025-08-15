<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadCommunicationTexts extends Model
{
	use SoftDeletes;
	
	protected $table = 'lead_communication_texts';
	
	protected $fillable = [
        'intake_id',
        'user_id',
        'texts_status_id',
        'campaign_type_id',
        'from_phone',
        'to_phone',
        'message',
    ];
	
	public function texts_status()
    {
        return $this->belongsTo(TextsStatus::class, 'texts_status_id');
    }
	
	public function campaign_type()
    {
        return $this->belongsTo(CampaignType::class, 'campaign_type_id');
    }
	
	public function contact()
	{
		return $this->hasOneThrough(Contact::class, Intake::class, 'id', 'id', 'intake_id', 'contact_id');
	}
}
