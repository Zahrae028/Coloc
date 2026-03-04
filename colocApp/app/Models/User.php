<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'reputation',
    'email_verified_at',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
];

   public function memberships()
{
    return $this->hasMany(Membership::class);
}
    public function colocations()
    {
        return $this->belongsToMany(Colocation::class, 'memberships')
            ->withTimestamps();
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'paid_id');
    }
    public function invitations()
{
    return $this->hasMany(\App\Models\Invitation::class, 'email', 'email');
}
}
