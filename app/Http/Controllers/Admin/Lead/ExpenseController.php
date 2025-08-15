<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

use App\Models\LeadExpense;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class ExpenseController extends Controller
{		
	/*
	*
	* Function to save Expense in a table.
	*
	*/
	public function store(Request $request)
	{
		abort_if(Gate::denies('intake_finance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
		}
		
		$validator = \Validator::make($request->all(), [
			'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 'validation_error',
				'message' => 'Validation Failed',
				'errors' => $validator->errors(),
			]);
		}
		
		$document = '';
		if ($request->hasFile('pop_expense_document')) {
			$folderPath = 'uploads/expense';
			$dirPath = public_path($folderPath);
			if(!File::exists($folderPath))
			{
				File::makeDirectory($folderPath, 0755, true);
			}	
			$file = $request->file('pop_expense_document');	
			$originalName = $file->getClientOriginalName();
			$filenameParts = explode('_', pathinfo($originalName, PATHINFO_FILENAME));
			$file_name = implode('-', $filenameParts);
			$extension = $file->getClientOriginalExtension();
			if(empty($extension))
			{
				$extension = $file->extension();
			}
			$document_name = $file_name . time(). '.' . $extension;  
			$file->move($dirPath, $document_name);					
			$document = $folderPath. '/' . $document_name;
			
		}
			
		$data = $request->only([
			'lead_id',
			'cost_type_id',
			'date_issued',
			'invoice_no',
			'amount_billed',
			'qty',
			'total',
			'expense_category_id',
			'billable_to_client',
			'description',
			'document_category_id',
			'document_description',
		]);

		// Map request field 'lead_id' to 'intake_id' in the DB
		$data['intake_id'] = $data['lead_id'];
		$data['document'] = $document;
		unset($data['lead_id']);

		$leadExpense = LeadExpense::create($data);

		// Log the activity
		Activity::log(
			'lead_expense',
			'create',
			"Lead Expense has been created with id - {$leadExpense->id}",
			[
				'details' => $leadExpense,
				'intake_id' => $data['intake_id'] ?? null
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Expense added successfully'
		]);
		
	}
	
	/*
	*
	* Function to update Expense in a table.
	*
	*/
	public function update(Request $request)
	{
		abort_if(Gate::denies('intake_finance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
	}
	
	/*
	*
	* Function to Fetch Expense List.
	*
	*/	
    public function leadExpenseList(Request $request)
    {
		abort_if(Gate::denies('intake_finance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		if($request->ajax()) {
			$data = LeadExpense::where('intake_id',$lead_id);
			return DataTables::of($data)
				->addColumn('cost_type', function ($row) {
					return @$row->cost_type->title ?? '';
				})
				->addColumn('expense_category', function ($row) {
					return @$row->expense_category->title ?? '';
				})
				->addColumn('amount_lien_hold', function ($row) {
					return '';
				})
				->addColumn('vendor_name', function ($row) {
					return '';
				})
				->addColumn('vendor_balance', function ($row) {
					return '';
				})
				->editColumn('billable_to_client', function ($row) {
					return $row->billable_to_client == "1" ? "Billed" : "Unbilled";
				})
				->editColumn('date_issued', function ($row) {
					return @$row->date_issued ?? '';
				})
				->rawColumns(['date_issued'])
				->make(true);
		}
    }
}