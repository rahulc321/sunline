<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

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

    public function scopeForCurrentUser(Builder $query): Builder
    {
        $user = Auth::user();

        if ($user->roles->contains('title', env('ROLE'))) {
            return $query->where(function ($q) use ($user) {
                $q->where('assign_to', $user->id)   // tickets assigned to me
                  ->orWhere('user_id', $user->id); // tickets created by me
            });
        }

        # if Admin or Director → no restriction
        return $query;
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id');
        # 'ticket_id' is the foreign key in the replies table
    }
}
