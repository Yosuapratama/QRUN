<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('ebook_places', 'logo_url')) {
            Schema::table('ebook_places', function (Blueprint $table) {
                $table->text('logo_url')->nullable()->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('ebook_places', 'logo_url')) {
            Schema::table('ebook_places', function (Blueprint $table) {
                $table->dropColumn('logo_url');
            });
        }
    }
};
