<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'token_id', 'email'
    ];

    protected $casts = [
        'email' => 'array'
    ];
}
