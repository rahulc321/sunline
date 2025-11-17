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
        Schema::create('lead_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->decimal('solar_commission', 10, 2)->default(0);
            $table->decimal('battery_commission', 10, 2)->default(0);
            $table->decimal('total_commission', 10, 2)->default(0);
            $table->timestamps();

            # if lead deleted, delete commission
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_commissions');
    }
};
