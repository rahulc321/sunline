<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use App\Models\Intake;
use App\Models\IntakeValues;
use App\Models\LeadStatus;
use App\Models\CaseType;
use App\User;
use Carbon\Carbon;
use Gate;

class AdvancedSearchController extends Controller
{
	/*
	*
	* Advance Search Form and List.
	*
	*/	
    public function index(Request $request)
    {
		abort_if(Gate::denies('advanced_search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$intake_values = [
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
			'case_type'             => CaseType::pluck('title', 'id'),
		];
		
		$staticDropdowns = [
			'users'         => User::all()->pluck('name', 'id'),
		];
		
		return view('admin.advanced-search.index', array_merge(
			[
				'intake_values' => $intake_values,
			],
			$staticDropdowns
		));
    }
	
	/*
	*
	* Function to Fetch Advanced Search Data List.
	*
	*/	
    public function getAdvancedSearchList(Request $request)
    {
		abort_if(Gate::denies('advanced_search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if($request->ajax()) {
			$query = Intake::with(['contact','contact.addresses'])->select('intakes.*');
			if ($request->filled('filter_lead')) {
				if ($request->filter_lead === 'closed') {
					$query->whereHas('status_value', function ($q) {
						$q->where('title', 'Closed');
					});
				} elseif ($request->filter_lead === 'open') {
					$query->whereHas('status_value', function ($q) {
						$q->where('title', '!=', 'Closed');
					});
				}
			}
			
			// Other Filters
			if ($request->filled('filter_user')) {
				$query->where(function ($query) use ($request) {
					$query->whereHas('assignee_value', function ($q) use ($request) {
						$q->where('id', $request->filter_user);
					})->orWhereHas('owner_value', function ($q) use ($request) {
						$q->where('id', $request->filter_user);
					});
				});
			}

			if ($request->filled('filter_firm')) {
				//$query->where('firm_id', $request->filter_firm);
			}

			if ($request->filled('filter_case_id')) {
				$query->where('case_type', $request->filter_case_id);
			}

			if ($request->filled('filter_case_name')) {
				$query->whereHas('case_type_value', function ($q) use ($request) {
					$q->where('title', 'like', '%' . $request->filter_case_name . '%');
				});
			}
			
			if ($request->filled('filter_sol_date')) {
				//$query->where('filter_sol_date', $request->filter_sol_date);
			}
			
			// Filters from `intakes` table
			if ($request->filled('filter_lead_id')) {
				$query->where('id', $request->filter_lead_id);
			}
			
			if ($request->filled('filter_case_type')) {
				$query->where('case_type', $request->filter_case_type);
			}

			if ($request->filled('filter_status')) {
				$query->where('status', $request->filter_status);
			}

			if ($request->filled('filter_attorney')) {
				$query->where('attorney', $request->filter_attorney);
			}

			if ($request->filled('filter_office_location')) {
				$query->where('office_location', $request->filter_office_location);
			}

			if ($request->filled('filter_from')) {
				$query->whereDate('created_at', '>=', $request->filter_from);
			}

			if ($request->filled('filter_to')) {
				$query->whereDate('created_at', '<=', $request->filter_to);
			}
			
			// Filters from related `contacts` table
			if ($request->filled('filter_first_name')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('first_name', 'like', '%' . $request->filter_first_name . '%'));
			}

			if ($request->filled('filter_middle_name')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('middle_name', 'like', '%' . $request->filter_middle_name . '%'));
			}

			if ($request->filled('filter_last_name')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('last_name', 'like', '%' . $request->filter_last_name . '%'));
			}

			if ($request->filled('filter_suffix')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('suffix', 'like', '%' . $request->filter_suffix . '%'));
			}

			if ($request->filled('filter_gender')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('gender', $request->filter_gender));
			}

			if ($request->filled('filter_primary_email')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('email', 'like', '%' . $request->filter_primary_email . '%'));
			}

			if ($request->filled('filter_secondary_email')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('secondary_email', 'like', '%' . $request->filter_secondary_email . '%'));
			}

			if ($request->filled('filter_home_phone')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('home_phone', 'like', '%' . $request->filter_home_phone . '%'));
			}

			if ($request->filled('filter_business_phone')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('work_phone', 'like', '%' . $request->filter_business_phone . '%'));
			}

			if ($request->filled('filter_cell_phone')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('phone', 'like', '%' . $request->filter_cell_phone . '%'));
			}

			if ($request->filled('filter_where_to_contact')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('contact_preference', 'like', '%' . $request->filter_where_to_contact . '%'));
			}

			if ($request->filled('filter_when_to_contact')) {
				$query->whereHas('contact', fn($q) =>
					$q->where('whentocontact', 'like', '%' . $request->filter_when_to_contact . '%'));
			}

			if ($request->filled('filter_date_of_birth')) {
				$query->whereHas('contact', fn($q) =>
					$q->whereDate('dob', $request->filter_date_of_birth));
			}
			
			// Filters from related `contact_address` and `address` table
			if ($request->filled('filter_city')) {
				$query->whereHas('contact.addresses', function ($q) use ($request) {
					$q->where('city', 'like', '%' . $request->filter_city . '%');
				});
			}
			
			if ($request->filled('filter_state')) {
				$query->whereHas('contact.addresses', function ($q) use ($request) {
					$q->where('state_id', $request->filter_state);
				});
			}
			
			if ($request->filled('filter_zip')) {
				$query->whereHas('contact.addresses', function ($q) use ($request) {
					$q->where('zip', 'like', '%' . $request->filter_zip . '%');
				});
			}
			
			if ($request->filled('filter_country')) {
				$query->whereHas('contact.addresses', function ($q) use ($request) {
					$q->where('country_id', $request->filter_country);
				});
			}
			
			return DataTables::of($query)
				->addIndexColumn()
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox"value="'.$row->id.'">';
				})
				->addColumn('first_name', function ($row) {
					$first_name='';
					if($row->contact) {
						$first_name = $row->contact->first_name ? $row->contact->first_name : '';
					}
					return '<a href="'.route('admin.intakes.edit', $row->id) .'" >'.$first_name.'</a>';
				})
				->addColumn('last_name', function ($row) {
					$last_name='';
					if($row->contact) {
						$last_name = $row->contact->last_name ? $row->contact->last_name : '';
					}
					return '<a href="'.route('admin.intakes.edit', $row->id) .'" >'.$last_name.'</a>';
				})
				->addColumn('created', function ($row) {
					return $row->created_at->format('Y-m-d H:i:s');
				})
				->addColumn('source', function ($row) {
					$marketing_source_value='';
					if($row->marketing_source_value) {
						$marketing_source_value = $row->marketing_source_value->value ? $row->marketing_source_value->value : '';
					}
					return $marketing_source_value;
				})
				->editColumn('status', function ($row) {
					$status_value='';
					if($row->status_value) {
						$status_value = $row->status_value->title ? $row->status_value->title : '';
					}
					return $status_value;
				})
				->editColumn('case_type', function ($row) {
					$case_type_value='';
					if($row->case_type_value) {
						$case_type_value = $row->case_type_value->title ? $row->case_type_value->title : '';
					}
					return $case_type_value;
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
					else {
						$owner_value = $row->user ? $row->user->name : 'System';
					}
					return $owner_value;
				})			
				->rawColumns(['checkbox','first_name','last_name'])
				->make(true);
		}
    }
}