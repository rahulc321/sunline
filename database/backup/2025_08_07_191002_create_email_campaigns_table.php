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
        Schema::create('email_campaigns', function (Blueprint $table) {
			$table->increments('id');
			$table->string('campaign_name', 255)->nullable();
			
			$table->unsignedInteger("campaign_type_id")->nullable();
			$table->foreign('campaign_type_id')
				->references('id')->on('campaign_types')
				->onDelete('set null');

			$table->date("from_date")->nullable();
			$table->date("to_date")->nullable();
			$table->tinyInteger('is_all_date')->default(0)->comment('1=Yes, 0=No');

			$table->unsignedInteger("email_come_from")->nullable();

			$table->timestamps();
			$table->softDeletes();
		});
		
		Schema::create('email_campaign_case_types', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('email_campaign_id');
			$table->unsignedInteger('case_type_id');

			$table->foreign('email_campaign_id')->references('id')->on('email_campaigns')->onDelete('cascade');
			$table->foreign('case_type_id')->references('id')->on('case_types')->onDelete('cascade');
		});
		
		Schema::create('email_campaign_lead_status', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('email_campaign_id');
			$table->unsignedInteger('lead_status_id');

			$table->foreign('email_campaign_id')->references('id')->on('email_campaigns')->onDelete('cascade');
			$table->foreign('lead_status_id')->references('id')->on('lead_status')->onDelete('cascade');
		});
		
		Schema::create('email_campaign_tags', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('email_campaign_id');
			$table->unsignedInteger('tag_id');

			$table->foreign('email_campaign_id')->references('id')->on('email_campaigns')->onDelete('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
		});
		
		Schema::create('email_campaign_marketing_source', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('email_campaign_id');
			$table->unsignedInteger('marketing_source_id');

			$table->foreign('email_campaign_id')->references('id')->on('email_campaigns')->onDelete('cascade');
			$table->foreign('marketing_source_id')->references('id')->on('intake_values')->onDelete('cascade');
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_campaign_marketing_sources');
        Schema::dropIfExists('email_campaign_tags');
        Schema::dropIfExists('email_campaign_lead_status');
        Schema::dropIfExists('email_campaign_case_types');

        Schema::dropIfExists('email_campaigns');

    }
};
