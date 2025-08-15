<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{	
	protected $table = 'expense_category';
	
	use SoftDeletes;
	
	protected $fillable = [
        'title'
    ];
}
