<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->id();
            $table->integer('min_value');        // e.g., 1
            $table->integer('max_value');        // e.g., 5
            $table->string('tier_name');         // e.g., Tier 1
            $table->decimal('commission', 10, 2); // e.g., 150.00
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiers');
    }
};