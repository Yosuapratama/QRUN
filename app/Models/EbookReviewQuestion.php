<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookReviewQuestion extends Model
{
    use HasFactory;

    public $table = 'ebook_review_questions';

    public $guarded = ['id'];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function place()
    {
        return $this->belongsTo(EbookPlace::class, 'ebook_place_id', 'id');
    }
}
