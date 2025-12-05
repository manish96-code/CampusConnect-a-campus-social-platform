<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'course',
        'description',
        'due_date',
        'file',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 👇 ADD THIS: Relationship to get ALL submissions (for teachers)
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    // 👇 ADD THIS: Relationship to get ONLY the current user's submission
    public function my_submission()
    {
        return $this->hasOne(AssignmentSubmission::class)->where('user_id', Auth::id());
    }
}