<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'session';

    protected $fillable = [
        'event_id',
        'date',
        'start_time',
        'end_time',
        'capacity',
        'is_active',
  
    ];
}

