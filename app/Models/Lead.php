<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Lead extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getAssignUserName(){
        return $this->hasOne(User::class,'id','assign_rep');
    }

    public function leadSource(){
        return $this->hasOne(LeadSource::class,'id','lead_source');
    }

    public function leadFollowUp(){
        return $this->hasMany(LeadFollowUp::class,'lead_id','id');
    }
}
