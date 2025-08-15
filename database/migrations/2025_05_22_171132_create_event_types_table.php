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
        Schema::create('event_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            
			$table->unsignedInteger("event_type_color_id")->nullable();
			$table->foreign('event_type_color_id')
      			  ->references('id')->on('event_type_colors')
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
        Schema::dropIfExists('event_types');
    }
};
