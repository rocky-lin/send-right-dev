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
     * Here the cron jobs checking time arrive for the specific auto response details
     */
    public function up()
    {
        Schema::create('auto_response_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('auto_response_id')->unsigned();
            $table->string('table_name')->default('contacts'); // this the table name ex: contacts, 
            $table->integer('table_id')->default(0)->unsigned(); // this is the id of the table name ex: 1
            $table->string('status')->default('active'); // 
            $table->string('email')->nullable(); // email address of the receiver
            $table->string('mobile_number')->nullable(); // mobile number of the receiver
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
