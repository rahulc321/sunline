<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventStatusType;

class EventStatusTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		EventStatusType::create([
			'title' => 'Attended',
		]);
		EventStatusType::create([
			'title' => 'Canceled',
		]);
		EventStatusType::create([
			'title' => 'Rescheduled',
		]);
		EventStatusType::create([
			'title' => 'No Showed',
		]);
		EventStatusType::create([
			'title' => 'Created',
		]);
    }
}
