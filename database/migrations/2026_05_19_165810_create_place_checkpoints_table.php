<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('place_checkpoints', function (Blueprint $table) {

            $table->id();

            $table->foreignId('place_id')
                ->constrained('places')
                ->cascadeOnDelete();

            $table->string('place_code')->index();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('session_id')->nullable()->index();

            $table->string('ip_address', 100)->nullable();

            $table->string('device_type')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();

            $table->text('referer')->nullable();

            $table->string('country')->nullable();
            $table->string('city')->nullable();

            $table->timestamp('checked_at')->index();

            $table->timestamps();

            $table->index([
                'place_id',
                'checked_at'
            ]);

            $table->index([
                'user_id',
                'checked_at'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('place_checkpoints');
    }
};