<?php

Route::get('zlogs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth.admin');

/**
 * Guest routes
 */
Route::get('/', 'GuestController@index');
Route::get('pricing', 'GuestController@pricing');
Route::get('affiliate', 'GuestController@affiliate');
Route::get('faq', 'GuestController@faq');
Route::get('terms', 'GuestController@terms');
Route::get('refund-policy', 'GuestController@refundPolicy');
Route::get('contact', ['as' => 'contact', 'uses' => 'GuestController@contact']);
Route::post('contact', ['as' => 'contact_store', 'uses' => 'GuestController@contactStore']);

Route::post('ajax_login_user', 'GuestController@ajaxLoginUser');

// Demo route
Route::get('demo/{id}', 'DemoController@showNew');
Route::post('demo/{id}/subscribe', 'DemoController@subscribe');
Route::post('demo', 'DemoController@store');
Route::post('demo/progress', 'DemoController@progress');

/**
 * Callback controllers section here
 */
Route::group(['prefix' => 'callback'], function() {
    Route::any('urlanalyzer', 'CallbackController@urlanalyzer');
    Route::any('fastspring', 'CallbackController@fastspring_activate');
    Route::any('fastspring/change', 'CallbackController@fastspring_change');
    Route::any('fastspring/deactivate', 'CallbackController@fastspring_deactivate');
    Route::any('fastspring/bill', 'CallbackController@fastspring_bill');
    Route::any('fastspring/rebill', 'CallbackController@fastspring_rebill');
    Route::any('fastspring/refund', 'CallbackController@fastspring_refund');

    Route::any('oauth2callback/{campaign_id?}', 'CallbackController@oauth2callback');
    Route::get('notifydownload/{id}/{download_location?}', 'CallbackController@notify_download')
        ->where('download_location', '(.*)');
});

/**
 * Google Analitycs
 */
Route::group(['prefix' => 'analitycs'], function() {
    Route::post('accounts', function() {
        return (new \App\Classes\GA_Service(\Cookie::get('access_token')))->accounts();
    });

    Route::post('properties/{id}', function($id) {
        return (new \App\Classes\GA_Service(\Cookie::get('access_token')))->properties($id);
    });

    Route::post('views/{account_id}/{property_id}', function($account_id, $property_id) {
        return (new \App\Classes\GA_Service(\Cookie::get('access_token')))->views($account_id, $property_id);
    });

});