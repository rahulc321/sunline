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
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("address_type")->nullable();
			$table->foreign('address_type')
      			  ->references('id')->on('address_types')
      			  ->onDelete('set null');
			$table->string('address_1',255)->nullable();
			$table->string('address_2',255)->nullable();
			$table->string('city',100)->nullable();
			$table->string('country',100)->nullable();
			$table->string('zip',10)->nullable();
			$table->integer('state_id')->nullable();
			$table->integer('country_id')->nullable();
			$table->enum('is_primary',['1','0'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
