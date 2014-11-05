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

Route::get('api/account/auth', 'Tappleby\AuthToken\AuthTokenController@index');
// (sign in) post username password to get access token
Route::post('api/account/token-auth', 'AccountController@login');
//(sign out) destory token, request header should contain "X-Auth-Token" parameter 
// and accesstoken as its value.
Route::delete('api/account/logout', 'Tappleby\AuthToken\AuthTokenController@destroy');
Route::post('api/account/signup', 'AccountController@signUp');


Route::get('api/profile', array('before' => 'auth.token',
 			'uses' => 'CompanyProfileController@index'));
Route::post('api/profile', array('before' => 'auth.token',
 			'uses' => 'CompanyProfileController@create'));

Route::get('api/business-matching', array('before' => 'auth.token',
 			'uses' => 'BusinessMatchingController@getBm'));
Route::post('api/business-matching', array('before' => 'auth.token',
 			'uses' => 'BusinessMatchingController@setBm'));

Route::get('api/business-categories', array('before' => 'auth.token',
 			'uses' => 'BusinessMatchingController@getCategories'));
Route::post('api/business-categories', array('before' => 'auth.token',
 			'uses' => 'BusinessMatchingController@setCategories'));
Route::post('api/business-categories/delete', array('before' => 'auth.token',
 			'uses' => 'BusinessMatchingController@deleteCategories'));

Route::post('api/account/social/token-auth', 'SocialAccountController@login');
Route::post('api/account/social/signup', 'SocialAccountController@signUp');

Route::get('api/business-list', array('before' => 'auth.token',
 			'uses' =>  'BusinessListingController@dummyGetlist'));
Route::get('api/member-list/{trade_license_number?}', array('before' => 'auth.token',
 			'uses' => 'BusinessListingController@dummyFilteredMemberlist'));
// ->where('id', '[0-9]+');

Route::get('api/connection/my-connections', array('before' => 'auth.token',
 			'uses' =>  'ConnectionController@my_connections'));
Route::get('api/connection/invitations', array('before' => 'auth.token',
 			'uses' =>  'ConnectionController@open_invites'));
Route::post('api/connection/invite', array('before' => 'auth.token',
 			'uses' =>  'ConnectionController@invite'));
Route::post('api/connection/accept', array('before' => 'auth.token',
 			'uses' =>  'ConnectionController@accept'));
Route::post('api/connection/delete', array('before' => 'auth.token',
 			'uses' =>  'ConnectionController@delete'));

Route::get('alpha', 'ConnectionController@alpha');

Route::get('beta', 'ConnectionController@beta');


Route::post('api/notifications/list', array('before' => 'auth.token',
 			'uses' =>  'NotificationController@notificationList'));
Route::post('api/notifications/mark', array('before' => 'auth.token',
 			'uses' =>  'NotificationController@markRead'));

Route::get('api/news', array(//'before' => 'auth.token',
                       'uses' =>  'RssDataController@news'));
Route::get('api/events', array(//'before' => 'auth.token',
                       'uses' =>  'RssDataController@events'));

Route::post('api/bookmarks/add', array('before' => 'auth.token','uses' =>  'BoomarkController@add'));
Route::post('api/bookmarks/list', array('before' => 'auth.token','uses' =>  'BoomarkController@bookmarkList'));
Route::post('api/bookmarks/delete', array('before' => 'auth.token','uses' =>  'BoomarkController@delete'));
Route::get('api/bookmarks/show/{id}', array('before' => 'auth.token',
	'uses' =>  'BoomarkController@show'))->where('id', '[0-9]+');

Event::listen('auth.token.valid', function($user)
{
  //Token is valid, set the user on auth system.
  Auth::setUser($user);
});