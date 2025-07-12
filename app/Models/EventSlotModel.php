<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSlotModel extends Model
{
    protected $table = 'event_slot';

     protected $fillable = [
        'event_id',
        'slot_start',
        'slot_end',
       
    ];
}
