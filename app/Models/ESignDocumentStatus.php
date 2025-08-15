<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class ESignDocumentStatus extends Model
{	
	
	use SoftDeletes;
	
	protected $table = 'e_sign_document_status';
	
	protected $fillable = [
        'intake_id',
        'signer_id',
		'order_no',
		'envelope_id',
		'template_name',
		'signed_status',
		'envelope_status',
		'created_by',
		'updated_by',
    ];
	
	public function intake_value()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }
	
	public function signers()
    {
        return $this->belongsTo(User::class, 'signer_id');
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
