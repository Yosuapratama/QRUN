<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = [
        'instagram', 'youtube', 'linkedin', 'email',
        'whatsapp', 'tiktok', 'website', 'reservation',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ebook_places', function (Blueprint $table) {
            foreach ($this->columns as $col) {
                if (!Schema::hasColumn('ebook_places', $col)) {
                    $table->string($col)->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebook_places', function (Blueprint $table) {
            foreach ($this->columns as $col) {
                if (Schema::hasColumn('ebook_places', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
