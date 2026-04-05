<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadMeta extends Model
{
    protected $table = 'lead_meta';

    protected $fillable = [
        'lead_id',
        'meta_key',
        'meta_value',
        'meta_type'
    ];

    # relation with lead
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
