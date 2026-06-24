<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;

    protected $table = 'reg_regencies'; // Nama tabel yang sesuai dengan konvensi Laravel

    public $timestamps = false; // Jika tabel tidak memiliki kolom created_at dan updated_at

    public function places()
    {
        return $this->hasMany(Place::class, 'regency_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'regency_id');
    }
}
