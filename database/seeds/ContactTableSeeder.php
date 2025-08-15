<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = json_decode('[
			{"id":"1","type":"18","first_name":"Antione","last_name":"Williams","display_name":"Antione Williams","email":"test@test.com","phone":"(314) 665-8742","language":"17","created_at":"2025-04-10 15:05:47","updated_at":"2025-04-10 15:05:47"},
			{"id":"2","type":"47","first_name":"Arthur Sc","last_name":"Page","display_name":"Arthur Sc Page","email":"test@scppc.com","phone":"(828) 730-9886","language":"17","created_at":"2025-04-10 15:05:47","updated_at":"2025-04-10 15:05:47"}
			]',true);
		
		Contact::insert($contacts);	
		
    }
}
