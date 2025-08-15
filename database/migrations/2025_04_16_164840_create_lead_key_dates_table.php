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
        Schema::create('lead_key_dates', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("key_date_id")->nullable();
			$table->foreign('key_date_id')
      			  ->references('id')->on('lead_key_date_types')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->date('key_date')->nullable();	  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_key_dates');
    }
};
