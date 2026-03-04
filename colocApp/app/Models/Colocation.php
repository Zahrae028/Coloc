<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{

    protected $fillable = [
        'name',
        'owner_id',
        'status',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->withTimestamps();
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function categories()
{
    return $this->hasMany(\App\Models\Category::class);
}
}
