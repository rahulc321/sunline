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
        Schema::create('e_sign_document_status', function (Blueprint $table) {
			$table->increments('id');
			
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			
			$table->unsignedInteger("signer_id")->nullable();
			$table->foreign('signer_id')
      			  ->references('id')->on('users')
      			  ->onDelete('set null');
				  
			$table->string('order_no')->nullable();
			$table->string('envelope_id')->nullable();
			$table->string('template_name')->nullable();	
			$table->string('signed_status')->nullable();	
			$table->string('envelope_status')->nullable();
			
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
        Schema::dropIfExists('e_sign_document_status');
    }
};
