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
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Pending, In Progress, Completed
            $table->string('color')->nullable(); // optional: to store label color like #ff0000
            $table->string('status')->default(1);
            $table->timestamps();
        });

        Schema::create('priority', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Pending, In Progress, Completed
            $table->string('status')->default(1);
            $table->timestamps();
        });

        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Pending, In Progress, Completed
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
