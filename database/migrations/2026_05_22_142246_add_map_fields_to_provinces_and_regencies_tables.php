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
        Schema::table('reg_provinces', function (Blueprint $table) {

            if (!Schema::hasColumn('reg_provinces', 'latitude')) {
                $table->double('latitude')
                    ->nullable()
                    ->after('name');
            }

            if (!Schema::hasColumn('reg_provinces', 'longitude')) {
                $table->double('longitude')
                    ->nullable()
                    ->after('latitude');
            }

            if (!Schema::hasColumn('reg_provinces', 'polygon_path')) {
                $table->longText('polygon_path')
                    ->nullable()
                    ->after('longitude');
            }
        });

        Schema::table('reg_regencies', function (Blueprint $table) {

            if (!Schema::hasColumn('reg_regencies', 'latitude')) {
                $table->double('latitude')
                    ->nullable()
                    ->after('name');
            }

            if (!Schema::hasColumn('reg_regencies', 'longitude')) {
                $table->double('longitude')
                    ->nullable()
                    ->after('latitude');
            }

            if (!Schema::hasColumn('reg_regencies', 'polygon_path')) {
                $table->longText('polygon_path')
                    ->nullable()
                    ->after('longitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reg_provinces', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('reg_provinces', 'latitude')) {
                $columns[] = 'latitude';
            }

            if (Schema::hasColumn('reg_provinces', 'longitude')) {
                $columns[] = 'longitude';
            }

            if (Schema::hasColumn('reg_provinces', 'polygon_path')) {
                $columns[] = 'polygon_path';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });

        Schema::table('reg_regencies', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('reg_regencies', 'latitude')) {
                $columns[] = 'latitude';
            }

            if (Schema::hasColumn('reg_regencies', 'longitude')) {
                $columns[] = 'longitude';
            }

            if (Schema::hasColumn('reg_regencies', 'polygon_path')) {
                $columns[] = 'polygon_path';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};