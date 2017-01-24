<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['domain' => env('APP_DOMAIN','')], function()
{

	/**
	* Routes Authorized used only for authorized (login / logout)
	*/
	include('routes_authorized.php');

	/**
	* Routes public resource could be opened by public user
	*/
	include('routes_public_resource.php');

	/**
	* Routes private resource could be opened by me user
	*/
	include('routes_private_resource.php');

	/**
	* Routes for updated business process
	*/
	include('routes_campaign.php');
});

/**
 * Server Error redirect route
 */
Route::get('error/{header?}/{msg?}',			['uses' => 'ErrorController@er404', 	'as' => 'page.error']);

Route::get('not/found',		 					['uses' => 'HomeController@notfound', 	'as' => 'balin.not.found']);
