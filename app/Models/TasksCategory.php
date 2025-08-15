<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksCategory extends Model
{
	protected $table = 'tasks_category';
	
	use SoftDeletes;
	
	protected $fillable = [
        'title'
    ];
}
