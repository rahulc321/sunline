<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupervisorIdToDialerGroups extends Migration
{
    public function up()
    {
        Schema::table('dialer_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('supervisor_id')->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('dialer_groups', function (Blueprint $table) {
            $table->dropColumn('supervisor_id');
        });
    }
}
