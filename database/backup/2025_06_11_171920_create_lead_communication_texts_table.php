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
        Schema::create('lead_communication_texts', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("user_id")->nullable();
			$table->foreign('user_id')
      			  ->references('id')->on('users')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');					
			$table->unsignedInteger("texts_status_id")->nullable();
			$table->foreign('texts_status_id')
      			  ->references('id')->on('texts_status')
      			  ->onDelete('set null');
			$table->unsignedInteger("campaign_type_id")->nullable();
			$table->foreign('campaign_type_id')
      			  ->references('id')->on('campaign_types')
      			  ->onDelete('set null');
			$table->string('from_phone',15)->nullable();
			$table->string('to_phone',15)->nullable();
			$table->longtext("message")->nullable();	 
				  
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_communication_texts');
    }
};
