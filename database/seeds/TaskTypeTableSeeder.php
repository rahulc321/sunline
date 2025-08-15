<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskType;

class TaskTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		TaskType::create([
			'title' => 'Key Date',
		]);
		TaskType::create([
			'title' => 'To Do',
		]);
    }
}
