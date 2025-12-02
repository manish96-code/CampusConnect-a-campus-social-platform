<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'comment'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
