<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDialerPerformanceIndexes extends Migration
{
    private function addIndexIfMissing(string $table, string $index, string $columns): void
    {
        $exists = collect(DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$index]))->isNotEmpty();
        if (! $exists) {
            DB::statement("CREATE INDEX `{$index}` ON `{$table}`({$columns})");
        }
    }

    public function up()
    {
        if (Schema::hasTable('dialer_calls')) {
            $this->addIndexIfMissing('dialer_calls', 'idx_dialer_calls_twilio_call_sid', 'twilio_call_sid');
            $this->addIndexIfMissing('dialer_calls', 'idx_dialer_calls_agent_id', 'agent_id');
            $this->addIndexIfMissing('dialer_calls', 'idx_dialer_calls_status', 'status');
            $this->addIndexIfMissing('dialer_calls', 'idx_dialer_calls_direction', 'direction');
        }
        if (Schema::hasTable('dialer_agent_status')) {
            $this->addIndexIfMissing('dialer_agent_status', 'idx_dialer_agent_status_user_id', 'user_id');
            $this->addIndexIfMissing('dialer_agent_status', 'idx_dialer_agent_status_status', 'status');
            $this->addIndexIfMissing('dialer_agent_status', 'idx_dialer_agent_status_current_call', 'current_call_id');
        }
        if (Schema::hasTable('dialer_groups')) {
            $this->addIndexIfMissing('dialer_groups', 'idx_dialer_groups_twilio_number', 'twilio_number');
            $this->addIndexIfMissing('dialer_groups', 'idx_dialer_groups_is_active', 'is_active');
        }
        if (Schema::hasTable('dialer_group_members')) {
            $this->addIndexIfMissing('dialer_group_members', 'idx_dialer_group_members_user', 'user_id, is_active');
            $this->addIndexIfMissing('dialer_group_members', 'idx_dialer_group_members_group', 'group_id, is_active');
        }
    }

    public function down()
    {
        $drops = [
            'dialer_calls'         => ['idx_dialer_calls_twilio_call_sid', 'idx_dialer_calls_agent_id', 'idx_dialer_calls_status', 'idx_dialer_calls_direction'],
            'dialer_agent_status'  => ['idx_dialer_agent_status_user_id', 'idx_dialer_agent_status_status', 'idx_dialer_agent_status_current_call'],
            'dialer_groups'        => ['idx_dialer_groups_twilio_number', 'idx_dialer_groups_is_active'],
            'dialer_group_members' => ['idx_dialer_group_members_user', 'idx_dialer_group_members_group'],
        ];
        foreach ($drops as $table => $indexes) {
            if (! Schema::hasTable($table)) continue;
            foreach ($indexes as $index) {
                $exists = collect(DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$index]))->isNotEmpty();
                if ($exists) {
                    DB::statement("DROP INDEX `{$index}` ON `{$table}`");
                }
            }
        }
    }
}
