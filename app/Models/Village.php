<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $table = 'reg_villages'; // Nama tabel yang sesuai dengan konvensi Laravel

    public function places()
    {
        return $this->hasMany(Place::class, 'village_id');
    }
}
