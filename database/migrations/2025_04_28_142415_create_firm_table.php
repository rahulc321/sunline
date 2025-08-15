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
        Schema::create('firms', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
			
			$table->unsignedInteger("firm_type_id")->nullable();
			$table->foreign('firm_type_id')
      			  ->references('id')->on('firm_types')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->string('firm_percentage')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firms');
    }
};
