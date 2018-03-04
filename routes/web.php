<?php

Route::view('/', 'welcome');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('tokens', 'TokenController');
    Route::put('reset-api-token', 'TokenController@resetApiToken')->name('reset-api-token');
    Route::resource('accounts', 'AccountController');
    Route::group(['prefix' => 'accounts/{accountId}'], function () {
        Route::get('sub-accounts/create', 'AccountController@createSubAccount')->name('sub-accounts.create');
        Route::post('sub-accounts', 'AccountController@storeSubAccount')->name('sub-accounts.store');
        Route::get('sub-accounts/{subAccountId}/edit', 'AccountController@editSubAccount')->name('sub-accounts.edit');
        Route::put('sub-accounts/{subAccountId}', 'AccountController@updateSubAccount')->name('sub-accounts.update');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::post('service-status', 'ServiceController@statusUpdate')->name('status.update');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::group(['prefix' => 'demo', 'name' => 'demo'], function () {
    Route::view('video', 'demo.video')->name('video');
    Route::view('chat', 'demo.chat')->name('chat');
    Route::view('sms', 'demo.sms')->name('sms');
    Route::view('email', 'demo.email')->name('email');
});

Route::get('dev-testr', function () {
    //
});
