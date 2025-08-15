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
        Schema::create('lead_events', function (Blueprint $table) {
            $table->increments('id');
			
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');

            $table->unsignedInteger("event_type_id")->nullable();
			$table->foreign('event_type_id')
      			  ->references('id')->on('event_types')
      			  ->onDelete('set null');
				  
			$table->string('event_title')->nullable();	  
			$table->string('location')->nullable();	
			$table->text('address')->nullable();	
			$table->longtext('description')->nullable();

			$table->date('event_date')->nullable();		
			$table->datetime('event_start_datetime')->nullable();			
			$table->datetime('event_end_datetime')->nullable();			

			$table->unsignedInteger("owner_id")->nullable();
			$table->foreign('owner_id')
      			  ->references('id')->on('users')
      			  ->onDelete('set null');		
            
			$table->unsignedInteger("event_status_id")->nullable();
			$table->foreign('event_status_id')
      			  ->references('id')->on('event_status_types')
      			  ->onDelete('set null');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_events');
    }
};
