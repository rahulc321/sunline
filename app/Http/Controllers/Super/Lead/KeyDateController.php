<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LeadKeyDate;
use App\Models\LeadKeyDateType;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Gate;
use DB;

class KeyDateController extends Controller
{		
	/*
	*
	* Function to Fetch All Lead Key Date Type List All or Only those which not assigned in lead.
	*
	*/	
    public function leadKeyDateTypeList(Request $request)
    {
		abort_if(Gate::denies('intake_key_dates_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		if($request->ajax()) {
			if(isset($lead_id) && $lead_id>0) {
				$keydate_ids = LeadKeyDate::where('intake_id',$lead_id)->pluck('key_date_id');
				if(isset($keydate_ids) && !empty($keydate_ids)) {
					$keydate_type_list = LeadKeyDateType::whereNotIn('id',$keydate_ids)->get();
				}
				else {
					$keydate_type_list = LeadKeyDateType::get();
				}
			}
			else {
				$keydate_type_list = LeadKeyDateType::get();
			}			
			if($keydate_type_list) {
				$data = $keydate_type_list->toArray();
				return response()->json([
					'status' => 'success',
					'message' => 'Key Date Type List',
					'data' => $data
				]);
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Key Date Type List Not Found'
				]);
			}
		}
    }
	
	/*
	*
	* Function to Fetch All Lead Key Date Type List All or Only those which not assigned in lead.
	*
	*/	
    public function leadKeyDateTypeAdd(Request $request)
    {
		abort_if(Gate::denies('intake_key_dates_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		$key_date_id = $request->key_date_id;
		if($request->ajax()) {
			if($lead_id>0 && $key_date_id>0) {
				$lkd = LeadKeyDate::where('intake_id', $lead_id)->where('key_date_id',$key_date_id)->first();
				if($lkd) { 
					return response()->json([
						'status' => 'success',
						'message' => 'Key date already assigned'
					]);
				} else {
					LeadKeyDate::create(['intake_id'=>$lead_id,'key_date_id'=>$key_date_id]);
					return response()->json([
						'status' => 'success',
						'message' => 'Key date added successfully'
					]);
				}
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Required field is empty'
				]);
			}
		}
    }
	
	/*
	*
	* Function to Fetch Lead Key Date List.
	*
	*/	
    public function leadKeyDateList(Request $request)
    {
		abort_if(Gate::denies('intake_key_dates_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		if($request->ajax()) {
			$data = LeadKeyDate::where('intake_id',$lead_id);
			return DataTables::of($data)
				->addColumn('key_date_name', function ($row) {
					return $key_date_name = $row->key_date_value ? $row->key_date_value->title : '';
				})
				->editColumn('key_date', function ($row) {
					$key_date = $row->key_date ? $row->key_date : '';
					return '<input type="date" name="key_date['.$row->key_date_id.']" value="'.$key_date.'" >';
				})
				->rawColumns(['key_date'])
				->make(true);
		}
    }
}