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
        Schema::create('event_images', function (Blueprint $table) {

            $table->id();

            // relation to event table
            $table->foreignId('event_id')
                ->constrained('event')
                ->cascadeOnDelete();

            // image path
            $table->string('image');

            // optional sort order
            $table->integer('sort_order')
                ->default(0);

            $table->timestamps();
            $table->softDeletes();

            // indexing
            $table->index('event_id');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_images');
    }
};