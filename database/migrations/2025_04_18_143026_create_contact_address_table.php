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
        Schema::create('contact_address', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("contact_id")->nullable();
			$table->foreign('contact_id')
      			  ->references('id')->on('contacts')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("address_id")->nullable();
			$table->foreign('address_id')
      			  ->references('id')->on('address')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_address');
    }
};
