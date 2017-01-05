<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_responses', function (Blueprint $table) {
            $table->increments('id'); // auto response id foreign key of auto response details
            $table->integer('campaign_id')->unsigned(); // this is the campaign template the kind should be auto response
            $table->string('table_name')->nullable(); // this is table name that is assigned to the auto response ex: contacts, campangns
            $table->integer('table_id')->unsigned(); // this is the table id that is assigned to the auto response ex: 1,2,3,4
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
        Schema::dropIfExists('auto_responses');
    }
}
