<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('intake_values', function (Blueprint $table) {
            $table->increments('id');
			$table->enum('type',['case_role', 'case_type', 'status', 'marketing_source', 'assignee', 'owner', 'ad_campaign', 'office_location', 'attorney']);
			$table->string('value',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intake_values');
    }
};
