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
        Schema::create('form_question_answers', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
            $table->string('question_id','100')->nullable();
            $table->string('answer','255')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_question_answers');
    }
};
