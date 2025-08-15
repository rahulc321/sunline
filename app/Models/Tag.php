<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * Relationships
     */
    public function emailCampaigns()
    {
        return $this->belongsToMany(EmailCampaign::class, 'email_campaign_tags', 'tag_id', 'email_campaign_id');
    }
}
