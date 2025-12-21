<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupPost extends Model{
     protected $fillable = [
        'group_id',
        'user_id',
        'caption',
        'image',
        'is_edited'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    // likes
    public function likes()
    {
        return $this->hasMany(GroupPostLike::class);
    }

    // comments
    public function comments()
    {
        return $this->hasMany(GroupPostComment::class)->latest();
    }
}
