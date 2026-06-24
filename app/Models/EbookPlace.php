<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EbookPlace extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'ebook_places';

    public $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'ads_always_show' => 'boolean',
        'lock_enabled' => 'boolean',
        'read_limit' => 'integer',
        'unlock_duration' => 'integer',
    ];

    /**
     * Ebooks assigned to this location.
     */
    public function ebooks()
    {
        return $this->belongsToMany(Ebook::class, 'ebook_place_assignments');
    }

    /**
     * Promo / ads slides shown as a modal player on the scan page.
     */
    public function ads()
    {
        return $this->hasMany(EbookPlaceAd::class, 'ebook_place_id', 'id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Custom review questions asked when unlocking via the "review" method.
     */
    public function reviewQuestions()
    {
        return $this->hasMany(EbookReviewQuestion::class, 'ebook_place_id', 'id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Visitor-submitted reviews collected at this location.
     */
    public function reviews()
    {
        return $this->hasMany(EbookReview::class, 'ebook_place_id', 'id')->latest();
    }

    /**
     * Scan checkpoints — one per visitor session that opens the scan page.
     */
    public function checkpoints()
    {
        return $this->hasMany(EbookPlaceCheckpoint::class, 'ebook_place_id', 'id')->latest('checked_at');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id')->select('id', 'email');
    }
}
