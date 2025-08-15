<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaignCaseType extends Model
{
	protected $table = 'email_campaign_case_types';
    public $timestamps = false;

    protected $fillable = [
        'email_campaign_id',
        'case_type_id'
    ];
}
