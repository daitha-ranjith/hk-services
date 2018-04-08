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

    Route::group(['prefix' => 'logs'], function () {
        Route::get('video', 'LogController@video')->name('logs.video');
        Route::get('sms', 'LogController@sms')->name('logs.sms');
        Route::get('email', 'LogController@email')->name('logs.email');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::post('service-status', 'ServiceController@statusUpdate')->name('status.update');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::group(['prefix' => 'demo'], function () {
    Route::view('/', 'demo.index')->name('demo')->middleware('admin');
    Route::view('video', 'demo.video')->name('demo.video');
    Route::view('chat', 'demo.chat')->name('demo.chat');
    Route::view('sms', 'demo.sms')->name('demo.sms')->middleware('admin');
    Route::view('email', 'demo.email')->name('demo.email')->middleware('admin');

    Route::post('email-invite', function () {
        $emails = explode(',', request('emails'));
        $room = request('room');

        $ctoken = str_random(60);
        $expiresAfter = 1;
        cache()->put($ctoken, 601, $expiresAfter);

        foreach ($emails as $email) {
            $url = env('APP_URL') . "/demo/video?email={$email}&room={$room}&ctoken={$ctoken}";
            $content = "Join the conference by clicking on this link: {$url}";
            \Mail::raw($content, function ($message) use ($email) {
                $message->to($email);
                $message->subject('Video Chat Conference Invite | Healthkon');
            });
        }

        return redirect()->back()->with('status', 'Successfully Invited!');
    })->name('email-invite');
});

Route::get('dev-testr', function () {
    return [cache('invite-token'), route('demo.video')];
});
