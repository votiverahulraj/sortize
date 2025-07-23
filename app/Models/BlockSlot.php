<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockSlot extends Model
{
    protected $table = 'block_slot';
    protected $fillable = [
        'user_id',
        'event_id',
        'event_slot_id',
        'quantity',
        'total_price',
        'expires_at',
    ];
}
