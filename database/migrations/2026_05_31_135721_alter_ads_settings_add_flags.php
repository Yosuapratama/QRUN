<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('custom_ads_settings', function (Blueprint $table) {

            $table->boolean('merge_with_advertise_users')
                ->default(false)
                ->after('is_active');

            $table->boolean('is_blocking')
                ->default(false)
                ->after('merge_with_advertise_users');

        });
    }

    public function down(): void
    {
        Schema::table('custom_ads_settings', function (Blueprint $table) {

            $table->dropColumn([
                'merge_with_advertise_users',
                'is_blocking'
            ]);

        });
    }
};