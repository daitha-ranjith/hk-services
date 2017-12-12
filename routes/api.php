<?php

Route::middleware('auth:token')->get('/check', function () {
    return request()->user();
});
