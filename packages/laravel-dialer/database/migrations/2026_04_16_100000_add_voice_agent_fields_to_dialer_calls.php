<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dialer_calls', function (Blueprint $table) {
            // External call ID from the voice agent provider (e.g. Retell, Bland, etc.)
            $table->string('voice_call_id')->nullable()->after('twilio_call_sid');

            // How the call was placed:
            //   direct   = agent-initiated via Twilio browser SDK (existing flow)
            //   ai_agent = placed through n8n → voice agent provider
            $table->enum('call_source', ['direct', 'ai_agent'])->default('direct')->after('voice_call_id');
        });
    }

    public function down()
    {
        Schema::table('dialer_calls', function (Blueprint $table) {
            $table->dropColumn(['voice_call_id', 'call_source']);
        });
    }
};
