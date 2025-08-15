<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntakeValues extends Model
{
	public $timestamps = false;
	protected $table = 'intake_values';
    protected $fillable = [
        'type',
        'value'
    ];
}
