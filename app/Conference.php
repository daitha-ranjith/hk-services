<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = [
        'user_id', 'account_sid', 'sid', 'name',
        'status', 'duration'
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

};
