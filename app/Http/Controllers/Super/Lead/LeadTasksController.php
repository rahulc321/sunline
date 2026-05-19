<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LeadTasks;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class LeadTasksController extends Controller
{		
	/*
	*
	* Function to save Lead Tasks in a table.
	*
	*/
	public function store(Request $request)
	{
		abort_if(Gate::denies('intake_tasks_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$data = [
					'intake_id'=>$request->lead_id,
					'type_id'=>$request->type_id,
					'category_id'=>$request->category_id,
					'subject'=>$request->subject, 
					'assigned_to' => $request->assigned_to, 
					'assigned_by'=> auth()->user()->id, 
					'assigned_date'=> date("Y-m-d"), 
					'due_date' => $request->due_date,
					'priority'=> $request->priority, 
					'activity' => $request->activity, 
					'billable_to_client' => ($request->billable_to_client && $request->billable_to_client==1)?"1":"0", 
					'notify_assignee' => ($request->notify_assignee && $request->notify_assignee==1)?"1":"0", 
					'add_calander_event' => ($request->add_calander_event && $request->add_calander_event==1)?"1":"0", 
					'calander_event' => null, 
					'appointment_reminder' => ($request->appointment_reminder && $request->appointment_reminder==1)?"1":"0", 
					'status' => "1", 
					'description' => $request->description
				];
		
		if($request->ajax()) {
			if($request->lead_id>0) {
				$lead_tasks = LeadTasks::create($data);
					
				// Log the activity
				Activity::log(
					'lead_tasks',   
					'create',    
					"Lead Tasks has been created with id - {$lead_tasks->id}",
					[
						'details' => $lead_tasks,
						'intake_id' => $request->lead_id
					]       
				);
	
				return response()->json([
					'status' => 'success',
					'message' => 'Tasks added successfully'
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
	* Function to Fetch Tasks List.
	*
	*/	
    public function leadTasksList(Request $request)
    {
		abort_if(Gate::denies('intake_tasks_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$search_task = $request->get('search_task');
		$task_category = $request->get('task_category');
		$task_type = $request->get('task_type');
		
		$task_assigned_to = $request->get('task_assigned_to');
		$task_assigned_by = $request->get('task_assigned_by');
		$task_status = $request->get('task_status');
		$task_date_range = $request->get('task_date_range');
		
		if($task_assigned_to)
		{
			if(is_array($task_assigned_to)) { } else {
				$task_assigned_to = array($task_assigned_to);
			}
		}
		
		if($task_assigned_by)
		{
			if(is_array($task_assigned_by)) { } else {
				$task_assigned_by = array($task_assigned_by);
			}
		}
		
		if($request->ajax()) {
			$data = LeadTasks::query();
			if($lead_id) {
				$data->where('intake_id', $lead_id);
			}
			if(!empty($task_type)) {
				if(in_array('all',$task_type)) { } else {
					$task_type = array_filter($task_type, fn($value) => $value !=='all');
					$data = $data->whereIn('type_id',$task_type);
				}
			}
			if(!empty($task_category)) {
				if(in_array('all',$task_category)) { } else {
					$task_category = array_filter($task_category, fn($value) => $value !=='all');
					$data = $data->whereIn('category_id',$task_category);
				}
			}
			if(!empty($search_task)) {				
				$data = $data->where(function ($query) use ($search_task) {
					$query->where('subject','like','%'.$search_task.'%')
						  ->orWhere('priority','like','%'.$search_task.'%')
						  ->orWhere('description','like','%'.$search_task.'%');
				});
			}
			if(!empty($task_assigned_to)) {
				if(in_array('all',$task_assigned_to)) { } else {
					$task_assigned_to = array_filter($task_assigned_to, fn($value) => $value !=='all');
					$data = $data->whereIn('assigned_to',$task_assigned_to);
				}
			}
			if(!empty($task_assigned_by)) {
				if(in_array('all',$task_assigned_by)) { } else {
					$task_assigned_by = array_filter($task_assigned_by, fn($value) => $value !=='all');
					$data = $data->whereIn('assigned_by',$task_assigned_by);
				}
			}
			$data->orderby('id', 'desc');
			return DataTables::of($data)
				->addColumn('task_type', function ($row) {
					return @$row->task_value->title ?? '';
				})
				->addColumn('task_category', function ($row) {
					return @$row->category_value->title ?? '';
				})
				->editColumn('assigned_to', function ($row) {
					return @$row->assigned_to_value->name ?? '';
				})
				->editColumn('assigned_by', function ($row) {
					return @$row->assigned_by_value->name ?? '';
				})
				->editColumn('assigned_date', function ($row) {
					return $row->assigned_date ? Carbon::parse($row->assigned_date)->format('Y-m-d') : '';
				})
				->editColumn('due_date', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->editColumn('status', function ($row) {
					return $row->status && $row->status=="1" ? 'Active' : 'InActive';
				})
				->rawColumns(['task_type','task_category'])
				->make(true);
		}
    }
}