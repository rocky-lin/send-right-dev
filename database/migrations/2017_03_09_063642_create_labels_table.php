<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) { 

            $table->increments('id');

            /**
             * account id of the user
             */
            $table->integer('account_id')->unsigned();
            
            /**
             *  form, campaign
             */
            $table->string('type')->default('form');    
            
            /**
             * Name of the label
             */
            $table->string('name')->nullable();    
            
            
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
        Schema::dropIfExists('labels');
    }
}