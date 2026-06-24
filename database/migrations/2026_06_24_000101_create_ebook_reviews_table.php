<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A review submitted by a visitor to unlock an ebook. `answers` is a JSON
     * map of { question_id: answer }. `rating` is pulled out of the first
     * rating-type answer for easy aggregation.
     */
    public function up(): void
    {
        if (Schema::hasTable('ebook_reviews')) {
            return;
        }

        Schema::create('ebook_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ebook_place_id');
            $table->unsignedBigInteger('ebook_id')->nullable();
            $table->string('ebook_slug')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->json('answers')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index('ebook_place_id');
            $table->index('ebook_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebook_reviews');
    }
};
