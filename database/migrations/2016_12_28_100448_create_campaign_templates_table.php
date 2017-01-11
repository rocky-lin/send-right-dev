<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_templates', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('account_id')->unsigned(); 
            $table->string('name')->nullable(); 
            $table->string('category')->nullable(); 
            $table->string('type')->default('newsletter'); 
            $table->text('content')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_templates');
    }
}
