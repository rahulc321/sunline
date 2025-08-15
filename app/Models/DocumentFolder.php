<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFolder extends Model
{	
	protected $table = 'document_folder';
	
	use SoftDeletes;
	
	protected $fillable = [
        'folder_name',
        'is_default',
        'order'
    ];
}
