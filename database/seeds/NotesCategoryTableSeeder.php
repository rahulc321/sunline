<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotesCategory;

class NotesCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotesCategory::create([
			'title' => 'Accounting',
		]);
		NotesCategory::create([
			'title' => 'Administrative',
		]);
		NotesCategory::create([
			'title' => 'Alternate Contact',
		]);
		NotesCategory::create([
			'title' => 'Appeal',
		]);
		NotesCategory::create([
			'title' => 'Arbitration',
		]);
		NotesCategory::create([
			'title' => 'Bankruptcy',
		]);
		NotesCategory::create([
			'title' => 'Campaign',
		]);
		NotesCategory::create([
			'title' => 'Client Communication',
		]);
		NotesCategory::create([
			'title' => 'Data Support',
		]);
		NotesCategory::create([
			'title' => 'Discovery',
		]);
		NotesCategory::create([
			'title' => 'Documents',
		]);
		NotesCategory::create([
			'title' => 'Expert',
		]);
		NotesCategory::create([
			'title' => 'Follow Up',
		]);
		NotesCategory::create([
			'title' => 'Insurance',
		]);
		NotesCategory::create([
			'title' => 'Intake',
		]);
		NotesCategory::create([
			'title' => 'Judge',
		]);
		NotesCategory::create([
			'title' => 'Mediation',
		]);
		NotesCategory::create([
			'title' => 'Medical',
		]);
		NotesCategory::create([
			'title' => 'PFS',
		]);
		NotesCategory::create([
			'title' => 'PID',
		]);
		NotesCategory::create([
			'title' => 'Pretrial',
		]);
		NotesCategory::create([
			'title' => 'Probate',
		]);
		NotesCategory::create([
			'title' => 'Ranking',
		]);
		NotesCategory::create([
			'title' => 'Referred',
		]);
		NotesCategory::create([
			'title' => 'Settlements',
		]);
		NotesCategory::create([
			'title' => 'SOL',
		]);
		NotesCategory::create([
			'title' => 'Treatment',
		]);
		NotesCategory::create([
			'title' => 'Trial',
		]);
		NotesCategory::create([
			'title' => 'Voice Memo',
		]);		
    }
}
