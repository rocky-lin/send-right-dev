<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_details', function (Blueprint $table) {
            
            $table->increments('id');  

            /**
             * Foreign key of labels table
             */
            $table->integer('label_id')->unsigned(); 

            /**
             * This could be form id or campaign id
             */
            $table->integer('table_id')->unsigned();
 

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
        Schema::dropIfExists('label_details');
    }
}
