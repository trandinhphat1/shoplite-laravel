<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'balo_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balo()
    {
        return $this->belongsTo(Balo::class);
    }
}
