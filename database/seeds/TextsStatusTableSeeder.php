<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TextsStatus;

class TextsStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TextsStatus::create([
			'title' => 'Queued',
		]);
		TextsStatus::create([
			'title' => 'Sending',
		]);
		TextsStatus::create([
			'title' => 'Sent',
		]);
		TextsStatus::create([
			'title' => 'Delivered',
		]);		
		TextsStatus::create([
			'title' => 'Failed',
		]);
		TextsStatus::create([
			'title' => 'Undelivered',
		]);
		TextsStatus::create([
			'title' => 'Rejected',
		]);
		TextsStatus::create([
			'title' => 'Expired',
		]);
		TextsStatus::create([
			'title' => 'Read',
		]);
		TextsStatus::create([
			'title' => 'Unread',
		]);
		TextsStatus::create([
			'title' => 'Automated',
		]);
		TextsStatus::create([
			'title' => 'Unknown',
		]);
		
    }
}
