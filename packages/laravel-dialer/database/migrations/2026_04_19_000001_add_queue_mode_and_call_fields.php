<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add queue_mode so admins can route items to AI agent vs human agent
        Schema::table('dialer_queue', function (Blueprint $table) {
            $table->enum('queue_mode', ['system', 'human_agent'])
                  ->default('system')
                  ->after('call_type');
        });

        // Add conference tracking columns used by hold/transfer (conference-based calls)
        Schema::table('dialer_calls', function (Blueprint $table) {
            if (! Schema::hasColumn('dialer_calls', 'conference_name')) {
                $table->string('conference_name')->nullable()->after('call_source');
            }
            if (! Schema::hasColumn('dialer_calls', 'customer_call_sid')) {
                $table->string('customer_call_sid')->nullable()->after('conference_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dialer_queue', function (Blueprint $table) {
            $table->dropColumn('queue_mode');
        });

        Schema::table('dialer_calls', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('dialer_calls', 'conference_name'))   $cols[] = 'conference_name';
            if (Schema::hasColumn('dialer_calls', 'customer_call_sid')) $cols[] = 'customer_call_sid';
            if ($cols) $table->dropColumn($cols);
        });

        Schema::table('dialer_calls', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('dialer_calls', 'conference_name'))   $cols[] = 'conference_name';
            if (Schema::hasColumn('dialer_calls', 'customer_call_sid')) $cols[] = 'customer_call_sid';
            if ($cols) $table->dropColumn($cols);
        });
    }
};
