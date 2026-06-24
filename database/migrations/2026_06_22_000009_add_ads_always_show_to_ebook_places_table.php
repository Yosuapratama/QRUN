<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Whether the ads modal re-appears on every page load (1) or only once
     * per browser session (0, default).
     */
    public function up(): void
    {
        if (Schema::hasColumn('ebook_places', 'ads_always_show')) {
            return;
        }

        Schema::table('ebook_places', function (Blueprint $table) {
            $table->boolean('ads_always_show')->default(0)->after('logo_url');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('ebook_places', 'ads_always_show')) {
            return;
        }

        Schema::table('ebook_places', function (Blueprint $table) {
            $table->dropColumn('ads_always_show');
        });
    }
};
