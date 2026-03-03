<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

       protected $fillable = [
        'colocation_id',
        'title',
        'amount',
        'date',
        'category_id',
        'payer_id',
    ];
    
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
