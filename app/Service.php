<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $casts = [
        'settings' => 'array'
    ];

    public static function video()
    {
        return self::where('name', 'video')->first();
    }

    public static function chat()
    {
        return self::where('name', 'chat')->first();
    }

    public static function sms()
    {
        return self::where('name', 'sms')->first();
    }

    public static function email()
    {
        return self::where('name', 'email')->first();
    }

}
