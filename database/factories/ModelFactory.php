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

 
$factory->define(App\List1::class, function (Faker\Generator $faker) { 
    static $password; 
    return [ 
            'account_id'=>1,
            'name' => $faker->firstName . ' ' . $faker->lastName,
            'url' => 'http://wwww.google.com',
            'reminder' => $faker->sentence,
    ];
});
 
$factory->define(App\ListContact::class, function (Faker\Generator $faker) { 
    static $password; 
    return [
           'list_id' => rand(1,App\List1::count()),
            'contact_id' => rand(1,App\Contact::count()) 
    ];
});
 


$factory->define(App\Form::class, function (Faker\Generator $faker) { 
    static $password; 
    return [
           'account_id' => 1, 
            'name' => $faker->firstName,
            'config_email'=> $faker->email,
            'folder_name' => $faker->name,
            'content' => $faker->paragraph,
            'redirect_url' =>  'http://www.google.com',
            'response' => $faker->sentence,
            'simple_embedded' => $faker->paragraph,
            'full_embedded' => $faker->paragraph,
            'opt_in_message' => $faker->paragraph  
    ];
});
 
$factory->define(App\FormList::class, function (Faker\Generator $faker) { 
    static $password; 
    return [ 
            'form_id' => rand(1,App\Form::count()),
            'folder_name' => rand(1,100),
            'list_id' => rand(1,App\List1::count())

    ];
});

$factory->define(App\FormEntry::class, function (Faker\Generator $faker) { 
    static $password; 
    return [ 
            'form_id' => rand(1,App\Form::count()),
            'content' => json_encode(['about me'=>$faker->paragraph,'name'=>$faker->name, 'age'=>rand(1,100)])
    ];
});
 

   //  $table->increments('id');    
   //  $table->string('sender_name', 50);
   //  $table->string('sender_email', 75);
   //  $table->string('sender_subject'); 
   //  $table->string('title'); 
   //  $table->text('content');
   //  $table->string('type', 50);
   //  $table->string('status', 50); 
 // 
$factory->define(App\Campaign::class, function (Faker\Generator $faker) { 
    static $password; 

    $typeA = ['direct send', 'schedule']; 
    $statusA = ['active', 'inactive'];

    return [
        'account_id' =>  1,
        'sender_name'=> $faker->firstName,
        'sender_email'=> $faker->email,
        'sender_subject'=> $faker->firstName . ' ' . $faker->lastName,
        'title'=> $faker->lastName,
        'content'=> $faker->paragraph,
        'type'=> $typeA[rand(0,1)],
        'status'=> $statusA[rand(0,1)]
    ];
});







 