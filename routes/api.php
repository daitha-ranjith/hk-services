<?php

Route::middleware('auth:api')->get('/', function () {
    return 'request';
});
