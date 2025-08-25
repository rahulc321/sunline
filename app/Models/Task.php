<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getAssignUserName(){
        return $this->hasOne(User::class,'id','assigned_to');
    }

    public function leadName(){
        return $this->hasOne(Lead::class,'id','lead');
    }
}
