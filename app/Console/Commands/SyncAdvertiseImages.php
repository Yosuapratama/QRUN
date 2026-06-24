<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Advertise;
use App\Models\AdvertiseImage;

class SyncAdvertiseImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advertise:sync-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync old image_url column into advertise_images table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $advertises = Advertise::whereNotNull('image_url')->get();

        $bar = $this->output->createProgressBar($advertises->count());

        $bar->start();

        foreach ($advertises as $advertise) {

            // Skip jika sudah ada image
            $alreadyExists = AdvertiseImage::where('advertise_id', $advertise->id)
                ->where('image_url', $advertise->image_url)
                ->exists();

            if (!$alreadyExists) {
                $imagePath = parse_url($advertise->image_url, PHP_URL_PATH);

                AdvertiseImage::create([
                    'advertise_id' => $advertise->id,
                    'image_url'    => ltrim($imagePath, '/'),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);

        $this->info('Advertise images synced successfully.');
    }
}
