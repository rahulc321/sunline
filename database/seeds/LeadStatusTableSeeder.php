<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadStatus;

class LeadStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		LeadStatus::create([
			'title' => 'BO Uploaded Signed Retainer Contract (Wet Signature)',
		]);
		LeadStatus::create([
			'title' => 'BO Mailed Out Retainer Contract for Wet Signature',
		]);
		LeadStatus::create([
			'title' => 'Client Req - BO Send Retainer for Wet Signature',
		]);
		LeadStatus::create([
			'title' => 'Signed Retainer Contract (E-Signature)',
		]);
		LeadStatus::create([
			'title' => 'New Lead-PPC-Call ASAP',
		]);
		LeadStatus::create([
			'title' => 'New Lead (High Cost) - Live Call - Call ASAP',
		]);
		LeadStatus::create([
			'title' => 'Converted to Case - Approved (CDCMS)',
		]);
		LeadStatus::create([
			'title' => 'New Lead - Live Call - Call ASAP',
		]);
		LeadStatus::create([
			'title' => 'New Lead - Form Leads - Call Back within 5 Mins',
		]);
		LeadStatus::create([
			'title' => 'New Lead - Duplicate/Conflict Check Failed',
		]);
		LeadStatus::create([
			'title' => 'New Lead-Possible Duplicate',
		]);
		LeadStatus::create([
			'title' => 'Start Retainer Verification',
		]);
		LeadStatus::create([
			'title' => 'Potential Future Client',
		]);
		LeadStatus::create([
			'title' => 'New Call',
		]);
		LeadStatus::create([
			'title' => 'Final Intake Review',
		]);
		LeadStatus::create([
			'title' => 'Mailed Paper Retainer',
		]);
		LeadStatus::create([
			'title' => 'Unable to Reach - High Value',
		]);
		LeadStatus::create([
			'title' => 'New Lead - Pre Screen within 2 Mins',
		]);
		LeadStatus::create([
			'title' => 'Contacted',
		]);
		LeadStatus::create([
			'title' => 'Awaiting Contact',
		]);
		LeadStatus::create([
			'title' => 'New Opportunity',
		]);
		LeadStatus::create([
			'title' => 'Awaiting Docs',
		]);
		LeadStatus::create([
			'title' => 'Contact Attempted',
		]);
		LeadStatus::create([
			'title' => 'Cancelled E-Sign',
		]);
		LeadStatus::create([
			'title' => 'Additional Contact',
		]);
		LeadStatus::create([
			'title' => 'Converted to Case - Pending Approval UDPATE',
		]);
		LeadStatus::create([
			'title' => 'Case Filed',
		]);
		LeadStatus::create([
			'title' => 'Under Review',
		]);
		LeadStatus::create([
			'title' => 'Closed',
		]);
		LeadStatus::create([
			'title' => 'Converted to Case - Approved',
		]);
		LeadStatus::create([
			'title' => 'New Lead',
		]);
		LeadStatus::create([
			'title' => 'Disqualified',
		]);
		LeadStatus::create([
			'title' => 'Warehoused',
		]);
		LeadStatus::create([
			'title' => 'Reopened - Case Conversion Denied',
		]);
		LeadStatus::create([
			'title' => 'Order Medical Records',
		]);
		LeadStatus::create([
			'title' => 'Rejected',
		]);
		LeadStatus::create([
			'title' => 'Rescheduled Appointment',
		]);
		LeadStatus::create([
			'title' => 'Requested E- Book',
		]);
		LeadStatus::create([
			'title' => 'Rejected by Lead',
		]);
		LeadStatus::create([
			'title' => 'Intake Questionnaire Emailed',
		]);
		LeadStatus::create([
			'title' => 'Intake Questionnaire Completed',
		]);
		LeadStatus::create([
			'title' => 'Intake Under Review',
		]);
		LeadStatus::create([
			'title' => 'Review Medical Records',
		]);
		LeadStatus::create([
			'title' => 'Appointment Cancelled',
		]);
		LeadStatus::create([
			'title' => 'Converted to Case',
		]);
		LeadStatus::create([
			'title' => 'Converted to Case – Failed',
		]);
		LeadStatus::create([
			'title' => 'Appointment Confirmed',
		]);
		LeadStatus::create([
			'title' => 'Scheduled Appointment',
		]);
		LeadStatus::create([
			'title' => 'Sent Retainer Contract',
		]);
		LeadStatus::create([
			'title' => 'Sent to Referral Firm',
		]);
		LeadStatus::create([
			'title' => 'Signed Retainer Contract',
		]);
		LeadStatus::create([
			'title' => 'Unable to Reach',
		]);
		LeadStatus::create([
			'title' => 'Converted to CoCounselor',
		]);
		LeadStatus::create([
			'title' => 'Converted to CoCounselor - Failed',
		]);
		LeadStatus::create([
			'title' => 'Converted to Prospect',
		]);
		LeadStatus::create([
			'title' => 'Converted to Prospect - Failed',
		]);
		LeadStatus::create([
			'title' => 'Reschedule Requested',
		]);
		LeadStatus::create([
			'title' => 'Convert to Needles Intake Failed',
		]);
		LeadStatus::create([
			'title' => 'Referral Declined',
		]);
		LeadStatus::create([
			'title' => 'Referral Accepted',
		]);
		LeadStatus::create([
			'title' => 'Referral Under Review',
		]);
		LeadStatus::create([
			'title' => 'New Case',
		]);
		LeadStatus::create([
			'title' => 'Export to Tabs3 Software',
		]);
		LeadStatus::create([
			'title' => 'Imported in Tabs3 Software',
		]);
    }
}
