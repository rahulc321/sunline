<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactMaritalStatus;

class ContactMaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactMaritalStatus::create([
			'title' => 'Divorced',
		]);
		ContactMaritalStatus::create([
			'title' => 'Married',
		]);
		ContactMaritalStatus::create([
			'title' => 'Never Married',
		]);
		ContactMaritalStatus::create([
			'title' => 'Separated',
		]);
		ContactMaritalStatus::create([
			'title' => 'Unknown/Not Stated',
		]);
		ContactMaritalStatus::create([
			'title' => 'Widowed',
		]);		
    }
}
