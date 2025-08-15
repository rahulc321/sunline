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
        Schema::create('calendar_share_users', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("user_id")->nullable();
			$table->foreign('user_id')
      			  ->references('id')->on('users')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("shared_user_id")->nullable();	  
			$table->foreign('shared_user_id')
      			  ->references('id')->on('users')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->enum('permission_type',['1','2'])->nullable()->comment('1:View Calendar 2:Edit Calendar');		
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_share_users');
    }
};
