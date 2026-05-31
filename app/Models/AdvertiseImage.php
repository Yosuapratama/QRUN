<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertiseImage extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function advertise()
    {
        return $this->belongsTo(Advertise::class);
    }
}