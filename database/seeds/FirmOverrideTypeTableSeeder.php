<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FirmOverrideType;

class FirmOverrideTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FirmOverrideType::create([
			'title' => 'Fee Share %',
		]);
		FirmOverrideType::create([
			'title' => 'Firm Flat Fee $',
		]);
    }
}
