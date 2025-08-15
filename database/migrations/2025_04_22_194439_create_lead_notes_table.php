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
        Schema::create('lead_notes', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("user_id")->nullable();
			$table->foreign('user_id')
      			  ->references('id')->on('users')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("category_id")->nullable();
			$table->foreign('category_id')
      			  ->references('id')->on('notes_category')
      			  ->onDelete('set null');
			$table->tinyInteger('is_pinned')->default(0)->comment('0: Not Pinned 1: Pinned');		
			$table->longtext("notes")->nullable();	  
			$table->string('attachment',255)->nullable();	  
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_notes');
    }
};
