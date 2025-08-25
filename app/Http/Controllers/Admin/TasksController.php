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
			$query->where('title', 'User');
		})->get();

		

		$followups = LeadFollowUp::with('lead')
        ->orderBy('date', 'desc')
        ->get();

		$this->data['upcoming'] = $followups->where('is_completed', 0);
		$this->data['past'] = $followups->where('is_completed', 1);

		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['leads'] = Lead::get();

		 
		return view('admin.tasks.index',$this->data); 
    }


	public function getTask(Request $request)
	{
		$limit = $request->limit ?? 1; // limit per request
		$offset = $request->offset ?? 0;

		# fetch current batch
		$leads = Task::orderBy('id', 'desc')
			->take($limit)
			->get();

		# check if more data exists for next load
		$totalRecords = Task::count();
		$hasMore = ($offset + $limit) < $totalRecords;

		return response()->json([
			'data' => $leads,
			'hasMore' => $hasMore
		]);
	}
	
	 
}