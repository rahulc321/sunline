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
        Schema::create('lead_expenses', function (Blueprint $table) {
            $table->increments('id');
			
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');

            $table->unsignedInteger("cost_type_id")->nullable();
			$table->foreign('cost_type_id')
      			  ->references('id')->on('cost_types')
      			  ->onDelete('set null');
				  
			$table->date('date_issued')->nullable();	  
			$table->string('invoice_no')->nullable();	  
			$table->string('amount_billed')->nullable();	  
			$table->string('qty')->nullable();	  
			$table->string('total')->nullable();	

			$table->unsignedInteger("expense_category_id")->nullable();
			$table->foreign('expense_category_id')
      			  ->references('id')->on('expense_category')
      			  ->onDelete('set null');
				  
			$table->enum('billable_to_client',['1', '0'])->default('1');			
			$table->string('description')->nullable();
			
			$table->string('document')->nullable();	
			
			$table->unsignedInteger("document_category_id")->nullable();
			$table->foreign('document_category_id')
      			  ->references('id')->on('document_category')
      			  ->onDelete('set null');
				  	  
			$table->string('document_description')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_expenses');
    }
};
