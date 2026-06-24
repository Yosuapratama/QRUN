<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertise_images', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('advertise_id');

            $table->string('image_url');

            $table->integer('sort_order')
                ->default(0);

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('advertise_id')
                ->references('id')
                ->on('advertise_tables')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertise_images');
    }
};