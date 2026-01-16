<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post(){
        return $this->belongsTo(UserPost::class, 'post_id');
    }
}
