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
        Schema::create('zoom_phone_recordings', function (Blueprint $table) {
            $table->id();
            $table->string('recording_id')->unique();  // Zoom id
            $table->string('caller_number');
            $table->string('caller_name')->nullable();
            $table->string('callee_number');
            $table->string('callee_name')->nullable();
            $table->string('direction'); // inbound/outbound
            $table->integer('duration')->nullable();
            $table->string('download_url');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->string('recording_type')->nullable();
            $table->string('call_id')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_phone_recordings');
    }
};