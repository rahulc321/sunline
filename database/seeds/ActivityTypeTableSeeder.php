<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityType;

class ActivityTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActivityType::create([
			'title' => 'Add Referral Firm to Case',
		]);
		ActivityType::create([
			'title' => 'Add Referral Firm to Lead',
		]);
		ActivityType::create([
			'title' => 'Added a Note',
		]);
		ActivityType::create([
			'title' => 'Added Key Date',
		]);
		ActivityType::create([
			'title' => 'Additional Contact removed',
		]);
		ActivityType::create([
			'title' => 'Additional Contacts added',
		]);
		ActivityType::create([
			'title' => 'Appointment Cancelled',
		]);
		ActivityType::create([
			'title' => 'Appointment Created',
		]);
		ActivityType::create([
			'title' => 'Appointment Deleted',
		]);
		ActivityType::create([
			'title' => 'Appointment Reminder Email',
		]);
		ActivityType::create([
			'title' => 'Appointment Reminder Text Message',
		]);
		ActivityType::create([
			'title' => 'Appointment Rescheduled',
		]);
		ActivityType::create([
			'title' => 'Appointment Updated',
		]);
		ActivityType::create([
			'title' => 'Assigned A Task',
		]);
		ActivityType::create([
			'title' => 'Call - Abandoned Call',
		]);
		ActivityType::create([
			'title' => 'Call - Call Outcome Status Changed',
		]);
		ActivityType::create([
			'title' => 'Call - Declined Inbound Call',
		]);
		ActivityType::create([
			'title' => 'Call - Inbound',
		]);
		ActivityType::create([
			'title' => 'Call - Missed Outbound Call',
		]);
		ActivityType::create([
			'title' => 'Call - Missed Queue Call',
		]);
		ActivityType::create([
			'title' => 'Call - Outbound',
		]);
		ActivityType::create([
			'title' => 'Call - Outbound Call Generated',
		]);
		ActivityType::create([
			'title' => 'Call - Recycled Outbound Call',
		]);
		ActivityType::create([
			'title' => 'Call - Taken Over',
		]);
		ActivityType::create([
			'title' => 'Call - Transfer Inbound',
		]);
		ActivityType::create([
			'title' => 'Call - Transfer Outbound',
		]);
		ActivityType::create([
			'title' => 'Canceled Payment Plan',
		]);
		ActivityType::create([
			'title' => 'Cancelled Appointment',
		]);
		ActivityType::create([
			'title' => 'Case Change',
		]);
		ActivityType::create([
			'title' => 'Case Role Added',
		]);
		ActivityType::create([
			'title' => 'Case Role Changed',
		]);
		ActivityType::create([
			'title' => 'Case Role Contact Changed',
		]);
		ActivityType::create([
			'title' => 'Case Role Contact Issue Resolved',
		]);
		ActivityType::create([
			'title' => 'Changed Contact',
		]);
		ActivityType::create([
			'title' => 'Changed Lead Status',
		]);
		ActivityType::create([
			'title' => 'ClientProfile - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'ClientProfile - Sync Notes',
		]);
		ActivityType::create([
			'title' => 'Clio - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'Completed a Task',
		]);
		ActivityType::create([
			'title' => 'Completed Payment Plan',
		]);
		ActivityType::create([
			'title' => 'Converted Lead',
		]);
		ActivityType::create([
			'title' => 'Copied Lead',
		]);
		ActivityType::create([
			'title' => 'CosmoLex - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'Created a New Lead',
		]);
		ActivityType::create([
			'title' => 'Created a new user',
		]);
		ActivityType::create([
			'title' => 'Created Payment Plan',
		]);
		ActivityType::create([
			'title' => 'Crocodile - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'Delete a Lead',
		]);
		ActivityType::create([
			'title' => 'Deleted a Note of',
		]);
		ActivityType::create([
			'title' => 'Deleted a Task of',
		]);
		ActivityType::create([
			'title' => 'Document Added To Print Queue',
		]);
		ActivityType::create([
			'title' => 'Document created',
		]);
		ActivityType::create([
			'title' => 'Document Deleted',
		]);
		ActivityType::create([
			'title' => 'Document Template',
		]);
		ActivityType::create([
			'title' => 'Draft Invoice Created',
		]);
		ActivityType::create([
			'title' => 'E-Sign Contract Cancelled',
		]);
		ActivityType::create([
			'title' => 'E-Sign Contract Sent',
		]);
		ActivityType::create([
			'title' => 'E-Sign Contract Signed Now',
		]);
		ActivityType::create([
			'title' => 'Edited Key Date',
		]);
		ActivityType::create([
			'title' => 'Edited Note',
		]);
		ActivityType::create([
			'title' => 'Edited Payment Plan',
		]);
		ActivityType::create([
			'title' => 'Email Campaign Status',
		]);
		ActivityType::create([
			'title' => 'Email Entry',
		]);
		ActivityType::create([
			'title' => 'Email Opt-In/Opt-Out',
		]);
		ActivityType::create([
			'title' => 'Email Sent Or Replied',
		]);
		ActivityType::create([
			'title' => 'Email Status',
		]);
		ActivityType::create([
			'title' => 'Erased Key Date',
		]);
		ActivityType::create([
			'title' => 'FileVine Send Case',
		]);
		ActivityType::create([
			'title' => 'Imported a New Lead',
		]);
		ActivityType::create([
			'title' => 'Installment Payment',
		]);
		ActivityType::create([
			'title' => 'Intake Form',
		]);
		ActivityType::create([
			'title' => 'Integration',
		]);
		ActivityType::create([
			'title' => 'Invoice Deleted',
		]);
		ActivityType::create([
			'title' => 'Invoice Disapproved',
		]);
		ActivityType::create([
			'title' => 'Invoice Item Added',
		]);
		ActivityType::create([
			'title' => 'Invoice Item Removed',
		]);
		ActivityType::create([
			'title' => 'Invoice Item Updated',
		]);
		ActivityType::create([
			'title' => 'Invoice Payment',
		]);
		ActivityType::create([
			'title' => 'Invoice Saved',
		]);
		ActivityType::create([
			'title' => 'Invoice Sent',
		]);
		ActivityType::create([
			'title' => 'LawPay Account Changed',
		]);
		ActivityType::create([
			'title' => 'Lead Checking Quesionnaire',
		]);
		ActivityType::create([
			'title' => 'Lead Closure',
		]);
		ActivityType::create([
			'title' => 'Lead Name Changed',
		]);
		ActivityType::create([
			'title' => 'Lead Source Changed',
		]);
		ActivityType::create([
			'title' => 'Lien',
		]);
		ActivityType::create([
			'title' => 'MerchantPaymentAPI',
		]);
		ActivityType::create([
			'title' => 'Merged Lead',
		]);
		ActivityType::create([
			'title' => 'Multimedia Message Reply',
		]);
		ActivityType::create([
			'title' => 'Needles - Sync Notes',
		]);
		ActivityType::create([
			'title' => 'Needles Email Campaign',
		]);
		ActivityType::create([
			'title' => 'Payment Transaction',
		]);
		ActivityType::create([
			'title' => 'Phone Opt-In/Opt-Out',
		]);
		ActivityType::create([
			'title' => 'Prevail - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'Remove Referral Firm from Case',
		]);
		ActivityType::create([
			'title' => 'Remove Referral Firm from Lead',
		]);
		ActivityType::create([
			'title' => 'Restore Lead',
		]);
		ActivityType::create([
			'title' => 'Sent to Referral Firm',
		]);
		ActivityType::create([
			'title' => 'SettlementPayee',
		]);
		ActivityType::create([
			'title' => 'Shipping Label',
		]);
		ActivityType::create([
			'title' => 'SmartAdvocateXML - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'SMS Opt-In/Opt-Out',
		]);
		ActivityType::create([
			'title' => 'Special Damage',
		]);
		ActivityType::create([
			'title' => 'Telmetrics Call Log',
		]);
		ActivityType::create([
			'title' => 'Text Message Campaign Status',
		]);
		ActivityType::create([
			'title' => 'Text Message Failure',
		]);
		ActivityType::create([
			'title' => 'Text Message for Task assigned',
		]);
		ActivityType::create([
			'title' => 'Text Message reply from user',
		]);
		ActivityType::create([
			'title' => 'Text Message Status',
		]);
		ActivityType::create([
			'title' => 'Time Entry added',
		]);
		ActivityType::create([
			'title' => 'Time Entry changed',
		]);
		ActivityType::create([
			'title' => 'Time Entry removed',
		]);
		ActivityType::create([
			'title' => 'TimeSolv - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'Transferred Lead From',
		]);
		ActivityType::create([
			'title' => 'TrialWorks - Lead Converted',
		]);
		ActivityType::create([
			'title' => 'Update Referral Firm on Case',
		]);
		ActivityType::create([
			'title' => 'Update Referral Firm on Lead',
		]);
		ActivityType::create([
			'title' => 'Updated Document Content',
		]);
		ActivityType::create([
			'title' => 'Updated Lead via import process (Fill)',
		]);
		ActivityType::create([
			'title' => 'Updated Lead via import process (Update)',
		]);
		ActivityType::create([
			'title' => 'Uploaded Document',
		]);
		ActivityType::create([
			'title' => 'Vonage Call Log',
		]);
		ActivityType::create([
			'title' => 'Webhook Failed Internally',
		]);
		ActivityType::create([
			'title' => 'Webhook Failed Response',
		]);
		ActivityType::create([
			'title' => 'Webhook Success Response',
		]);
    }
}
