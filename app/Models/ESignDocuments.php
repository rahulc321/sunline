<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class ESignDocuments extends Model
{	
	
	use SoftDeletes;
	
	protected $table = 'e_sign_documents';
	
	protected $fillable = [
        'case_type_id',
		'document_name',
		'document_path',
		'document_size',
		'document_type',
		'description',
		'created_by',
		'updated_by',
    ];
	
	public function case_type()
    {
        return $this->belongsTo(CaseType::class, 'case_type_id');
    }
	
	public function created_by_name()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
	
	public function updated_by_name()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
