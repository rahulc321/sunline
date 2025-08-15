<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use App\Jobs\SendEmailJob;
use App\Models\EmailQueue;
use Illuminate\Support\Facades\Validator;
use App\Models\LeadCommunicationEmail;
use App\Models\LeadCommunicationTexts;
use App\Models\EmailStatus;
use App\Models\TextsStatus;
use App\Models\CampaignType;
use App\Models\Intake;
use App\Models\Contact;
use App\User;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class CommunicationsController extends Controller
{		
	/*
	*
	* Function to Show Compose Email Form.
	*
	*/	
    public function showComposeForm(Request $request)
    {
		abort_if(Gate::denies('intake_communications_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = @$request->lead ?? '';
		return view('admin.emails.compose-email', ['lead_id'=>$lead_id]);
    }
	
	/*
	*
	* Function to Compose Email Communications in a table.
	*
	*/
	public function composeEmail(Request $request)
	{
		abort_if(Gate::denies('intake_communications_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if($request->ajax()) {
			if($request->lead_id>0) {
				
				$email_status_id = EmailStatus::where('title', 'Queued')->value('id');
				
				$CampaignType = CampaignType::firstOrNew(['id' => 1]);
				
				$email = new LeadCommunicationEmail();
				$email->intake_id = @$request->lead_id ?? null;
				$email->user_id = auth()->user()->id;
				$email->email_status_id = $email_status_id;
				$email->campaign_type_id = $CampaignType->id;
				$email->from_email = ($request->from_email)?implode(',',User::where('id',$request->from_email)->pluck('email')->toArray()):'';
				$email->to_email = implode(',',User::whereIn('id',$request->input('to_email', []))->pluck('email')->toArray());
				$email->cc_email = implode(',',User::whereIn('id',$request->input('cc_email', []))->pluck('email')->toArray());
				$email->bcc_email = implode(',',User::whereIn('id',$request->input('bcc_email', []))->pluck('email')->toArray());
				$email->subject = $request->subject;
				$email->message = $request->message;
				$email->save();
				
				// Dispatch job to queue
				SendEmailJob::dispatch($email->id);
					
				Activity::log(
					'email_communications', 
					'create',   
					"Email Communication has been created with id - {$email->id}",
					[
						'details' => $email,
						'intake_id' => @$request->lead_id ?? null
					]	           
				);
	
				return response()->json([
					'status' => 'success',
					'message' => 'Email has been queued for sending!'
				]);
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
	* Function to List Queued Email.
	*
	*/
	public function emailQueue()
    {
		abort_if(Gate::denies('intake_communications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = @$request->lead ?? '';
        $emails = LeadCommunicationEmail::with('email_status')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.emails.queue', ['emails'=>$emails, 'lead_id'=>$lead_id]);
    }
	
	/*
	*
	* Function to Resend Email.
	*
	*/
    public function resendEmail($id)
    {
		abort_if(Gate::denies('intake_communications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
        $emailQueue = LeadCommunicationEmail::findOrFail($id);
        
        // Reset status to pending
		$email_status_id = EmailStatus::where('title', 'Pending')->value('id');
        $emailQueue->update(['email_status_id' => $email_status_id, 'error_message' => null]);
        
        // Dispatch job again
        SendEmailJob::dispatch($emailQueue->id);
        
        return redirect()->back()->with('success', 'Email has been queued for resending!');
    }
	
	/*
	*
	* Function to Fetch Communications Email List.
	*
	*/	
    public function leadCommunicationsEmailList(Request $request)
    {
		abort_if(Gate::denies('intake_communications_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$search = $request->get('search_communications');
		
		if($request->ajax()) {
			$query = LeadCommunicationEmail::query();
			if ($lead_id) {
				$query->where('intake_id', $lead_id);
			}
			if (!empty($search)) {
				$query->where(function ($q) use ($search) {
					$q->where('from_email', 'like', "%{$search}%")
					  ->orWhere('to_email', 'like', "%{$search}%")
					  ->orWhere('cc_email', 'like', "%{$search}%")
					  ->orWhere('bcc_email', 'like', "%{$search}%")
					  ->orWhere('subject', 'like', "%{$search}%")
					  ->orWhere('message', 'like', "%{$search}%");
				});
			}
			
			return DataTables::of($query)
				->editColumn('communications_date', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->editColumn('status', function ($row) {
					return @$row->email_status->title ?? '';
				})
				->editColumn('campaign_type', function ($row) {
					return @$row->campaign_type->title ?? '';					
				})				
				->rawColumns(['communications_date'])
				->make(true);
		}
    }
	
}