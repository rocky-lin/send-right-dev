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
            $table->integer('account_id')->nullable(); 
            $table->integer('campaign_id')->nullable(); 
            $table->integer('total_send')->nullable();
            $table->integer('total_arrival')->nullable(); 
            $table->integer('total_open')->nullable(); 
            $table->integer('total_click')->nullable(); ; 
            $table->integer('total_unsubscribe')->nullable();  
            $table->integer('total_complain')->nullable();  
            $table->double('total_arrival_rate')->nullable();  
            $table->double('total_open_rate')->nullable();   
            $table->double('total_click_rate')->nullable();  
            $table->double('total_unsubscribe_rate')->nullable();    
            $table->dateTime('last_sent_date_time')->nullable();   
            $table->string('status')->nullable();   
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
