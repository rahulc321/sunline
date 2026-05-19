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
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("activity_type_id")->nullable();
			$table->foreign('activity_type_id')
      			  ->references('id')->on('activity_types')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');	
			$table->unsignedInteger("client_id")->nullable();
			$table->foreign('client_id')
      			  ->references('id')->on('contacts')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');	  
			$table->unsignedInteger("user_id")->nullable();
			$table->foreign('user_id')
      			  ->references('id')->on('users')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->string('module');
            $table->string('action');
            $table->text('description')->nullable();
            $table->text('details')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();	  
            $table->timestamps();
			$table->softDeletes();
			
			// Add index for faster module-wise queries
            $table->index('module');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity');
    }
};
