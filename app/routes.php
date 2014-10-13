<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::group(array('prefix' => 'api', 'before' => 'auth.token'), function() {
//   Route::get('/', function() {
//     return "Protected resource";
//   });
// });  
//Route::get('/', 'TodoListController@index');
//Route::resource('todos', 'TodoListController');

//Route::resource('/', 'TodoListController');
//Route::post('api-token-auth', 'AccountController@getToken');

//(authendicate test)
Route::get('api/account/auth', 'Tappleby\AuthToken\AuthTokenController@index');

// (sign in) post username password to get access token
Route::post('api/account/token-auth', 'Tappleby\AuthToken\AuthTokenController@store');

//(sign out) destory token, request header should contain "X-Auth-Token" parameter 
// and accesstoken as its value.
Route::delete('api/account/logout', 'Tappleby\AuthToken\AuthTokenController@destroy');


Route::post('api/account/signup', 'AccountController@signUp');
// route to show the login form
//Route::get('login', array('uses' => 'AccountController@showLogin'));
// route to process the form
//Route::post('login', array('uses' => 'AccountController@doLogin'));
//Route::get('logout', array('uses' => 'AccountController@doLogout'));


