<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Read-gating (unlock) policy for a location.
     *
     *  - lock_enabled    : turn the read limit on/off for this location.
     *  - read_limit      : number of ebooks a visitor may open for free
     *                      before the next one is locked.
     *  - unlock_method   : how a locked ebook can be unlocked
     *                      (timed | review | both).
     *  - unlock_duration : seconds the visitor must wait on a timed ad
     *                      before the unlock is granted (enforced server-side).
     */
    public function up(): void
    {
        Schema::table('ebook_places', function (Blueprint $table) {
            if (!Schema::hasColumn('ebook_places', 'lock_enabled')) {
                $table->boolean('lock_enabled')->default(0)->after('ads_always_show');
            }
            if (!Schema::hasColumn('ebook_places', 'read_limit')) {
                $table->unsignedInteger('read_limit')->default(2)->after('lock_enabled');
            }
            if (!Schema::hasColumn('ebook_places', 'unlock_method')) {
                $table->string('unlock_method')->default('timed')->after('read_limit');
            }
            if (!Schema::hasColumn('ebook_places', 'unlock_duration')) {
                $table->unsignedInteger('unlock_duration')->default(15)->after('unlock_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ebook_places', function (Blueprint $table) {
            foreach (['lock_enabled', 'read_limit', 'unlock_method', 'unlock_duration'] as $col) {
                if (Schema::hasColumn('ebook_places', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
