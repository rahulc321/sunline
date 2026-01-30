<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\Intake\StoreRequest;
use App\Http\Requests\Intake\EditRequest;
use App\Http\Requests\Intake\UpdateRequest;
use App\Http\Requests\Intake\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Helpers\GeneralFunctions;

use App\Models\Intake;
use App\Models\IntakeValues;
use App\Models\LeadStatus;
use App\Models\Contact;
use App\Models\AddressType;
use App\Models\IntakeContact;
use App\Models\LeadKeyDate;
use App\Models\CaseType;
use App\Models\CaseRole;
use App\Models\LeadCaseRole;
use App\Models\FormQuestionAnswer;
use App\Models\ContactType;
use App\Models\Language;
use App\Models\ContactPrefixes;
use App\Models\ContactMaritalStatus;
use App\Models\LeadCallOutcome;
use App\Models\NotesCategory;
use App\Models\TaskType;
use App\Models\TasksCategory;
use App\Models\Firm;
use App\Models\FirmType;
use App\Models\FirmOverrideType;
use App\Models\FirmReferralStatus;
use App\Models\CostType;
use App\Models\ExpenseCategory;
use App\Models\DocumentCategory;
use App\Models\DocumentFolder;
use App\Models\EventStatusType;
use App\Models\EventType;
use App\Models\Activity;
use App\Models\ActivityType;
use App\User;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Gate;
use DB;

class IntakeController extends Controller
{
	/*
	*
	* Display a listing of the Intake table records.
	*
	*/	 
	public function index(Request $request)
    {	
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$exportDataRoute = route('admin.intakes.exportIntakes');
		
		return view('admin.intakes.index', 
			[
				'exportDataRoute' => $exportDataRoute ?? '',
			]
		);
    }
	
	/*
	*
	* Function to show from to get form inputs for New Intake.
	*
	*/	
	public function create()
    {		
		abort_if(Gate::denies('intake_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');		
		
		// Load all dropdown-type values and group by 'type'
		$intake_values = IntakeValues::all()->groupBy('type');
		
		// Add additional dropdowns to the intake_values array
		$additionalDropdowns = [
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
			'case_type'             => CaseType::pluck('title', 'id'),
			'case_role'             => CaseRole::pluck('title', 'id'),
			//'lead_call_outcome'     => LeadCallOutcome::pluck('title', 'id'),
			'address_type'          => AddressType::pluck('title', 'id'),
		];

		foreach ($additionalDropdowns as $key => $values) {
			$intake_values[$key] = $values;
		}
		
		$user_list = User::pluck('name','id');
		$assignee_list = ["0" => "Unassigned"];
		$assignee_list = array_merge($assignee_list, $user_list->toArray());
		$owner_list = ["0" => "None"];
		$owner_list = array_merge($owner_list, $user_list->toArray());
		
		$contact_type_list = ContactType::distinct()->pluck('title','id');
		$languages = Language::distinct()->pluck('name','id');
		$prefix_list = ContactPrefixes::distinct()->pluck('title','id');
		$marital_status_list = ContactMaritalStatus::distinct()->pluck('title','id');
		
        return view('admin.intakes.create',['intake_values'=>$intake_values, 'contact_type_list'=>$contact_type_list, 'languages'=>$languages, 'prefix_list'=>$prefix_list, 'marital_status_list'=>$marital_status_list, 'assignee_list' => $assignee_list, 'owner_list' => $owner_list]);
    }
	
	/*
	*
	* Function to save new Intake records in a table.
	*
	*/
	public function store(StoreRequest $request)
    {
		$filterInputData = Intake::getFilteredFormData($request->all()); /* filter form inputs according to table columns */ 
		
        $intake = Intake::create($filterInputData);
		
		$contact_id = $request->contact_id;
		if(isset($contact_id) && $contact_id>0)
		{
			IntakeContact::updateOrCreate(['intake_id'=>$intake->id,'contact_id'=>$contact_id],['intake_id'=>$intake->id,'contact_id'=>$contact_id]);
		}
		
		$case_role = $request->case_role;
		if(isset($case_role) && $case_role>0)
		{
			LeadCaseRole::updateOrCreate(['intake_id'=>$intake->id,'case_role_id'=>$case_role],['intake_id'=>$intake->id,'case_role_id'=>$case_role]);
		}
		
		// Log the activity
		Activity::log(
			'intake',       
			'create',     
			"New Intake has been created with id - {$intake->id}",
			[
				'details' => $intake,
				'intake_id' => $intake->id
			]
		);

        return redirect()->route('admin.intakes.create')->with('message','New Intake Created successfully.');
    }
	
	/*
	*
	* Function to show Intake table records in details.
	*
	*/
	public function show(Request $request, $id)
    {
		abort_if(Gate::denies('intake_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		// Eager load related models
		$lead_data = Intake::with(['contact','case_roles', 'question_answer'])->findOrFail($id);
		$contact_data = $lead_data->contact;
		
		// Load all dropdown-type values and group by 'type'
		$intake_values = IntakeValues::all()->groupBy('type');
		
		// Add additional dropdowns to the intake_values array
		$additionalDropdowns = [
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
			'case_type'             => CaseType::pluck('title', 'id'),
			'case_role'             => CaseRole::pluck('title', 'id'),
			'lead_call_outcome'     => LeadCallOutcome::pluck('title', 'id'),
			'address_type'          => AddressType::pluck('title', 'id'),
			'activity_type'         => ActivityType::pluck('title', 'id'),
		];

		foreach ($additionalDropdowns as $key => $values) {
			$intake_values[$key] = $values;
		}
		
		$user_list = User::pluck('name','id');
		$assignee_list = ["0" => "Unassigned"];
		$assignee_list = array_merge($assignee_list, $user_list->toArray());
		$owner_list = ["0" => "None"];
		$owner_list = array_merge($owner_list, $user_list->toArray());
		
		$current_folder_name = '';
		if(isset($contact_data) && !empty($contact_data))
		{
		  $current_folder_name = trim($current_folder_name.$contact_data->display_name);
		  $current_folder_name = GeneralFunctions::generateNames($current_folder_name);
		}

		// Load dropdowns
		$staticDropdowns = [
			'contact_type_list' => ContactType::pluck('title', 'id'),
			'languages' => Language::pluck('name', 'id'),
			'prefix_list' => ContactPrefixes::pluck('title', 'id'),
			'marital_status_list' => ContactMaritalStatus::pluck('title', 'id'),
			'notes_category_list' => NotesCategory::pluck('title', 'id'),
			'tasks_type_list' => TaskType::pluck('title', 'id'),
			'tasks_category_list' => TasksCategory::pluck('title', 'id'),
			'firm_type_list' => FirmType::pluck('title', 'id'),
			'firm_override_type_list' => FirmOverrideType::pluck('title', 'id'),
			'firm_referral_status_list' => FirmReferralStatus::pluck('title', 'id'),
			'firm_list' => Firm::pluck('name', 'id'),
			'cost_type_list' => CostType::where('show_on_form','1')->pluck('title', 'id'),
			'cost_type_filter_list' => CostType::where('show_in_filter','1')->pluck('title', 'id'),
			'expense_category_list' => ExpenseCategory::pluck('title', 'id'),
			'document_category' => DocumentCategory::pluck('title', 'id'),
			'document_folder_list' => array_merge(
													['0' => $current_folder_name], 
													DocumentFolder::pluck('folder_name', 'id')->toArray()
												 ),
			'assignee_list' => $assignee_list,
			'owner_list' => $owner_list,
		];

		return view('admin.intakes.show', array_merge([
			'lead_data' => $lead_data,
			'intake_values' => $intake_values,
			'contact_data' => $contact_data,
		], $staticDropdowns));
    }
	
	/*
	*
	* Function to edit Intake table records.
	*
	*/
	public function edit(EditRequest $request, $id)
	{
		// Eager load related models
		$lead_data = Intake::with(['case_roles', 'question_answer'])->findOrFail($id);
		$contact_data = Contact::findOrFail($lead_data->contact_id);

		// Load all dropdown-type values and group by 'type'
		$intake_values = IntakeValues::all()->groupBy('type');

		// Add additional dropdowns to the intake_values array
		$additionalDropdowns = [
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
			'case_type'             => CaseType::pluck('title', 'id'),
			'case_role'             => CaseRole::pluck('title', 'id'),
			'lead_call_outcome'     => LeadCallOutcome::pluck('title', 'id'),
			'address_type'          => AddressType::pluck('title', 'id'),
			'activity_type'         => ActivityType::pluck('title', 'id'),
		];

		foreach ($additionalDropdowns as $key => $values) {
			$intake_values[$key] = $values;
		}
		
		$user_list = User::pluck('name','id');
		$assignee_list = ["0" => "Unassigned"];
		$assignee_list = array_merge($assignee_list, $user_list->toArray());
		$owner_list = ["0" => "None"];
		$owner_list = array_merge($owner_list, $user_list->toArray());
		
		$current_folder_name = '';
		$root_document_folder_id = null;
		$document_default_folder = [];
		if(isset($contact_data) && !empty($contact_data))
		{
		  $current_folder_name = trim($current_folder_name.$contact_data->display_name);
		  $current_folder_name = GeneralFunctions::generateNames($current_folder_name);
		  $folderDetails = GeneralFunctions::getFolderDetails($id.'-'.$current_folder_name, 'name');
		  $root_document_folder_id = $folderDetails['id'] ?? null;
		}	
		
		/* Start:: Map Default Folder Dir */
			$document_default_dir = DocumentFolder::select('id','folder_name as name')->get()->toArray();
			$document_folder_dir = $folderDetails['subfolders'] ?? [];

			// Create name => id map from Array B
			$mapB = collect($document_folder_dir)->pluck('id', 'name');

			// Merge with Array A
			$document_default_folder = collect($document_default_dir)->map(function ($itemA) use ($mapB) {
				return [
					'id_a' => $itemA['id'],
					'name' => $itemA['name'],
					'id_b' => $mapB[$itemA['name']] ?? 0,
				];
			})->toArray();
		/* End:: Map Default Folder Dir */

		// Other dropdown lists
		$staticDropdowns = [
			'contact_type_list'         => ContactType::pluck('title', 'id'),
			'languages'                 => Language::pluck('name', 'id'),
			'prefix_list'               => ContactPrefixes::pluck('title', 'id'),
			'marital_status_list'       => ContactMaritalStatus::pluck('title', 'id'),
			'notes_category_list'       => NotesCategory::pluck('title', 'id'),
			'tasks_type_list'           => TaskType::pluck('title', 'id'),
			'tasks_category_list'       => TasksCategory::pluck('title', 'id'),
			'firm_type_list'            => FirmType::pluck('title', 'id'),
			'firm_override_type_list'   => FirmOverrideType::pluck('title', 'id'),
			'firm_referral_status_list' => FirmReferralStatus::pluck('title', 'id'),
			'firm_list'                 => Firm::pluck('name', 'id'),
			'cost_type_list' => CostType::where('show_on_form','1')->pluck('title', 'id'),
			'cost_type_filter_list' => CostType::where('show_in_filter','1')->pluck('title', 'id'),
			'expense_category_list' => ExpenseCategory::pluck('title', 'id'),
			'document_category' => DocumentCategory::pluck('title', 'id'),
			'root_document_folder' => [
										'id' => $root_document_folder_id,
										'name' => $current_folder_name,
										'code' => $id.'-'.$current_folder_name,
									  ],
			'document_default_folder' => $document_default_folder,
			'document_folder_list' => array_merge(
													['0' => $current_folder_name], 
													DocumentFolder::pluck('folder_name', 'id')->toArray()
												 ),
			'assignee_list' => $assignee_list,
			'owner_list' => $owner_list,									 
			'created_by_list' => [
									auth()->user()->id =>auth()->user()->name
								 ],
			'event_status_list' => EventStatusType::pluck('title', 'id'),
			'event_type_list' => EventType::pluck('title', 'id'),
			'event_repeat_list' => [
										'0'=>'Never',
										'1'=>'1 Week',
										'2'=>'2 Weeks',
										'3'=>'3 Weeks',
										'4'=>'4 Weeks',
								   ]
		];

		return view('admin.intakes.edit', array_merge(
			[
				'lead_data' => $lead_data,
				'intake_values' => $intake_values,
				'contact_data' => $contact_data,
			],
			$staticDropdowns
		));
	}
	
	/*
	*
	* Function to update Intake table records.
	*
	*/
	public function update(UpdateRequest $request, $id)
    {
		$filterInputData = Intake::getFilteredFormData($request->all()); /* filter form inputs according to table columns */ 
		
		$intake = Intake::findOrFail($id);
		
		$old_data = [];
		if($intake)
		{
			$intake_id = $intake->id;
			$old_data = $intake->toArray();
			$intake->update($filterInputData);
			
			/* Start:: Key Date Section Updates */
			$key_date = $request->key_date;
			if(isset($key_date) && !empty($key_date))
			{
				$keyDateUpdateDataArr = [];
				foreach($key_date as $key=>$value)
				{
					$keyDateUpdateData = ['intake_id'=>$intake_id, 'key_date_id'=>$key, 'key_date'=>$value];
					$keyDateUpdateDataArr[] = $keyDateUpdateData;
					LeadKeyDate::updateOrCreate(['intake_id'=>$intake_id,'key_date_id'=>$key],$keyDateUpdateData);
				}
			}
			/* End:: Key Date Section Updates */
			
			/* Start:: Form Section Updates */
			$data = $request->all();
			$formData = collect($data)->filter(function ($value, $key) {
				return str_starts_with($key, 'f_genque_') || str_starts_with($key, 'f_esign_') || str_starts_with($key, 'f_migration_') || str_starts_with($key, 'f_gencaseque_') || str_starts_with($key, 'f_additional_');
			});
			FormQuestionAnswer::where('intake_id',$intake_id)->delete();
			$data_insert = []; 
			if(isset($formData) && !empty($formData))
			{
				foreach($formData as $key => $value)
				{
					$data_insert[] = [
							'intake_id'=>$intake_id,
							'question_id'=>$key,
							'answer'=>$value
					];
				}
			}
			FormQuestionAnswer::insert($data_insert);
			/* End:: Form Section Updates */
		}	
		
		// Log the activity
		Activity::log(
			'intake',    
			'update',    
			"Intake has been updated with id - {$id}",
			[
				'details' => [
								'old' => $old_data,
								'new' => $filterInputData
							 ],
				'intake_id' => $id
			]	                  	
		);
		
		return redirect()->route('admin.intakes.edit', $id)->with('message','New Intake Updated successfully.');
    }
	
	/*
	*
	* Function to delete Intake table records.
	*
	*/
	public function destroy(DeleteRequest $request, $id)
	{	
		$intake = Intake::findOrFail($id);
				
		if($intake)
		{
			$intake->delete();
		
			// Log the activity
			Activity::log(
				'intake',    
				'delete', 
				"Intake with Id - {$intake->id} has been deleted.",
				[
					'details' => $intake,
					'intake_id' => $intake->id
				]	                      
			);
		}

		return response()->json(['message' => 'New Intake deleted successfully.']);
	}
	
	/*
	*
	* Function to fetch All Intake table records.
	*
	*/
	public function getIntakes(Request $request)
    {
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if ($request->ajax()) {
            $data = Intake::query();
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox"value="'.$row->id.'">';
				})
                ->addColumn('action', function($row){
					$btn = '';
					
					if(!Gate::denies('intake_show'))
					{
                    $btn = $btn . '<a href="'.route('admin.intakes.show', $row->id) .'" class="show-btn btn btn-info btn-sm m-1"><i class="fa fa-eye ph-eye" aria-hidden="true"></i></a>';
					}
					
					if(!Gate::denies('intake_edit'))
					{
						$btn = $btn . '<a href="'.route('admin.intakes.edit', $row->id) .'" class="edit-btn btn btn-primary btn-sm m-1"><i class="fa fa-edit ph-pencil" aria-hidden="true"></i></a>';
					}
					
					if(!Gate::denies('intake_delete'))
					{
						$btn = $btn . '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete-btn btn btn-danger btn-sm m-1"><i class="fa fa-trash ph-trash" aria-hidden="true"></i></a>';
					}
					
                    return $btn;
                })
				->editColumn('case_role', function ($row) {
					$case_role_value='';
					if($row->case_role_value) {
						$case_role_value = $row->case_role_value->title ? $row->case_role_value->title : '';
					}
					return $case_role_value;
				})
				->editColumn('case_type', function ($row) {
					$case_type_value='';
					if($row->case_type_value) {
						$case_type_value = $row->case_type_value->title ? $row->case_type_value->title : '';
					}
					return $case_type_value;
				})
				->editColumn('status', function ($row) {
					$status_value='';
					if($row->status_value) {
						$status_value = $row->status_value->title ? $row->status_value->title : '';
					}
					return $status_value;
				})
				->editColumn('marketing_source', function ($row) {
					$marketing_source_value='';
					if($row->marketing_source_value) {
						$marketing_source_value = $row->marketing_source_value->value ? $row->marketing_source_value->value : '';
					}
					return $marketing_source_value;
				})
				->editColumn('assignee', function ($row) {
					$assignee_value='';
					if($row->assignee_value) {
						$assignee_value = $row->assignee_value->name ? $row->assignee_value->name : '';
					}
					return $assignee_value;
				})
				->editColumn('owner', function ($row) {
					$owner_value='';
					if($row->owner_value) {
						$owner_value = $row->owner_value->name ? $row->owner_value->name : '';
					}
					return $owner_value;
				})
				->editColumn('ad_campaign', function ($row) {
					$ad_campaign_value='';
					if($row->ad_campaign_value) {
						$ad_campaign_value = $row->ad_campaign_value->value ? $row->ad_campaign_value->value : '';
					}
					return $ad_campaign_value;
				})
				->editColumn('created_at', function ($row) {
					return $row->created_at->format('Y-m-d H:i:s');
				})
                ->rawColumns(['checkbox','action'])
                ->make(true);
        }
    }
	
	/*
	*
	* Function to change case role of lead from related contact section.
	*
	*/
	public function changeCaseRole(Request $request)
    {
		abort_if(Gate::denies('intake_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		$case_role = $request->case_role;
		if($request->ajax()) {
			if($lead_id>0 && is_array($case_role) && count($case_role)>0) {
				LeadCaseRole::where('intake_id',$lead_id)->delete();
				$data = []; 
				foreach($case_role as $case_role_id)
				{
					$data[] = [
							'intake_id'=>$lead_id,
							'case_role_id'=>$case_role_id
					];
				}
				$inserted = LeadCaseRole::insert($data);
				if($inserted) { 
					return response()->json([
						'status' => 'success',
						'message' => 'Case Role Updated Successfully'
					]);
				} else {
					return response()->json([
						'status' => 'success',
						'message' => 'Case Role Not Updated'
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
	* Function to export All Intake table records according to date range.
	*
	*/
	public function exportIntakes(Request $request)
    {
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$from = $request->from_date;
		$to = $request->to_date;
		
		$request->validate([
			'from_date' => 'required|date',
			'to_date' => 'required|date|after_or_equal:from_date',
		]);
		
		$model = new Intake;
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
		
		$query = Intake::select($columns)->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])->get()->map(function ($record) {
			$record->formated_created_at = Carbon::parse($record->created_at)->format('Y-m-d H:i:s');
			$record->formated_updated_at = Carbon::parse($record->updated_at)->format('Y-m-d H:i:s');
			return $record;
		});
		
		if($query)
		{
			$finalCsvDataArray=$query->toArray();
		}
		
		$Filename ='new_intake_list_'.date('Y-m-d').'_'.rand(10,100).'.csv';
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
	
	/*
	*
	* Function to get Lead List For Select Options.
	*
	*/
	public function getLeadForSelect2(Request $request)
	{
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$search = $request->input('q');
		
		$leads = Intake::with('contact')
			->whereHas('contact', function ($q) use ($search) {
				$q->where('display_name', 'like', "%{$search}%")
				  ->orWhere('first_name', 'like', "%{$search}%")
				  ->orWhere('middle_name', 'like', "%{$search}%")
				  ->orWhere('last_name', 'like', "%{$search}%")
				  ->orWhere('email', 'like', "%{$search}%");
			})
			->limit(20)
			->get();
			
		$formattedLeads = $leads->map(function ($lead) {
			$contact = @$lead->contact ?? null;
			$lead_text = '';
			if ($contact) {
				$lead_text = $contact->display_name ?? trim("{$contact->first_name} {$contact->last_name}");
			}
			
			return [
				'id' => $lead->id,
				'text' => "{$lead->id} | {$lead_text}",
			];
		});

		return response()->json($formattedLeads);
	}
	
	/*
	*
	* Function to get Update Intake Specific Fields.
	*
	*/
	public function updateField(Request $request)
    {
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
        $request->validate([
			'intake_id' => 'required|integer|exists:intakes,id',
            'field' => 'required|string',
            'value' => 'required'
		]);

        // Allowed fields to update (to prevent arbitrary column updates)
        $allowedFields = ['read_status', 'case_type', 'status', 'rating', 'owner', 'assignee'];

        if (!in_array($request->field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid field update request'
            ]);
        }

        try {
            $intake = Intake::findOrFail($request->intake_id);
            $intake->{$request->field} = $request->value;
            $intake->save();

            return response()->json([
                'success' => true,
                'message' => ucfirst(str_replace('_', ' ', $request->field)) . ' updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ]);
        }
    }
	
	/*
	*
	* Function to check Intake Specific Field Value.
	*
	*/
	public function selectedField(Request $request)
    {
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
        $request->validate([
			'intake_id' => 'required|integer|exists:intakes,id',
            'field' => 'required|string'
		]);

        // Allowed fields to update (to prevent arbitrary column updates)
        $allowedFields = ['read_status', 'case_type', 'status', 'rating', 'owner', 'assignee'];

        if (!in_array($request->field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid field request'
            ]);
        }

        try {
            $intake = Intake::findOrFail($request->intake_id);

            return response()->json([
                'success' => true,
                'message' => 'Data fetched successfully for ' . ucfirst(str_replace('_', ' ', $request->field)),
				'data' => ['field' => $request->field, 'value' => $intake->{$request->field}]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to Fetch Data: ' . $e->getMessage()
            ]);
        }
    }
}
