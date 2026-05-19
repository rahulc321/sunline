<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'note',
        'created_by'
    ];

    # note belongs to lead
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
