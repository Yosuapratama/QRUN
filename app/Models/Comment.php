<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'rating','comment', 'place_id', 'parent_id'];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the Post model
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    // Recursive relationship for replies
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relationship to the parent comment
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
