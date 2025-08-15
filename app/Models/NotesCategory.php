<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotesCategory extends Model
{
	protected $table = 'notes_category';
	
	use SoftDeletes;
	
	protected $fillable = [
        'title'
    ];
}
