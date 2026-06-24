<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Per-ebook unlock ad creatives, used when the ebook overrides the location
     * gating policy. Each ebook can supply its own timed banner and review
     * banner; when absent the location's ads are used as a fallback.
     */
    public function up(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            if (!Schema::hasColumn('ebooks', 'unlock_timed_image')) {
                $table->string('unlock_timed_image')->nullable()->after('unlock_duration');
            }
            if (!Schema::hasColumn('ebooks', 'unlock_timed_target_url')) {
                $table->string('unlock_timed_target_url')->nullable()->after('unlock_timed_image');
            }
            if (!Schema::hasColumn('ebooks', 'unlock_review_image')) {
                $table->string('unlock_review_image')->nullable()->after('unlock_timed_target_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            foreach (['unlock_timed_image', 'unlock_timed_target_url', 'unlock_review_image'] as $col) {
                if (Schema::hasColumn('ebooks', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
