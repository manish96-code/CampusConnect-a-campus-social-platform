<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function likes(){
        return $this->hasMany(LikePost::class, 'post_id');
    }
}
