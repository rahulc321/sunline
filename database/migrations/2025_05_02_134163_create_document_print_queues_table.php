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
        Schema::create('document_print_queues', function (Blueprint $table) {
            $table->increments('id');
			
			$table->unsignedInteger("document_id")->nullable();
			$table->foreign('document_id')
      			  ->references('id')->on('documents')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->tinyInteger('is_printed')->default(0)->comment('1=Yes, 0=No');	  
			$table->tinyInteger('mail_merge_status')->default(0)->comment('1=Yes, 0=No'); 
			$table->unsignedInteger("created_by")->nullable();
			$table->foreign('created_by')
      			  ->references('id')->on('users')
      			  ->onDelete('set null');	  
				  
			$table->unsignedInteger("updated_by")->nullable();
			$table->foreign('updated_by')
      			  ->references('id')->on('users')
      			  ->onDelete('set null');	  
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_print_queues');
    }
};
