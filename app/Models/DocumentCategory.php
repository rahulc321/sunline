<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentCategory extends Model
{	
	protected $table = 'document_category';
	
	use SoftDeletes;
	
	protected $fillable = [
        'title'
    ];
}
