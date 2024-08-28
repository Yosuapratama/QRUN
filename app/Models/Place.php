<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    public $table = 'place';

    public $guarded = ['id'];

    public function creator_id(){
        return $this->belongsTo(User::class, 'creator_id', 'id')->select('id', 'email');
    }

}
