<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Auth;

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

    public function scopeForCurrentUser(Builder $query): Builder
    {
        $user = Auth::user();

        if ($user->roles->contains('title', env('ROLE'))) {
            return $query->where('assigned_to', $user->id);
        }

        # if Admin or Director → no restriction
        return $query;
    }
}
