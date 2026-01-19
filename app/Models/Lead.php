<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(LeadImages::class);
    }

    public function getAssignUserName(){
        return $this->hasOne(User::class,'id','assign_rep');
    }

    public function leadSource(){
        return $this->hasOne(LeadSource::class,'id','lead_source');
    }

    public function leadFollowUp(){
        return $this->hasMany(LeadFollowUp::class,'lead_id','id');
    }

    public function scopeForCurrentUser(Builder $query): Builder
    {
        $user = Auth::user();

        if ($user->roles->contains('title', env('ROLE'))) {
            return $query->where('assign_rep', $user->id);
        }

        # if Admin or Director → no restriction
        return $query;
    }
}
