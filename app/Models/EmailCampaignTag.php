<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaignTag extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email_campaign_id',
        'tag_id'
    ];
}
