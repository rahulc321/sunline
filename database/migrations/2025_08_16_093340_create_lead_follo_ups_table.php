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
        Schema::create('lead_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->string('type')->nullable();
            $table->dateTime('date')->nullable();
            $table->text('notes')->nullable();
            $table->string('is_completed')->default(0);
            $table->timestamps();
            $table->foreign('lead_id')
            ->references('id')
            ->on('leads')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_follo_ups');
    }
};
