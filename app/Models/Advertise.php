<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertise extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'advertise_tables';

    public $guarded = ['id'];

    public function places()
    {
        return $this->belongsToMany(Place::class, 'advertise_place');
    }
}
