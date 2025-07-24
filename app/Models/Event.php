<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    public function coach()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event_reviews()
    {
        return $this->hasMany(Review::class, 'event_id');
    }

    public function event_slots()
    {
        return $this->hasMany(EventSlot::class, 'event_id');
    }

    public function joind_members()
    {
        return $this->hasMany(JoinedEvent::class, 'event_id');
    }

    // Event has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('end_date', '>', now());
    }

    // Scope for past (expired) events
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now());
    }


}