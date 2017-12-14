<?php

Route::view('/', 'welcome');

Auth::routes();

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('accounts', 'AccountController');
});
