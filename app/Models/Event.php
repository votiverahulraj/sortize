<?php

namespace App\Models;

use App\Models\Scopes\NotDeletedScope;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventCategory;


class Event extends Model
{
    protected $table = 'events';

    protected static function booted()
    {
        static::addGlobalScope(new NotDeletedScope);
    }

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

    public function category(){
        return $this->belongsTo(EventCategory::class,'event_type');
    }

    public function scopeUpcoming($query)
    {
        return $query->whereRaw("STR_TO_DATE(CONCAT(end_date, ' ', end_time), '%Y-%m-%d %H:%i:%s') > NOW()");
    }

    // Scope for past (expired) events
    public function scopePast($query)
    {
        return $query->whereRaw("STR_TO_DATE(CONCAT(end_date, ' ', end_time), '%Y-%m-%d %H:%i:%s') <= NOW()");
    }
}