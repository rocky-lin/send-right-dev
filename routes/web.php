<?php   
// Auth::loginUsingId(1);  
// welcome page for loggedout
// use Auth; 
 
Route::get('user/registration/create/{email?}/{fullName?}/{password?}', 'Auth\RegisterController@createUserHttp');









Route::get('/', function () { 
	// print " url = " . url('/');  
	$url = url('/');  
	$urlArray = explode("/", $url); 
	if(in_array('extension', $urlArray)) { 
		// print "in extension"; 
	} else {   
		if(Auth::guest()) {
			// print "gues";
			return view('auth/login'); 
		} else {
			print "home";
			return redirect(url('/home'));
		} 
		// return redirect('login');
		// print "not in extension";
	} 
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
Route::post('cash/create', 'CashController@store'); 
// Route::get('admin/order', 'admin\OrderController@index');
// Route::get('admin/order/requestPay/{order_id}', 'admin\OrderController@requestPay'); 
Route::group(['prefix' => 'user' , 'middleware' =>  'auth' ], function() {


	// billing

		Route::post('billing/deactivate', 'BillingController@deactivate')->name('user.billing.deactivate');
		Route::get('billing/test', 'BillingController@testing')->name('user.billing.deactivate');




		Route::post('label-detail-delete', 'LabelDetailController@ajaxDelete');
		Route::resource('label-detail', 'LabelDetailController');

 		Route::post('campaign/template/select/post', 'CampaignController@postChooseTemplateNew')->name('user.post.campaign.select');

	    Route::post('campaign/templates/post', 'CampaignController@postChooseTemplate')->name('user.post.campaign.choose.template');

		Route::get('campaign/templates', 'CampaignController@getChooseTemplate')->name('user.get.campaign.choose.template');

		 
			
		Route::get('campaign/view', 'CampaignController@viewCampaignAll')->name('user.campaign.campaign.view');
		
	// Campaign Template 
	// 
	 	Route::get('campaign/template', 'CampaignTemplateController@getTheme')->name('user.campaign.template.get.theme'); 
		Route::resource('campaign', 'CampaignTemplateController');  	


	// Label  
	Route::resource('label', 'LabelController'); 



	// when confirm user registration
	Route::group(['prefix'=>'registration'], function(){
		Route::get('confirm', "Auth\RegisterController@confirmUserRegistration")->name('user.registration.confirm'); 
  	});    

	// contact
	//

		Route::get('contact/search/{keyword?}', 'ContactController@search')->name('user.contact.search');
		Route::get('contact/filter/status/{keyword?}', 'ContactController@filterStatus')->name('user.contact.filter.status');
		Route::get('contact/filter/list/{list_id?}', 'ContactController@filterList')->name('user.contact.filter.list');


		Route::get('contact/{contact}/get', 'ContactController@getById')->name('user.contact.get.by.id');
	  	Route::get('contact/get/all', 'ContactController@getUserAccountContacts')->name('user.contact.get.all');

	  	Route::get('contact/import/choose', 'ContactController@importChoose')->name('user.contact.import.choose');
	  	Route::post('contact/import/choose', 'ContactController@importChoosePost')->name('user.contact.import.choose.post');

	  	Route::get('contact/import/start', 'ContactController@import')->name('user.contact.import');

		Route::post('contact/import/store', 'ContactController@importStore')->name('user.contact.import.store');

		Route::get('contact/data-table/test', 'ContactController@testContact')->name('user.contact.data.table.test');


	  	Route::get('contact/unsubscribe/{id?}/{email?}', 'ContactController@unsubscribe')->name('user.contact.unsubscribe');
	  	Route::get('contact/profile/{id?}', 'ContactController@profile')->name('user.contact.profile');
	  	Route::resource('contact', 'ContactController');  

	// list   
		Route::get('list/get/all', 'ListController@getListsAndDetails');  
		Route::get('list/get/{id}', 'ListController@getLists');  
		Route::get('list/get/{id}/contacts', 'ListController@getListContacts'); 
		Route::get('list/search/{name?}', 'ListController@searchLists');  
	  	Route::resource('list', 'ListController');   

	//  form  


		Route::get('form/get/all/label/{label_id?}', 'FormController@getAllByLabel')->name('user.form.get.all.by.label');   
		Route::get('form/get/all', 'FormController@getUserAccountForms')->name('user.form.get.all');   
		Route::get('form/list/connect/view', 'FormController@viewConnectList')->name('user.form.list.connect.view'); 
		Route::post('form/register/step1', 'FormController@registerNewFormStep1')->name('user.form.register.step1'); 
		// Route::get('form/list/connect/get', 'FormController@getUserAccountForms')->name('user.form.list.connect.get'); 
		Route::get( 'form/{id}/contacts/view', 'FormController@viewContacts' )->name('form.contacts.view');
		Route::get( 'form/{id}/contacts/get', 'FormController@getContacts' )->name('form.contacts.get');
		Route::post('form/list/connect/post', 'FormController@postConnectList')->name('user.form.list.connect.post');  
		Route::resource('form', 'FormController');   

	// 	    
		Route::get('campaign/get/all/label/{label_id?}', 'CampaignController@getAllByLabel')->name('user.campaign.get.all.by.label');
		Route::get('campaign/newsletters','CampaignController@index')->name('user.campaign.newsletter.view'); 
		Route::get('campaign/auto-responders','CampaignController@autoResponderIndex')->name('user.campaign.autoresponders.view'); 
		Route::get('campaign/mobile-optin','CampaignController@mobileOptInIndex')->name('user.campaign.mobileoptin.view'); 

		// create start gate 
			Route::get('campaign/create/start','CampaignController@createStart')->name('user.campaign.create.start');
			
		// create step 1
			Route::get('campaign/get/all', 'CampaignController@getAllCampaign')->name('user.campaign.get.all');
			Route::get('campaign/get/all/now', 'CampaignController@getAllCampaignNow')->name('user.campaign.get.all.now');


		    Route::post('campaign/create/validate', 'CampaignController@createValidate')->name('user.campaign.create.validate');

	    	Route::post('campaign/create/update/{id?}', 'CampaignController@createUpdate')->name('user.campaign.create.update');

			Route::get('campaign/get/all/by/kind/{kind?}', 'CampaignController@getAllCampaignSortByKind')->name('user.campaign.get.all.sort.by.kind');




			// create step 2
			Route::get('campaign/create/sender', 'CampaignController@createSender')->name('user.campaign.create.sender.view');
			Route::post('campaign/create/sender', 'CampaignController@createSenderValidate')->name('user.campaign.create.sender.validate');
			Route::post('campaign/create/sender/update/{id?}', 'CampaignController@createSenderUpdate')->name('user.campaign.sender.update');




			// step 3
				// Route::post('campaign/create/compose', 'CampaignController@composeValidate')->name('user.campaign.create.settings.validate'); 
			// creation of campaign

			// step 4 ui and template

		

			// step 5
			Route::get('campaign/create/settings', 'CampaignController@createSettings')->name('user.campaign.create.settings');
			Route::post('campaign/create/settings', 'CampaignController@createSettingsValidate')->name('user.campaign.create.settings.validate');
	 		Route::post('campaign/create/settings-optin', 'CampaignController@createSettingsMobileOptinValidate')->name('user.campaign.create.settings.mobile.optin.validate');


	 
			// preview 
			 	Route::get('campaign/create/settings/preview/mobile', 'CampaignController@getPreviewMobile')->name('user.campaign.create.settings.preview.mobile');
			 	Route::get('campaign/create/settings/preview/desktop', 'CampaignController@getPreviewDesktop')->name('user.campaign.create.settings.preview.desktop');
			 	Route::get('campaign/create/settings/preview/tablet', 'CampaignController@getPreviewTablet')->name('user.campaign.create.settings.preview.tablet');
				Route::get('campaign/template/preview/{templateId?}', 'CampaignController@templatePreview')->name('campaign.template.preview');  
 
			// send test email 
				Route::get('campaign/create/settings/email/send/test/{id?}/{email?}', 'CampaignController@sendTestCampaignEmail')->name('user.campaign.create.settings.email.send.test');


				

 		// create step 1
		Route::resource('campaign', 'CampaignController');  	
	
		// Route::post('campaign', 'CampaignController@create')->name('user.campaign.create.post');
  
	// Home 
		Route::get('home/preview/activities', 'HomeController@previewActivities')->name('home.preview.activities');  
		Route::get('home/preview/contacts', 'HomeController@previewContacts')->name('home.preview.contacts');  
		Route::get('home/preview/lists', 'HomeController@previewLists')->name('home.preview.lists');  
		Route::get('home/preview/forms', 'HomeController@previewForms')->name('home.preview.forms');  
		Route::get('home/preview/campaigns', 'HomeController@previewCampaigns')->name('home.preview.campaigns');  



		Route::get('home/preview/statics', 'HomeController@previewStatistics')->name('home.preview.statistics');   

	//newsletter 
		Route::resource('newsletter', 'NewsLetterController', ['only' => [
		    'index', 'destroy'
		]]); 

		// set subject sender
		Route::get('newsletter/sender', 'NewsLetterController@getSender')->name('user.newsletter.get.sender'); 
		Route::post('newsletter/sender', 'NewsLetterController@postSender')->name('user.newsletter.post.sender'); 

		// compose newsletter
		Route::get('newsletter/compose', 'NewsLetterController@getCompose')->name('user.newsletter.get.compose'); 
		Route::post('newsletter/compose', 'NewsLetterController@postCompose')->name('user.newsletter.post.compose'); 

		// set sender
		Route::get('newsletter/send', 'NewsLetterController@getSend')->name('user.newsletter.get.send'); 
		Route::post('newsletter/send', 'NewsLetterController@postSend')->name('user.newsletter.post.send');

	// responder

		Route::get('auto-response/start/process', 'AutoResponseDetailsController@startResponse');

	// member

		Route::get('billing/invoice/{billingId?}', 'UserController@billingInvoice')->name('user.billing.invoice');

		Route::get('profile', 'UserController@profile')->name('user.profile');

		Route::get('billing', 'UserController@billing')->name('user.billing');

		Route::get('account', 'UserController@account')->name('user.account');

		Route::get('change-password', 'UserController@changePassword')->name('user.change-password');
		Route::post('update-billing-address', 'UserController@updateBillingAddress')->name('user.update-billing-address');
		Route::post('update-billing-credit-card', 'UserController@updateBillingCreditCard')->name('user.update-billing-credit-card');

	 	// bilig 
		/* 1、place table
		 * 2、payment page
		 * 3、Pay2go page
		 * 4、thanks you page
		 */    
		
		route::post('billing/confirm', 'SubscriptionController@confirm')->name('user.billing.confirm'); 
		route::post('billing/confirm/proceed', 'SubscriptionController@confirmProceed')->name('user.billing.confirm.proceed'); 
		route::get('billing/success', 'SubscriptionController@success')->name('user.billing.success'); 
		
		
		 



	// user 
	Route::post('update-password', 'UserController@updatePasswordPost')->name('user.update.password.post'); 
	Route::post('update-account', 'UserController@updateAccountPost')->name('user.update.account.post');
 
	// billing 
	route::post('product/select/{product?}', 'ProductController@processSelectedProduct')->name('user.product.select');  
});    
 
Route::get('contact/unsubscribe/{email}', 'ContactController@unsubscribe'); 

Route::get('optin/{id?}/{url?}', 'CampaignController@mobileOptinUrl')->name('user.campaign.mobile.optin.url')->where(['url'=>'[0-9a-zA-Z-]+']);
// TESTING CODES AND ROUTES 
// case testing
Route::get('cash', 'CashController@index');
Route::get('cash/notify-url', 'CashController@notifyUrl');
Route::get('cash/return-url', 'CashController@returnUrl');



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
use Carbon\Carbon;
use App\Helper; 
use App\Mail\OrderShipped;


	Route::get("test/billing/deactivate", function(){


        $settings = [
            'HashIV'=>'t8jUsqArVyJOPZcF',
            'HashKey'=>'YK5drj7GZuYiSgfoPlc24OhHJj5g6I35',
            "MerchantID_" => 'MS3709347',
            'url' => 'https://ccore.spgateway.com/API/CreditCard/Cancel',
            'PostData_' => '',
        ];

        $post_data_str = [
            'RespondType' => 'JSON',
            'Version' => '1.0',
            'Amt' => 6600,
            'MerchantOrderNo' => '5097',
            'TradeNo' => '17022412335368443',
            'IndexType' => '1',
            'TimeStamp' => time(),
            'NotifyURL' => 'http://google.com/test',
        ];

        $post_data_str = http_build_query ($post_data_str);
        // print " prepare encryp  " . $post_data_str;
        $post_data = trim(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $settings['HashKey'], addpadding($post_data_str), MCRYPT_MODE_CBC, $settings['HashIV'])));
        // echo " encrypted string " . $post_data;
        ?>

        <form method="post" action="<?php print $settings['url']; ?>"  target="_top">
            <input type="text" value="<?php print $post_data; ?>" name="PostData_" />
            <input type="text" value="<?php print $settings['MerchantID_']; ?>" name="MerchantID_" />
            <input type="submit" class="button-alt" id="submit_spgateway_payment_form" value="Deactivate" />

        </form>

        <?php

});

Route::get("test/curl", function(){
	$payShortCutUrl = 'http://payshortcut.net/api/member/get-by-mail';
	print "<pre>";
	$getMember = curlGetRequest(['email'=>'mrjesuserwinsuarez@gmail.com'], $payShortCutUrl);
	print "results from  123";
	print_r($getMember);
});



Route::get('/send-email-test', function(){
	Mail::to('mrjesuserwinsuarez@gmail.com')->send(new OrderShipped()) ; 
}); 
 
Route::get('ng-bootstrap-ui', function(){
	return view('test.ng-strap');
}); 
   
Route::get('/campaign-send', 'CampaignScheduleController@send'); 
Route::get('/campaign-send', 'CampaignScheduleController@send'); 

Route::get('/carbon-test', function(){ 
	// create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tz = null); 
	  
	$dateTime = Helper::dateTimeExplode('2016-12-09 06:45:40'); 
	print "<pre>"; 
	print_r($dateTime); 
	print "</pre>";

	$date =  Carbon::create($dateTime['year'], $dateTime['month'], $dateTime['day'],  $dateTime['hour'], $dateTime['min'], $dateTime['sec']); 
	print "<br> now " . $date->now();
	print "<br> tomorrow " . $date->now()->addDays(1);
	print "<br> next week " .  $date->now()->addDays(7);  
	print "<br> next month " .  $date->now()->addMonth(1);
}); 


Route::get('/sortable-div', function(){
	?>

 <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Sortable - Portlets</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  body {
    min-width: 520px;
  }
  .column {
    width: 170px;
    float: left;
    padding-bottom: 100px;
  }
  .portlet {
    margin: 0 1em 1em 0;
    padding: 0.3em;
  }
  .portlet-header {
    padding: 0.2em 0.3em;
    margin-bottom: 0.5em;
    position: relative;
  }
  .portlet-toggle {
    position: absolute;
    top: 50%;
    right: 0;
    margin-top: -8px;
  }
  .portlet-content {
    padding: 0.4em;
  }
  .portlet-placeholder {
    border: 1px dotted black;
    margin: 0 1em 1em 0;
    height: 50px;
  }
  </style>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>


  $( function() {

  	// sorting and draggining 
    $( ".column" ).sortable({
      connectWith: ".column",
      handle: ".portlet-header",
      cancel: ".portlet-toggle",
      placeholder: "portlet-placeholder ui-corner-all"
    }); 
 
    // add css or style in the header and append classes
    $( ".portlet" )
      .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
 
 	// show hide toggle
    $( ".portlet-toggle" ).on( "click", function() {
      var icon = $( this );
      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
      icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
    });
 
  } );
  </script>
</head>
<body>
   
<div class="column"> 
  <div class="portlet">
    <div class="portlet-header">Testing 1 </div>
    <div class="portlet-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
  </div>
  <div class="portlet">
    <div class="portlet-header">Test2</div>
    <div class="portlet-content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
  </div> 
</div>
  	 
</body>
</html>
	<?php 
}); 
 
Route::group(['prefix' => 'debugging' ], function() {     
	Route::get('/data-tables', 'TestPagesController@dataTable'); 
}); 

/**
 * Test Angularjs
 */
Route::group(['prefix' => 'test/angular' , 'middleware' => 'auth' ], function() {      
	Route::get('popup', 'TestController@angularJsPopup'); 
});