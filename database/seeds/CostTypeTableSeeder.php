<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CostType;

class CostTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CostType::create([
			'title' => 'Hard Cost - Third-Party Vendor',
			'show_in_filter' => '0',
			'show_on_form' => '1',
		]);
		CostType::create([
			'title' => 'Soft Cost - Due to Our Firm',
			'show_in_filter' => '0',
			'show_on_form' => '1',
		]);
		CostType::create([
			'title' => 'Hard Costs',
			'show_in_filter' => '1',
			'show_on_form' => '0',
		]);
		CostType::create([
			'title' => 'Soft Costs',
			'show_in_filter' => '1',
			'show_on_form' => '0',
		]);
		CostType::create([
			'title' => 'Soft Cost - Hold',
			'show_in_filter' => '1',
			'show_on_form' => '0',
		]);
		CostType::create([
			'title' => 'Special Damage',
			'show_in_filter' => '1',
			'show_on_form' => '0',
		]);
		CostType::create([
			'title' => 'Settlement Loan',
			'show_in_filter' => '1',
			'show_on_form' => '0',
		]);
		CostType::create([
			'title' => 'Other Client Debt',
			'show_in_filter' => '1',
			'show_on_form' => '0',
		]);
    }
}
