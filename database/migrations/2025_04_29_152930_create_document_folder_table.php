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
        Schema::create('document_folder', function (Blueprint $table) {
            $table->increments('id');

            $table->string('folder_name')->nullable();
			$table->tinyInteger('is_default')->default(0)->comment('1=Yes, 0=No');
			$table->integer('order')->default(0);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_folder');
    }
};
