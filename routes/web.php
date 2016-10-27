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
Route::group(['prefix' => 'user'], function() {    
	// when confirm user registration
	Route::group(['prefix'=>'registration'], function(){
		Route::get('confirm', "Auth\RegisterController@confirmUserRegistration")->name('user.registration.confirm'); 
  	});    
	// contact 
  	Route::resource('contact', 'ContactController'); 
  	Route::get('get/all', 'ContactController@getUserAccountContacts')->name('user.contact.get.all');
	// list   
	//  form 
});  
 /**
* Test  
Route::get('get', function() { 	 
  	return App\User::getUserAccountContacts();
}); 

















/* 
use App\Notifications\UserRegistered; 
Route::group(['prefix' => 'test'], function() { 

	//send notification email
	Route::get('mail-notification', function() {     
		$user = Auth::user(); 
		$user->notify(new UserRegistered($user));  
	}); 
	// send email 
	Route::get('/mail', function() {   
		Mail::to('mrjesuserwinsuarez@gmail.com', 'Jesus')->send(new  App\Mail\UserRegistered());
	}); 

	Route::get('/html-builder', function() {
		return view('test.html');
	}); 

});


