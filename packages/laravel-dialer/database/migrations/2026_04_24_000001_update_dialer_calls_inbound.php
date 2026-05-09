<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE dialer_calls DROP CONSTRAINT IF EXISTS dialer_calls_status_check");
            DB::statement("ALTER TABLE dialer_calls ADD CONSTRAINT dialer_calls_status_check CHECK (status::text = ANY(ARRAY['initiated','ringing','in-progress','queued','completed','busy','no-answer','failed','canceled','voicemail']::text[]))");
            DB::statement("ALTER TABLE dialer_calls DROP CONSTRAINT IF EXISTS dialer_calls_disposition_check");
            DB::statement("ALTER TABLE dialer_calls ADD CONSTRAINT dialer_calls_disposition_check CHECK (disposition::text = ANY(ARRAY['contacted','voicemail','no_answer','busy','wrong_number','callback_requested','not_interested','retained']::text[]))");
        } else {
            // MySQL/MariaDB: drop old CHECK constraints if they exist, re-add with updated values
            try { DB::statement("ALTER TABLE dialer_calls DROP CHECK dialer_calls_status_check"); } catch (\Throwable $e) {}
            try { DB::statement("ALTER TABLE dialer_calls DROP CHECK dialer_calls_disposition_check"); } catch (\Throwable $e) {}
            try {
                DB::statement("ALTER TABLE dialer_calls ADD CONSTRAINT dialer_calls_status_check CHECK (status IN ('initiated','ringing','in-progress','queued','completed','busy','no-answer','failed','canceled','voicemail'))");
                DB::statement("ALTER TABLE dialer_calls ADD CONSTRAINT dialer_calls_disposition_check CHECK (disposition IN ('contacted','voicemail','no_answer','busy','wrong_number','callback_requested','not_interested','retained'))");
            } catch (\Throwable $e) {}
        }

        if (!Schema::hasColumn('dialer_calls', 'group_id')) {
            Schema::table('dialer_calls', function (Blueprint $table) {
                $table->unsignedBigInteger('group_id')->nullable()->index()->after('queue_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('dialer_calls', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });

        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE dialer_calls DROP CONSTRAINT IF EXISTS dialer_calls_status_check");
            DB::statement("ALTER TABLE dialer_calls ADD CONSTRAINT dialer_calls_status_check CHECK (status::text = ANY(ARRAY['initiated','ringing','in-progress','completed','busy','no-answer','failed','canceled']::text[]))");
            DB::statement("ALTER TABLE dialer_calls DROP CONSTRAINT IF EXISTS dialer_calls_disposition_check");
            DB::statement("ALTER TABLE dialer_calls ADD CONSTRAINT dialer_calls_disposition_check CHECK (disposition::text = ANY(ARRAY['contacted','voicemail','no_answer','busy','wrong_number','callback_requested','not_interested']::text[]))");
        } else {
            try { DB::statement("ALTER TABLE dialer_calls DROP CHECK dialer_calls_status_check"); } catch (\Throwable $e) {}
            try { DB::statement("ALTER TABLE dialer_calls DROP CHECK dialer_calls_disposition_check"); } catch (\Throwable $e) {}
        }
    }
};
