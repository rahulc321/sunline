<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerCallSidToDialerCalls extends Migration
{
    public function up()
    {
        Schema::table('dialer_calls', function (Blueprint $table) {
            $table->string('customer_call_sid')->nullable()->after('twilio_call_sid');
            $table->string('conference_name')->nullable()->after('customer_call_sid');
        });
    }

    public function down()
    {
        Schema::table('dialer_calls', function (Blueprint $table) {
            $table->dropColumn(['customer_call_sid', 'conference_name']);
        });
    }
}
