<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GooglePlacesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\EventType;
use App\Models\EventTypeColor;
use App\Models\EventTypeRule;
use App\Models\LeadStatus;
use App\Models\AppointmentSettings;
use App\Models\CalendarShareUser;
use App\User;

use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class CalendarController extends Controller
{
    /*
	*
	* Display a Calendar For Events, Task, etc.
	*
	*/	 
	public function index(Request $request)
    {	
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$users = User::all()->pluck('name', 'id');
		
		return view('admin.calendar.index', ['users'=>$users]);
    }
	
	/*
	*
	* Appointment Settings Page.
	*
	*/	 
	public function appointmentSettings(Request $request)
    {	
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$event_type_color_list = EventTypeColor::get();
		$appointment_settings = AppointmentSettings::first();
		$event_type_list = EventType::pluck('title', 'id');
		$lead_status_list = LeadStatus::pluck('title', 'id');
		
		return view('admin.calendar.appointment-settings', ['event_type_color_list'=>$event_type_color_list, 'appointment_settings' => $appointment_settings, 'event_type_list' => $event_type_list, 'lead_status_list' => $lead_status_list]);
    }	
	
	/*
	*
	* Function to save Appointment Settings.
	*
	*/
	public function saveAppointmentSettings(Request $request)
	{
		abort_if(Gate::denies('appointment_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if($request->ajax()) {
			$setting = AppointmentSettings::firstOrNew(['id' => 1]); // always work with ID 1
			$success_message = 'Appointment Settings Updated';
			$log_message = 'Appointment settings has been updated';
			
			if($request->type == 'appointlet_switch')
			{
				$success_message = 'Appointment Settings Updated';
				$setting->appointlet_switch = ($request->appointlet_switch && $request->appointlet_switch=='on')?1:0;
				
				if($setting->appointlet_switch==1) {
					$log_message = 'Appointment settings has been updated and Show Global Appointlet Calendar Folder is ON';
				}
				else 
				{
					$log_message = 'Appointment settings has been updated Show Global Appointlet Calendar Folder is OFF';
				}
			}
			
			if($request->type == 'appointment_reminder')
			{
				$success_message = 'Appointment Reminder Settings Updated';
				$log_message = 'Appointment reminder settings has been updated';
				$setting->remind_lead_assignee = ($request->remind_lead_assignee && $request->remind_lead_assignee=='on')?1:0;
				$setting->remind_lead_owner = ($request->remind_lead_owner && $request->remind_lead_owner=='on')?1:0;
				$setting->remind_lead = ($request->remind_lead && $request->remind_lead=='on')?1:0;
				$setting->remind_loggedin_user = ($request->remind_loggedin_user && $request->remind_loggedin_user=='on')?1:0;
				$setting->remind_instant_ics = ($request->remind_instant_ics && $request->remind_instant_ics=='on')?1:0;
			}
			
			if($request->type == 'appointment_cancellation')
			{
				$success_message = 'Appointment Cancellation Settings Updated';
				$log_message = 'Appointment cancellation settings has been updated';
				$setting->cancellation_email_subject = $request->cancellation_email_subject;
				$setting->cancellation_email_body = $request->cancellation_email_body;
				$setting->cancellation_notification = ($request->cancellation_notification && $request->cancellation_notification=='on')?1:0;
			}
			
			if($request->type == 'cancellation_change_status')
			{
				$success_message = 'Cancellation Setting Updated';
				$log_message = 'Appointment cancellation status has been updated';
				$setting->cancellation_change_status = ($request->cancellation_change_status && $request->cancellation_change_status=='on')?1:0;
			}
			
			$setting->save();
				
			Activity::log(
				'appointment_settings',                          
				'update',                         
				$log_message,  
				[
					'details' => $setting,
					'intake_id' => null
				]                         
			);

			return response()->json([
				'status' => 'success',
				'message' => $success_message
			]);
		}
	}
	
	/*
	*
	* Function to Fetch Add Lead Event Type Rule.
	*
	*/	
    public function leadEventTypeRuleAdd(Request $request)
    {
		abort_if(Gate::denies('intake_events_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$validator = Validator::make($request->all(), [
			'etr_event_type' => 'required',
			'etr_lead_status' => 'required'
		]);
		
		if($validator->fails()) {
			return response()->json([
					'status' => 'validation_error',
					'message' => 'Validation Error',
					'errors' => $validator->errors()
				], 422);
		}
		
		$data = [
					'event_type_id'=>$request->etr_event_type,
					'lead_status_id' =>$request->etr_lead_status,
					'appointment_reminders' => ($request->etr_appointment_reminder && $request->etr_appointment_reminder=='on')?1:0
				];
		
		if($request->ajax()) {
			$etRule = EventTypeRule::create($data);
			
			$lead_status_title = LeadStatus::where('id', $request->etr_lead_status)->value('title');		
			$event_type_title = EventType::where('id', $request->etr_event_type)->value('title');		
			if($data['appointment_reminders']==1)
			{
				$log_message = "Rule has been created with id - {$etRule->id} for Event Type '{$event_type_title}' with status '{$lead_status_title}' and appointment reminder is set to ON";
			}	
			else 
			{
				$log_message = "Rule has been created with id - {$etRule->id} for Event Type '{$event_type_title}' with status '{$lead_status_title}' and appointment reminder is set to OFF";
			}
				
			Activity::log(
				'event_type_rule', 
				'create', 
				$log_message,
				[
					'details' => $etRule,
					'intake_id' => null
				]  
			);
			
			return response()->json([
				'status' => 'success',
				'message' => 'Event Type Rule Added Successfully'
			]);
		}
	}
	
	/*
	*
	* Function to update Event Type Rule Details.
	*
	*/
	public function updateEventTypeRuleDetails(Request $request)
	{
		abort_if(Gate::denies('intake_events_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid request type'
			], 400);
		}

		$etRule = EventTypeRule::find($request->event_type_rule_id);

		if (!$etRule) {
			return response()->json([
				'status' => 'error',
				'message' => 'Event Type Rule not found',
			]);
		}

		$oldData = $etRule->toArray();

		$updateData = [
					'event_type_id'=>$request->etre_event_type,
					'lead_status_id' =>$request->etre_lead_status,
					'appointment_reminders' => ($request->etre_appointment_reminder && $request->etre_appointment_reminder=='on')?1:0
				];

		$etRule->update($updateData);
		
		$lead_status_title = LeadStatus::where('id', $request->etre_lead_status)->value('title');		
		$event_type_title = EventType::where('id', $request->etre_event_type)->value('title');		
		if($updateData['appointment_reminders']==1)
		{
			$log_message = "Event Type Rule - {$request->event_type_rule_id} has been updated for Event Type '{$event_type_title}' with status '{$lead_status_title}' and appointment reminder is set to ON";
		}	
		else 
		{
			$log_message = "Event Type Rule - {$request->event_type_rule_id} has been updated for Event Type '{$event_type_title}' with status '{$lead_status_title}' and appointment reminder is set to OFF";
		}

		Activity::log(
			'event_type_rule',
			'update',
			$log_message,
			[
				'details' => [
								'old' => $oldData,
								'new' => $updateData
							 ],
				'intake_id' => null
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Lead Event Type Rule updated successfully',
		]);
	}
	
	/*
	*
	* Function to get Event Type Rule Details.
	*
	*/	
    public function getEventTypeRuleDetails(Request $request)
    {
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$event_type_rule_id = $request->event_type_rule_id;
		if($request->ajax()) {
			if($event_type_rule_id>0) {
				$etRuleDtls = EventTypeRule::where('id', $event_type_rule_id)->first();
				if($etRuleDtls) { 
					return response()->json([
						'status' => 'success',
						'message' => 'Details Found',
						'data' => $etRuleDtls
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
	* Function to Fetch Lead Event Type Rule List.
	*
	*/	
    public function leadEventTypeRuleList(Request $request)
	{
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		if ($request->ajax()) {
			return DataTables::of(EventTypeRule::query())
				->addColumn('event_type', fn($row) => $row->event_type->title ?? '')
				->addColumn('status_change', fn($row) => $row->lead_status->title ?? '')
				->addColumn('appointment_reminders', function($row){
					$btn = '<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" ';
					if($row->appointment_reminders ?? false) {
						$btn = $btn.'checked';		
					}
					$btn = $btn.' />
					</div>';
					return $btn;
				})
				->addColumn('action', function($row){
					$btn = '';
					
					if(!Gate::denies('intake_events_edit'))
					{
						$btn = $btn . '<a href="javascript:;" data-id="'.$row->id.'" class="edit-btn btn btn-primary btn-sm m-1 editEventTypeRuleBtn"><i class="fa fa-edit ph-pencil" aria-hidden="true"></i></a>';
					}
					
					if(!Gate::denies('intake_events_delete'))
					{
						$btn = $btn . '<a href="javascript:void(0);" data-id="'.$row->id.'" class="etr-delete-btn btn btn-danger btn-sm m-1"><i class="fa fa-trash ph-trash" aria-hidden="true"></i></a>';
					}
					
                    return $btn;
                })
				->rawColumns(['appointment_reminders', 'action'])
				->make(true);
		}
		
		return response()->json([], 400);
	}
	
	/*
	*
	* Function to delete Intake table records.
	*
	*/
	public function deleteEventTypeRule(Request $request)
	{	
		abort_if(Gate::denies('intake_events_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$id = $request->id;
		$etrdetails = EventTypeRule::findOrFail($id);
				
		if($etrdetails)
		{
			$lead_status_title = LeadStatus::where('id', $etrdetails->lead_status_id)->value('title');		
			$event_type_title = EventType::where('id', $etrdetails->event_type_id)->value('title');		
			if($etrdetails->appointment_reminders==1)
			{
				$log_message = "Event Type Rule - {$etrdetails->id} has been deleted where Event Type is '{$event_type_title}', status is '{$lead_status_title}' and appointment reminder is ON";
			}	
			else 
			{
				$log_message = "Event Type Rule - {$etrdetails->id} has been deleted where Event Type is '{$event_type_title}', status is '{$lead_status_title}' and appointment reminder is OFF";
			}
		
			$etrdetails->delete();
		
			// Log the activity
			Activity::log(
				'event_type_rule',
				'delete',  
				$log_message,
				[
					'details' => $etrdetails,
					'intake_id' => null
				]	
			);
		}

		return response()->json(['message' => 'Event Type Rule deleted successfully.']);
	}
	
	/*
	*
	* Function to Save Selected User Permission For Calendar.
	*
	*/
	public function saveSelectedUsersCalenPermiss(Request $request)
	{
		abort_if(Gate::denies('calendar_sharing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return;
		}
		
		$user_id = auth()->user()->id;
		$userIds = json_decode($request->input('selected_users'), true);
		$calen_permission = $request->calen_permission;
		
		if (empty($userIds)) {
			return response()->json([
				'status' => 'error',
				'message' => 'Please select users'
			]);
		}
		// Get existing shares including soft-deleted
		$existing = CalendarShareUser::withTrashed()
        ->where('user_id', $user_id)
        ->get()
        ->keyBy('shared_user_id');
		
		$insertData = [];
		$now = Carbon::now();
		
		foreach ($userIds as $shared_user_id) {
			if ($existing->has($shared_user_id)) {
				$record = $existing[$shared_user_id];

				if ($record->trashed()) {
					// Restore soft-deleted record
					$record->restore();
				}
				// Update timestamp and permission type
				$record->permission_type = @($calen_permission[$shared_user_id]) ?? null;
				$record->updated_at = $now;
				$record->save();
			} else {
				// Prepare insert data
				$insertData[] = [
					'user_id' => $user_id,
					'shared_user_id' => $shared_user_id,
					'permission_type' => @($calen_permission[$shared_user_id]) ?? null,
					'created_at' => $now,
					'updated_at' => $now
				];
			}
		}
		
		// Soft delete old ones not in new list
		$toDelete = $existing->keys()->diff($userIds);
		if ($toDelete->isNotEmpty()) {
			CalendarShareUser::where('user_id', $user_id)
				->whereIn('shared_user_id', $toDelete)
				->delete();
		}
		
		// Insert new records
		if (!empty($insertData)) {
			CalendarShareUser::insert($insertData);
		}

		$share_data = json_encode($userIds);
		$user_name = auth()->user()->name;
		$userNames = User::whereIn('id', $userIds)->pluck('name')->implode(', ');		
		// Log the activity
		Activity::log(
			'calendar_user_permission', 
			'create',  
			"User - {$user_name} has shared calendar with user's - {$userNames}", 
			[
				'details' => $share_data,
				'intake_id' => null
			]                      
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Permission added successfully'
		]);	
	}
    
}