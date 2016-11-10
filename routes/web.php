<?php  
  Auth::loginUsingId(1);  
// welcome page for loggedout
Route::get('/', function () { 
    return view('welcome');
})->middleware('guest'); 
// Authentication
Auth::routes();  
// home page dispaly
Route::get('/home', 'HomeController@index'); 
Route::get('/home/test', 'HomeController@test'); 

Route::group(['prefix' => 'user' ], function() {    

	// when confirm user registration
	Route::group(['prefix'=>'registration'], function(){
		Route::get('confirm', "Auth\RegisterController@confirmUserRegistration")->name('user.registration.confirm'); 
  	});    

	// contact 
	Route::get('contact/{contact}/get', 'ContactController@getById')->name('user.contact.get.by.id');
  	Route::get('contact/get/all', 'ContactController@getUserAccountContacts')->name('user.contact.get.all'); 
  	Route::get('contact/import', 'ContactController@import')->name('user.contact.import');
  	Route::post('contact/import/store', 'ContactController@importStore')->name('user.contact.import.store');
  	

  	Route::resource('contact', 'ContactController'); 
  
	// list   
	Route::get('list/get/all', 'ListController@getListsAndDetails');  
	Route::get('list/get/{id}', 'ListController@getLists');  
	Route::get('list/get/{id}/contacts', 'ListController@getListContacts');  
	
	 
  	Route::resource('list', 'ListController');  
 
	//  form 
	Route::get('form/get/all', 'FormController@getUserAccountForms')->name('user.form.get.all'); 
	Route::resource('form', 'FormController');
});   
 
Route::get('send-slack-notification', function(){
	$user = App\User::find(1); 
	$user->notify(new App\Notifications\PaymentDeadlineNotification());
});

/**
 * Documentation: http://www.maatwebsite.nl/laravel-excel/docs/import#extra
 * 
 */
Route::get('csv', function(){


	print "<h4>This is the csv file</h4>"; 

	Excel::load('E:\xampp\htdocs\rocky\send-right-dev\public\files\import\contacts\export.csv', function($reader) { 
	    // reader methods 
		print "excel file loaded";
		 $results = $reader->skip(false)->take(10)->get();
		 dd($results);
	});
}); 
 