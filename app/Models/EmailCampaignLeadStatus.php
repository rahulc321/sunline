<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaignLeadStatus extends Model
{
    protected $table = 'email_campaign_lead_status';
    public $timestamps = false;

    protected $fillable = [
        'email_campaign_id',
        'lead_status_id'
    ];
}
