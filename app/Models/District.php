<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'reg_districts'; // Nama tabel yang sesuai dengan konvensi Laravel

    public function places()
    {
        return $this->hasMany(Place::class, 'district_id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'district_id');
    }
}
