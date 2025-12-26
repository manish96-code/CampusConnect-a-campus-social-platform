<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['course_name', 'description', 'image'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

     public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
