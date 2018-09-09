<?php

Route::get('', 'UserController@showDashboard');

/**
 * Admin routes
 */
Route::group(['middleware' => 'auth.admin'], function(){
    Route::get('clients', 'AdminController@showClients');
    Route::get('client/{id}', 'AdminController@showClient');

    Route::get('support', 'AdminController@showSupport');
    Route::match(['get', 'post'], 'support/{id}', 'AdminController@viewSupport');
    Route::post('support/{id}/update', 'AdminController@updateSupport');

    Route::get('payments', 'AdminController@showPayments');
    Route::post('payments', 'AdminController@createPayments');
    Route::post('payments/{id}', 'AdminController@createPayment');

    Route::get('events', 'AdminController@showEvents');
    Route::get('events/{id}', 'AdminController@showEventsUser');

});

/**
 * Ref routes
 */
Route::group(['prefix' => 'ref'], function(){
    Route::get('', 'ReferralController@index');
    Route::get('faq', 'ReferralController@index');
    Route::post('pay_history', 'ReferralController@payHistory');
    Route::post('referrals', 'ReferralController@referrals');
    Route::get('{id}', 'ReferralController@refCookie');
});

/**
 * User routes
 */
Route::get('profile', 'UserController@showProfile');
Route::post('profile', 'UserController@storeProfile');
Route::post('profile/password', 'UserController@storePassword');
Route::get('subscription', 'UserController@showSubscription');
Route::get('subscribe/{plan}', 'UserController@doSubscription');
Route::get('change_subscribe/{plan}', 'UserController@changeSubscriptionPlan');
Route::get('cancel_subscribe/{plan}', 'UserController@cancelSubscription');

Route::post('subscription/check_domain', 'UserController@checkDomain');
Route::post('subscription/custom_subscription', 'UserController@customSubscription');
Route::post('subscription/custom_email', 'UserController@customEmail');

Route::get('ssb', 'UserController@ssb');
Route::post('csvs', 'UserController@csvs');


Route::get('settings', 'UserController@showSettings');
Route::get('notifications', 'UserController@notifications');

// Support routes
Route::get('support', 'SupportController@showSupport');
Route::any('support/new', 'SupportController@createSupport');
Route::any('support/{id}/', 'SupportController@viewSupport');

// Destination routes
Route::get('campaign/{id}/destination', 'DestinationController@showDestinations');
Route::post('campaign/{id}/destination', 'DestinationController@showDestinationTarget');

// Ref links routes
Route::get('campaign/{id}/refs', 'RefController@showRefs');
Route::get('campaign/{id}/refs/{domain}', 'RefController@showRefSingle');


// Campaign routes
Route::post('campaign', 'CampaignController@store');
Route::get('campaign/{id}/start/{view_id?}', 'CampaignController@start');
Route::get('campaign/{id}/restart/{view_id?}', 'CampaignController@restart');
Route::post('campaign/restart_many', 'CampaignController@restartMany');

Route::get('campaign/{id}', 'CampaignController@show');

Route::post('campaign/add_participant', 'CampaignController@addParticipant');
Route::delete('campaign/remove_participant', 'CampaignController@removeParticipant');
Route::post('campaign/getVisits', 'CampaignController@getVisits');


Route::get('campaign/{id}/download_disavow', 'CampaignController@downloadDisavow');
Route::post('campaign/{id}/download_disavow', 'CampaignController@downloadDisavowTarget');
Route::post('campaign/{id}/upload_disavow', 'CampaignController@uploadDisavow');
Route::post('campaign/{id}/monitor', 'CampaignController@monitor');
Route::delete('campaign/{id}', 'CampaignController@destroy');
Route::delete('campaign/remove_many', 'CampaignController@removeMany');

Route::post('tags', 'CampaignController@addTags');
Route::delete('tags', 'CampaignController@removeTags');


Route::delete('campaign/{id}/upload_disavow', function($id) {
    \Session::remove('uploaded_disavow_'.$id);
    return \Redirect::back();
});

Route::get('campaign/{id}/topics/{domain}', 'CampaignController@showTopicsSingle');
Route::post('campaign/{id}/download', 'CampaignController@downloadBacklinks');
Route::get('campaign/{id}/backlinks', 'CampaignController@backlinksCampaign');
Route::get('campaign/{id}/{url_id}', 'CampaignController@showUrl');


/**
 * Ajax requests
 */
Route::group(['prefix' => 'ajax'], function() {
    Route::post('backlinks', 'AjaxController@getBacklinks');

    Route::post('refs', 'AjaxController@getRefs');
    Route::post('refsingle', 'AjaxController@getRefSingle');
    Route::post('topicsSingle', 'AjaxController@getTopicsSingle');
    Route::post('campaigns', 'AjaxController@getCampaigns');
    Route::post('campaigns_client', 'AjaxController@getCampaignsClient');
    Route::post('support', 'AjaxController@getSupport')->middleware('auth.admin');
    Route::post('client', 'AjaxController@getClient')->middleware('auth.admin');
    Route::post('dashboard_progress', 'AjaxController@getCampaignsProgress');
    Route::post('not_finished_campaign_progress', 'AjaxController@getNotFinishedCampaignProgress');
    Route::post('not_finished_campaign_progress_backlink', 'AjaxController@getNotFinishedCampaignProgressBacklink');

    Route::post('getTrafficChart', 'AjaxController@getTrafficChart');
    Route::get('addCredits', 'AjaxController@addCredits');

    Route::post('user_add_backlinks', 'AjaxController@userAddBacklinks');
    Route::post('user_check_backlinks', 'AjaxController@userCheckBacklinks');
    Route::post('notifications', 'AjaxController@notifications');

});



Route::get('acampaign/{id}/start', 'CampaignController@adminStart')->middleware('auth.admin');
Route::get('acampaign/{id}/restart', 'CampaignController@adminRestart')->middleware('auth.admin');
