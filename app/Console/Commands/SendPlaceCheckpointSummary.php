<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlaceCheckpoint;
use App\Services\TelegramService;
use Illuminate\Support\Facades\DB;

class SendPlaceCheckpointSummary extends Command
{
    protected $signature = 'checkpoint:summary {hours=6}';

    protected $description = 'Send place checkpoint summary';

    public function handle()
    {
        $hours = (int) $this->argument('hours');

        $start = now()->subHours($hours);
        $end = now();

        $baseQuery = PlaceCheckpoint::query()
            ->whereBetween('checked_at', [$start, $end]);

        $totalCheckins = (clone $baseQuery)->count();

        if ($totalCheckins === 0) {
            $this->info('No checkpoint data');
            return;
        }

        $uniqueVisitors = (clone $baseQuery)
            ->distinct('session_id')
            ->count('session_id');

        $topPlaces = (clone $baseQuery)
            ->select(
                'place_id',
                'place_code',
                DB::raw('COUNT(*) as total_checkins'),
                DB::raw('COUNT(DISTINCT session_id) as unique_visitors')
            )
            ->with('place:id,title')
            ->groupBy('place_id', 'place_code')
            ->orderByDesc('total_checkins')
            ->take(10)
            ->get();

        $deviceStats = (clone $baseQuery)
            ->select(
                'device_type',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('device_type')
            ->pluck('total', 'device_type');

        $platformStats = (clone $baseQuery)
            ->select(
                'platform',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('platform')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $browserStats = (clone $baseQuery)
            ->select(
                'browser_name',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('browser_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $message = "📊 <b>QRUN CHECKPOINT SUMMARY</b>\n";
        $message .= "━━━━━━━━━━━━━━\n\n";

        $message .= "🕒 <b>Period</b>\n";
        $message .= "{$start->format('d M Y H:i')} - {$end->format('d M Y H:i')}\n";
        $message .= "Last {$hours} Hours\n\n";

        $message .= "📌 <b>Overview</b>\n";
        $message .= "• Total Checkins: <b>" . number_format($totalCheckins) . "</b>\n";
        $message .= "• Unique Visitors: <b>" . number_format($uniqueVisitors) . "</b>\n\n";

        $message .= "📱 <b>Device Usage</b>\n";

        foreach ($deviceStats as $device => $total) {
            $deviceName = ucfirst($device ?: 'Unknown');

            $message .= "• {$deviceName}: {$total}\n";
        }

        $message .= "\n💻 <b>Top Platforms</b>\n";

        foreach ($platformStats as $platform) {
            $name = $platform->platform ?: 'Unknown';

            $message .= "• {$name}: {$platform->total}\n";
        }

        $message .= "\n🌐 <b>Top Browsers</b>\n";

        foreach ($browserStats as $browser) {
            $name = $browser->browser_name ?: 'Unknown';

            $message .= "• {$name}: {$browser->total}\n";
        }

        $message .= "\n🏆 <b>Top 10 Places</b>\n";

        foreach ($topPlaces as $index => $item) {
            $title = $item->place->title ?? 'Unknown Place';

            $message .= "\n" . ($index + 1) . ". <b>{$title}</b>\n";
            $message .= "└ Code: <code>{$item->place_code}</code>\n";
            $message .= "└ Checkins: {$item->total_checkins}\n";
            $message .= "└ Visitors: {$item->unique_visitors}\n";
        }

        TelegramService::send($message);

        $this->info('Summary sent');
    }
}