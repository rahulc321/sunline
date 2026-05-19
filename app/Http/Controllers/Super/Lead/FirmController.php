<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Firm;
use App\Models\LeadFirm;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class FirmController extends Controller
{		
	/*
	*
	* Function to save Firm in a table.
	*
	*/
	public function store(Request $request)
	{
		abort_if(Gate::denies('intake_finance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
		}

		$data = $request->only([
			'lead_id',
			'firm_type_id',
			'firm_name',
			'firm_percentage',
			'firm_override_type_id',
			'firm_override_fee_share',
			'firm_agreement_in_place',
			'firm_referral_status_id',
		]);

		$data['intake_id'] = $data['lead_id'];
		unset($data['lead_id']);

		$data['firm_status'] = '1'; // Consider replacing with a constant or config value

		$leadFirm = LeadFirm::create($data);

		// Log the activity
		Activity::log(
			'lead_firm',
			'create',
			"Lead Firm has been created with id - {$leadFirm->id}",
			[
				'details' => $leadFirm,
				'intake_id' => $data['intake_id'] ?? null
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Firm added successfully'
		]);
	}
	
	/*
	*
	* Function to update Firm in a table.
	*
	*/
	public function update(Request $request, $id)
	{
		abort_if(Gate::denies('intake_finance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
	}
	
	/*
	*
	* Function to update Firm in a table.
	*
	*/
	public function updateFirmDetails(Request $request)
	{
		abort_if(Gate::denies('intake_finance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid request type'
			], 400);
		}

		$leadfirm = LeadFirm::find($request->firm_id);

		if (!$leadfirm) {
			return response()->json([
				'status' => 'error',
				'message' => 'Firm not found',
			]);
		}

		$oldData = $leadfirm->toArray();

		$updateData = $request->only([
			'firm_type_id',
			'firm_name',
			'firm_percentage',
			'firm_override_type_id',
			'firm_override_fee_share',
			'firm_agreement_in_place',
			'firm_referral_status_id',
		]);

		// Ensure required fields are set manually or via defaults
		$updateData['intake_id'] = $leadfirm->intake_id;
		$updateData['firm_status'] = '1';

		$leadfirm->update($updateData);

		Activity::log(
			'lead_firm',
			'update',
			"Lead Firm id - {$leadfirm->id} has been updated",
			[
				'details' => [
								'old' => $oldData,
								'new' => $updateData
							 ],
				'intake_id' => $leadfirm->intake_id
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Firm updated successfully',
		]);
	}
	
	/*
	*
	* Function to Fetch Firm List.
	*
	*/	
    public function leadFirmList(Request $request)
    {
		abort_if(Gate::denies('intake_finance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		if($request->ajax()) {
			$data = LeadFirm::where('intake_id',$lead_id);
			return DataTables::of($data)
				->addColumn('firm_type', function ($row) {
					return @$row->firm_type->title ?? '';
				})
				->addColumn('firm_referral_status', function ($row) {
					return @$row->referral_status->title ?? '';
				})
				->editColumn('firm_name', function ($row) {
					return @$row->firm->name ?? '';
				})
				->addColumn('firm_action', function ($row) {
					$btn = '';
					if(!Gate::denies('intake_finance_edit'))
					{
						$btn = $btn . '<button type="button" class="btn btn-primary editFirmFinanceBtn" data-id="'.$row->id.'" ><i class="fa fa-edit ph-pencil"></i></button>';
					}
					return $btn;
				})
				->editColumn('firm_agreement_in_place', function ($row) {
					return $row->firm_agreement_in_place == "1" ? 'Yes' : 'No';
				})
				->rawColumns(['firm_action'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to get firm Details in lead.
	*
	*/	
    public function getFirmDetails(Request $request)
    {
		abort_if(Gate::denies('intake_finance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		$firm_id = $request->firm_id;
		if($request->ajax()) {
			if($lead_id>0 && $firm_id>0) {
				$firmDtls = LeadFirm::where('id', $firm_id)->first();
				if($firmDtls) { 
					return response()->json([
						'status' => 'success',
						'message' => 'Details Found',
						'data' => $firmDtls
					]);
				} else {
					return response()->json([
						'status' => 'error',
						'message' => 'Details Not Found'
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
	* Function to get Firm List By Firm Type.
	*
	*/	
    public function getFirmListByFirmType(Request $request)
    {
		abort_if(Gate::denies('intake_finance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$firm_type_id = $request->firm_type_id;
		if($request->ajax()) {
			if(isset($firm_type_id) && $firm_type_id>0) {
				$firms = Firm::where('firm_type_id',$firm_type_id)->get();
			}
			else {
				$firms = Firm::get();
			}			
			if($firms) {
				$data = $firms->toArray();
				return response()->json([
					'status' => 'success',
					'message' => 'Firms List',
					'data' => $data
				]);
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Firms List Not Found'
				]);
			}
		}
    }
	
	/*
	*
	* Function to get Firm Name Details By Firm Name Id.
	*
	*/	
    public function getFirmNameDetails(Request $request)
    {
		abort_if(Gate::denies('intake_finance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$firm_name_id = $request->firm_name_id;
		if($request->ajax()) {
			if(isset($firm_name_id) && $firm_name_id>0) {
				$firmDetails = Firm::where('id',$firm_name_id)->first();
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Firm Not Found'
				]);
			}			
			if($firmDetails) {
				$data = $firmDetails->toArray();
				return response()->json([
					'status' => 'success',
					'message' => 'Firm Details',
					'data' => $data
				]);
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Firms List Not Found'
				]);
			}
		}
    }
}