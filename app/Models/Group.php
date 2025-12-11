<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Group extends Model{

    protected $fillable = [
        'created_by',
        'group_name',
        'slug',
        'description',
        'group_type',
        'profile_pic',
        'cover_pic',
    ];

    // public function members(){
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function members(){
        return $this->belongsToMany(
            User::class,
            'group_members',   // pivot table name
            'group_id',        // foreign key on pivot referencing this model
            'user_id'          // foreign key on pivot referencing the related model
        )
        ->withPivot('id', 'role', 'status') // pivot extra columns you might have
        ->withTimestamps();
    }

    public function requests(){
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id')
                    ->withPivot('id','role','status')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }


    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
