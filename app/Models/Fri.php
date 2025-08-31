<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

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
}
