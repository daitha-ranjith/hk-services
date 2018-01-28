<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'user_id', 'access_token', 'label', 'config'
    ];

    protected $casts = [
        'config' => 'array'
    ];

    public static function getByToken($token)
    {
        return static::where('access_token', $token)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
