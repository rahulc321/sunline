<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDialerTables extends Migration
{
    public function up()
    {
        // Call queue — pending/active calls waiting for an agent
        Schema::create('dialer_queue', function (Blueprint $table) {
            $table->id();
            $table->string('project_key')->default('ncms')->index();
            $table->unsignedBigInteger('case_id')->nullable()->index();
            $table->unsignedBigInteger('assigned_agent_id')->nullable()->index();
            $table->string('phone')->index();
            $table->string('contact_name')->nullable();
            $table->enum('status', ['pending', 'calling', 'completed', 'skipped', 'failed'])->default('pending')->index();
            $table->enum('call_type', ['auto', 'manual'])->default('auto');
            $table->unsignedTinyInteger('priority')->default(5); // 1=highest, 10=lowest
            $table->unsignedSmallInteger('attempt')->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('called_at')->nullable();
            $table->timestamps();

        });

        // Call detail records — one row per completed/attempted call
        Schema::create('dialer_calls', function (Blueprint $table) {
            $table->id();
            $table->string('project_key')->default('ncms')->index();
            $table->unsignedBigInteger('queue_id')->nullable()->index();
            $table->unsignedBigInteger('case_id')->nullable()->index();
            $table->unsignedBigInteger('agent_id')->nullable()->index();
            $table->string('phone');
            $table->string('twilio_call_sid')->nullable()->unique();
            $table->enum('direction', ['outbound', 'inbound'])->default('outbound');
            $table->enum('status', ['initiated', 'ringing', 'in-progress', 'completed', 'busy', 'no-answer', 'failed', 'canceled'])->default('initiated');
            $table->enum('disposition', ['contacted', 'voicemail', 'no_answer', 'busy', 'wrong_number', 'callback_requested', 'not_interested'])->nullable();
            $table->unsignedSmallInteger('duration')->default(0); // seconds
            $table->string('recording_url')->nullable();
            $table->string('recording_sid')->nullable();
            $table->text('agent_notes')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();

        });

        // Agent status — tracks each agent's current dialer state
        Schema::create('dialer_agent_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->index();
            $table->enum('status', ['offline', 'available', 'on_call', 'wrap_up', 'break'])->default('offline');
            $table->string('twilio_identity')->nullable(); // browser client identity
            $table->unsignedBigInteger('current_call_id')->nullable();
            $table->timestamp('status_changed_at')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('dialer_agent_status');
        Schema::dropIfExists('dialer_calls');
        Schema::dropIfExists('dialer_queue');
    }
}
