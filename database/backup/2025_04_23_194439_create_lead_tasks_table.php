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
        Schema::create('lead_tasks', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger("intake_id")->nullable();
			$table->foreign('intake_id')
      			  ->references('id')->on('intakes')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("type_id")->nullable();
			$table->foreign('type_id')
      			  ->references('id')->on('task_types')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("category_id")->nullable();
			$table->foreign('category_id')
      			  ->references('id')->on('tasks_category')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->string('subject',255)->nullable();		
			$table->unsignedInteger("assigned_to")->nullable();
			$table->foreign('assigned_to')
      			  ->references('id')->on('users')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');
			$table->unsignedInteger("assigned_by")->nullable();
			$table->foreign('assigned_by')
      			  ->references('id')->on('users')
      			  ->onDelete('CASCADE')
      			  ->onUpdate('CASCADE');	
			$table->date('assigned_date')->nullable();		
			$table->datetime('due_date')->nullable();		
			$table->string('priority',100)->nullable();	  
			$table->string('activity',100)->nullable();
			$table->enum('billable_to_client',['0', '1'])->nullable();			
			$table->enum('notify_assignee',['0', '1'])->nullable();		  
			$table->enum('add_calander_event',['0', '1'])->nullable();
            $table->string('calander_event',255)->nullable();	  			
			$table->enum('appointment_reminder',['0', '1'])->nullable();		  
			$table->enum('status',['0', '1'])->nullable();		  
			$table->longtext("description")->nullable();	  
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_tasks');
    }
};
