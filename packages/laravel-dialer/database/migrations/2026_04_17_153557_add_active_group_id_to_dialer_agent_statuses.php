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
        Schema::table('dialer_agent_status', function (Blueprint $table) {
            $table->unsignedBigInteger('active_group_id')->nullable()->after('status_changed_at');
        });
    }

    public function down()
    {
        Schema::table('dialer_agent_status', function (Blueprint $table) {
            $table->dropColumn('active_group_id');
        });
    }
};
