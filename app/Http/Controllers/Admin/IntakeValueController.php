<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\IntakeValues;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Gate;
use DB;

class IntakeValueController extends Controller
{
	/*
	*
	* Display a listing of the Intake Values table records.
	*
	*/	
	public function index(Request $request)
    {	
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$module = $request->get('module');
        $modules = IntakeValues::distinct()->pluck('type');
        return view('admin.intake-values.index', compact('modules', 'module'));
    }
	
	/*
	*
	* Function to show from to get form inputs for Intake Values.
	*
	*/
	public function create()
    {	
		abort_if(Gate::denies('intake_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		return view('admin.intake-values.create');
    }
	
	/*
	*
	* Function to save new Intake Values in a table.
	*
	*/
	public function store(Request $request)
    {	
		abort_if(Gate::denies('intake_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
        $request->validate([
            'type' => ['required'],
            'value' => ['required']
        ]);

        IntakeValues::create([
            'type' => $request->type,
            'value' => $request->value
        ]);

        return redirect()->route('admin.intake-values.index')->with('message','Intake value Created successfully.');
    }
	
	/*
	*
	* Function to show Intake Values in details.
	*
	*/
	public function show(Request $request, $id)
    {
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$intake_values = IntakeValues::findOrFail($id);

        return view('admin.intake-values.show', ['intake_values'=> $intake_values]);
    }
	
	/*
	*
	* Function to edit Intake Values table records.
	*
	*/
	public function edit(Request $request, $id)
    {		
		abort_if(Gate::denies('intake_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$intake_values = IntakeValues::findOrFail($id);
		
        return view('admin.intake-values.edit', ['intake_values'=> $intake_values]);
    }
	
	/*
	*
	* Function to update Intake Values table records.
	*
	*/
	public function update(Request $request, $id)
    {
		abort_if(Gate::denies('intake_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$request->validate([
            'type' => ['required'],
            'value' => ['required']
        ]);
		
        IntakeValues::where('id',$id)->update([
            'type' => $request->type,
            'value' => $request->value
        ]);
		
		return redirect()->route('admin.intake-values.index')->with('message','Intake value Updated successfully.');
    }
	
	/*
	*
	* Function to delete Intake Values table records.
	*
	*/
	public function destroy(Request $request, $id)
	{	
		abort_if(Gate::denies('intake_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$intake_values = IntakeValues::findOrFail($id);
		$intake_values->delete();

		return response()->json(['message' => 'Intake value deleted successfully.']);
	}
	
	/*
	*
	* Function to fetch All Intake Values table records.
	*
	*/
	public function getIntakeValues(Request $request)
    {
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$module = $request->get('module');
		
		if ($request->ajax()) {
            $data = IntakeValues::query();
			if(!empty($module)) {
				$data = $data->where('type',$module);
			}
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '';
					
					if(!Gate::denies('intake_show'))
					{
                    $btn = $btn . '<a href="'.route('admin.intake-values.show', $row->id) .'" class="show-btn btn btn-info btn-sm m-1"><i class="fa fa-eye" aria-hidden="true"></i></a>';
					}
					
					if(!Gate::denies('intake_edit'))
					{
						$btn = $btn . '<a href="'.route('admin.intake-values.edit', $row->id) .'" class="edit-btn btn btn-primary btn-sm m-1"><i class="fa fa-edit" aria-hidden="true"></i></a>';
					}
					
					if(!Gate::denies('intake_delete'))
					{
						$btn = $btn . '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete-btn btn btn-danger btn-sm m-1"><i class="fa fa-trash" aria-hidden="true"></i></a>';
					}
					
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
