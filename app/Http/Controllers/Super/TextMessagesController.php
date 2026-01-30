<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\LeadCommunicationTexts;
use App\Models\TextsStatus;
use App\Models\CampaignType;
use App\Models\Intake;
use App\Models\Contact;
use App\User;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class TextMessagesController extends Controller
{		
	/*
	*
	* Function to get Text Message List.
	*
	*/
	public function textMessage(Request $request)
	{
		abort_if(Gate::denies('intake_communications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = '';
		return view('admin.text-message.index', ['lead_id'=>$lead_id]);
	}
	
	/*
	*
	* Function to Fetch Communications Text List.
	*
	*/	
    public function textMessageList(Request $request)
	{
		abort_if(Gate::denies('intake_communications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		if (!$request->ajax()) {
			return response()->json(['message' => 'Invalid request type.'], Response::HTTP_BAD_REQUEST);
		}

		$lead_id = $request->get('lead_id');
		$filters = $request->texts_msg_filter;
		$search = $request->get('search_communications');
		$fromDate = $request->get('from_date');
		$toDate = $request->get('to_date');
		
		$query = Intake::query();

		if ($lead_id > 0) { 
			$query->where('id', $lead_id);
		}

		if (!empty($search)) {
			$query->whereHas('contact', function ($q) use ($search) {
				$q->where('display_name', 'like', "%{$search}%")
					->orWhere('first_name', 'like', "%{$search}%")
					///->orWhere('middle_name', 'like', "%{$search}%")
					->orWhere('last_name', 'like', "%{$search}%");
			});
		}

		// Eager load contact after filtering
		$query->with('contact');

		return DataTables::of($query)
			->editColumn('communications_date', function ($row) {
				return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
			})
			->addColumn('client', function ($row) {
				//return @$row->contact->display_name ?? '';
				if($row->contact->display_name) {
					return $row->contact->display_name;
				}
				else if($row->contact->first_name || $row->contact->last_name)
				{
					return trim($row->contact->first_name .' '.$row->contact->last_name);
				}
				else 
				{
					return '';
				}
			})
			->editColumn('lead_id', function ($row) {
				return @$row->id ?? '';
			})
			->editColumn('message', function ($row) {
				return '';
			})
			->rawColumns(['communications_date'])
			->make(true);
	}
	
	/*
	*
	* Function to Send Text Communications.
	*
	*/
	public function sendTextMessage(Request $request)
	{
		abort_if(Gate::denies('intake_communications_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if($request->ajax()) {
			if($request->lead_id>0) {
				
				$texts_status_id = TextsStatus::where('title', 'Queued')->value('id');
				
				$CampaignType = CampaignType::firstOrNew(['id' => 1]);
				
				$texts = new LeadCommunicationTexts();
				$texts->intake_id = @$request->lead_id ?? null;
				$texts->user_id = auth()->user()->id;
				$texts->texts_status_id = $texts_status_id;
				$texts->campaign_type_id = $CampaignType->id;
				$texts->from_phone = null;
				$texts->to_phone = null;
				$texts->message = $request->message;
				$texts->save();
					
				Activity::log(
					'text_communications', 
					'create',   
					"Text Communication has been created with id - {$texts->id}",
					[
						'details' => $texts,
						'intake_id' => @$request->lead_id ?? null
					]            
				);
				
				$lead_contact_id = Intake::where('id', $texts->intake_id)->value('contact_id');
				$contact_data = Contact::where('id', $lead_contact_id)->first();
				
				if($contact_data)
				{
					$phone = $contact_data->phone;
					$mobile = preg_replace('/\D/', '', $phone);
					$smsObj = new \App\Http\Controllers\Admin\SmsController();
					$request->merge(['country_code' => '91', 'mobile' => $mobile]);
					$smsResponse = $smsObj->sendSms($request);
					
					Activity::log(
						'sms_api_response', 
						'create',   
						"For Text Communication Id - {$texts->id}, text message api has been initiated with response " . json_encode($smsResponse),
						[
							'details' => $smsResponse,
							'intake_id' => @$request->lead_id ?? null
						]            
					);
		
					return response()->json([
						'status' => 'success',
						'message' => 'Text message has been queued for sending!'
					]);
				}
				else 
				{					
					return response()->json([
						'status' => 'error',
						'message' => 'Contact Details not found. Text message not sent'
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
	
	public function getChildTextMessageData(Request $request)
	{
		abort_if(Gate::denies('intake_communications_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = @$request->lead_id ?? null;
		$filters = $request->texts_msg_filter;
		$search = $request->get('search_communications');
		$fromDate = $request->get('from_date');
		$toDate = $request->get('to_date');
		
		$lead_data = Intake::where('id',$lead_id)->with('contact')->first();
		
		$query = LeadCommunicationTexts::query();
		$query->where('intake_id',$lead_id);
		
		if (!empty($filters)) {
			$statusIds = TextsStatus::whereIn('title', $filters)->pluck('id');
			if ($statusIds->isNotEmpty()) {
				$query->where(function ($q) use ($statusIds) {
					foreach ($statusIds as $id) {
						$q->orWhere('texts_status_id', $id);
					}
				});
			}
		}

		if (!empty($search)) {
			$query->where(function ($q) use ($search) {
				$q->where('from_phone', 'like', "%{$search}%")
					->orWhere('to_phone', 'like', "%{$search}%")
					->orWhere('message', 'like', "%{$search}%");
			});
		}

		if (!empty($fromDate) && !empty($toDate)) {
			try {
				$startDate = Carbon::parse($fromDate)->startOfDay();
				$endDate = Carbon::parse($toDate)->endOfDay();
				$query->whereBetween('created_at', [$startDate, $endDate]);
			} catch (\Exception $e) {
				return response()->json(['message' => 'Invalid date format.'], Response::HTTP_UNPROCESSABLE_ENTITY);
			}
		}
		
		$query->orderBy('id', 'desc');
		$text_msg_data = $query->get();

		// return a Blade partial or inline HTML
		return view('admin.text-message.child_row', ['lead_data' => $lead_data, 'text_msg_data' => $text_msg_data])->render();
	}

	
}