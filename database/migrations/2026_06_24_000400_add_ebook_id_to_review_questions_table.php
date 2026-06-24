<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Allow review questions to belong to an ebook (per-ebook override set)
     * instead of a location. Location questions keep ebook_id = null; ebook
     * questions keep ebook_place_id = null.
     */
    public function up(): void
    {
        Schema::table('ebook_review_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('ebook_review_questions', 'ebook_id')) {
                $table->unsignedBigInteger('ebook_id')->nullable()->after('ebook_place_id');
                $table->index('ebook_id');
            }
        });

        // Location id is no longer required (ebook-owned questions have none).
        Schema::table('ebook_review_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('ebook_place_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ebook_review_questions', function (Blueprint $table) {
            if (Schema::hasColumn('ebook_review_questions', 'ebook_id')) {
                $table->dropColumn('ebook_id');
            }
        });
    }
};
