<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_analytics', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('table_id'); 
            $table->string('table_name',50); 
            $table->string('open_or_read',10)->default('off')->nullable();
            $table->string('click_link',10)->default('off')->nullable();
            $table->string('reply',10)->default('off')->nullable();  
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
        Schema::dropIfExists('email_analytics');
    }
}
