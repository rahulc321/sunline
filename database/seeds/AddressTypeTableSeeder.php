<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AddressType;

class AddressTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddressType::create([
			'title' => 'Alternate',
		]);
		AddressType::create([
			'title' => 'Billing',
		]);
		AddressType::create([
			'title' => 'Business',
		]);
		AddressType::create([
			'title' => 'Home',
		]);
		AddressType::create([
			'title' => 'Mailing',
		]);
		AddressType::create([
			'title' => 'Main',
		]);
		AddressType::create([
			'title' => 'Physical',
		]);
		AddressType::create([
			'title' => 'Work',
		]);		
    }
}
