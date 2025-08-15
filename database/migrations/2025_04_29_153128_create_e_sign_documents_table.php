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
        Schema::create('e_sign_documents', function (Blueprint $table) {
			$table->increments('id');
			
			$table->unsignedInteger("case_type_id")->nullable();
			$table->foreign('case_type_id')
      			  ->references('id')->on('case_types')
      			  ->onDelete('set null');	 	  
				  
			$table->string('document_name')->nullable();
			$table->text('document_path')->nullable();
			$table->string('document_size')->nullable();	
			$table->string('document_type')->nullable();	
			$table->longtext('description')->nullable();
			
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
        Schema::dropIfExists('e_sign_documents');
    }
};
