<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserHasPlaceLimit extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'users_has_place_limit';

    public $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function placeLimit()
    {
        return $this->belongsTo(PlaceLimit::class, 'place_limit_id', 'id');
    }
}
