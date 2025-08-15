<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class DocumentPrintQueue extends Model
{		
	use SoftDeletes;
	
	protected $fillable = [
        'document_id',
        'is_printed',
        'mail_merge_status',
		'created_by',
		'updated_by',
    ];
	
	public function document()
    {
        return $this->belongsTo(Documents::class, 'document_id');
    }
}
