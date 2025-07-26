<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

        protected $fillable = [
        'user_id',
        'event_id',
        'event_slot_id',
        'ticket_quantity',
        'total_price',
        'payment_status',
        'payment_method',
        'booking_status',
        'booked_at',
        'is_active'
    ];

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
        return $this->belongsTo(Session::class, 'event_slot_id','id');
    }

}
