<?php   

// Auth::loginUsingId(1);  
// welcome page for loggedout
Route::get('/', function () {

	// PRINT "TEST"; 
	// $current = Carbon::now();
	// $current = new Carbon(); 
	// // get today - 2015-12-19 00:00:00
	// $today = Carbon::today();
	// PRINT "TODAY" . $today; 
	// put condition here to validate if you are visiting extensions or not
	// visiting extension page - no need to redirect because we need to use the functions of laravel
	// if visited the main pages then we need to redirect to home because it must be logged in
	// return view('welcome');
});
Route::post('/', function () {
	// put condition here to validate if you are visiting extensions or not
	// visiting extension page - no need to redirect because we need to use the functions of laravel
	// if visited the main pages then we need to redirect to home because it must be logged in
	// return view('welcome');
});
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
	Route::get('list/search/{name?}', 'ListController@searchLists');  
  	Route::resource('list', 'ListController');   

	//  form  
	Route::get('form/get/all', 'FormController@getUserAccountForms')->name('user.form.get.all');   
	Route::get('form/list/connect/view', 'FormController@viewConnectList')->name('user.form.list.connect.view'); 
	Route::post('form/register/step1', 'FormController@registerNewFormStep1')->name('user.form.register.step1'); 
	// Route::get('form/list/connect/get', 'FormController@getUserAccountForms')->name('user.form.list.connect.get'); 
	Route::get( 'form/{id}/contacts/view', 'FormController@viewContacts' )->name('form.contacts.view');
	Route::get( 'form/{id}/contacts/get', 'FormController@getContacts' )->name('form.contacts.get');
	Route::post('form/list/connect/post', 'FormController@postConnectList')->name('user.form.list.connect.post');  
	Route::resource('form', 'FormController');   

	// campaign 
	// 
	// create step 1
		Route::get('campaign/get/all', 'CampaignController@getAllCampaign')->name('user.campaign.get.all');
	    Route::post('campaign/create/validate', 'CampaignController@createValidate')->name('user.campaign.create.validate');
    	Route::post('campaign/create/update/{id?}', 'CampaignController@createUpdate')->name('user.campaign.create.update');


		// create step 2
		Route::get('campaign/create/sender', 'CampaignController@createSender')->name('user.campaign.create.sender.view');
		Route::post('campaign/create/sender', 'CampaignController@createSenderValidate')->name('user.campaign.create.sender.validate');
		Route::post('campaign/create/sender/update/{id?}', 'CampaignController@createSenderUpdate')->name('user.campaign.sender.update');

		// step 3
			Route::post('campaign/create/compose', 'CampaignController@composeValidate')->name('user.campaign.create.settings.validate'); 
		// creation of campaign
		
		// step 4
		Route::get('campaign/create/settings', 'CampaignController@createSettings')->name('user.campaign.create.settings');
		Route::post('campaign/create/settings', 'CampaignController@createSettingsValidate')->name('user.campaign.create.settings.validate'); 


		// preview 
		 	Route::get('campaign/create/settings/preview/mobile', 'CampaignController@getPreviewMobile')->name('user.campaign.create.settings.preview.mobile');
		 	Route::get('campaign/create/settings/preview/desktop', 'CampaignController@getPreviewDesktop')->name('user.campaign.create.settings.preview.desktop');
		 	Route::get('campaign/create/settings/preview/tablet', 'CampaignController@getPreviewTablet')->name('user.campaign.create.settings.preview.tablet');

 	// create step 1
	Route::resource('campaign', 'CampaignController');  	  

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
	Excel::load('E:\xampp\htdocs\rocky\send-right-dev\public\files\import\contacts\export.csv', function($reader) { 
	    // reader methods 
		print "excel file loaded";
		 $results = $reader->skip(false)->take(10)->get();
		 dd($results);
	});
}); 



// Testing development 
Route::get('ng-bootstrap-ui', function(){
	return view('test.ng-strap');
}); 
 


