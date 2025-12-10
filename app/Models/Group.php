<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function members()
    {
        return $this->belongsToMany(
            User::class,
            'group_members',   // pivot table name
            'group_id',        // foreign key on pivot referencing this model
            'user_id'          // foreign key on pivot referencing the related model
        )
        ->withPivot('id', 'role', 'status') // pivot extra columns you might have
        ->withTimestamps();
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
