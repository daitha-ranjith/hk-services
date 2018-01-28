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
    Route::resource('accounts', 'AccountController');
    Route::resource('tokens', 'TokenController');
    Route::put('reset-api-token', 'TokenController@resetApiToken')->name('reset-api-token');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::post('service-status', 'ServiceController@statusUpdate')->name('status.update');
});

Route::view('demo', 'demo.conference')->name('demo');

// Route::get('demo', function () {
//     $token = '1vLfhTU5MhVLfEou5pK0F3Ra5AFTJnvpA4qcsUmHR7LXVV9LRx9wf4GKbvTt';
//     $url = "https://healthkon-video-api.herokuapp.com/api/authorize?api_token=" . $token;
//     $data = json_decode(file_get_contents($url));

//     return view('demo.conference')->withToken($data->token);
// });
