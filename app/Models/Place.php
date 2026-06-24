<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Place extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'place';

    public $guarded = ['id'];

    protected $appends = ['comment_count'];

    // Relationship to advertises
    public function advertises()
    {
        return $this->belongsToMany(Advertise::class, 'advertise_place');
    }

    // Relationship to comments
    public function comments()
    {
        return $this->hasMany(Comment::class, 'place_id', 'id');
    }

    // Get the count of comments for this place
    public function getCommentCountAttribute()
    {
        return $this->comments()->count();
    }
    
    public function creator_id()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id')->select('id', 'email');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id')->select('id', 'email');
    }

     /**
     * Get the formatted created_at attribute.
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s'); // Change format as needed
    }

    /**
     * Get the formatted updated_at attribute.
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s'); // Change format as needed
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

}
