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
        Schema::create('document_path', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('parent_id')->nullable();
			$table->unsignedInteger("intake_id")->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('parent_id')->references('id')->on('document_path')->onDelete('CASCADE');
			$table->foreign('intake_id')->references('id')->on('intakes')->onDelete('CASCADE')->onUpdate('CASCADE');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_path');
    }
};
