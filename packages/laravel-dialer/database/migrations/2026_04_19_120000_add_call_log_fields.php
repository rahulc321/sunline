<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('call_conversations')) {
            return;
        }
        Schema::table('call_conversations', function (Blueprint $table) {
            $table->string('source', 20)->nullable()->after('notes');               // 'manual' | 'dialer'
            $table->unsignedInteger('call_duration')->nullable()->after('source');  // seconds
            $table->string('call_outcome', 50)->nullable()->after('call_duration');
            $table->text('agent_note')->nullable()->after('call_outcome');
            $table->string('recording_blob_path')->nullable()->after('agent_note');
            $table->string('twilio_call_sid')->nullable()->after('recording_blob_path');
            $table->string('direction', 10)->nullable()->after('twilio_call_sid');  // 'inbound' | 'outbound'
            $table->string('recording_sid')->nullable()->after('direction');
            $table->timestamp('started_at')->nullable()->after('recording_sid');
            $table->timestamp('ended_at')->nullable()->after('started_at');
            $table->unsignedBigInteger('dialer_call_id')->nullable()->after('ended_at');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('call_conversations')) {
            return;
        }
        Schema::table('call_conversations', function (Blueprint $table) {
            $table->dropColumn([
                'source', 'call_duration', 'call_outcome', 'agent_note',
                'recording_blob_path', 'twilio_call_sid', 'direction',
                'recording_sid', 'started_at', 'ended_at', 'dialer_call_id',
            ]);
        });
    }
};
