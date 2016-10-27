<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'registration_token' => bcrypt(strtotime("now") . rand(0, 999999)), 
    ];
});

$factory->define(App\UserAccount::class, function (Faker\Generator $faker) { 
	static $password;
    return [
	        'user_id' => App\User::create( 
	        	[
			        'name' => $faker->name,
			        'email' => $faker->unique()->safeEmail,
			        'password' => $password ?: $password = bcrypt('secret'),
			        'remember_token' => str_random(10),
			        'registration_token' => bcrypt(strtotime("now") . rand(0, 999999)), 
    			]
    		)->id, 
        'account_id' => App\Account::create()->id, 
    ];
});





$factory->define(App\Contact::class, function (Faker\Generator $faker) { 
    static $password;
    return [
           'account_id' => 1,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'location' => $faker->address,
            'phone_number' => $faker->phoneNumber,
            'telephone_number' => $faker->phoneNumber,
            'type' =>'contact',
    ];
});


 