<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'reg_provinces'; // Nama tabel yang sesuai dengan konvensi Laravel

    public $timestamps = false; // Jika tabel tidak memiliki kolom created_at dan updated_at

    public function places()
    {
        return $this->hasMany(Place::class, 'province_id');
    }

    public function regencies()
    {
        return $this->hasMany(Regency::class, 'province_id');
    }
}
