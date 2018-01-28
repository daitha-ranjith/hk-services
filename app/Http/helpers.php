<?php

if (!function_exists("isAdmin")) {
    function isAdmin()
    {
        return auth()->user()->email == env('ADMIN_EMAIL');
    }
}
