<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeedAutomationDialerPermissions extends Migration
{
    private array $permissions = [
        'automation_access',
        'automation_create',
        'automation_edit',
        'automation_delete',
        'dialer_access',
        'dialer_supervisor',
    ];

    public function up()
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable('permissions')) {
            return;
        }
        $now = now();
        foreach ($this->permissions as $title) {
            DB::table('permissions')->insertOrIgnore([
                'title'      => $title,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down()
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable('permissions')) {
            return;
        }
        DB::table('permissions')->whereIn('title', $this->permissions)->delete();
    }
}
