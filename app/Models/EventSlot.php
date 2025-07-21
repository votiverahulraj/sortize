<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSlot extends Model
{
    protected $table = 'session';

    // Event slot has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_slot_id');
    }

}
