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
        Schema::create('intake_contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("contact_id")->nullable();
			$table->foreign('contact_id')
      			  ->references('id')->on('contacts')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intake_contacts');
    }
};
