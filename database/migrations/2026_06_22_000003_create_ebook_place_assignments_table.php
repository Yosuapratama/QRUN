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
        Schema::create('ebook_place_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ebook_id')->constrained('ebooks')->cascadeOnDelete();
            $table->foreignId('ebook_place_id')->constrained('ebook_places')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['ebook_id', 'ebook_place_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_place_assignments');
    }
};
