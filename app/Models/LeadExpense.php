<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadExpense extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
        'intake_id',
        'cost_type_id',
        'date_issued',
        'invoice_no',
        'amount_billed',
        'qty',
        'total',
        'expense_category_id',
        'billable_to_client',
        'description',
        'document',
        'document_category_id',
        'document_description'
    ];
	
	public function cost_type()
    {
        return $this->belongsTo(CostType::class, 'cost_type_id');
    }
	
	public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
	
	public function document_category()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }
}
