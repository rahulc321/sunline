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
        Schema::create('appointment_settings', function (Blueprint $table) {
            $table->increments('id');
			
			$table->boolean('appointlet_switch')->default(false);
			$table->boolean('remind_lead_assignee')->default(false);
			$table->boolean('remind_lead_owner')->default(false);
			$table->boolean('remind_lead')->default(false);
			$table->boolean('remind_loggedin_user')->default(false);
			$table->boolean('remind_instant_ics')->default(false);
			
			$table->boolean('cancellation_change_status')->default(false);
			$table->string('cancellation_email_subject')->nullable();
			$table->longtext('cancellation_email_body')->nullable();
			$table->boolean('cancellation_notification')->default(false);
			
			$table->timestamps();
				
			$table->softDeletes();	
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_settings');
    }
};
