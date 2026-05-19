<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;
use App\Models\IntakeValues;
use App\Models\LeadStatus;
use App\Models\CaseType;
use App\Models\ActivityType;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class ActivityController extends Controller
{		
	/*
	*
	* Display a Activity / News Feed etc.
	*
	*/	 
	public function index(Request $request)
    {	
		abort_if(Gate::denies('intake_activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		// Load all dropdown-type values and group by 'type'
		$intake_values = IntakeValues::all()->groupBy('type');
		
		// Add additional dropdowns to the intake_values array
		$additionalDropdowns = [
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
			'case_type'             => CaseType::pluck('title', 'id'),
			'activity_type'         => ActivityType::pluck('title', 'id'),
		];

		foreach ($additionalDropdowns as $key => $values) {
			$intake_values[$key] = $values;
		}
		
		// Other dropdown lists
		$staticDropdowns = [
			'created_by_list'   =>  [ auth()->user()->id =>auth()->user()->name ],
		];

		$exportDataRoute = route('admin.activity.exportActivity');
		$date_range_options = [
			'all' => trans('global.all_time'),
			'today' => trans('global.today'),
			'last_week' => trans('global.last_week'),
			'current_month' => trans('global.current_month'),
			//'all_dates' => trans('global.all_dates'),
			'last_month' => trans('global.last_month'),
			'last_year' => trans('global.last_year'),
			'custom' => trans('global.custom'),
		];
		
		return view('admin.activity.index', array_merge(
			[
				'intake_values' => $intake_values,
				'exportDataRoute' => $exportDataRoute ?? '',
				'date_range_options' => $date_range_options ?? [],
			],
			$staticDropdowns
		));
    }
	
	/*
	*
	* Function to Fetch All Activity Logs.
	*
	*/	
    public function activityLogs(Request $request)
    {
		abort_if(Gate::denies('activity_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');		
		
		$lead_id = $request->get('lead_id');
		$search_activity = $request->get('search_activity');
		$activity_category = $request->get('activity_category');
		$module = $request->get('module');
		
		if($request->ajax()) {
			$data = Activity::query();
			$data = $data->with('user');
			if($lead_id) {
				$data->where('intake_id', $lead_id);
			}
			if(!empty($activity_category)) {
				if(in_array('all',$activity_category)) { } else {
					$activity_category = array_filter($activity_category, fn($value) => $value !=='all');
					$data = $data->whereIn('activity_type_id',$activity_category);
				}
			}
			$data->when($request->search_activity, function ($query, $search) {
				$query->where(function ($q) use ($search) {
					$q->where('description', 'like', "%{$search}%")
					  ->orWhereHas('user', function ($q2) use ($search) {
						  $q2->where('name', 'like', "%{$search}%");
					  });
				});
			});
			if(!empty($module)) {
				$data = $data->where('module',$module);
			}
			$data->orderby('id', 'desc');
			return DataTables::of($data)
				->addColumn('user', function ($row) {
					return $row->user ? $row->user->name : 'System';
				})
				->addColumn('completed_on', function ($row) {
					return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');;
				})
				->make(true);
		}
    }
	
	/*
	*
	* Function to export All Activity / News Feed table records according to date range.
	*
	*/
	public function exportActivity(Request $request)
	{
		abort_if(Gate::denies('intake_activity_export_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		// Validate request
		$request->validate([
			'from_date' => 'required|date',
			'to_date' => 'required|date|after_or_equal:from_date',
		]);

		// Format dates
		$from = (new \DateTime($request->from_date))->format("Y-m-d");
		$to = (new \DateTime($request->to_date))->format("Y-m-d");

		// Fetch activities
		$activities = Activity::with(['intake_value.case_type_value', 'contact_value', 'user'])
			->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
			->get()
			->map(function ($record) {
				$record->formated_created_at = Carbon::parse($record->created_at)->format('Y-m-d H:i:s');
				$record->formated_updated_at = Carbon::parse($record->updated_at)->format('Y-m-d H:i:s');
				return $record;
			});

		// Prepare CSV download
		$filename = 'newsfeed_list_' . date('Y-m-d') . '_' . rand(10, 100) . '.csv';

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');

		// CSV Header
		fputcsv($output, ['Lead ID', 'Case Type', 'Client', 'User Name', 'Description', 'Completed On']);

		// CSV Rows
		foreach ($activities as $row) {
			$clientName = $row->contact_value->display_name
				?? trim($row->contact_value->first_name . ' ' . $row->contact_value->last_name);

			fputcsv($output, [
				$row->intake_id,
				$row->intake_value->case_type_value ? $row->intake_value->case_type_value->title : null,
				$clientName,
				$row->user->name ?? '',
				$row->description,
				$row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('Y-m-d') : '',
			]);
		}

		fclose($output);
		exit();
	}

	
	/*
	*
	* Function to Activity / News Feed List.
	*
	*/	
    public function activityList(Request $request)
	{
		// Request: lead_id, date_range, search_activity, type, case_type, status, activity_type
		
		abort_if(Gate::denies('intake_activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		[$startDate, $endDate] = $this->getDateRangeFromKeyword($request->get('date_range'));
		
		if ($request->ajax()) {
			$data = Activity::with(['intake_value.case_type_value', 'contact_value', 'user']);

			$data->when($request->lead_id, fn($q) => $q->where('intake_id', $request->lead_id));

			if ($request->date_range && $request->date_range !== 'all') {
				$data->whereBetween('created_at', [$startDate, $endDate]);
			}

			$data->when($request->type, function ($query, $type) {
				$type = array_filter($type, fn($v) => $v !== 'all');
				if (!empty($type)) {
					$query->whereIn('activity_type_id', $type);
				}
				
			});

			$data->when($request->case_type, function ($query, $case_type) {
				$case_type = array_filter($case_type, fn($v) => $v !== 'all');
				if (!empty($case_type)) {
					$query->whereHas('intake_value', fn($q) => $q->whereIn('case_type', $case_type));
				}
			});

			$data->when($request->status, function ($query, $status) {
				$status = array_filter($status, fn($v) => $v !== 'all');
				if (!empty($status)) {
					$query->whereHas('intake_value', fn($q) => $q->whereIn('status', $status));
				}
			});

			$data->when($request->activity_type, function ($query, $activity_type) {
				$activity_type = array_filter($activity_type, fn($v) => $v !== 'all');
				// Code for activity type filter
			});

			$data->when($request->search_activity, function ($query, $search) {
				$query->where(function ($q) use ($search) {
					$q->where('description', 'like', "%{$search}%")
					  ->orWhereHas('user', function ($q2) use ($search) {
						  $q2->where('name', 'like', "%{$search}%");
					  })
					  ->orWhereHas('intake_value.case_type_value', function ($q3) use ($search) {
						  $q3->where('title', 'like', "%{$search}%");
					  })
					  ->orWhereHas('contact_value', function ($q4) use ($search) {
						  $q4->where(function ($subQuery) use ($search) {
							  $subQuery->where('display_name', 'like', "%{$search}%")
									   ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
						  });
					  });
				});
			});
			
			$data->orderby('id', 'desc');

			return DataTables::of($data)
				->addColumn('completed_on', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->addColumn('lead_id', fn($row) => $row->intake_id ?? '')
				->addColumn('case_type', function ($row) {
					if($row->intake_value) {
						return $row->intake_value->case_type_value ? $row->intake_value->case_type_value->title : null;
					}
					else {
						return '';
					}
				})
				->addColumn('client', function ($row) {
					if($row->contact_value) {
						if ($row->contact_value->display_name) {
							return $row->contact_value->display_name;
						}
						return trim($row->contact_value->first_name . ' ' . $row->contact_value->last_name);
					}
					else {
						return '';
					}
				})
				->addColumn('user_name', fn($row) => $row->user->name ?? '')
				->editColumn('description', fn($row) => $row->description ?? '')
				->rawColumns(['case_type', 'description'])
				->make(true);
		}
	}

	
	/*
	*
	* Function to get Date Range From Keyword.
	*
	*/
	private function getDateRangeFromKeyword($keyword) {
		switch ($keyword) {
			case 'today':
				return [Carbon::today(), Carbon::now()];
			case 'last_week':
				return [Carbon::now()->subWeek(), Carbon::now()];
			case 'current_month':
				return [Carbon::now()->startOfMonth(), Carbon::now()];
			case 'last_month':
				return [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()];
			case 'last_year':
				return [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()];
			default:
				//return [Carbon::minValue(), Carbon::now()];
				return [null, null];
		}
	}
}