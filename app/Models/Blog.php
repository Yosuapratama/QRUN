<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'blogs';

    public $guarded = ['id'];

    public function creator_id()
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
}
