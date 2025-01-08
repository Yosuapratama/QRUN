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
        Schema::create('custom_settings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('field_one_value')->nullable();
            $table->string('field_two_value')->nullable();
            $table->string('field_three_value')->nullable();
            $table->string('field_four_value')->nullable();
            $table->string('photo_url')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_settings');
    }
};
