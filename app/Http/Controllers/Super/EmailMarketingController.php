<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LeadCommunicationEmail;
use App\Models\CaseType;
use App\Models\LeadStatus;
use App\Models\IntakeValues;
use App\Models\EmailCampaign;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Gate;

class EmailMarketingController extends Controller
{
	/*
	*
	* Email Marketing List.
	*
	*/	
    public function index(Request $request)
    {
		abort_if(Gate::denies('email_marketing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		return view('admin.email-marketing.index');
    }
	
	/*
	*
	* Create Email Campaign.
	*
	*/	
    public function createEmailCampaign(Request $request)
    {
		abort_if(Gate::denies('email_marketing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		// Load all dropdown-type values and group by 'type'
		$intake_values = IntakeValues::all()->groupBy('type');

		// Add additional dropdowns to the intake_values array
		$additionalDropdowns = [
			'case_type'             => CaseType::pluck('title', 'id'),
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
		];
		
		foreach ($additionalDropdowns as $key => $values) {
			$intake_values[$key] = $values;
		}
		
		return view('admin.email-marketing.instant-email-campaign',[
				'intake_values' => $intake_values,
			]);
    }
	
	/*
	*
	* Store Email Marketing.
	*
	*/	
	public function store(Request $request)
	{
		$request->merge([
			'filter_case_type'      => array_filter((array) $request->filter_case_type, 'is_numeric'),
			'filter_current_status' => array_filter((array) $request->filter_current_status, 'is_numeric'),
			'filter_tags'           => array_filter((array) $request->filter_tags, 'is_numeric'),
			'filter_source'         => array_filter((array) $request->filter_source, 'is_numeric'),
			'is_all_date'           => $request->boolean('is_all_date'),
		]);


		$validated = $request->validate([
			'filter_campaign_name'   => 'required|string|max:255',
			'filter_case_type'       => 'nullable|array',
			'filter_case_type.*'     => 'nullable|integer|exists:case_types,id',
			'filter_current_status'  => 'nullable|array',
			'filter_current_status.*'=> 'nullable|integer|exists:lead_status,id',
			'filter_unsent_campaign' => 'nullable|string',
			'filter_from'            => 'nullable|date',
			'filter_to'              => 'nullable|date',
			'is_all_date'            => 'boolean',
			'filter_tags'            => 'nullable|array',
			'filter_tags.*'          => 'nullable|integer|exists:tags,id',
			'filter_source'          => 'nullable|array',
			'filter_source.*'        => 'nullable|integer|exists:intake_values,id',
			'filter_email_come_from' => 'nullable|string',
		]);

		$campaign = EmailCampaign::create([
			'campaign_name'    => $validated['filter_campaign_name'],
			'campaign_type_id' => $request->filter_unsent_campaign,
			'from_date'        => $request->filter_from,
			'to_date'          => $request->filter_to,
			'is_all_date'      => $validated['is_all_date'],
			'email_come_from'  => $request->filter_email_come_from,
		]);

		// Sync relationships
		$campaign->case_types()->sync($validated['filter_case_type'] ?? []);
		$campaign->lead_status()->sync($validated['filter_current_status'] ?? []);
		$campaign->tags()->sync($validated['filter_tags'] ?? []);
		$campaign->marketing_source()->sync($validated['filter_source'] ?? []);

		return response()->json([
			'success' => true,
			'message' => 'Email campaign created successfully',
			'data'    => $campaign->load('case_types', 'lead_status', 'tags', 'marketing_source')
		]);
	}


	
	/*
	*
	* Function to Fetch Email Marketing Data List.
	*
	*/	
    public function getEmailMarketingList(Request $request)
    {
		abort_if(Gate::denies('email_marketing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
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
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox" value="'.$row->id.'">';
				})
				->addColumn('campaign_type', function ($row) {
					return @$row->campaign_type->title ?? '';					
				})
				->addColumn('datetime_edited', function ($row) {
					return $row->updated_at ? Carbon::parse($row->updated_at)->format('Y-m-d') : '';
				})
				->addColumn('datetime_sent', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->addColumn('of_recipients', function ($row) {
					return '';					
				})	
				->addColumn('sent', function ($row) {
					return '';
				})
				->addColumn('viewed', function ($row) {
					return '';
				})
				->addColumn('viewed_percentage', function ($row) {
					return '';
				})
				->addColumn('clicked', function ($row) {
					return '';
				})
				->addColumn('clicked_percentage', function ($row) {
					return '';
				})
				->rawColumns(['datetime_edited', 'datetime_sent'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to get Counts For sent, viewed, clicked and their % for Lead Email Communication.
	*
	*/	
	public function getEmailMarketingSummary(Request $request)
	{
		$from = $request->input('filter_from');
		$to = $request->input('filter_to');

		$query = LeadCommunicationEmail::with('email_status');

		if ($from && $to) {
			$query->whereBetween('created_at', [$from, $to]);
		}
		
		$emails = $query->get();

		$totalSent = $emails->count();

		$totalViewed = $emails->filter(function ($email) {
			return optional($email->email_status)->title === 'Viewed';
		})->count();

		$totalClicked = $emails->filter(function ($email) {
			return optional($email->email_status)->title === 'Clicked';
		})->count();

		$viewedPercent = $totalSent > 0 ? round(($totalViewed / $totalSent) * 100, 2) : 0;
		$clickedPercent = $totalSent > 0 ? round(($totalClicked / $totalSent) * 100, 2) : 0;

		return response()->json([
			'sent' => $totalSent,
			'viewed' => $totalViewed,
			'viewed_percent' => $viewedPercent,
			'clicked' => $totalClicked,
			'clicked_percent' => $clickedPercent,
		]);
	}
}