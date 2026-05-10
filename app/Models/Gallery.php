<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'galleries'; // opsional jika nama tabel tidak default (jamak dari model)

    protected $fillable = [
        'title',
        'is_active',
        'image_url',
    ];

    
}
