<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailCampaign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'campaign_name',
        'campaign_type_id',
        'from_date',
        'to_date',
        'is_all_date',
        'email_come_from',
    ];

    /**
     * Relationships
     */
    public function campaign_type()
    {
        return $this->belongsTo(CampaignType::class, 'campaign_type_id');
    }

    public function case_types()
    {
        return $this->belongsToMany(
            CaseType::class,
            'email_campaign_case_types',
            'email_campaign_id',
            'case_type_id'
        );
    }

    public function lead_status()
    {
        return $this->belongsToMany(
            LeadStatus::class,
            'email_campaign_lead_status',
            'email_campaign_id',
            'lead_status_id'
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'email_campaign_tags',
            'email_campaign_id',
            'tag_id'
        );
    }

    public function marketing_source()
    {
        return $this->belongsToMany(
            IntakeValues::class,
            'email_campaign_marketing_source',
            'email_campaign_id',
            'marketing_source_id'
        );
    }
}
