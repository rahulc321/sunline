<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use App\Models\LeadStatus;
use App\Models\CaseType;
use App\Models\LeadFollowUp;
use App\User;
use App\Models\LeadSource;
use Carbon\Carbon;
use Gate;
use App\Models\Lead;

class LeadInboxController extends Controller
{
	/*
	*
	* Display a listing of the Lead Inbox Data.
	*
	*/	
    public function index(Request $request)
	{
		abort_if(Gate::denies('lead_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', 'User');
		})->get();

		//dd($this->data['users']);

		$followups = LeadFollowUp::with('lead')
        ->orderBy('date', 'desc')
        ->get();

		$this->data['upcoming'] = $followups->where('date', '>=', now());
		$this->data['past'] = $followups->where('date', '<', now());

		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		
		return view('admin.leads.index',$this->data);
	}

	public function listLeads(Request $request)
	{
		$limit = $request->limit ?? 1; // limit per request
		$offset = $request->offset ?? 0;

		# fetch current batch
		$leads = Lead::with('getAssignUserName','leadSource','leadFollowUp')->orderBy('id', 'desc')
		->withCount('leadFollowUp')	
		->skip($offset)
			->take($limit)
			->get();

		# check if more data exists for next load
		$totalRecords = Lead::count();
		$hasMore = ($offset + $limit) < $totalRecords;

		$totalFollowups = \DB::table('lead_follow_ups')->count();

		return response()->json([
			'data' => $leads,
			'hasMore' => $hasMore,
			'followupCount' => $totalFollowups
		]);
	}


	public function leadStore(Request $request)
    {
			// Validate incoming request
			$validated = $request->validate([
				'first_name'            => 'nullable|string|max:255',
				'last_name'             => 'nullable|string|max:255',
				'email'                 => 'nullable|email|max:255',
				'phone'                 => 'nullable|string|max:20',
				'address'               => 'nullable|string|max:255',
				'assign_rep'            => 'nullable|string|max:255',
				'lead_source'           => 'nullable|string|max:255',
				'roof_type'             => 'nullable|string|max:255',
				'elogible_for_rebate'   => 'nullable|string|max:255',
			]);

			// Create lead
			$lead = Lead::create($validated);

			return redirect()->back()->with('success', 'Lead created successfully!');
	}


	public function leadFollowUps(Request $request)
	{
		$request->validate([
			'type' => 'required|string',
			'date' => 'required|date',
			'time' => 'required',
			'notes' => 'nullable|string',
		]);

		# merge date + time into one datetime string
		$dateTime = $request->date . ' ' . $request->time;
		 
		LeadFollowUp::create([
			'lead_id' => $request->lead_id,
			'type' => $request->type,
			'date' => $dateTime,   // store in one column
			'notes' => $request->notes,
		]);

		return redirect()->back()->with('success', 'Follow-up saved successfully!');
	}

	


	
	/*
	*
	* Function to Fetch All Lead Inbox Data.
	*
	*/	
    public function getLeadInboxList(Request $request)
    {
		abort_if(Gate::denies('intake_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if($request->ajax()) {
			$isNewInquiries = $request->isNewInquiries;
			$data = Intake::query();
			if($isNewInquiries == true) {
				$data = $data->where('read_status', 'unread');
			}
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox"value="'.$row->id.'">';
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
				->editColumn('read_status', function ($row) {
					$row->read_status = $row->read_status ?? 'unread';
					$status = '<div class="dropdown ms-2">';
					$status = $status . '<a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="far fa-ellipsis-h ph-dots-three"></i>
					</a>';
					$status = $status . '<div class="dropdown-menu dropdown-menu-end" style="">';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="add_note">
						<i class="far fa-sticky-note ph-note-blank me-2"></i>
						Add Note
					</button>';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="mark_read">
						<i class="far fa-envelope-open-text ph-envelope-open me-2"></i>
						Mark Read
					</button>';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="mark_unread">
						<i class="far fa-envelope ph-envelope me-2"></i>
						Mark UnRead
					</button>';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="change_case_type">
						<i class="far fa-briefcase ph-briefcase me-2"></i>
						Case Type
					</button>';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="change_status">
						<i class="far fa-circle-notch ph-circle-notch me-2"></i>
						Status
					</button>';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="change_rating">
						<i class="far fa-star ph-star me-2"></i>
						Change Rating
					</button>';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="change_owner">
						<i class="far fa-user ph-user me-2"></i>
						Owner
					</button>';
					
					$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="change_assignee" >
						<i class="far fa-user-circle ph-user-circle me-2"></i>
						Assignee
					</button>';
					
					if(!Gate::denies('intake_access'))
					{	
						$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="transfer_record" >
							<i class="far fa-exchange-alt ph-swap me-2"></i>
							Transfer Record
						</button>';
					}
					
					if(!Gate::denies('intake_tasks_create'))
					{	
						$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="add_task" >
							<i class="far fa-check ph-check me-2"></i>
							Add Task
						</button>';
					}
					
					if(!Gate::denies('intake_delete'))
					{	
						$status = $status . '<button type="button" class="dropdown-item delete-btn" data-id="'.$row->id.'">
							<i class="far fa-trash ph-trash me-2"></i>
							Delete
						</button>';
					}
					
					/* $status = $status . '<div class="dropdown-divider"></div>'; */
					
					if(!Gate::denies('intake_access'))
					{	
						$status = $status . '<button type="button" class="dropdown-item open-change-modal" data-id="'.$row->id.'" data-modal_type="lock">
							<i class="far fa-lock ph-lock me-2"></i>
							Lock
						</button>';
					}
					
                    $status = $status . '</div>';
					$status = $status . '</div>';
					
					$read_status = $row->read_status=='read' ? '<i class="fas fa-fw fa-envelope-open ph-envelope-open open-change-modal" title="read" data-id="'.$row->id.'" data-modal_type="mark_unread" ></i>' : '<i class="fas fa-fw fa-envelope ph-envelope open-change-modal" title="unread" data-id="'.$row->id.'" data-modal_type="mark_read" ></i>';
					return '<div class="d-flex justify-content-end align-items-center">'.$status.'<div class="mx-1">'.$read_status.'</div></div>';
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
				->addColumn('phone', function ($row) {
					$phone='';
					if($row->contact) {
						$phone = $row->contact->phone ? $row->contact->phone : '';
					}
					return $phone;
				})
				->editColumn('marketing_source', function ($row) {
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
				->addColumn('idle_time', function ($row) {
					return $this->calculateIdleTime($row->created_at);
				})
				->editColumn('created_at', function ($row) {
					return $row->created_at->format('Y-m-d H:i:s');
				})
				->rawColumns(['checkbox','idle_time','read_status','first_name','last_name'])
				->make(true);
		}
    }
	
	private function calculateIdleTime($created_at)
    {
		$now = Carbon::now();
		$created = Carbon::parse($created_at);
		return $created->diffForHumans($now, true); // e.g. "2 hours", "5 minutes" etc
	}
}