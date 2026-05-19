<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class Fri extends Model
{
    use HasFactory;

    protected $guarded= [];

    public function images()
    {
        return $this->hasMany(FriImage::class);
    }

    public function createdByName()
    {
        return $this->hasOne(User::class,'id','created_by');
    }

    public function leadName()
    {
        return $this->hasOne(Lead::class,'id','lead_id');
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

    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id');
        # 'ticket_id' is the foreign key in the replies table
    }

    public function lead_name()
    {
    return $this->belongsTo(Lead::class,'lead_id');
    }

    public function created_by_name()
    {
    return $this->belongsTo(User::class,'created_by');
    }

    public function assigned_user()
    {
    return $this->belongsTo(User::class,'assigned_to');
    }

     

     

     
}
