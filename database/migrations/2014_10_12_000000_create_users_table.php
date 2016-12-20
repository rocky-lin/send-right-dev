<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50); 
            $table->string('email', 50)->unique(); 
            $table->string('first_name')->nullable(); 
            $table->string('last_name')->nullable();  
            $table->string('password');
            $table->string('registration_token');
            $table->string('status', 25)->default('inactive');  
            $table->rememberToken(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
