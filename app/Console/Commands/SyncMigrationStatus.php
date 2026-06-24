<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SyncMigrationStatus extends Command
{
    protected $signature = 'migration:sync';

    protected $description = 'Sync existing migration files into migrations table';

    public function handle()
    {
        $migrationPath = database_path('migrations');

        if (!File::exists($migrationPath)) {
            $this->error('Migration folder not found.');
            return Command::FAILURE;
        }

        $files = File::files($migrationPath);

        if (empty($files)) {
            $this->warn('No migration files found.');
            return Command::SUCCESS;
        }

        // ambil batch terakhir
        $lastBatch = DB::table('migrations')->max('batch') ?? 0;
        $batch = $lastBatch + 1;

        $inserted = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $migrationName = pathinfo($file->getFilename(), PATHINFO_FILENAME);

            $exists = DB::table('migrations')
                ->where('migration', $migrationName)
                ->exists();

            if ($exists) {
                $this->line("SKIP  : {$migrationName}");
                $skipped++;
                continue;
            }

            DB::table('migrations')->insert([
                'migration' => $migrationName,
                'batch' => $batch,
            ]);

            $this->info("SYNC  : {$migrationName}");
            $inserted++;
        }

        $this->newLine();
        $this->info("Done.");
        $this->line("Inserted : {$inserted}");
        $this->line("Skipped  : {$skipped}");

        return Command::SUCCESS;
    }
}