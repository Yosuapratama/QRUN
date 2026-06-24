<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookReview extends Model
{
    use HasFactory;

    public $table = 'ebook_reviews';

    public $guarded = ['id'];

    protected $casts = [
        'answers' => 'array',
        'rating' => 'integer',
    ];

    public function place()
    {
        return $this->belongsTo(EbookPlace::class, 'ebook_place_id', 'id');
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id', 'id');
    }
}
