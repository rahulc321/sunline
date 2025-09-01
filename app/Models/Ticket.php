<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getAssignUserName(){
        return $this->hasOne(User::class,'id','assign_to');
    }

    public function submited(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
