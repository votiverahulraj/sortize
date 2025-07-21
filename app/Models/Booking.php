<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    // Booking belongs to an event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id','id');
    }

    // Booking belongs to an event slot
    public function slot()
    {
        return $this->belongsTo(EventSlot::class, 'event_slot_id','id');
    }

}
