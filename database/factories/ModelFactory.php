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
        'name' => $faker->firstName . ' ' . $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'), 
        'first_name' => $faker->firstName, 
        'last_name' => $faker->lastName,
        'remember_token' => str_random(10),
        'registration_token' => bcrypt(strtotime("now") . rand(0, 999999)),
    ];
});
 
$factory->define(App\Account::class, function (Faker\Generator $faker) {
    static $password; 
    return [ 
        'user_name'=>$faker->userName,
        'company' =>$faker->company,
        'time_zone'=>$faker->timezone 
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
        'account_id' => rand(1, App\Account::count()), 
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

    $typeA = ['direct send', 'schedule send']; 
    $statusA = ['active', 'inactive'];

    $kind = 'newsletter';


    return [
        'account_id' =>  1,
        'sender_name'=> $faker->firstName,
        'sender_email'=> $faker->email,
        'sender_subject'=> $faker->firstName . ' ' . $faker->lastName,
        'title'=> $faker->lastName,
        'content'=> $faker->paragraph,
        'type'=> $typeA[rand(0,1)],
        'kind' => $kind,
        'status'=> $statusA[rand(0,1)]
    ];
});

$factory->define(App\CampaignSchedule::class, function (Faker\Generator $faker) {   
    return [ 
        'campaign_id' =>1,
        'repeat' =>'One Time',
        'schedule_send' =>Carbon\Carbon::now()
    ];
}); 

//
$factory->define(App\Newsletter::class, function (Faker\Generator $faker) {   
    return [ 
        'account_id' =>1,
        'content'=>$faker->paragraph,
        'status'=>'active' 
    ];
});
 
$factory->define(App\AutoResponseDetails::class, function (Faker\Generator $faker) {   
    return [ 
        'auto_response_id'=> 1,
        'table_name'=> 'contacts', 
        'table_id'=> 0,
        'status'=> 'active',
        'email'=> $faker->email
    ];
}); 

$factory->define(App\Subscription::class, function (Faker\Generator $faker) {   
    return [ 
        'account_id'=> rand(1, App\Account::count()),
        'product_id'=> rand(1, App\Product::count()), 
        'payment_api_id'=> bcrypt('secret'),
        'payment_api_plan'=>bcrypt('secret'), 
        'quantity'=> rand(1,200)
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {   
    return [ 
        'name' => 'Bronze',
        'description' => $faker->paragraph,
        'price' => rand(100, 2000),
        'unit' => 'USD'
    ];
});

$factory->define(App\ProductDetail::class, function (Faker\Generator $faker) {   
    return [  
        'product_id' =>  rand(1, App\Product::count()),
        'name' => $faker->name
    ];
});
$factory->define(App\Invoice::class, function (Faker\Generator $faker) {   
    return [  
        'account_id' => rand(1, App\Account::count()),
        'product_id' => rand(1, App\Product::count()),
        'total_amount' => rand(200, 2000),
    ];
});
 $factory->define(App\AddOn::class, function (Faker\Generator $faker) {
    return [
        'account_id' => rand(1, App\Account::count()),
        'name' => $faker->name
    ];
});
 $factory->define(App\Language::class, function (Faker\Generator $faker) {
    return [
        'name' => "en",
        'status' => 'active'
    ];
});
