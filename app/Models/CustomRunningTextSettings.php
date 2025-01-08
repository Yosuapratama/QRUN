<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomRunningTextSettings extends Model
{
    use HasFactory;

    public $table = 'custom_running_text_settings';

    public $guarded = ['id'];

}
