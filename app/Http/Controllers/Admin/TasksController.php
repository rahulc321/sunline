<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;
use App\Models\LeadTasks;
use App\Models\TaskType;
use App\Models\TasksCategory;
use App\Models\Activity;
use App\Models\Task;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;
use App\User;
use App\Models\LeadFollowUp;
use App\Models\LeadSource;
use App\Models\EmailTemplate;
use App\Models\Lead;


class TasksController extends Controller
{		
	/*
	*
	* Display a Tasks etc.
	*
	*/	 
	public function taskList(Request $request)
    {	
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();

	
		$task = Task::get();

		// pending tasks
		$this->data['pending'] = Task::where('status', 'Pending')->forCurrentUser()->count();

		// completed tasks
		$this->data['completed'] = Task::where('status', 'Completed')->forCurrentUser()->count();

		// overdue tasks (not completed & due before today)
		$this->data['overdue'] = Task::where('status', '!=', 'Completed')
			->whereDate('due_date', '<', Carbon::today())->forCurrentUser()
			->count();

		// today tasks (any status but due today)
		$this->data['today'] = Task::where('status', '!=', 'Completed')->whereDate('due_date', Carbon::today())->forCurrentUser()->count();

		// upcoming tasks (not completed & due after today)
		$this->data['upcoming'] = Task::where('status', '!=', 'Completed')
			->whereDate('due_date', '>', Carbon::today())->forCurrentUser()
			->count();

		//dd($this->data);
		 
		$this->data['leads'] = Lead::forCurrentUser()->get();

		 
		return view('admin.tasks.index',$this->data); 
    }


	public function getTask(Request $request)
	{
		$limit = $request->limit ?? 10;
		$offset = $request->offset ?? 0;
	
		# base query
		$query = Task::with(['getAssignUserName','leadName'])->orderBy('id', 'desc')->forCurrentUser();
	
		# apply filters dynamically
		if ($request->filled('assigned_to')) {
			$query->where('assigned_to', $request->assigned_to);
		}
	
		if ($request->filled('priority')) {
			$query->where('priority', $request->priority);
		}
	
		if ($request->filled('task_type')) {
			$query->where('task_type', $request->task_type);
		}
	
		# if you still want search
		// if ($request->filled('search_key')) {
		// 	$search = $request->search_key;
		// 	$query->where(function ($q) use ($search) {
		// 		$q->where('title', 'like', "%{$search}%")
		// 		  ->orWhere('description', 'like', "%{$search}%");
		// 	});
		// }
	
		# count after filters
		$totalRecords = $query->count();
	
		# fetch with pagination
		$tasks = $query->skip($offset)
			->take($limit)
			->get()
			->map(function ($task) {
				if (!empty($task->due_date)) {
					$task->due_date_only = \Carbon\Carbon::parse($task->due_date)->format('Y-m-d');
					$task->due_time_only = \Carbon\Carbon::parse($task->due_date)->format('h:i A');
					$task->due_time_only1 = \Carbon\Carbon::parse($task->due_date)->format('H:i');
				} else {
					$task->due_date_only = null;
					$task->due_time_only = null;
					$task->due_time_only1 = null;
				}
				return $task;
			});
	
		$hasMore = ($offset + $limit) < $totalRecords;
	
		return response()->json([
			'data' => $tasks,
			'hasMore' => $hasMore
		]);
	}
	

	# store task
	public function taskStore(Request $request){

			$data = $request->all();
			$data['due_date'] = $request->due_date.' '.$request->due_time;
			unset($data['due_time']);
			Task::create($data);
			return redirect()->back()->with('success', 'You have successfully added!');
	}

	# update task
	public function taskUpdate(Request $request)
	{
		$validated = $request->validate([
			'lead' => 'required|string|max:255',
			'description' => 'required|string',
			'assigned_to' => 'nullable|exists:users,id',
			'due_date' => 'required|date',
			'due_time' => 'required|date_format:H:i',
			'priority' => 'required|string',
			'task_type' => 'required|string',
			'status' => 'required|string',
		]);

		# merge date & time into single due_date field
		$validated['due_date'] = $validated['due_date'] . ' ' . $validated['due_time'];
		unset($validated['due_time']);
		//dd($validated);
		$task = Task::find($request->id);
		$task->update($validated);

		return back()->with('success', 'Task updated successfully!');
	}

	
	 
}