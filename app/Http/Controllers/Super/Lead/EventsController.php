<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LeadEvent;
use App\Models\EventTypeColor;
use App\Models\EventType;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class EventsController extends Controller
{		
	/*
	*
	* Function to save Lead Event in a table.
	*
	*/
	public function store(Request $request)
	{
		abort_if(Gate::denies('intake_events_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		if (!$request->ajax()) {
			return;
		}

		if ((int) $request->lead_id <= 0) {
			return response()->json([
				'status' => 'error',
				'message' => 'Required field is empty'
			]);
		}

		$eventDate = $request->input('event_date');
		$startFrom = $request->input('event_start_from');
		$startTo = $request->input('event_start_to');
		
		$startDateTime = Carbon::parse("{$eventDate} {$startFrom}");
		$endDateTime = Carbon::parse("{$eventDate} {$startTo}");

		$data = $request->only([
			'event_type_id',
			'event_title',
			'location',
			'address',
			'description',
			'owner_id',
			'event_status_id',
		]);

		$data['intake_id'] = $request->lead_id;
		$data['event_date'] = $eventDate;
		$data['event_start_datetime'] = $startDateTime->format('Y-m-d H:i:s');
		$data['event_end_datetime'] = $endDateTime->format('Y-m-d H:i:s');
		$data['all_day'] = $request->boolean('all_day');

		$leadEvent = LeadEvent::create($data);

		Activity::log(
			'lead_events',
			'create',
			"Lead Events has been created with id - {$leadEvent->id}",
			[
				'details' => $leadEvent,
				'intake_id' => $request->lead_id
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Events added successfully'
		]);
	}

	
	/*
	*
	* Function to update Lead Event in a table.
	*
	*/
	public function update(Request $request, $id)
	{
		abort_if(Gate::denies('intake_events_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
	}
	
	/*
	*
	* Function to Fetch Lead Event List.
	*
	*/	
    public function leadEventsList(Request $request)
	{
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$lead_id = $request->get('lead_id');
		$start_date = $request->get('start_date');

		if ($request->ajax()) {
			$data = LeadEvent::with(['event_type', 'owner', 'event_status']);
				
			if($lead_id) {
				$data->where('intake_id', $lead_id);
			}	
				
			if($start_date) {
				$data->whereDate('event_date', '>=', Carbon::today());
			}	

			return DataTables::of($data)
				->editColumn('title', fn($row) => $row->event_title ?? '')
				->addColumn('date_time', fn($row) => $row->created_at?->format('Y-m-d H:i:s') ?? '')
				->addColumn('type', fn($row) => $row->event_type->title ?? 'None')
				->addColumn('location', fn($row) => $row->location ?? '')
				->addColumn('owner', fn($row) => $row->owner->name ?? '')
				->addColumn('status', fn($row) => $row->event_status->title ?? '')
				->rawColumns(['owner', 'status'])
				->make(true);
		}

		return response()->json([], 400);
	}

	
	/*
	*
	* Function to get Lead Event Details in lead.
	*
	*/	
    public function getEventDetails(Request $request)
    {
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		$event_id = $request->event_id;
		if($request->ajax()) {
			
		}
    }
	
	/*
	*
	* Function to get Lead Event Status Count.
	*
	*/
	public function countLeadEventStatus(Request $request)
	{
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		
		if($request->ajax()) {
			if($lead_id>0) {
				$default_count_data = [
					'attended' => 0,
					'attendance' => 0,
					'canceled' => 0,
					'rescheduled' => 0,
					'no_showed' => 0,
				];

				$leadEventCountsRaw  = DB::table('lead_events')
					->join('event_status_types', 'lead_events.event_status_id', '=', 'event_status_types.id')
					->select('event_status_types.title', DB::raw('count(lead_events.id) as count'))
					->groupBy('event_status_types.title')
					//->pluck('count', 'title');
					->get();
					
				//$leadEvntCounts = $default_count_data + $leadEventCountsRaw->toArray();	
				
				$leadEvntCounts = [];
				if($leadEventCountsRaw)	
				{
					// Transform to lowercase keys
					foreach ($leadEventCountsRaw as $item) {
						$leadEvntCounts[strtolower($item->title)] = $item->count;
					}
					
					$leadEvntCounts = array_merge($default_count_data, $leadEvntCounts);
					ksort($leadEvntCounts);
					$data = $leadEvntCounts;
				}
				else {
					$data = $default_count_data;
				}
	
				return response()->json([
					'status' => 'success',
					'message' => 'Lead Event Status Count Details',
					'data' => $data
				]);
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
	* Function to Fetch All Event Type Color List All.
	*
	*/	
    public function getEventTypeColorList(Request $request)
    {
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if($request->ajax()) {
			$etColorList = EventTypeColor::get();			
			if($etColorList) {
				$data = $etColorList->toArray();
				return response()->json([
					'status' => 'success',
					'message' => 'Event Type Color List',
					'data' => $data
				]);
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Event Type Color List Not Found'
				]);
			}
		}
    }
	
	/*
	*
	* Function to Fetch Lead Event List.
	*
	*/	
    public function leadEventTypeList(Request $request)
	{
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		if ($request->ajax()) {
			return DataTables::of(EventType::query())
				->addColumn('event_type', fn($row) => $row->title ?? '')
				->addColumn('color', fn($row) => $row->event_type_color->title ?? '')
				->addColumn('color_code', fn($row) => $row->event_type_color->color_code ?? '')
				->rawColumns(['event_type', 'color', 'color_code'])
				->make(true);
		}
		
		return response()->json([], 400);
	}
	
	/*
	*
	* Function to Fetch Add Lead Event Type.
	*
	*/	
    public function leadEventTypeAdd(Request $request)
    {
		abort_if(Gate::denies('intake_events_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$data = [
					'title'=>$request->event_type_name,
					'event_type_color_id' =>$request->event_type_color
				];
		
		if($request->ajax()) {
			if(!empty($request->event_type_name)) {
				$lead_event_type = EventType::create($data);
					
				// Log the activity
				Activity::log(
					'lead_event_type',
					'create',     
					"Lead Event Type has been created with id - {$lead_event_type->id}",
					[
						'details' => $lead_event_type,
						'intake_id' => null
					]  
				);
				
				$etTypeList = EventType::get();	
                $data = [];				
				if($etTypeList) {
					$data = $etTypeList->toArray();
				}
	
				return response()->json([
					'status' => 'success',
					'message' => 'Event Type added successfully',
					'data' => $data
				]);
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
	* Function to save Lead Event in Calander in a table.
	*
	*/
	public function getCalanderEvents(Request $request)
    {
		abort_if(Gate::denies('intake_events_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$start = $request->start;
		$end = $request->end;
		
		if($start)
		{
			$start = Carbon::parse($start)->toDateString();
		}
		
		if($end)
		{
			$end = Carbon::parse($end)->toDateString();
		}
		
        $eventList = LeadEvent::select('id', 'event_title as title', 'event_start_datetime as start', 'event_end_datetime as end')
					->when($start, function ($query) use ($start) {
						return $query->whereDate('event_date', '>=', $start);
					})
					->when($end, function ($query) use ($end) {
						return $query->whereDate('event_date', '<=', $end);
					})
					->get();
	
		$events = [];				
		if($eventList) {
			$events = $eventList->toArray();
		}

        return response()->json($events);
    }
}