<?php

namespace Database\Seeders;

use App\Models\Ebook;
use App\Models\EbookCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    /**
     * Seed 200 ebooks (plus the master categories they use).
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $categoryNames = [
            'Novel', 'Komik', 'Majalah', 'Motivasi', 'Bisnis',
            'Teknologi', 'Pendidikan', 'Sejarah', 'Budaya', 'Anak',
        ];

        // Ensure the master categories exist.
        foreach ($categoryNames as $name) {
            EbookCategory::firstOrCreate(['name' => $name]);
        }

        // Use a superadmin as the creator when available.
        $creatorId = User::role('superadmin')->value('id')
            ?? User::value('id');

        $rows = [];

        for ($i = 1; $i <= 200; $i++) {
            $title = Str::title($faker->unique()->sentence(rand(3, 6)));
            $title = rtrim($title, '.');

            $paragraphs = collect(range(1, rand(4, 8)))
                ->map(fn () => '<p>' . $faker->paragraph(rand(4, 9)) . '</p>')
                ->implode("\n");

            $createdAt = Carbon::now()->subDays(rand(0, 365))->subMinutes(rand(0, 1440));

            $rows[] = [
                'slug'         => Str::slug($title) . '-' . $i,
                'title'        => $title,
                'description'  => $faker->sentence(rand(8, 14)),
                'author'       => $faker->name(),
                'category'     => $faker->randomElement($categoryNames),
                'image_url'    => "https://picsum.photos/seed/ebook{$i}/400/600",
                'file_url'     => null,
                'creator_id'   => $creatorId,
                'content'      => $paragraphs,
                'views'        => rand(0, 5000),
                'is_published' => $faker->boolean(80) ? 1 : 0,
                'created_at'   => $createdAt,
                'updated_at'   => $createdAt,
            ];

            // Insert in chunks to keep memory usage low.
            if (count($rows) === 50) {
                DB::table('ebooks')->insert($rows);
                $rows = [];
            }
        }

        if (!empty($rows)) {
            DB::table('ebooks')->insert($rows);
        }

        $this->command->info('Seeded 200 ebooks across ' . count($categoryNames) . ' categories.');
    }
}
