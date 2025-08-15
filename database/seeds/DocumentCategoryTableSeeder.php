<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentCategory::create([
			'title' => 'Closing Statement',
		]);
		DocumentCategory::create([
			'title' => 'Communications - Client',
		]);
		DocumentCategory::create([
			'title' => 'Email Attachment',
		]);
		DocumentCategory::create([
			'title' => 'Intake',
		]);
		DocumentCategory::create([
			'title' => 'Invoice',
		]);
		DocumentCategory::create([
			'title' => 'Lien/Subrogation',
		]);
		DocumentCategory::create([
			'title' => 'Mailed Document',
		]);
		DocumentCategory::create([
			'title' => 'Medical Authorization',
		]);
		DocumentCategory::create([
			'title' => 'Medical Billing',
		]);
		DocumentCategory::create([
			'title' => 'Medical Records',
		]);
		DocumentCategory::create([
			'title' => 'Photographs',
		]);
		DocumentCategory::create([
			'title' => 'Police Records',
		]);
		DocumentCategory::create([
			'title' => 'Release',
		]);
		DocumentCategory::create([
			'title' => 'Service Bills',
		]);
		DocumentCategory::create([
			'title' => 'Shipping Label',
		]);
		DocumentCategory::create([
			'title' => 'Signed Contracts',
		]);
		DocumentCategory::create([
			'title' => 'Vendor',
		]);
		DocumentCategory::create([
			'title' => 'VoiceMemo',
		]);
		
    }
}
