<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'conference_id', 'sid', 'participant', 'duration'
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
