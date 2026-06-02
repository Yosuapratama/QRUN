<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomAdsSettings extends Model
{
    use HasFactory;

    public $table = 'custom_ads_settings';

    public $guarded = ['id'];

    public function images()
    {
        return $this->hasMany(
            AdsSettingImage::class,
            'custom_ads_setting_id'
        );
    }
}
