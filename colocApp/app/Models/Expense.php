<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

       protected $fillable = [
        'colocation_id',
        'title',
        'amount',
        'category_id',
        'paid_by',
    ];
    
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function members()
{
    return $this->belongsToMany(User::class, 'payments')
                ->withPivot('share', 'paid')
                ->withTimestamps();
}
}
