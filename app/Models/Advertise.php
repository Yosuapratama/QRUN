<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertise extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'advertise_tables';

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_block' => 'boolean',
    ];

    public function places()
    {
        return $this->belongsToMany(
            Place::class,
            'advertise_place'
        );
    }

    public function images()
    {
        return $this->hasMany(AdvertiseImage::class);
    }
}