<?php

namespace App\Http\Controllers\Super;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use App\Models\LeadStatus;
use App\Models\CaseType;
use App\Models\LeadFollowUp;
use App\Models\LeadCommission;
use App\User;
use App\Models\{LeadSource, LeadContact, ContactFollowUp, LeadImages, LeadMeta};
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
			//->whereIn('status', ['Sold'])
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

		$customStatus = "";
		//dd($request->status);
		if ($request->status) {

			if (in_array('Lead', $request->status)) {
				// Leads → NOT Sold
				$query->where('status', '!=', 'Sold');
			}else if (in_array('Not Applied', $request->status)) {
				// Leads → NOT Sold
				$customStatus = $request->status;
				$query->where('status','Sold');
			} else {
				$query->whereIn('status', $request->status);
			}
		}


		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('lead_source', function ($lead) {
				return $lead->leadSource->source ?? '-';
			})

			->addColumn('name', function ($lead) use ($request){

				$name = $lead->first_name . ' ' . $lead->last_name;
				$url    = $request->url;
			
				return '<a href="' . route('superadmin.leadDetails', $lead->id) . '?url=' . urlencode($url) . '">' . e($name) . '</a>';
			})

			->addColumn('salesRep', function ($lead) {
				return $lead->getAssignUserName->name ?? '';
			})

			// ->addColumn('created_at', function ($lead) {
			// 	return $lead->created_at
			// 		? $lead->created_at->format('m-d-Y')
			// 		: '';
			// })

			->addColumn('status', function ($lead) use ($customStatus) {

				$status = (!empty($customStatus) && is_array($customStatus))
					? implode(', ', $customStatus)
					: trim($lead->status ?? '');
			
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
					'Not Applied'        => 'dark',      // unique
					'Awaiting Approval'  => 'warning',   // pending
					'Approved'           => 'success',
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
				if (auth('superadmin')->user()->can('lead_email_access')) {
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
				if (auth('superadmin')->user()->can('lead_edit')) {
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
		return view('admin.contact.index',$this->data);
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

	
	# get sale where status is sold
	public function getSale(Request $request)
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
		

		if(!$this->data['lead']){
			return back()->with('error', 'Lead not found');
		}

		return view('admin.leads.timeline',$this->data);
	}

	// connectGmail

	public function connectGmail(){
		error_reporting(0);
		$this->data['lead'] = User::find(auth('superadmin')->id());

		if(!$this->data['lead']){
			return back()->with('error', 'Lead not found');
		}

		return view('super.users.timeline',$this->data);
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
            'file'   => 'required|file|mimes:pdf,png,jpg,jpeg|max:10240'
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

		return response()->json([
			'status' => true,
			'message' => 'Deleted successfully'
		]);
	}

	public function leadDetails($leadId, Request $request){
		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();
		$this->data['lead'] = Lead::with('leadNotes.creator','getAssignUserName','leadSource','leadFollowUp','images','meta')->findOrFail($leadId);
		$this->data['leadMeta'] = $this->data['lead']->meta->pluck('meta_value', 'meta_key')->toArray();
		//echo '<pre>';print_r($this->data['lead'] );die;


		if($request->url == 'distributorApproval'){
			return view('super.leads.dist.lead_details',$this->data);

		}else if($request->url == 'vicRebate'){
			return view('super.leads.vic.lead_details',$this->data);

		}else if($request->url == 'complianceCheck'){
			return view('super.leads.comp.lead_details',$this->data);

		}else{
			return view('super.leads.lead_details',$this->data);
		}
		
	}

	public function saveDistributorApprovalMeta(Request $request)
	{
		$request->validate([
			'lead_id' => 'required|integer|exists:leads,id',
			'approval_required' => 'required|in:Yes,No',
			'distributor_name' => 'nullable|string|max:255',
			'existing_system' => 'required|in:Yes,No',
			'meter_number' => 'nullable|string|max:255',
			'nmi_number' => 'nullable|string|max:255',
			'photos_required' => 'nullable|in:Yes,No',
			'approval_file' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240',
			'status' => 'nullable|string',
		]);

		if ($request->approval_required === 'Yes' && empty($request->distributor_name)) {
			return response()->json([
				'status' => false,
				'message' => 'Please select distributor.',
			], 422);
		}

		$lead = Lead::findOrFail($request->lead_id);

		$metaData = [
			'distributor_approval_required' => $request->approval_required,
			'distributor_name' => $request->approval_required === 'Yes' ? $request->distributor_name : '',
			'existing_system' => $request->existing_system,
			'meter_number' => $request->approval_required === 'Yes' ? $request->meter_number : '',
			'nmi_number' => $request->approval_required === 'Yes' ? $request->nmi_number : '',
			'photos_required' => $request->approval_required === 'Yes' ? $request->photos_required : '',
		];

		foreach ($metaData as $metaKey => $metaValue) {
			LeadMeta::updateOrCreate(
				[
					'lead_id' => $lead->id,
					'meta_key' => $metaKey,
				],
				[
					'meta_value' => $metaValue,
					'meta_type' => 'text',
				]
			);
		}

		$fileUrl = null;
		if ($request->hasFile('approval_file')) {
			$file = $request->file('approval_file');
			$fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
			$file->move(public_path('lead/approval'), $fileName);
			$fileUrl = asset('lead/approval/' . $fileName);

			LeadMeta::updateOrCreate(
				[
					'lead_id' => $lead->id,
					'meta_key' => 'distributor_approval_file',
				],
				[
					'meta_value' => $fileUrl,
					'meta_type' => 'file',
				]
			);
		}

		if ($request->filled('status')) {
			$lead->status = $request->status;
			$lead->save();
		}

		return response()->json([
			'status' => true,
			'message' => 'Distributor approval data saved successfully.',
			'file_url' => $fileUrl,
		]);
	}

	public function saveVicRebateMeta(Request $request)
	{
		$request->validate([
			'lead_id' => 'required|integer|exists:leads,id',
			'status' => 'required|string|in:VIC REBATE NOT APPLIED,VIC REBATE AWAITING APPROVAL,COMPLIANCE NOT APPLIED',
			'customer_applying' => 'nullable|in:Yes,No',
			'ins_number' => 'nullable|string|max:255',
			'rebate_status' => 'nullable|string|max:255',
		]);

		$lead = Lead::findOrFail($request->lead_id);

		$metaData = [
			'vic_customer_applying' => $request->customer_applying ?? '',
			'vic_ins_number' => $request->ins_number ?? '',
			'vic_rebate_status' => $request->rebate_status ?? '',
		];

		foreach ($metaData as $metaKey => $metaValue) {
			LeadMeta::updateOrCreate(
				[
					'lead_id' => $lead->id,
					'meta_key' => $metaKey,
				],
				[
					'meta_value' => $metaValue,
					'meta_type' => 'text',
				]
			);
		}

		$lead->status = $request->status;
		$lead->save();

		return response()->json([
			'status' => true,
			'message' => 'Solar VIC rebate data saved successfully.',
		]);
	}


	// /////////////////////////////For Salse ///////////////////////////
	public function sales(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Sales Pipeline';
		$this->data['desc'] = 'Manage and track workflow progress';

		$this->data['lstatus'] =[]; // pass to blade

		$this->data['tabs'] = [
			'Leads' => ['Lead'],
			'Contacts' => ['Qualified'],
			'Sales'  => ['Sold'],
		];

		return view('super.leads.index', $this->data);
	}

	public function distributorApproval(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Distributor Approval';
		$this->data['desc'] = 'Manage and track workflow progress';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		$this->data['tabs'] = [
			'Not Applied' => ['Not Applied'],
			'Awaiting Approval' => ['Awaiting Approval'],
			//'Approved'  => ['Approved'],
		];

		return view('super.leads.index', $this->data);
	}

	public function vicRebate(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Solar VIC Rebate';
		$this->data['desc'] = 'Manage Solar VIC rebate applications and approvals';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		$this->data['tabs'] = [
			'Not Applied' => ['VIC REBATE NOT APPLIED'],
			'Awaiting Approval' => ['VIC REBATE AWAITING APPROVAL'],
			//'Approved'  => ['Approved'],
		];

		return view('super.leads.index', $this->data);
	}

	# complianceCheck

	public function complianceCheck(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Compliance Check';
		$this->data['desc'] = 'Manage and track workflow progress';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		$this->data['tabs'] = [
			'Not Applied' => ['COMPLIANCE NOT APPLIED'],
			'Awaiting Approval' => ['COMPLIANCE AWAITING APPROVAL'],
			//'Approved'  => ['Approved'],
		];

		return view('super.leads.index', $this->data);
	}

	# bookInstallation
	public function bookInstallation(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Book Installation';
		$this->data['desc'] = 'Manage and track workflow progress';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# customerPayment
	public function customerPayment(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Customer Payment';
		$this->data['desc'] = 'Manage and track workflow progress';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# coES
	public function coES(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Awaiting CoES';
		$this->data['desc'] = 'Manage and track workflow progress';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# vicPayment
	public function vicPayment(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Solar VIC Payment';
		$this->data['desc'] = 'Track Solar VIC rebate payments and claim processing';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# stcPayment
	public function stcPayment(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'STCs Payment';
		$this->data['desc'] = 'Track Small-scale Technology Certificate payments and processing';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# connectionPaperwork
	public function connectionPaperwork(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Connection Paperwork';
		$this->data['desc'] = 'Manage network connection applications and approvals';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# supplierPayment
	public function supplierPayment(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Supplier Payment';
		$this->data['desc'] = 'Track supplier invoices and payment processing';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# installerPayment
	public function installerPayment(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Installer Payment';
		$this->data['desc'] = 'Track installer payments based on CoES completion';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}

	# salesRepPayment
	public function salesRepPayment(Request $request)
	{
		$this->data = $this->commonLeadData();

		$this->data['title'] = 'Sales Rep Payment';
		$this->data['desc'] = 'Track sales representative commission payments';

		$this->data['lstatus'] = ['Sold']; // pass to blade

		return view('super.leads.index', $this->data);
	}


	private function commonLeadData()
	{
		$data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();

		$followups = LeadFollowUp::whereHas('lead', function ($q) {
			$q->whereNull('deleted_at');
		})
		->with('lead')
		->orderBy('date', 'desc')
		->get();

		$data['upcoming'] = $followups->where('is_completed', 0);
		$data['past'] = $followups->where('is_completed', 1);

		$data['leadSource'] = LeadSource::where('status',1)->get();
		$data['emailTemplates'] = EmailTemplate::get();
		$data['leads'] = Lead::forCurrentUser()->get();

		$data['role'] = auth('superadmin')->user()->roles[0]->title;

		return $data;
	}

	# Update lead status
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






}
