<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaignMarketingSource extends Model
{
	protected $table = 'email_campaign_marketing_sources';
    public $timestamps = false;

    protected $fillable = [
        'email_campaign_id',
        'marketing_source_id'
    ];
}
