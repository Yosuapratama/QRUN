<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Custom review questions a location asks visitors before unlocking a
     * locked ebook. Answers are stored in `ebook_reviews` — everything stays
     * on our own site (no external review service).
     *
     *  type    : rating | text | textarea | choice
     *  options : choices for the "choice" type (JSON array of strings)
     */
    public function up(): void
    {
        if (Schema::hasTable('ebook_review_questions')) {
            return;
        }

        Schema::create('ebook_review_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ebook_place_id');
            $table->string('question');
            $table->string('type')->default('text');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('ebook_place_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebook_review_questions');
    }
};
