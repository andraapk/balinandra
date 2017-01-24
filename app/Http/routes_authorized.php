<?php

Route::group([env('ROUTE_BALIN_ATTRIBUTE') => env('ROUTE_BALIN_VALUE')], function() 
{
	/* Sign up page */
	Route::post('signup',												['uses' => 'AuthController@postSignUp', 	'as' => 'balin.post.signup']);

	/* Sign up using invitation */
	Route::get('invite/by/{code}/at/{link}',							['uses' => 'InvitationController@get', 		'as' => 'balin.invitation.get']);
	Route::post('invite/by/{code}/at/{link}',							['uses' => 'InvitationController@post', 	'as' => 'balin.invitation.post']);

	/* Login using SSO */
	Route::get('sso',													['uses' => 'AuthController@getSso', 		'as' => 'balin.get.sso']);
	Route::get('sso/success',											['uses' => 'AuthController@redirectSso', 	'as' => 'balin.redirect.sso']);

	/* Login using email */
	Route::get('sign-in', 												['uses' => 'AuthController@getlogin', 		'as' => 'balin.get.login']);
	Route::post('sign-in',												['uses' => 'AuthController@postlogin', 		'as' => 'balin.post.login']);

	/* Logout */
	Route::get('logout',												['uses' => 'AuthController@getlogout', 		'as' => 'balin.get.logout']);

	/* Account activation */
	Route::get('activation/link/{activation_link?}',					['uses' => 'AuthController@getActive', 		'as' => 'balin.get.active']);
	
	/* Reset Password */
	Route::post('forgot/password',										['uses' => 'PasswordController@forgot', 	'as' => 'balin.forgot.password']);
	Route::get('reset/password/{link}',									['uses' => 'PasswordController@reset', 		'as' => 'balin.reset.password']);
	Route::post('change/password',										['uses' => 'PasswordController@change', 	'as' => 'balin.change.password']);

});
