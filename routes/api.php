<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
 
/**
 * Full Name, Email and Password
 */
Route::get('user-new/create/{email?}/{fullname?}/{password?}', 'Auth\RegisterController@createUserHttp');  
Route::post('user-new/create-post', 'Auth\RegisterController@createUserHttpPost');  
Route::get('user-new/create-get', function(){
	return "Test";
}); 

