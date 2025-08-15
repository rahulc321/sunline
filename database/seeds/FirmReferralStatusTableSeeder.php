<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FirmReferralStatus;

class FirmReferralStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FirmReferralStatus::create([
			'title' => 'Pending',
		]);
		FirmReferralStatus::create([
			'title' => 'Accepted',
		]);
		FirmReferralStatus::create([
			'title' => 'Declined',
		]);
		FirmReferralStatus::create([
			'title' => 'Pre-Lit',
		]);
		FirmReferralStatus::create([
			'title' => 'Litigation',
		]);
		FirmReferralStatus::create([
			'title' => 'Settled',
		]);
		FirmReferralStatus::create([
			'title' => 'Final Judgment',
		]);
		FirmReferralStatus::create([
			'title' => 'Appeal Filed',
		]);
		FirmReferralStatus::create([
			'title' => 'Case Closed – Lost',
		]);
		FirmReferralStatus::create([
			'title' => 'Case Closed – Won',
		]);
		
    }
}
