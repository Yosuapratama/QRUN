<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Ebook extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'ebooks';

    public $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'ad_override_enabled' => 'boolean',
        'lock_enabled' => 'boolean',
        'read_limit' => 'integer',
        'unlock_duration' => 'integer',
    ];

    public function creator_id()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id')->select('id', 'email');
    }

    /**
     * Locations (ebook places) this ebook is assigned to.
     */
    public function places()
    {
        return $this->belongsToMany(EbookPlace::class, 'ebook_place_assignments');
    }

    /**
     * Per-ebook review questions (used when this ebook overrides the gating
     * policy with the "review" unlock method).
     */
    public function reviewQuestions()
    {
        return $this->hasMany(EbookReviewQuestion::class, 'ebook_id', 'id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Reviews submitted for this ebook (across any location).
     */
    public function reviews()
    {
        return $this->hasMany(EbookReview::class, 'ebook_id', 'id')->latest();
    }

    /**
     * Get the formatted created_at attribute.
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * Get the formatted updated_at attribute.
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
