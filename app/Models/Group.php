<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Group extends Model
{
    protected $fillable = [
        'created_by',
        'group_name',
        'description',
        'group_type',
        'profile_pic',
        'cover_pic',
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    public function approvedMembers()
    {
        return $this->members()->wherePivot('status', 'approved');
    }

    public function requests()
    {
        return $this->members()->wherePivot('status', 'pending');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
