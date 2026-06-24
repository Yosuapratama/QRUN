<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceCheckpoint extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'checked_at' => 'datetime'
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}