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
        Schema::create('documents', function (Blueprint $table) {
			$table->increments('id');
			
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			
			$table->unsignedInteger("document_category_id")->nullable();
			$table->foreign('document_category_id')
      			  ->references('id')->on('document_category')
      			  ->onDelete('set null');
				  
			$table->unsignedInteger("document_folder_id")->nullable();
			$table->foreign('document_folder_id')
      			  ->references('id')->on('document_folder')
      			  ->onDelete('set null');

			$table->unsignedInteger('path_id')->nullable();
			$table->foreign('path_id')
				  ->references('id')->on('document_path')
				  ->onDelete('set null');			
			
			$table->string('document_title')->nullable();	
			$table->text('document_path')->nullable();
			$table->string('document_name')->nullable();
			$table->string('document_type')->nullable();
			$table->string('document_size')->nullable();
			$table->longtext('description')->nullable();	
			$table->string('created_by')->nullable();	  
			$table->string('updated_by')->nullable();
			
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
