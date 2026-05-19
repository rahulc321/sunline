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
        Schema::create('intakes', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("contact_id")->nullable();
			$table->foreign('contact_id')
      			  ->references('id')->on('contacts')
      			  ->onDelete('set null');
            $table->string('case_role',100)->nullable();
            $table->string('case_type',100);
            $table->string('status',100);
            $table->string('marketing_source',100);
            $table->string('assignee',100);
            $table->string('owner',100)->nullable();
            $table->string('ad_campaign',100)->nullable();
			$table->string('office_location',100)->nullable();
			$table->string('attorney',100)->nullable();
			$table->string('contact_method',255)->nullable();
			$table->decimal('estimated_case_value',10,2)->nullable();	
			$table->tinyInteger("rating")->nullable();
			$table->unsignedInteger("call_outcomes")->nullable();
			$table->foreign('call_outcomes')
      			  ->references('id')->on('lead_call_outcomes')
      			  ->onDelete('set null');
			$table->enum('read_status',['read','unread'])->default('unread');
            $table->text('case_description')->nullable();
			$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intakes');
    }
};
