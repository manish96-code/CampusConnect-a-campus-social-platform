<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];
}
