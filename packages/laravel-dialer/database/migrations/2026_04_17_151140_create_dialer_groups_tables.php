<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Agent groups — each group has one Twilio inbound number
        Schema::create('dialer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('twilio_number', 20)->nullable();       // E.164 e.g. +15551234567
            $table->string('twilio_number_sid', 50)->nullable();   // Twilio PhoneNumber SID (PNxxx)
            $table->string('trigger_type', 30)->nullable();        // case_stage | checklist_code
            $table->string('trigger_value')->nullable();           // e.g. "Hearing Level" or "SA1"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Group members — agents assigned to a group with an extension
        Schema::create('dialer_group_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->string('extension', 10)->nullable();           // e.g. "101"
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['group_id', 'user_id']);
            $table->unique(['group_id', 'extension']);
        });

        // Purchased Twilio numbers — inventory of all numbers bought via the portal
        Schema::create('dialer_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 20);                    // E.164
            $table->string('twilio_sid', 50)->unique();            // PNxxx
            $table->string('friendly_name')->nullable();           // Twilio label
            $table->string('country', 5)->default('US');
            $table->unsignedBigInteger('group_id')->nullable();    // assigned group
            $table->boolean('is_active')->default(true);
            $table->timestamp('purchased_at')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dialer_group_members');
        Schema::dropIfExists('dialer_phone_numbers');
        Schema::dropIfExists('dialer_groups');
    }
};
