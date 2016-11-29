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
            $table->string('sender_name', 50);
            $table->string('sender_email', 75);
            $table->string('sender_subject'); 
            $table->string('title'); 
            $table->text('content');
            $table->string('type', 50);
            $table->string('status', 50); 
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
