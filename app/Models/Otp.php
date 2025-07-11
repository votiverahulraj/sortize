<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table = 'otps';

     protected $fillable = [
        'user_id',
        'user_type',
        'otp_code',
        'otp_type',
        'is_verify',
    ];
}
