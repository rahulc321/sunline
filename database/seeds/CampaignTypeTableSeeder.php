<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampaignType;

class CampaignTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CampaignType::create([
			'title' => 'Notification Center',
		]);
		
    }
}
