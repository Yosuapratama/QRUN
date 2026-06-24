<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ads / promo slides shown as a modal "player" on a location's scan page.
     * Each row is one image with an optional title.
     */
    public function up(): void
    {
        if (Schema::hasTable('ebook_place_ads')) {
            return;
        }

        Schema::create('ebook_place_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ebook_place_id');
            $table->string('title')->nullable();
            $table->string('image_url');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('ebook_place_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebook_place_ads');
    }
};
