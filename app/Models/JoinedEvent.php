<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinedEvent extends Model
{
    protected $table = 'joined_events';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
