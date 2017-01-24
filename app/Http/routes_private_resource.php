<?php 

Route::group([env('ROUTE_BALIN_ATTRIBUTE') => env('ROUTE_BALIN_VALUE'), 'prefix' => 'me', 'namespace' => 'Me\\', 'middleware' => 'auth.me'], function() 
{
	/* User profile */
	Route::get('/',													['uses' => 'UserController@index', 			'as' => 'my.balin.profile']);
	Route::get('edit', 												['uses' => 'UserController@edit', 			'as' => 'my.balin.profile.edit']);
	Route::post('edit', 											['uses' => 'UserController@update', 		'as' => 'my.balin.profile.update']);
	Route::get('point', 											['uses' => 'UserController@points', 		'as' => 'my.balin.profile.point']);
	Route::get('referral',											['uses' => 'UserController@referrals', 		'as' => 'my.balin.profile.referral']);
	Route::get('order',												['uses' => 'UserController@orders', 		'as' => 'my.balin.profile.order']);
	Route::get('resend/activation',									['uses' => 'UserController@activation',		'as' => 'my.balin.profile.activate']);
	Route::get('myorder',											['uses' => 'UserController@myorder', 			'as' => 'my.balin.profile.myorder']);

	/* page user redeem code */
	Route::get('redeem',											['uses' => 'RedeemController@index', 		'as' => 'my.balin.redeem.index']);
	Route::get('redeem/create',										['uses' => 'RedeemController@create', 		'as' => 'my.balin.redeem.create']);
	Route::post('redeem/store', 									['uses' => 'RedeemController@store', 		'as' => 'my.balin.redeem.store']);

	/* broadcast invitation */
	Route::get('who/got/my/invitation',								['uses' => 'InvitationController@index', 	'as' => 'my.balin.invitation.index']);
	Route::get('broadcast/invitation',								['uses' => 'InvitationController@create', 	'as' => 'my.balin.invitation.create']);
	Route::post('broadcast/invitation', 							['uses' => 'InvitationController@store', 	'as' => 'my.balin.invitation.store']);

	/* Checkout info */
	Route::get('checkout',											['uses' => 'CheckoutController@get', 		'as' => 'my.balin.checkout.get']);
	Route::post('checkout',											['uses' => 'CheckoutController@post', 		'as' => 'my.balin.checkout.post']);
	Route::any('checkout/voucher',									['uses' => 'CheckoutController@voucher', 	'as' => 'my.balin.checkout.voucher']);
	Route::any('checkout/shipping/cost',							['uses' => 'CheckoutController@shipping', 	'as' => 'my.balin.checkout.shippingcost']);
	Route::any('checkout/extension',								['uses' => 'CheckoutController@extension', 	'as' => 'my.balin.checkout.extension']);
	Route::any('checkdoout/{id}',									['uses'	=> 'CheckoutController@checkdoout', 'as' => 'my.balin.checkout.checkdoout']);
	Route::any('checkout/choice/payment',							['uses' => 'CheckoutController@choice_payment', 'as' => 'my.balin.checkout.choicepayment']);
	
	/* Get order in view total cart */
	Route::any('checkout/order/{id}',								['uses' => 'CheckoutController@get_view',		'as' => 'my.balin.checkout.get.order']);

	Route::get('veritrans/paying/{id}',								['uses' => 'CheckoutController@vtprocessing', 	'as' => 'my.balin.payment.processing']);
	
	Route::get('veritrans/payment/finish',							['uses' => 'CheckoutController@vtfinish', 	'as' => 'my.balin.payment.finish']);
	Route::get('veritrans/payment/unfinish',						['uses' => 'CheckoutController@vtunfinish', 'as' => 'my.balin.payment.unfinish']);

	/* Order info */
	Route::get('order/{id}',										['uses' => 'OrderController@show', 			'as' => 'my.balin.order.show']);
	Route::get('order/cancel/{id}',									['uses' => 'OrderController@destroy', 		'as' => 'my.balin.order.destroy']);
	Route::any('order/resend/invoice/{id}',							['uses' => 'OrderController@resend_invoice','as' => 'my.balin.order.resend.invoice']);
});