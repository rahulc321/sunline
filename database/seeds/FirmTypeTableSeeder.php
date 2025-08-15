<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FirmType;

class FirmTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FirmType::create([
			'title' => 'Chiropractor',
		]);
		FirmType::create([
			'title' => 'Common Benefit Fund',
		]);
		FirmType::create([
			'title' => 'Handling',
		]);
		FirmType::create([
			'title' => 'Inbound',
		]);
		FirmType::create([
			'title' => 'Medical Provider',
		]);
		FirmType::create([
			'title' => 'Originating Attorney',
		]);
		FirmType::create([
			'title' => 'Our Firm',
		]);
		FirmType::create([
			'title' => 'Outbound',
		]);
    }
}
