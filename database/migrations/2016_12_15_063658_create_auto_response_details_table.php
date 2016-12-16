<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoResponseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_response_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('auto_response_id')->unsigned();
            $table->string('table_name')->default('contacts');
            $table->integer('table_id')->default(0)->unsigned();
            $table->string('status')->default('active');
            $table->string('email');
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
        Schema::dropIfExists('auto_response_details');
    }
}