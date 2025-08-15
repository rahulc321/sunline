<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentFolder;

class DocumentFolderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentFolder::create([
			'folder_name' => 'Document Templates',
			'is_default' => 1,
			'order' => 1
		]);
		DocumentFolder::create([
			'folder_name' => 'Photos',
			'is_default' => 1,
			'order' => 2
		]);
		DocumentFolder::create([
			'folder_name' => 'Recordings',
			'is_default' => 1,
			'order' => 3
		]);
		DocumentFolder::create([
			'folder_name' => 'Signed Contracts',
			'is_default' => 1,
			'order' => 4
		]);
		DocumentFolder::create([
			'folder_name' => 'Medical Records',
			'is_default' => 1,
			'order' => 5
		]);
		DocumentFolder::create([
			'folder_name' => 'Email Attachments',
			'is_default' => 1,
			'order' => 6
		]);
		DocumentFolder::create([
			'folder_name' => 'Note Attachments',
			'is_default' => 1,
			'order' => 7
		]);
		DocumentFolder::create([
			'folder_name' => 'Tasks',
			'is_default' => 1,
			'order' => 8
		]);
		
    }
}
