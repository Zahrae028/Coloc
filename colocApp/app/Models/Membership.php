<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Membership extends Pivot
{
    protected $table = 'colocation_user';

    protected $fillable = [
        'colocation_id',
        'user_id',
    ];
}