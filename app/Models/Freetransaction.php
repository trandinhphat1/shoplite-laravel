<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freetransaction extends Model
{
    use HasFactory;

    protected $table = 'freetransactions';
    
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'status',
        'note'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
