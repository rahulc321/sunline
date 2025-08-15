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
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->enum("nature",['individual_contact','business_contact'])->default('individual_contact');
			$table->unsignedInteger("type")->nullable();
			$table->foreign('type')
      			  ->references('id')->on('contact_types')
      			  ->onDelete('set null');
			$table->unsignedInteger("prefix")->nullable();
			$table->foreign('prefix')
      			  ->references('id')->on('contact_prefixes')
      			  ->onDelete('set null');	  
			$table->string('first_name')->nullable();
			$table->string('middle_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('display_name')->nullable();
			$table->string('suffix')->nullable();
			$table->enum("gender",['M','F'])->nullable();
			$table->string('email')->nullable();
			$table->string('contact_preference')->nullable();
			$table->string('phone')->nullable();
			$table->string('whentocontact')->nullable();
			$table->unsignedInteger("language")->nullable();
			$table->foreign('language')
      			  ->references('id')->on('languages')
      			  ->onDelete('set null');
			$table->string('alias')->nullable();
			$table->unsignedInteger("marital_status")->nullable();
			$table->string('company_name')->nullable();
			$table->string('job_title')->nullable();
			$table->string('ssn')->nullable();
			$table->string('work_phone')->nullable();
			$table->string('home_phone')->nullable();			
			$table->string('fax')->nullable();			
			$table->string('secondary_email')->nullable();			
			$table->string('drivers_license')->nullable();			
			$table->date('dob')->nullable();			
			$table->date('dodeath')->nullable();			
			$table->date('dobankruptcy')->nullable();			
			$table->text('notes')->nullable();			
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
