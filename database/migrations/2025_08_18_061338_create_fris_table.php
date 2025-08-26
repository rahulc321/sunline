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
        Schema::create('fris', function (Blueprint $table) {
            $table->id();
            $table->string('project')->nullable();
            $table->string('client')->nullable();
            $table->string('category')->nullable();
            $table->string('priority')->nullable();
            $table->date('due_date')->nullable(); // better to store as date instead of string
            $table->unsignedBigInteger('assigned_to')->nullable(); // assuming this links to users
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('fri_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fri_id'); // foreign key to fris table
            $table->string('image_path'); // store path or filename
            $table->timestamps();
        
            $table->foreign('fri_id')
                  ->references('id')
                  ->on('fris')
                  ->onDelete('cascade'); // delete images if FRI is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fris');
    }
};
