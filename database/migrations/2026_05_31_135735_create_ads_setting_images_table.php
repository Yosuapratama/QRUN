<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads_setting_images', function (Blueprint $table) {

            $table->id();

            $table->foreignId('ads_setting_id')
                ->constrained('custom_ads_settings')
                ->cascadeOnDelete();

            $table->text('image_url');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads_setting_images');
    }
};
