<?php

Route::group(['middleware' => 'auth:token'], function () {
    # Route for authenticating and generating the user jwt token
    Route::get('authorize', 'JwtController@auth');
});

Route::group(['prefix' => 'video', 'middleware' => 'cors'], function () {
    // Authorize the conference connection
    Route::group(['middleware' => ['jwt.auth', 'check.token']], function () {
        Route::post('authenticate', 'VideoController@authenticate');
    });

    // Conference Connection API
    // Route::post('connect', 'ConferenceController@connect');

    // Conference Disconnection API
    // Route::post('disconnect', 'ConferenceController@disconnect');
});

Route::group(['prefix' => 'sms', 'middleware' => 'cors'], function () {
    Route::group(['middleware' => ['auth:token']], function () {
        Route::post('send', 'SmsController@send');
    });

    Route::post('status/update', 'SmsController@statusUpdate');
});

Route::group(['prefix' => 'email', 'middleware' => 'cors'], function () {
    Route::group(['middleware' => ['auth:token']], function () {
        Route::post('send', 'EmailController@send');
    });
});

Route::group(['prefix' => 'chat', 'middleware' => 'cors'], function () {
    // Authorize the conference connection
    Route::group(['middleware' => ['jwt.auth', 'check.token']], function () {
        Route::post('authenticate', 'ChatController@authenticate');
    });

    // Conference Connection API
    // Route::post('connect', 'ConferenceController@connect');

    // Conference Disconnection API
    // Route::post('disconnect', 'ConferenceController@disconnect');
});
