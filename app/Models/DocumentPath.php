<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentPath extends Model
{	
	protected $table = 'document_path';
	
	use SoftDeletes;

    protected $fillable = ['name', 'parent_id', 'intake_id'];

    public function parent()
    {
        return $this->belongsTo(DocumentPath::class, 'parent_id');
    }
	
	public function documents()
	{
		return $this->hasMany(Documents::class, 'path_id');
	}

    public function children()
    {
        return $this->hasMany(DocumentPath::class, 'parent_id');
    }
}
