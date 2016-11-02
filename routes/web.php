<?php  
// Auth::loginUsingId(1);  
// welcome page for loggedout
Route::get('/', function () { 
    return view('welcome');
})->middleware('guest'); 
// Authentication
Auth::routes();  
// home page dispaly
Route::get('/home', 'HomeController@index'); 

Route::group(['prefix' => 'user' ], function() {    
	// when confirm user registration
	Route::group(['prefix'=>'registration'], function(){
		Route::get('confirm', "Auth\RegisterController@confirmUserRegistration")->name('user.registration.confirm'); 
  	});    
	// contact 
  	Route::resource('contact', 'ContactController'); 
  	Route::get('contact/{contact}/get', 'ContactController@getById')->name('user.contact.get.by.id');
  	Route::get('get/all', 'ContactController@getUserAccountContacts')->name('user.contact.get.all'); 
	// list   

	//  form 
});   
 
Route::get('send-slack-notification', function(){
	$user = App\User::find(1); 
	$user->notify(new App\Notifications\PaymentDeadlineNotification());
});