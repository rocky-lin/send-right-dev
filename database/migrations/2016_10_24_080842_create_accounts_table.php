<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');  
            $table->string('user_name')->nullable(); 
            $table->string('company')->nullable();  
            $table->string('time_zone')->nullable();  
            $table->string('payment_api_id')->nullable();

            // card info
            $table->string('billing_card_holder_name')->nullable();
            $table->string('billing_card_number')->nullable();
            $table->string('billing_card_month_expiry')->nullable();
            $table->string('billing_card_year_expiry')->nullable();
            $table->string('billing_card_cvv')->nullable();

            // billing address
            $table->string('billing_address')->nullable();
            $table->string('billing_address_street')->nullable();
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_address_city')->nullable();
            $table->string('billing_address_state')->nullable();
            $table->string('billing_address_zip_code')->nullable();

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
        Schema::dropIfExists('accounts');
    }
}
