<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Models\LeadStatus;
use App\Models\CaseType;
use App\Models\LeadFollowUp;
use App\Models\LeadCommission;
use App\User;
use App\Models\{LeadSource, LeadContact, ContactFollowUp, LeadImages, Note};
use Carbon\Carbon;
use Gate;
use App\Models\Lead;
use App\Models\EmailTemplate;
use DB;
use Auth;
use App\Notifications\NewNotification;

class LeadInboxController extends Controller
{
	/*
	*
	* Display a listing of the Lead Inbox Data.
	*
	*/	
    public function index(Request $request)
	{	
		 
		// $user = User::find(1);
		// $user->notify(new NewNotification("📝 New task created for you!", 'The task icon appears on the left (depends on browser)', route('admin.taskList')));

		//Auth::logout();
 
		// $this->data['body'] = "
		// 	<p>Hello <strong>User</strong>,</p>
		// 	<p>We’re excited to share the latest updates with you.</p>
		// 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
		// 	Donec vel sapien vel nunc viverra sollicitudin.</p>
		// 	<p style='margin-top:20px;'>Best regards,<br><strong>Your Company Team</strong></p>
		// ";

		// return view('admin.emails.custom-email', $this->data);

		abort_if(Gate::denies('lead_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();

		

		$followups = LeadFollowUp::whereHas('lead', function ($q) {
			$q->whereNull('deleted_at')->forCurrentUser();
		})
		->with('lead')
        ->orderBy('date', 'desc')
        ->get();

		$this->data['upcoming'] = $followups->where('is_completed', 0);
		$this->data['past'] = $followups->where('is_completed', 1);

		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['leads'] = Lead::forCurrentUser()->get();

		 
		return view('admin.leads.index',$this->data);
	}
	
	public function listLeads(Request $request)
	{
		$query = Lead::with('getAssignUserName','leadSource','leadFollowUp','images')
			->whereNotIn('status', ['Sold'])
			->orderBy('id','DESC')
			->forCurrentUser();

		# filters
		if ($request->lead_source) {
			$query->where('lead_source', $request->lead_source);
		}

		if ($request->assign_rep !== null && $request->assign_rep !== '') {

			if ($request->assign_rep == 'unassigned') {
				$query->whereNull('assign_rep');
			} else {
				$query->where('assign_rep', $request->assign_rep);
			}
		}

		if ($request->status) {
			$query->where('status', $request->status);
		}


		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('lead_source', function ($lead) {
				return $lead->leadSource->source ?? '-';
			})

			->addColumn('name', function ($lead) {
				$name = $lead->first_name . ' ' . $lead->last_name;
			
				return '<a href="' . route('admin.leadDetails', $lead->id) . '">' . e($name) . '</a>';
			})

			->addColumn('salesRep', function ($lead) {
				return $lead->getAssignUserName->name ?? '';
			})

			// ->addColumn('created_at', function ($lead) {
			// 	return $lead->created_at
			// 		? $lead->created_at->format('m-d-Y')
			// 		: '';
			// })

			->addColumn('status', function ($lead) {

				$status = $lead->status ?? '';
			
				// status → color mapping (same as JS)
				$statusColors = [
					'New'               => 'primary',
					'Send Intro Email'  => 'info',
					'1st Attempt'       => 'warning',
					'2nd Attempt'       => 'warning',
					'3rd Attempt'       => 'warning',
					'Under Construction'=> 'secondary',
					'Qualified'         => 'success',
					'Lost'              => 'danger',
				];
			
				$color = $statusColors[$status] ?? 'secondary';
			
				return '
					<div class="d-flex align-items-center justify-content-end flex-wrap mb-2 gap-2">
						<span class="badge text-'.$color.' border border-'.$color.' rounded-pill px-2 py-1">
							'.$status.'
						</span>
					</div>
				';
			})

			->addColumn('address', function ($lead) {
				return trim(implode(', ', array_filter([
					$lead->address,
					$lead->suburb,
					$lead->state ? $lead->state . ' ' . $lead->postcode : $lead->postcode,
				])));
			})

			->addColumn('category', function ($lead) {

				$html = 'Category: <strong class="text-dark">'.($lead->category ?? '').'</strong>';
			
				// Solar KW condition
				if (
					in_array($lead->category, ['Solar', 'Solar+Battery']) &&
					!empty($lead->solar_kw)
				) {
					$html .= ' &nbsp;|&nbsp; Solar KW: 
						<strong class="text-dark">'.$lead->solar_kw.'</strong>';
				}
			
				// Battery KW condition
				if (
					in_array($lead->category, ['Battery', 'Solar+Battery']) &&
					!empty($lead->battery_kw)
				) {
					$html .= ' &nbsp;|&nbsp; Battery KW: 
						<strong class="text-dark">'.$lead->battery_kw.'</strong>';
				}
			
				return $html;
			})
			->addColumn('action', function ($lead) {

				$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
				$buttons = '<div class="">';
	
				// permission: lead_email_access
				if (auth()->user()->can('lead_email_access')) {
					$buttons .= '
						<button class="btn btn-sm btn-warning custom-btn send_email d-none"
							data-lead="'.$leadJson.'"
							data-bs-toggle="modal"
							data-bs-target="#emailModel">
							<i class="ph-envelope-simple"></i>
						</button>';
				}
	
				// view button (always visible)
				$buttons .= '
					<button class="btn btn-sm btn-primary view-lead d-none"
						data-lead="'.$leadJson.'"
						data-bs-toggle="modal"
						data-bs-target="#leadDetailsModal">
						<i class="ph-eye"></i>
					</button>
					<a href="'.route('admin.timeline',[$lead->id]).'"> <i class="ph-clock-counter-clockwise"></i></a>
					 
					';
	
				// permission: lead_edit
				if (auth()->user()->can('lead_edit')) {
					$buttons .= '
						<button class="btn btn-sm btn-outline-secondary edit_lead d-none"
							data-lead="'.$leadJson.'"
							data-bs-toggle="modal"
							data-bs-target="#editlead">
							<i class="ph-pencil-line"></i>
						</button> ';
				}
	
				$buttons .= '</div>';
	
				return $buttons;
			})
			->rawColumns(['status','category','action','name'])
			->make(true);
	}

	 

	public function listLeads_old(Request $request)
	{
		$limit = $request->limit ?? 10;
		$offset = $request->offset ?? 0;

		$query = Lead::with('getAssignUserName','leadSource','leadFollowUp')
			->withCount('leadFollowUp')
			->orderBy('id', 'desc')
			->whereNotIn('status', ['Qualified', 'Sold'])
			->forCurrentUser();

		# filters
		if ($request->lead_source) {
			$query->where('lead_source', $request->lead_source);
		}

		if ($request->assign_rep) {
			$query->where('assign_rep', $request->assign_rep);
		}

		if ($request->status) {
			$query->where('status', $request->status);
		}

		$leads = $query->skip($offset)->take($limit)->get();

		$totalRecords = $query->count();
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
				'category'   => 'nullable|string|max:255',
				'solar_kw'   => 'nullable|string|max:255',
				'battery_kw'   => 'nullable|string|max:255',
			]);

			// Check manually if phone or email exists
			$existingLead = Lead::where(function($q) use ($validated) {
				if (!empty($validated['phone'])) {
					$q->where('phone', $validated['phone']);
				}
				if (!empty($validated['email'])) {
					$q->orWhere('email', $validated['email']);
				}
			})->first();
			
			if ($existingLead) {
				$messages = [];
			
				if (!empty($validated['email']) && $existingLead->email === $validated['email']) {
					$messages[] = 'Email already exists';
				}
				if (!empty($validated['phone']) && $existingLead->phone === $validated['phone']) {
					$messages[] = 'Phone already exists';
				}
			
				// join messages with ' and '
				session()->flash('warning', implode(' and ', $messages) . '!');
				return redirect()->back();
			}

			// Create lead
			$lead = Lead::create($validated);

			return redirect()->back()->with('success', 'Lead created successfully!');
	}

	# update lead data
	public function updateStore(Request $request)
    {

			$lead = Lead::find($request->id);
			$lead->update($request->all());

			return redirect()->back()->with('success', 'You have successfully updated lead!');
	}

	# delete lead data
	public function deleteLead($id)
    {

			$lead = Lead::findOrFail($id);
			$lead->delete();

			return redirect()->back()->with('danger', 'You have successfully deleted!');
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
		 if(@$request->ftype == 'contact'){
			ContactFollowUp::create([
				'lead_id' => $request->lead_id,
				'type' => $request->type,
				'date' => $dateTime,   // store in one column
				'notes' => $request->notes,
			]);
		 }else{
			LeadFollowUp::create([
				'lead_id' => $request->lead_id,
				'type' => $request->type,
				'date' => $dateTime,   // store in one column
				'notes' => $request->notes,
			]);
		}
		

		return redirect()->back()->with('success', 'Follow-up saved successfully!');
	}

	 
	private function calculateIdleTime($created_at)
    {
		$now = Carbon::now();
		$created = Carbon::parse($created_at);
		return $created->diffForHumans($now, true); // e.g. "2 hours", "5 minutes" etc
	}


	public function updateLeadStatus(Request $request)
	{
		$request->validate([
			'id' => 'required|integer|exists:leads,id',
			'status' => 'required|string'
		]);

		$lead = Lead::findOrFail($request->id);
		$lead->status = $request->status;
		$lead->save();

		if ($request->status == 'Qualified') {
			$exists = LeadContact::where('lead_id', $lead->id)->exists();
		
			if (! $exists) {
				LeadContact::create([
					'lead_id' => $lead->id,
				]);
			}
		}

		session()->flash('success', 'You have successfully update lead status!');
		return response()->json(['success' => true]);
	}

	public function updateLeadStatusNew(Request $request)
	{
		$request->validate([
			'id' => 'required|integer|exists:leads,id',
			'status' => 'required|string'
		]);
		
		$lead = Lead::findOrFail($request->id);
		$lead->status = $request->status;
		$lead->save();

		if ($request->status == 'Qualified') {
			$exists = LeadContact::where('lead_id', $lead->id)->exists();
		
			if (! $exists) {
				LeadContact::create([
					'lead_id' => $lead->id,
				]);
			}
		}

		session()->flash('success', 'You have successfully updated!');
		return back();
	}


	public function updateContactStatus1(Request $request)
	{
		$request->validate([
			'id' => 'required|integer|exists:leads,id',
			'status' => 'required|string'
		]);
		
		$contact = LeadContact::findOrFail($request->id);
		$contact->status = $request->status;
		$contact->save();
 
		session()->flash('success', 'You have successfully updated!');
		return back();
	}


	public function followupComplete(Request $request){

        $id = $request->id;


		if(@$request->c_type == 'fup'){
			$followUp = ContactFollowUp::find($id);
		}else{
			$followUp = LeadFollowUp::find($id);
		}
        
        if (!$followUp) {
            return response()->json(['success' => false, 'message' => 'Follow-up not found.']);
        }

        # mark as completed
        $followUp->is_completed = 1;
        $followUp->save();
        session()->flash('success', 'You have successfully update status!');
        return response()->json(['success' => true]);

    }


	///////////////////////////////////////////////////// Contacts ///////////////////////////////////////////
	public function contacts(){
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();

		

		$followups = LeadFollowUp::with('lead')
        ->orderBy('date', 'desc')
        ->get();

		$this->data['upcoming'] = $followups->where('is_completed', 0);
		$this->data['past'] = $followups->where('is_completed', 1);

		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['leads'] = Lead::get();
		return view('admin.contact.index_table',$this->data);
	}


	public function listContact(Request $request)
	{
		$limit = $request->limit ?? 10; 
		$offset = $request->offset ?? 0;

		# base query
		$query = LeadContact::whereHas('lead', function ($q) {
			$q->whereNull('deleted_at')
			->whereNotIn('status', ['Sold'])
			->forCurrentUser();
		})
		->with([
				'lead.getAssignUserName',
				'lead.leadSource',
			])
			->withCount('followUp')
			->orderBy('id', 'desc');

		# apply search filter
		if ($request->filled('search_key')) {
			$search = $request->search_key;
		
			$query->whereHas('lead', function ($leadQuery) use ($search) {
				$leadQuery->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
						  ->orWhere('email', 'like', "%{$search}%")
						  ->orWhere('address', 'like', "%{$search}%")
						  ->orWhere('phone', 'like', "%{$search}%");
			});
		}
		

		# apply assign rep filter
		if ($request->filled('assign_rep')) {
			$query->whereHas('lead', function ($q) use ($request) {
				$q->where('assign_rep', $request->assign_rep);
			});
		}

		# apply lead source filter
		if ($request->filled('lead_source')) {
			$query->whereHas('lead', function ($q) use ($request) {
				$q->where('lead_source', $request->lead_source);
			});
		}

		# clone query for total count with filters
		$totalRecords = (clone $query)->count();

		# get paginated data
		$contacts = $query->skip($offset)
						->take($limit)
						->get();

		# check if more data exists for next load
		$hasMore = ($offset + $limit) < $totalRecords;

		# total followups count (global)
		$totalFollowups = \DB::table('lead_follow_ups')->count();

		return response()->json([
			'data' => $contacts,
			'hasMore' => $hasMore,
			'followupCount' => $totalFollowups
		]);
	}

	# for updateContact
	public function updateContact(Request $request)
	{
		$contact = LeadContact::find($request->id);
		$contact->update($request->all());
		return redirect()->back()->with('success', 'Contact updated successfully!');
	}

	public function contactFollowUp($leadId)
	{
		$followups = ContactFollowUp::with('lead')
		->where('lead_id',$leadId)
        ->orderBy('date', 'desc')
        ->get();

		$this->data['upcoming'] = $followups->where('is_completed', 0);
		$this->data['past'] = $followups->where('is_completed', 1);
		
		$html = view('admin.contact._listfollowup_modal',$this->data)->render();

    	return response()->json(['html' => $html]);

	}

	

	// /////////////////////////////For Salse ///////////////////////////
	public function sales(Request $request)
	{	
		 
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();

		$followups = LeadFollowUp::whereHas('lead', function ($q) {
			$q->whereNull('deleted_at')->forCurrentUser();
		})
		->with('lead')
        ->orderBy('date', 'desc')
        ->get();

		$this->data['upcoming'] = $followups->where('is_completed', 0);
		$this->data['past'] = $followups->where('is_completed', 1);

		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['leads'] = Lead::forCurrentUser()->get();

		$userRole = auth()->user()->roles[0]->title;
		$this->data['role'] = $userRole;
		//dd($userRole);
		$this->data['leads'] = Lead::forCurrentUser()->get();

		return view('admin.sales_new.index',$this->data);
	}

	# get sale where status is sold
	public function getSale_old(Request $request)
	{
		$limit = $request->limit ?? 10;
		$offset = $request->offset ?? 0;

		$query = Lead::with('getAssignUserName','leadSource','leadFollowUp')
			->withCount('leadFollowUp')
			->orderBy('id', 'desc')
			->whereIn('status', ['Sold'])
			->forCurrentUser();

		# filters
		if ($request->lead_source) {
			$query->where('lead_source', $request->lead_source);
		}

		if ($request->assign_rep) {
			$query->where('assign_rep', $request->assign_rep);
		}

		if ($request->status) {
			$query->where('status', $request->status);
		}

		if ($request->from_date && $request->to_date) {
			$query->whereBetween('created_at', [$request->from_date, $request->to_date]);
		}

		$leads = $query->skip($offset)->take($limit)->get();

		$totalRecords = $query->count();
		$hasMore = ($offset + $limit) < $totalRecords;

		$totalFollowups = \DB::table('lead_follow_ups')->count();

		
		$totalCommision = 0;
		$totalPayout = 0;

		foreach ($leads as $lead) {

				$getComm = LeadCommission::where('lead_id', $lead->id)
				->whereMonth('created_at', date('m'))
				->whereYear('created_at', date('Y'))
				->first();
			
				// if commission row not found → treat as 0
				$solar = $getComm->solar_commission ?? 0;
				$battery = $getComm->battery_commission ?? 0;
			
				$total = $solar + $battery;
			
				$lead->commission = $total;
				if($lead->sale_status != 'Cancelled'){
					$totalCommision += $total ?? 0;
				}

				if ($lead->sale_status == 'Installed') {
					$totalPayout += $total;
				}
			
		}


		//dd($totalCommission);

		return response()->json([
			'data' => $leads,
			'hasMore' => $hasMore,
			'totalCommision' => $totalCommision,
			'totalPayout' => $totalPayout,
			'followupCount' => $totalFollowups
		]);
	}

	public function getSale(Request $request)
	{
		$query = Lead::with('getAssignUserName','leadSource','leadFollowUp','images')
			->whereIn('status', ['Sold'])
			->orderBy('id','DESC')
			->forCurrentUser();

		# filters
		if ($request->lead_source) {
			$query->where('lead_source', $request->lead_source);
		}

		if ($request->assign_rep !== null && $request->assign_rep !== '') {

			if ($request->assign_rep == 'unassigned') {
				$query->whereNull('assign_rep');
			} else {
				$query->where('assign_rep', $request->assign_rep);
			}
		}

		if ($request->status) {
			$query->where('status', $request->status);
		}

		$totalCommision = 0;
		$totalPayout = 0;

		return DataTables::of($query)	
			->addIndexColumn()
			->addColumn('lead_source', function ($lead) {
				return $lead->leadSource->source ?? '-';
			})

			->addColumn('name', function ($lead) {

				$name = $lead->first_name . ' ' . $lead->last_name;
			
				$statusColor = '#ad8504';
			
				if ($lead->sale_status == 'Installed') {
					$statusColor = 'green';
				} elseif ($lead->sale_status == 'Cancelled') {
					$statusColor = 'red';
				}
			
				return '
					<a href="' . route('admin.salesDetails', $lead->id) . '">' . e($name) . '</a>
					<br>
					<span style="color:' . $statusColor . '; font-weight:600;">
						' . ($lead->sale_status ?? 'Pending') . '
					</span>
				';
			})
			 

			 
			->addColumn('salesRep', function ($lead) use ($totalCommision, $totalPayout) {

				$name = $lead->getAssignUserName->name ?? '';
			
				$getComm = LeadCommission::where('lead_id', $lead->id)
					->whereMonth('created_at', date('m'))
					->whereYear('created_at', date('Y'))
					->first();

				# if commission row not found → treat as 0
				$solar = $getComm->solar_commission ?? 0;
				$battery = $getComm->battery_commission ?? 0;

				$total = $solar + $battery;

				if ($lead->sale_status != 'Cancelled') {
					$totalCommision += $total;
				}

				if ($lead->sale_status == 'Installed') {
					$totalPayout += $total;
				}
			
				return '
					<a href="' . route('admin.salesDetails', $lead->id) . '">' . e($name) . '</a>
					<br>
					<span style="color:green;">
					💰 Commission: ₹' . $total . '
					</span>
				';
			})
			

			// ->addColumn('created_at', function ($lead) {
			// 	return $lead->created_at
			// 		? $lead->created_at->format('m-d-Y')
			// 		: '';
			// })

			->addColumn('status', function ($lead) {

				$status = $lead->status ?? '';
			
				// status → color mapping (same as JS)
				$statusColors = [
					'New'               => 'primary',
					'Send Intro Email'  => 'info',
					'1st Attempt'       => 'warning',
					'2nd Attempt'       => 'warning',
					'3rd Attempt'       => 'warning',
					'Under Construction'=> 'secondary',
					'Qualified'         => 'success',
					'Lost'              => 'danger',
				];
			
				$color = $statusColors[$status] ?? 'secondary';
			
				return '
					<div class="d-flex align-items-center justify-content-end flex-wrap mb-2 gap-2">
						<span class="badge text-'.$color.' border border-'.$color.' rounded-pill px-2 py-1">
							'.$status.'
						</span>
					</div>
				';
			})

			->addColumn('address', function ($lead) {
				return trim(implode(', ', array_filter([
					$lead->address,
					$lead->suburb,
					$lead->state ? $lead->state . ' ' . $lead->postcode : $lead->postcode,
				])));
			})

			->addColumn('category', function ($lead) {

				$html = 'Category: <strong class="text-dark">'.($lead->category ?? '').'</strong>';
			
				// Solar KW condition
				if (
					in_array($lead->category, ['Solar', 'Solar+Battery']) &&
					!empty($lead->solar_kw)
				) {
					$html .= ' &nbsp;|&nbsp; Solar KW: 
						<strong class="text-dark">'.$lead->solar_kw.'</strong>';
				}
			
				// Battery KW condition
				if (
					in_array($lead->category, ['Battery', 'Solar+Battery']) &&
					!empty($lead->battery_kw)
				) {
					$html .= ' &nbsp;|&nbsp; Battery KW: 
						<strong class="text-dark">'.$lead->battery_kw.'</strong>';
				}
			
				return $html;
			})
			->addColumn('action', function ($lead) {

				$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
				$buttons = '<div class="">';
	
				// permission: lead_email_access
				if (auth()->user()->can('lead_email_access')) {
					$buttons .= '
						<button class="btn btn-sm btn-warning custom-btn send_email d-none"
							data-lead="'.$leadJson.'"
							data-bs-toggle="modal"
							data-bs-target="#emailModel">
							<i class="ph-envelope-simple"></i>
						</button>';
				}
	
				// view button (always visible)
				$buttons .= '
					<button class="btn btn-sm btn-primary view-lead d-none"
						data-lead="'.$leadJson.'"
						data-bs-toggle="modal"
						data-bs-target="#leadDetailsModal">
						<i class="ph-eye"></i>
					</button>
					<a href="'.route('admin.timeline',[$lead->id]).'"> <i class="ph-clock-counter-clockwise"></i></a>
					 
					';
	
				// permission: lead_edit
				if (auth()->user()->can('lead_edit')) {
					$buttons .= '
						<button class="btn btn-sm btn-outline-secondary edit_lead d-none"
							data-lead="'.$leadJson.'"
							data-bs-toggle="modal"
							data-bs-target="#editlead">
							<i class="ph-pencil-line"></i>
						</button> ';
				}
	
				$buttons .= '</div>';
	
				return $buttons;
			})
			->rawColumns(['status','category','action','name','salesRep'])
			->with([
				'totalCommision' => $totalCommision,
				'totalPayout' => $totalPayout
			])
			->make(true);
	}

	public function zoomRecordings($id)
	{
		$getLead = Lead::find($id);
	
		// keep only digits and take last 9
		$phoneDigits = preg_replace('/\D/', '', $getLead->phone);
		$last9 = substr($phoneDigits, -9);
	
		$logs = DB::table('zoom_phone_recordings')
			->whereRaw("RIGHT(REGEXP_REPLACE(caller_number, '[^0-9]', ''), 9) = ?", [$last9])
			->orWhereRaw("RIGHT(REGEXP_REPLACE(callee_number, '[^0-9]', ''), 9) = ?", [$last9])
			->get();
	
		if ($logs->isEmpty()) {
			return response()->json([
				'success' => false,
				'logs' => [],
				'message' => 'No recordings found'
			]);
		}
	
		return response()->json([
			'success' => true,
			'logs' => $logs
		]);
	}

	/////////////////////////////FOr ZOOM/////////////////////////
	private function getAccessToken()
    {
        $clientId     = env('ZOOM_CLIENT_ID');
        $clientSecret = env('ZOOM_CLIENT_SECRET');
        $accountId    = env('ZOOM_ACCOUNT_ID');

        $response = Http::asForm()->withBasicAuth($clientId, $clientSecret)
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $accountId,
            ]);

        if ($response->failed()) {
            Log::error('Zoom Token Error: ' . $response->body());
            return null;
        }

        return $response->json()['access_token'];
    }


	public function audioUrl(Request $request)
	{
		$fullUrl = $request->input('full_url');
		$recordingId = $request->input('recording_id');

		if (empty($fullUrl)) {
			return response()->json(['error' => 'Missing full_url'], 400);
		}

		# if recording_id not passed, parse it from URL
		if (empty($recordingId)) {
			$recordingId = basename(parse_url($fullUrl, PHP_URL_PATH));
		}

		if (empty($recordingId)) {
			return response()->json(['error' => 'Cannot determine recording_id'], 400);
		}

		# get OAuth token
		$accessToken = $this->getAccessToken();
		if (!$accessToken) {
			return response()->json(['error' => 'Cannot get token'], 500);
		}

		# define file path
		$fileName = 'zoom_' . $recordingId . '.mp3';
		$filePath = public_path('audio/' . $fileName);
		$publicUrl = asset('audio/' . $fileName);

		# check DB & file
		$existing = DB::table('zoom_phone_recordings')
			->where('recording_id', $recordingId)
			->value('recording_url');

		if (!empty($existing) && file_exists(public_path(parse_url($existing, PHP_URL_PATH)))) {
			return response()->json(['url' => $existing]);
		}

		# download recording
		$response = Http::withToken($accessToken)
			->timeout(300)      // total request timeout: 5 minutes
		//	->readTimeout(300) 
			->sink($filePath)
			->get($fullUrl);

		if ($response->failed()) {
			return response()->json(['error' => 'Cannot fetch recording from Zoom'], 403);
		}

		# save/update DB entry
		DB::table('zoom_phone_recordings')->updateOrInsert(
			['recording_id' => $recordingId],
			['recording_url' => $publicUrl, 'updated_at' => now()]
		);

		return response()->json(['url' => $publicUrl]);
	}

	public function updateSalesStatus(Request $request)
	{
		$request->validate([
			'lead_id' => 'required',
			'status'  => 'nullable|string',
		]);
		
		$lead = Lead::find($request->lead_id);

		if(!$lead){
			return back()->with('error', 'Lead not found');
		}

		$lead->sale_status = $request->status;
		$lead->installed_date = now();
		$lead->save();

		//dd($lead);

		return back()->with('success', 'Sale status updated');
	}

	public function timeline($id){
		error_reporting(0);

		//dd(\Hash::make('password'));
		$this->data['lead'] = User::find(Auth::Id());
		$this->data['lData'] = Lead::find($id);

		if(!$this->data['lead']){
			return back()->with('error', 'Lead not found');
		}

		return view('admin.leads.timeline',$this->data);
	}

	// connectGmail

	public function connectGmail(){
		error_reporting(0);
		$this->data['lead'] = User::find(Auth::Id());

		if(!$this->data['lead']){
			return back()->with('error', 'Lead not found');
		}

		return view('admin.users.timeline',$this->data);
	}

	// Update lead note

	public function updateLeadNotes(Request $request)
	{
		$lead = Lead::findOrFail($request->lead_id);
		$lead->notes = $request->notes;
		$lead->save();

		return response()->json(['success' => true]);
	}


	public function leadImages(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|integer',
            'file'   => 'required|file|max:2048'
        ]);

        # get original file name
        $originalName = $request->file('file')->getClientOriginalName();

        # move file to public/fri_images
        $file = $request->file('file');
        $file->move(public_path('lead'), $originalName);

        # store in db
        $image = LeadImages::create([
            'lead_id'    => $request->lead_id,
            'image_path' => 'lead/' . $originalName
        ]);

		session()->flash('success', 'You have successfully added.');
        return response()->json([
            'file_name' => $originalName,
            'file_url'  => asset('lead/'.$originalName)
        ]);
    }

	public function deleteImages(Request $request)
	{
		DB::table($request->tble)
        ->where('id', $request->id)
        ->delete();
		session()->flash('warning', 'You have successfully deleted!');
		return response()->json([
			'status' => true,
			'message' => 'Deleted successfully'
		]);
	}


	// Lead details
	public function leadDetails($leadId){
		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();
		$this->data['lead'] = Lead::with('leadNotes.creator','getAssignUserName','leadSource','leadFollowUp','images')->findOrFail($leadId);
		//echo '<pre>';print_r($this->data['lead'] );die;
		return view('admin.leads.lead_details',$this->data);
	}
	// Contact details
	public function contactDetails($leadId){
		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();
		$this->data['lead'] = Lead::with('leadNotes.creator','getAssignUserName','leadSource','leadFollowUp','images','contact')->findOrFail($leadId);
		//echo '<pre>';print_r($this->data['lead'] );die;
		return view('admin.contact.contact_details',$this->data);
	}

	public function noteStore(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'note' => 'required'
        ]);

        Note::create([
            'lead_id' => $request->lead_id,
            'note' => $request->note,
            'created_by' => auth()->user()->id ?? 'System',
        ]);

        return back()->with('success', 'Note added successfully');
    }


	public function listLeadsContact(Request $request)
	{
		$query = Lead::with('getAssignUserName','leadSource','leadFollowUp','images','contact')
			->whereIn('status', ['Qualified'])
			->orderBy('id','DESC')
			->forCurrentUser();

		# filters
		if ($request->lead_source) {
			$query->where('lead_source', $request->lead_source);
		}

		if ($request->assign_rep !== null && $request->assign_rep !== '') {

			if ($request->assign_rep == 'unassigned') {
				$query->whereNull('assign_rep');
			} else {
				$query->where('assign_rep', $request->assign_rep);
			}
		}

		if ($request->status) {
			$query->whereHas('contact', function ($q) use ($request) {
				$q->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
			});
		}


		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('lead_source', function ($lead) {
				return $lead->leadSource->source ?? '-';
			})

			->addColumn('name', function ($lead) {
				$name = $lead->first_name . ' ' . $lead->last_name;
			
				return '<a href="' . route('admin.contactDetails', $lead->id) . '">' . e($name) . '</a>';
			})

			->addColumn('salesRep', function ($lead) {
				return $lead->getAssignUserName->name ?? '';
			})

			// ->addColumn('created_at', function ($lead) {
			// 	return $lead->created_at
			// 		? $lead->created_at->format('m-d-Y')
			// 		: '';
			// })

			->addColumn('status', function ($lead) {

				$status = $lead->contact->status ?? '';
			
				// status → color mapping (same as JS)
				$statusColors = [
					'pending' => 'warning',
					'getting proposal ready' => 'info',
					'proposal sent' => 'secondary',
					'follow up scheduled' => 'warning',
					'proposal accepted' => 'success',
					'lost' => 'danger',
				];
				
				$color = $statusColors[strtolower($status ?? '')] ?? 'secondary';
			
				return '
					<div class="d-flex align-items-center justify-content-end flex-wrap mb-2 gap-2">
						<span class="badge text-'.$color.' border border-'.$color.' rounded-pill px-2 py-1">
							'.ucwords(strtolower($status)).'
						</span>
					</div>
				';
			})

			->addColumn('address', function ($lead) {
				return trim(implode(', ', array_filter([
					$lead->address,
					$lead->suburb,
					$lead->state ? $lead->state . ' ' . $lead->postcode : $lead->postcode,
				])));
			})

			->addColumn('category', function ($lead) {

				$html = 'Category: <strong class="text-dark">'.($lead->category ?? '').'</strong>';
			
				// Solar KW condition
				if (
					in_array($lead->category, ['Solar', 'Solar+Battery']) &&
					!empty($lead->solar_kw)
				) {
					$html .= ' &nbsp;|&nbsp; Solar KW: 
						<strong class="text-dark">'.$lead->solar_kw.'</strong>';
				}
			
				// Battery KW condition
				if (
					in_array($lead->category, ['Battery', 'Solar+Battery']) &&
					!empty($lead->battery_kw)
				) {
					$html .= ' &nbsp;|&nbsp; Battery KW: 
						<strong class="text-dark">'.$lead->battery_kw.'</strong>';
				}
			
				return $html;
			})
			->addColumn('action', function ($lead) {

				$leadJson = htmlspecialchars(json_encode($lead), ENT_QUOTES, 'UTF-8');
				$buttons = '<div class="">';
	 
				// view button (always visible)
				$buttons .= '<a href="' . route('admin.contactDetails', $lead->id) . '"
					class="btn btn-sm btn-primary">
					<i class="ph-eye"></i>
				</a>';
				 
				$buttons .= '</div>';
	
				return $buttons;
			})
			->rawColumns(['status','category','action','name'])
			->make(true);
	}

	# Export csv lead
	public function exportLead(Request $request)
	{
		$query = Lead::with('getAssignUserName','leadSource','leadFollowUp','images');

		if($request->lead_source){
			$query->where('lead_source',$request->lead_source);
		}

		if($request->assign_rep == 'unassigned'){
			$query->whereNull('assign_rep');
		}elseif($request->assign_rep){
			$query->where('assign_rep',$request->assign_rep);
		}

		if($request->status){
			$query->where('status',$request->status);
		}

		if($request->from_date){
			$query->whereDate('created_at','>=',$request->from_date);
		}

		if($request->to_date){
			$query->whereDate('created_at','<=',$request->to_date);
		}

		$leads = $query->get();

		$filename = "leads.csv";

		$headers = [
			"Content-Type" => "text/csv",
			"Content-Disposition" => "attachment; filename=$filename",
		];

		$callback = function() use ($leads){

			$file = fopen('php://output','w');

			fputcsv($file,[
				'Lead Name',
				'Phone',
				'Email',
				'Address',
				'Status',
				'Lead Source',
				'Sales Rep',
				'Category Details',
				'Created At'
			]);

			foreach($leads as $lead){

				$name = trim(($lead->first_name ?? '').' '.($lead->last_name ?? ''));

				$address = trim(implode(', ', array_filter([
					$lead->address,
					$lead->suburb,
					$lead->state ? $lead->state.' '.$lead->postcode : $lead->postcode,
				])));

				# category text
				$categoryText = 'Category: '.($lead->category ?? '');

				# solar condition
				if(in_array($lead->category, ['Solar','Solar+Battery']) && !empty($lead->solar_kw)){
					$categoryText .= ' | Solar KW: '.$lead->solar_kw;
				}

				# battery condition
				if(in_array($lead->category, ['Battery','Solar+Battery']) && !empty($lead->battery_kw)){
					$categoryText .= ' | Battery KW: '.$lead->battery_kw;
				}

				fputcsv($file,[
					$name,
					$lead->phone,
					$lead->email,
					$address,
					$lead->status,
					$lead->leadSource->source ?? '-',
					$lead->getAssignUserName->name ?? '',
					$categoryText,
					$lead->created_at
				]);
			}

			fclose($file);
		};

		return response()->stream($callback,200,$headers);
	}

	# Sales details
	public function salesDetails($leadId){
		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();
		$this->data['lead'] = Lead::with('leadNotes.creator','getAssignUserName','leadSource','leadFollowUp','images')->findOrFail($leadId);
		//echo '<pre>';print_r($this->data['lead'] );die;

		$getComm = LeadCommission::where('lead_id', $leadId)
			->whereMonth('created_at', date('m'))
			->whereYear('created_at', date('Y'))
			->first();

		# if commission row not found → treat as 0
		$solar = $getComm->solar_commission ?? 0;
		$battery = $getComm->battery_commission ?? 0;

		$this->data['totalCommision'] = $solar + $battery;

		return view('admin.sales_new.lead_details',$this->data);
	}

}