<?php

Route::group(['middleware' => 'auth:token'], function () {
    Route::get('authorize', 'JwtController@auth');
});

Route::group(['prefix' => 'video', 'middleware' => 'cors'], function () {
    Route::group(['middleware' => ['jwt.auth', 'check.token']], function () {
        Route::post('authenticate', 'VideoController@authenticate');
    });

    Route::post('callback/{token_id}', 'VideoController@callback');
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
    Route::group(['middleware' => ['jwt.auth', 'check.token']], function () {
        Route::post('authenticate', 'ChatController@authenticate');
    });
});
