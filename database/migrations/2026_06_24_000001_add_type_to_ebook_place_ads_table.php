<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Distinguish the role each ad plays:
     *  - promo  : auto-playing modal slider on the scan page (existing behaviour).
     *  - timed  : interstitial shown to unlock a locked ebook; the visitor must
     *             wait `duration_seconds` (falls back to the place default).
     *  - review : unlock card that sends the visitor to `review_url` to leave a review.
     *
     *  target_url is an optional click-through for promo/timed banners.
     */
    public function up(): void
    {
        Schema::table('ebook_place_ads', function (Blueprint $table) {
            if (!Schema::hasColumn('ebook_place_ads', 'type')) {
                $table->string('type')->default('promo')->after('ebook_place_id');
            }
            if (!Schema::hasColumn('ebook_place_ads', 'duration_seconds')) {
                $table->unsignedInteger('duration_seconds')->nullable()->after('image_url');
            }
            if (!Schema::hasColumn('ebook_place_ads', 'target_url')) {
                $table->string('target_url')->nullable()->after('duration_seconds');
            }
            if (!Schema::hasColumn('ebook_place_ads', 'review_url')) {
                $table->string('review_url')->nullable()->after('target_url');
            }
            if (!Schema::hasColumn('ebook_place_ads', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('review_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ebook_place_ads', function (Blueprint $table) {
            foreach (['type', 'duration_seconds', 'target_url', 'review_url', 'is_active'] as $col) {
                if (Schema::hasColumn('ebook_place_ads', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
