<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\WilayahLevelSyncHelper;

class SyncWilayahLevelSeeder extends Seeder
{
    public function run(): void
    {
        WilayahLevelSyncHelper::sync();

        $this->command->info(
            'Province & regency synced successfully.'
        );
    }
}