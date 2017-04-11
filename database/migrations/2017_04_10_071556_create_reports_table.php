<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('account_id'); 
            $table->integer('campaign_id'); 
            $table->integer('total_send'); 
            $table->integer('total_arrival'); 
            $table->integer('total_open'); 
            $table->integer('total_click'); 
            $table->integer('total_unsubscribe'); 
            $table->integer('total_complain'); 
            $table->double('total_arrival_rate'); 
            $table->double('total_open_rate'); 
            $table->double('total_click_rate'); 
            $table->double('total_unsubscribe_rate');   
            $table->dateTime('last_sent_date_time');   
            $table->dateTime('status');   
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
        Schema::dropIfExists('reports');
    }
}
