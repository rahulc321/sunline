<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailStatus;

class EmailStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailStatus::create([
			'title' => 'Queued',
		]);
		EmailStatus::create([
			'title' => 'Pending',
		]);
		EmailStatus::create([
			'title' => 'Processing',
		]);
		EmailStatus::create([
			'title' => 'Sending',
		]);
		EmailStatus::create([
			'title' => 'Sent',
		]);
		EmailStatus::create([
			'title' => 'Delivered',
		]);
		EmailStatus::create([
			'title' => 'Failed',
		]);
		EmailStatus::create([
			'title' => 'Deferred',
		]);
		EmailStatus::create([
			'title' => 'Bounded',
		]);
		EmailStatus::create([
			'title' => 'Bounded (Soft)',
		]);
		EmailStatus::create([
			'title' => 'Bounded (Hard)',
		]);
		EmailStatus::create([
			'title' => 'Opened',
		]);
		EmailStatus::create([
			'title' => 'Clicked',
		]);
		EmailStatus::create([
			'title' => 'Unsubscribed',
		]);
		EmailStatus::create([
			'title' => 'Spam Reported',
		]);
		EmailStatus::create([
			'title' => 'Failed',
		]);
		EmailStatus::create([
			'title' => 'Blocked',
		]);
		EmailStatus::create([
			'title' => 'Invalid Address',
		]);
		EmailStatus::create([
			'title' => 'Suppressed',
		]);	
		
    }
}
