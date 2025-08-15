<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadCallOutcome;

class LeadCallOutcomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadCallOutcome::create([
			'title' => 'Abandoned Call',
		]);
		LeadCallOutcome::create([
			'title' => 'Appointment Made',
		]);
		LeadCallOutcome::create([
			'title' => 'Busy – Call Back Later',
		]);
		LeadCallOutcome::create([
			'title' => 'Do Not Call - Opt Out',
		]);
		LeadCallOutcome::create([
			'title' => 'Hang Up',
		]);
		LeadCallOutcome::create([
			'title' => 'Incorrect Contact – No Referral',
		]);
		LeadCallOutcome::create([
			'title' => 'Incorrect Contact – Referral',
		]);
		LeadCallOutcome::create([
			'title' => 'Interest – Call Back Later',
		]);
		LeadCallOutcome::create([
			'title' => 'Interest – Send Information',
		]);
		LeadCallOutcome::create([
			'title' => 'Left Voicemail',
		]);
		LeadCallOutcome::create([
			'title' => 'Missed Call',
		]);
		LeadCallOutcome::create([
			'title' => 'New Opportunity',
		]);
		LeadCallOutcome::create([
			'title' => 'No Answer',
		]);
		LeadCallOutcome::create([
			'title' => 'No Interest – No Reason Given',
		]);
		LeadCallOutcome::create([
			'title' => 'No Interest – Reason Given',
		]);
		LeadCallOutcome::create([
			'title' => 'Scheduled Call Back',
		]);
		LeadCallOutcome::create([
			'title' => 'Transfer',
		]);
    }
}
