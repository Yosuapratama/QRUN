<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Per-ebook override of the location's read-gating policy. When
     * `ad_override_enabled` is on, the columns below take precedence over the
     * location settings (so a specific ebook can be stricter / looser).
     */
    public function up(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            if (!Schema::hasColumn('ebooks', 'ad_override_enabled')) {
                $table->boolean('ad_override_enabled')->default(0)->after('is_published');
            }
            if (!Schema::hasColumn('ebooks', 'lock_enabled')) {
                $table->boolean('lock_enabled')->nullable()->after('ad_override_enabled');
            }
            if (!Schema::hasColumn('ebooks', 'read_limit')) {
                $table->unsignedInteger('read_limit')->nullable()->after('lock_enabled');
            }
            if (!Schema::hasColumn('ebooks', 'unlock_method')) {
                $table->string('unlock_method')->nullable()->after('read_limit');
            }
            if (!Schema::hasColumn('ebooks', 'unlock_duration')) {
                $table->unsignedInteger('unlock_duration')->nullable()->after('unlock_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            foreach (['ad_override_enabled', 'lock_enabled', 'read_limit', 'unlock_method', 'unlock_duration'] as $col) {
                if (Schema::hasColumn('ebooks', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
