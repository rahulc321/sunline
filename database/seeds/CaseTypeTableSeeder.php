<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseType;

class CaseTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CaseType::create([
			'title' => '3M Earplug',
		]);
		CaseType::create([
			'title' => 'Auto Accident',
		]);
		CaseType::create([
			'title' => 'Hernia Mesh',
		]);
		CaseType::create([
			'title' => 'n/a',
		]);
		CaseType::create([
			'title' => 'Roundup',
		]);
		CaseType::create([
			'title' => 'Social Security Disability',
		]);
		CaseType::create([
			'title' => 'Talc',
		]);
		CaseType::create([
			'title' => 'Unassigned',
		]);
		CaseType::create([
			'title' => 'VA Disability',
		]);
		CaseType::create([
			'title' => 'Zantac',
		]);	
    }
}
