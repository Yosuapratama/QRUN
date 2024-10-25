<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Place;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'event';

    public $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime'
        ];
    }

    public function place_id(){
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }
    public function places(){
        return $this->belongsTo(Place::class, 'place_id', 'id')->select('id', 'title', 'place_code','creator_id');
    }
}
