<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventGalleryImage extends Model
{
    protected $table = 'event_gallery_images';

    protected $fillable = [
        'event_id',
        'event_media',
        // add other fillable fields if needed
    ];

    // public function event()
    // {
    //     return $this->belongsTo(Event::class);
    // }
}
