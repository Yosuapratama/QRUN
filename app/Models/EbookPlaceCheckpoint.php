<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookPlaceCheckpoint extends Model
{
    use HasFactory;

    public $table = 'ebook_place_checkpoints';

    public $guarded = ['id'];

    protected $casts = [
        'is_mobile' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function place()
    {
        return $this->belongsTo(EbookPlace::class, 'ebook_place_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
