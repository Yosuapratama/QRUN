<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsSettingImage extends Model
{
    protected $guarded = ['id'];

    public function adsSetting()
    {
        return $this->belongsTo(
            CustomAdsSettings::class,
            'custom_ads_setting_id'
        );
    }
}
