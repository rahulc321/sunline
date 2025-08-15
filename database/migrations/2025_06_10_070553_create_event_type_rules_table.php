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
        Schema::create('event_type_rules', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("event_type_id")->nullable();
			$table->foreign('event_type_id')
				  ->references('id')->on('event_types')
				  ->onDelete('set null');

			$table->unsignedInteger("lead_status_id")->nullable();
			$table->foreign('lead_status_id')
				  ->references('id')->on('lead_status')
				  ->onDelete('set null');
            
			$table->boolean('appointment_reminders')->default(false);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_type_rules');
    }
};
