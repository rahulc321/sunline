<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Documents extends Model
{	
	
	use SoftDeletes;
	
	protected $table = 'documents';
	
	protected $fillable = [
        'intake_id',
		'document_category_id',
		'document_folder_id',
		'path_id',
		'document_title',
		'document_name',
		'document_path',
		'document_size',
		'document_type',
		'description',
		'created_by',
		'updated_by',
    ];
	
	public function folder()
    {
        return $this->belongsTo(DocumentPath::class, 'path_id');
    }
	
	public function document_category_value()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }
	
	public function intake_value()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }
	
	public function modified_by()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
	
	public function print_queue()
    {
        return $this->hasOne(DocumentPrintQueue::class, 'document_id');
    }	
	
}
