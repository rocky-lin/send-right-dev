<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) { 
            $table->increments('id');
            $table->integer('account_id');
            $table->string('sender_name', 50)->nullable();
            $table->string('sender_email', 75)->nullable();
            $table->string('sender_subject')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable(); 
            $table->smallInteger('batch_send')->default(0); 
            $table->string('type_send', 50)->default('email'); 
            $table->string('type', 50)->default('direct send');
            $table->string('status', 50)->default('inactive'); 
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
        Schema::dropIfExists('campaigns');
    }
}
