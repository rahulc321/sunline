<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FirmReferralStatus extends Model
{	
	protected $table = 'firm_referral_status';
	
	use SoftDeletes;
	
	protected $fillable = [
        'title'
    ];
}
