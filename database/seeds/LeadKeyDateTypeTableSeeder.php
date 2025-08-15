<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadKeyDateType;

class LeadKeyDateTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadKeyDateType::create([
			'slug' => 'case_created_date',
			'title' => 'Case Created Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'case_opened_date',
			'title' => 'Case Opened Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'claim_filed_date',
			'title' => 'Claim Filed Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'closed_date',
			'title' => 'Closed Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'date_of_incident',
			'title' => 'Date of Incident',
		]);
		LeadKeyDateType::create([
			'slug' => 'discovery_due_date',
			'title' => 'Discovery Due Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'lawsuit_filed_date',
			'title' => 'Lawsuit Filed Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'lead_created_date',
			'title' => 'Lead Created Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'sol_date',
			'title' => 'SOL Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'trial_date',
			'title' => 'Trial Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'bond_posted',
			'title' => 'Bond Posted',
		]);
		LeadKeyDateType::create([
			'slug' => 'case_conference',
			'title' => 'Case Conference',
		]);
		LeadKeyDateType::create([
			'slug' => 'complaint_filed',
			'title' => 'Complaint Filed',
		]);
		LeadKeyDateType::create([
			'slug' => 'date_of_denial',
			'title' => 'Date of Denial',
		]);
		LeadKeyDateType::create([
			'slug' => 'date_of_estate_closing',
			'title' => 'Date of Estate Closing',
		]);
		LeadKeyDateType::create([
			'slug' => 'file_ac_appeal_date',
			'title' => 'File AC Appeal Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'file_appeal_date',
			'title' => 'File Appeal Date',
		]);
		LeadKeyDateType::create([
			'slug' => 'mediation',
			'title' => 'Mediation',
		]);
		LeadKeyDateType::create([
			'slug' => 'petition_file_date',
			'title' => 'Petition File Date',
		]);
			
    }
}
