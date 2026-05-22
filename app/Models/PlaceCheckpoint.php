<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceCheckpoint extends Model
{
    protected $fillable = [
        'place_id',
        'place_code',
        'user_id',
        'session_id',
        'ip_address',
        'device_type',
        'platform',
        'browser',
        'referer',
        'country',
        'city',
        'checked_at'
    ];

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