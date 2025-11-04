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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('urgency_label')->nullable();
            $table->string('assign_to')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['responded', 'open', 'close'])->nullable();
            $table->timestamps();

             
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
