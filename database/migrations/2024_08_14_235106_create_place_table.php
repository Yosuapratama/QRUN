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
        Schema::create('place', function (Blueprint $table) {
            $table->id();
            $table->string('place_code')->unique();
            $table->string('title');
            $table->string('description');
            $table->foreignId('creator_id')->nullable()->references('id')->on('users');
            $table->longText('content');
            $table->integer('views');
            $table->boolean('is_comment')->default(1);
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place');
    }
};
