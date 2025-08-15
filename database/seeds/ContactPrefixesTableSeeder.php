<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactPrefixes;

class ContactPrefixesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactPrefixes::create([
			'title' => 'Captain',
		]);
		ContactPrefixes::create([
			'title' => 'Chief',
		]);
		ContactPrefixes::create([
			'title' => 'Col.',
		]);
		ContactPrefixes::create([
			'title' => 'Commissioner',
		]);
		ContactPrefixes::create([
			'title' => 'Corporal',
		]);
		ContactPrefixes::create([
			'title' => 'Decedent',
		]);
		ContactPrefixes::create([
			'title' => 'Deputy',
		]);
		ContactPrefixes::create([
			'title' => 'Detective',
		]);
		ContactPrefixes::create([
			'title' => 'Dr.',
		]);
		ContactPrefixes::create([
			'title' => 'Honorable',
		]);
		ContactPrefixes::create([
			'title' => 'Lieutenant',
		]);
		ContactPrefixes::create([
			'title' => 'Mr.',
		]);
		ContactPrefixes::create([
			'title' => 'Mrs.',
		]);
		ContactPrefixes::create([
			'title' => 'Ms.',
		]);
		ContactPrefixes::create([
			'title' => 'Officer',
		]);
		ContactPrefixes::create([
			'title' => 'Paramedic',
		]);
		ContactPrefixes::create([
			'title' => 'Professor',
		]);
		ContactPrefixes::create([
			'title' => 'Sergeant',
		]);
		ContactPrefixes::create([
			'title' => 'Sheriff',
		]);
		ContactPrefixes::create([
			'title' => 'Sr.',
		]);
		ContactPrefixes::create([
			'title' => 'Sra.',
		]);
		
    }
}
