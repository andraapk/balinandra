<?php

// ------------------------------------------------------------------------------------
// CAMPAIGN
// ------------------------------------------------------------------------------------
Route::group(['namespace' => 'Campaign\\', env('ROUTE_CAMPAIGN_ATTRIBUTE') => env('ROUTE_CAMPAIGN_VALUE')], function() 
{
	// ------------------------------------------------------------------------------------
	// INVITATION
	// ------------------------------------------------------------------------------------
	Route::get('join/by/invitation', 									['uses' => 'InvitationController@getInvitation', 'as' => 'balin.campaign.join.get']);
	Route::post('join/by/invitation', 									['uses' => 'InvitationController@postInvitation', 'as' => 'balin.campaign.join.post']);
});
