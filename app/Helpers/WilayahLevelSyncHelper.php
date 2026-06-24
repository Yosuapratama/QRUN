<?php

namespace App\Helpers;

use App\Models\Province;
use App\Models\Regency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WilayahLevelSyncHelper
{
    public static function sync(): void
    {
        DB::transaction(function () {

            self::syncProvince();
            self::syncRegency();
        });
    }

    private static function syncProvince(): void
    {
        $boundaries = DB::table('wilayah_level_1_2')
            ->whereRaw('CHAR_LENGTH(kode) = 2')
            ->get();

        Province::chunk(100, function ($provinces) use ($boundaries) {

            foreach ($provinces as $province) {

                // Priority 1: Match by code
                $provinceCode = str_pad($province->id, 2, '0', STR_PAD_LEFT);

                $match = $boundaries
                    ->firstWhere('kode', $provinceCode);

                // Priority 2: Match by normalized name
                if (!$match) {

                    $match = $boundaries->first(function ($item) use ($province) {

                        return self::normalizeName($item->nama)
                            === self::normalizeName($province->name);
                    });
                }

                if (!$match) {
                    continue;
                }

                $province->update([
                    'latitude' => $match->lat,
                    'longitude' => $match->lng,
                    'polygon_path' => $match->path,
                ]);
            }
        });
    }

    private static function syncRegency(): void
    {
        $boundaries = DB::table('wilayah_level_1_2')
            ->whereRaw('CHAR_LENGTH(kode) = 5')
            ->get();

        Regency::chunk(100, function ($regencies) use ($boundaries) {

            foreach ($regencies as $regency) {

                /**
                 * Convert:
                 * 1101 -> 11.01
                 * 5101 -> 51.01
                 * 3674 -> 36.74
                 */
                $regencyCode = substr($regency->id, 0, 2)
                    . '.'
                    . substr($regency->id, 2, 2);

                // Priority 1: Match by code
                $match = $boundaries->firstWhere(
                    'kode',
                    $regencyCode
                );

                // Priority 2: Match by normalized name
                if (!$match) {

                    $match = $boundaries->first(function ($item) use ($regency) {

                        return self::normalizeName($item->nama)
                            === self::normalizeName($regency->name);
                    });
                }

                if (!$match) {

                    logger()->warning('Regency not matched', [
                        'id' => $regency->id,
                        'name' => $regency->name,
                        'generated_code' => $regencyCode,
                    ]);

                    continue;
                }

                $regency->update([
                    'latitude' => $match->lat,
                    'longitude' => $match->lng,
                    'polygon_path' => $match->path,
                ]);
            }
        });
    }

    private static function normalizeName(?string $name): string
    {
        if (!$name) {
            return '';
        }

        return Str::of($name)
            ->upper()
            ->replace('KABUPATEN', '')
            ->replace('KOTA', '')
            ->replace('DAERAH ISTIMEWA', '')
            ->replace('PROVINSI', '')
            ->replace('DKI', '')
            ->replace('DI ', '')
            ->replace('.', '')
            ->replace(',', '')
            ->squish()
            ->toString();
    }
}
