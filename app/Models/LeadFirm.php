<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadFirm extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
        'intake_id',
        'firm_type_id',
        'firm_name',
        'firm_percentage',
        'firm_override_type_id',
        'firm_override_fee_share',
        'firm_agreement_in_place',
        'firm_referral_status_id',
        'firm_status'
    ];
	
	public function firm()
    {
        return $this->belongsTo(Firm::class, 'firm_name');
    }
	
	public function firm_type()
    {
        return $this->belongsTo(FirmType::class, 'firm_type_id');
    }
	
	public function override_type()
    {
        return $this->belongsTo(FirmOverrideType::class, 'firm_override_type_id');
    }
	
	public function referral_status()
    {
        return $this->belongsTo(FirmReferralStatus::class, 'firm_referral_status_id');
    }
}
