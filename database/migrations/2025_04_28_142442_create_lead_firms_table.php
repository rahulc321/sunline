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
        Schema::create('lead_firms', function (Blueprint $table) {
            $table->increments('id');
			
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');

            $table->unsignedInteger("firm_type_id")->nullable();
			$table->foreign('firm_type_id')
      			  ->references('id')->on('firm_types')
      			  ->onDelete('set null');
				  
			$table->string('firm_name')->nullable();	  
			$table->string('firm_percentage')->nullable();	  
				  
			$table->unsignedInteger("firm_override_type_id")->nullable();
			$table->foreign('firm_override_type_id')
      			  ->references('id')->on('firm_override_types')
      			  ->onDelete('set null');	

			$table->string('firm_override_fee_share')->nullable();		
			$table->string('firm_agreement_in_place')->nullable();	

			$table->unsignedInteger("firm_referral_status_id")->nullable();
			$table->foreign('firm_referral_status_id')
      			  ->references('id')->on('firm_referral_status')
      			  ->onDelete('set null');				  
            
			$table->enum('firm_status',['1', '0'])->default('1');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_firms');
    }
};
