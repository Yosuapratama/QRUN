<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One row per visitor that opens a location's scan page — the ebook
     * equivalent of place_checkpoints. Used to count & analyse scans.
     */
    public function up(): void
    {
        if (Schema::hasTable('ebook_place_checkpoints')) {
            return;
        }

        Schema::create('ebook_place_checkpoints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ebook_place_id');
            $table->string('ebook_place_code')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('referrer')->nullable();
            $table->string('user_agent')->nullable();

            $table->string('browser_name')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device_name')->nullable();
            $table->boolean('is_mobile')->default(false);

            $table->timestamp('checked_at')->nullable();
            $table->timestamps();

            $table->index('ebook_place_id');
            $table->index('checked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebook_place_checkpoints');
    }
};
