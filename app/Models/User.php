<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'gender',
        'contact',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* =====================
       RELATIONSHIPS
    ====================== */

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members')
            ->withPivot('id', 'role', 'status')
            ->withTimestamps();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Friend::class, 'sender_id');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friend::class, 'receiver_id');
    }

    public function groupPostLikes()
    {
        return $this->hasMany(GroupPostLike::class);
    }

    public function groupPostComments()
    {
        return $this->hasMany(GroupPostComment::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function friends()
    {
        return Friend::where(function ($query) {
            $query->where('sender_id', $this->id)
                ->orWhere('receiver_id', $this->id);
        })
            ->where('status', 'accepted');
    }

    public function courses()
{
    return $this->belongsToMany(Course::class, 'course_users')->withTimestamps();
}

}
