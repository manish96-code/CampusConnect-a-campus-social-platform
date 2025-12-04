<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file',
        'user_id',
        'status',
        'grade',
        'due_date',
        'course',
    ];
}
