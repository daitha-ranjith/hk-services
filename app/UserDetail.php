<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id', 'mobile_no', 'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
