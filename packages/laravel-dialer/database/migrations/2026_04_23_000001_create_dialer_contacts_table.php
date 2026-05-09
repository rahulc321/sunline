<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dialer_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('project_key')->default('default')->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable();
            $table->string('state', 2)->nullable();
            $table->boolean('has_consent')->default(true);
            $table->text('notes')->nullable();
            $table->timestamp('last_called_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dialer_contacts');
    }
};
