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
use App\Models\{LeadSource, LeadContact, ContactFollowUp};
use Carbon\Carbon;
use Gate;
use App\Models\Lead;
use App\Models\EmailTemplate;
use DB;
use Auth;

class LeadInboxController extends Controller
{
	/*
	*
	* Display a listing of the Lead Inbox Data.
	*
	*/	
    public function index(Request $request)
	{	
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
			$q->whereNull('deleted_at');   // only leads that are not soft deleted
		})
		->with('lead')
        ->orderBy('date', 'desc')
        ->get();

		$this->data['upcoming'] = $followups->where('is_completed', 0);
		$this->data['past'] = $followups->where('is_completed', 1);

		$this->data['leadSource'] = LeadSource::where('status',1)->get();
		$this->data['emailTemplates'] = EmailTemplate::get();
		$this->data['leads'] = Lead::get();

		 
		return view('admin.leads.index',$this->data);
	}

	public function listLeads(Request $request)
{
    $limit = $request->limit ?? 10;
    $offset = $request->offset ?? 0;

    $query = Lead::with('getAssignUserName','leadSource','leadFollowUp')
        ->withCount('leadFollowUp')
        ->orderBy('id', 'desc');

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
			]);

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
			$q->whereNull('deleted_at');  // exclude soft-deleted leads
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


}