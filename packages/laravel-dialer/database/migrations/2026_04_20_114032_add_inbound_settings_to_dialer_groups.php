<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dialer_groups', function (Blueprint $table) {
            $table->string('ring_strategy', 20)->default('simultaneous')->after('is_active');
            $table->unsignedSmallInteger('ring_timeout')->default(20)->after('ring_strategy');
            $table->unsignedBigInteger('backup_group_id')->nullable()->after('ring_timeout');
            $table->boolean('voicemail_enabled')->default(false)->after('backup_group_id');
            $table->boolean('missed_call_notify')->default(true)->after('voicemail_enabled');
        });
    }

    public function down()
    {
        Schema::table('dialer_groups', function (Blueprint $table) {
            $table->dropColumn(['ring_strategy', 'ring_timeout', 'backup_group_id', 'voicemail_enabled', 'missed_call_notify']);
        });
    }
};
