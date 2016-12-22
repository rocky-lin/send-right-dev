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
            $table->string('payment_api_id')->nullable();
            $table->string('payment_api_plan')->nullable();
            $table->timestamp('bill_start_at')->nullable();
            $table->timestamp('bill_end_at')->nullable(); 
            $table->integer('quantity')->default(0);
            $table->timestamp('trial_start_at')->nullable();
            $table->timestamp('trial_end_at')->nullable();
            $table->integer('status')->default(2); // 1 - expired,  2 - free, 3 - billed
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
