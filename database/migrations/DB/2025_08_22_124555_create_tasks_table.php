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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable(); # task details
            $table->enum('status', ['pending', 'inprogress', 'completed'])->default('pending'); # status
            $table->unsignedBigInteger('assigned_to'); # user id (who task is assigned to)
            $table->dateTime('due_date')->nullable();
            $table->string('priority')->nullable(); 
            $table->string('task_type')->nullable();

            $table->timestamps();

            
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
