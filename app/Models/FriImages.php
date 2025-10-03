<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriImages extends Model
{
    use HasFactory;

    protected $fillable = ['fri_id', 'image_path'];
}
