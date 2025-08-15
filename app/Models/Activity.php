<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\User;

class Activity extends Model
{
	use SoftDeletes;
	
	protected $table = 'activity';
    protected $fillable = [
        'intake_id',
        'activity_type_id',
        'client_id',
        'user_id',
		'module',
        'action',
        'description',
        'details',
        'ip_address',
        'user_agent',
    ];
	
	protected $casts = [
        'details' => 'array',
    ];
	
	public function intake_value()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }
	
	public function activity_type_value()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }
	
	public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
	
	public function contact_value()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }
	
	public static function getByModule($module = null)
    {
        $query = Activity::with('user')->latest();
        
        if ($module) {
            $query->where('module', $module);
        }
        
        return $query;
    }
	
	public static function log($module, $action, $description = null, $other_info = [])
    {
		$data = [
            'user_id' => Auth::id(),
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ];
		
		if(isset($other_info['details']) && !empty($other_info['details'])) {
			$data['details'] = $other_info['details'];
		}
		if(isset($other_info['intake_id']) && $other_info['intake_id']>0) {
			$data['intake_id'] = $other_info['intake_id'];
		}
		if(isset($other_info['client_id']) && $other_info['client_id']>0) {
			$data['client_id'] = $other_info['client_id'];
		}
		if(isset($other_info['activity_type_id']) && $other_info['activity_type_id']>0) {
			$data['activity_type_id'] = $other_info['activity_type_id'];
		}
		
        return Activity::create($data);
    }
}
