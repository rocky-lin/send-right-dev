<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) { 
            $table->increments('id');
            $table->integer('account_id');
            $table->string('sender_name', 50)->nullable(); // sender name
            $table->string('sender_email', 75)->nullable(); // sender email
            $table->string('sender_subject')->nullable(); // sender subject 
            $table->string('title')->nullable(); // title of the campaign
            $table->text('content')->nullable(); // content of the campaign
            $table->smallInteger('batch_send')->default(0); // batch total email sent 
            $table->string('type_send', 50)->default('email'); // email 
            $table->string('type', 50)->default('direct send'); // direct send, schedule send, one time, daily, monthly
            $table->string('kind')->default('newsletter'); // newsletter, mobile optin and autoresponder
            $table->string('status', 50)->default('inactive');    // active or inactive

            

            // mobile email optin
            $table->string('email_address')->nullable();  
            $table->string('optin_url')->nullable();  
            $table->string('optin_email_subject')->nullable();  
            $table->string('optin_email_content')->nullable(); 
            $table->string('optin_popup_link')->nullable(); 
            $table->string('optin_email_to_name')->nullable(); 
            $table->string('optin_email_to_mail')->nullable();  


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
        Schema::dropIfExists('campaigns');
    }
}
