<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadCommunicationEmail extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
        'intake_id',
        'user_id',
        'email_status_id',
        'campaign_type_id',
        'from_email',
        'to_email',
        'cc_email',
        'bcc_email',
        'subject',
        'message',
        'sent_at',
        'error_message',
    ];
	
	public function email_status()
    {
        return $this->belongsTo(EmailStatus::class, 'email_status_id');
    }
	
	public function campaign_type()
    {
        return $this->belongsTo(CampaignType::class, 'campaign_type_id');
    }
}
