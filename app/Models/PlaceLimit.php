<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceLimit extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'place_limit';

    public $guarded = ['id'];

}
