<?php

if (!function_exists("isAdmin")) {
    function isAdmin()
    {
        return auth()->user()->email == env('ADMIN_EMAIL');
    }
}

if (!function_exists("getStringFromArray")) {
    function getStringFromJson($data)
    {
        return htmlspecialchars(json_encode($data));
    }
}
