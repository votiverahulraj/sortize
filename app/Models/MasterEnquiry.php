<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterEnquiry extends Model
{
    protected $table = 'enquiry';
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
