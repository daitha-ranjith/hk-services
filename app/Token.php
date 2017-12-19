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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
