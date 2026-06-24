<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookPlaceAd extends Model
{
    use HasFactory;

    public $table = 'ebook_place_ads';

    public $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_seconds' => 'integer',
    ];

    public function place()
    {
        return $this->belongsTo(EbookPlace::class, 'ebook_place_id', 'id');
    }
}
