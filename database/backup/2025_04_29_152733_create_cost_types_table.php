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
        Schema::create('cost_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
			$table->enum('show_in_filter',['1', '0'])->default('1');
			$table->enum('show_on_form',['1', '0'])->default('1');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_types');
    }
};
