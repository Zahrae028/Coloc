<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{

    protected $fillable = [
        'colocation_id',
        'email',
        'token',
        'status',

    ];
    protected $casts = [
        'status' => 'string',
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
