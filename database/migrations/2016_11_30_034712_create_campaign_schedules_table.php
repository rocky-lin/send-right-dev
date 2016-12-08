<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_schedules', function (Blueprint $table) {
            $table->increments('id');  
             $table->integer('campaign_id'); 
             $table->string('repeat', 100)->default('one time');
             $table->dateTime('schedule_send');  
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
        Schema::dropIfExists('campaign_schedules');
    }
}
