<?php

Route::view('/', 'welcome');

Auth::routes();

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('accounts', 'AccountController');

    Route::resource('tokens', 'TokenController');

    Route::put('reset-api-token', 'TokenController@resetApiToken')->name('reset-api-token');
});

Route::view('test', 'demo.test');
