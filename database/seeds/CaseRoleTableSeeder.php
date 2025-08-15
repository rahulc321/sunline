<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseRole;

class CaseRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CaseRole::create([
			'title' => '3rd Party Defendant',
		]);
		CaseRole::create([
			'title' => 'Adjuster',
		]);
		CaseRole::create([
			'title' => 'Administrator',
		]);
		CaseRole::create([
			'title' => 'Agency',
		]);
		CaseRole::create([
			'title' => 'Arbitrator',
		]);
		CaseRole::create([
			'title' => 'Attorney',
		]);
		CaseRole::create([
			'title' => 'Caller',
		]);
		CaseRole::create([
			'title' => 'Claimant',
		]);
		CaseRole::create([
			'title' => 'Client',
		]);
		CaseRole::create([
			'title' => 'Defendant',
		]);
		CaseRole::create([
			'title' => 'Def-Deceased',
		]);
		CaseRole::create([
			'title' => 'Def-Driver',
		]);
		CaseRole::create([
			'title' => 'Def-Driver/Owner',
		]);
		CaseRole::create([
			'title' => 'Def-Owner',
		]);
		CaseRole::create([
			'title' => 'Def-Gov',
		]);
		CaseRole::create([
			'title' => 'Doctor',
		]);
		CaseRole::create([
			'title' => 'Expert',
		]);
		CaseRole::create([
			'title' => 'Guardian',
		]);
		CaseRole::create([
			'title' => 'Heir',
		]);
		CaseRole::create([
			'title' => 'Injured Party',
		]);
		CaseRole::create([
			'title' => 'Insurance Co',
		]);
		CaseRole::create([
			'title' => 'Judge',
		]);
		CaseRole::create([
			'title' => 'Lienholder',
		]);
		CaseRole::create([
			'title' => 'Mediator',
		]);
		CaseRole::create([
			'title' => 'Medical Provider',
		]);
		CaseRole::create([
			'title' => 'Minor',
		]);
		CaseRole::create([
			'title' => 'Nurse Case Mgr',
		]);
		CaseRole::create([
			'title' => 'Opposing Attorney',
		]);
		CaseRole::create([
			'title' => 'Parent',
		]);
		CaseRole::create([
			'title' => 'Passenger',
		]);
		CaseRole::create([
			'title' => 'Petitioner',
		]);
		CaseRole::create([
			'title' => 'Plaintiff',
		]);
		CaseRole::create([
			'title' => 'Plntf-Deceased',
		]);
		CaseRole::create([
			'title' => 'Plntf-Driver',
		]);
		CaseRole::create([
			'title' => 'Plntf-Minor',
		]);
		CaseRole::create([
			'title' => 'Plntf-Owner',
		]);
		CaseRole::create([
			'title' => 'Plntf-Parent',
		]);
		CaseRole::create([
			'title' => 'Relative',
		]);
		CaseRole::create([
			'title' => 'Rejected Caller',
		]);
		CaseRole::create([
			'title' => 'Representative',
		]);
		CaseRole::create([
			'title' => 'Spouse',
		]);
		CaseRole::create([
			'title' => 'Trustee',
		]);
		CaseRole::create([
			'title' => 'Witness',
		]);
		CaseRole::create([
			'title' => 'Client Related',
		]);
		CaseRole::create([
			'title' => 'Deceased',
		]);
		CaseRole::create([
			'title' => 'Incapacitated',
		]);
		CaseRole::create([
			'title' => 'Caregiver',
		]);		
    }
}
