<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) { 
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->integer('product_id')->unsigned(); 
            $table->string('payment_api_id');
            $table->string('payment_api_plan');
            $table->timestamp('bill_start_at')->nullable();
            $table->timestamp('bill_end_at')->nullable(); 
            $table->integer('quantity'); 
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
