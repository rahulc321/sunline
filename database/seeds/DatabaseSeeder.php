<?php

use Illuminate\Database\Seeder;
use Database\Seeders\OtherPermissionsTableSeeder;
use Database\Seeders\IntakeValuesTableSeeder;
use Database\Seeders\LeadStatusTableSeeder;
use Database\Seeders\ContactTypeTableSeeder;
use Database\Seeders\ContactTableSeeder;
use Database\Seeders\ContactPrefixesTableSeeder;
use Database\Seeders\ContactMaritalStatusTableSeeder;
use Database\Seeders\LanguageTableSeeder;
use Database\Seeders\LeadCallOutcomeTableSeeder;
use Database\Seeders\CaseRoleTableSeeder;
use Database\Seeders\CaseTypeTableSeeder;
use Database\Seeders\LeadKeyDateTypeTableSeeder;
use Database\Seeders\AddressTypeTableSeeder;
use Database\Seeders\NotesCategoryTableSeeder;
use Database\Seeders\TasksCategoryTableSeeder;
use Database\Seeders\TaskTypeTableSeeder;
use Database\Seeders\FirmTypeTableSeeder;
use Database\Seeders\FirmOverrideTypeTableSeeder;
use Database\Seeders\FirmReferralStatusTableSeeder;
use Database\Seeders\CostTypeTableSeeder;
use Database\Seeders\ExpenseCategoryTableSeeder;
use Database\Seeders\DocumentCategoryTableSeeder;
use Database\Seeders\EventTypeTableSeeder;
use Database\Seeders\EventStatusTypeTableSeeder;
use Database\Seeders\EventTypeColorTableSeeder;
use Database\Seeders\EmailStatusTableSeeder;
use Database\Seeders\TextsStatusTableSeeder;
use Database\Seeders\CampaignTypeTableSeeder;
use Database\Seeders\ActivityTypeTableSeeder;
use Database\Seeders\DocumentFolderTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            OtherPermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            IntakeValuesTableSeeder::class,
			LeadStatusTableSeeder::class,
            ContactTypeTableSeeder::class,            
            ContactPrefixesTableSeeder::class,
            ContactMaritalStatusTableSeeder::class,
            LanguageTableSeeder::class,
			ContactTableSeeder::class,	
			LeadCallOutcomeTableSeeder::class,
			CaseRoleTableSeeder::class,
			CaseTypeTableSeeder::class,
			LeadKeyDateTypeTableSeeder::class,
			AddressTypeTableSeeder::class,
			NotesCategoryTableSeeder::class,
			TasksCategoryTableSeeder::class,
			TaskTypeTableSeeder::class,
			FirmTypeTableSeeder::class,
			FirmOverrideTypeTableSeeder::class,
			FirmReferralStatusTableSeeder::class,
			CostTypeTableSeeder::class,
			ExpenseCategoryTableSeeder::class,
			DocumentCategoryTableSeeder::class,
			EventTypeTableSeeder::class,
			EventStatusTypeTableSeeder::class,
			EventTypeColorTableSeeder::class,			
			EmailStatusTableSeeder::class,			
			TextsStatusTableSeeder::class,			
			CampaignTypeTableSeeder::class,			
			ActivityTypeTableSeeder::class,			
			DocumentFolderTableSeeder::class			
        ]);
    }
}
