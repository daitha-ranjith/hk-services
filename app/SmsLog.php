<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $dates = [
        'sent_at', 'delivered_at'
    ];

    protected $fillable = [
        'sid',
        'token_id',
        'sent_to',
        'message',
        'status',
        'characters',
        'sent_at',
        'delivered_at'
    ];
}
