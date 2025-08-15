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
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class TasksController extends Controller
{		
	/*
	*
	* Display a Tasks etc.
	*
	*/	 
	public function index(Request $request)
    {	
		abort_if(Gate::denies('intake_tasks_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		// Other dropdown lists
		$staticDropdowns = [
			'tasks_type_list'           => TaskType::pluck('title', 'id'),
			'tasks_category_list'       => TasksCategory::pluck('title', 'id'),
			'created_by_list' => [
									auth()->user()->id =>auth()->user()->name
								 ],
		];

		$exportDataRoute = route('admin.task.exportIntakes');
		
		return view('admin.task.index', array_merge(
			[
				'exportDataRoute' => $exportDataRoute ?? '',
			],
			$staticDropdowns
		));
    }
	
	/*
	*
	* Function to export All Intake table records according to date range.
	*
	*/
	public function exportIntakes(Request $request)
    {
		abort_if(Gate::denies('intake_tasks_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$from = $request->from_date;
		$to = $request->to_date;
		
		$request->validate([
			'from_date' => 'required|date',
			'to_date' => 'required|date|after_or_equal:from_date',
		]);
		
		$model = new LeadTasks;
		$columns = Schema::getColumnListing($model->getTable());
		
		$extra_fields = ['id','deleted_at','created_at','updated_at'];
		if(isset($extra_fields) && !empty($extra_fields))
		{
			foreach($extra_fields as $field)
			{
				$index = array_search($field,$columns);
				if($index !==false)
				{
					/* find the index value and remove from the array */
					unset($columns[$index]);
					$columns = array_values($columns); //Re-index the array
				}
			}
		}
		
		$from = (new \DateTime($from))->format("Y-m-d");
		$to = (new \DateTime($to))->format("Y-m-d");
		
		$selected_array = $columns;
		$selected_array = array_merge($selected_array, ['created_at','updated_at']);
		$additional_key=array();
		
		$finalcsvcolumn=array_merge($selected_array,$additional_key);
		
		$finalCsvDataArray=[];
		
		$query = LeadTasks::select($columns)->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])->get()->map(function ($record) {
			$record->formated_created_at = Carbon::parse($record->created_at)->format('Y-m-d H:i:s');
			$record->formated_updated_at = Carbon::parse($record->updated_at)->format('Y-m-d H:i:s');
			return $record;
		});
		
		if($query)
		{
			$finalCsvDataArray=$query->toArray();
		}
		
		$Filename ='tasks_list_'.date('Y-m-d').'_'.rand(10,100).'.csv';
		header('Content-Type: text/csv; charset=utf-8');
		Header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename='.$Filename.'');
		// create a file pointer connected to the output stream
		$output = fopen('php://output', 'w');
		fputcsv($output, $finalcsvcolumn);
		if(isset($finalCsvDataArray) && !empty($finalCsvDataArray))
		{
			foreach ($finalCsvDataArray as $row){
				fputcsv($output, $row);
			}
		}
		fclose($output);
		exit();
    }
}