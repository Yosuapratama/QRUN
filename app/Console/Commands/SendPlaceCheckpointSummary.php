<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\PlaceCheckpoint;
use App\Services\TelegramService;
use Illuminate\Support\Facades\DB;

class SendPlaceCheckpointSummary extends Command
{
    protected $signature = 'checkpoint:summary {hours=6}';

    protected $description =
        'Send place checkpoint summary';

    public function handle()
    {
        $hours = (int) $this->argument('hours');

        $start = now()->subHours($hours);
        $end = now();

        $summary = PlaceCheckpoint::query()
            ->select(
                'place_id',
                'place_code',
                DB::raw('COUNT(*) as total_checkins'),
                DB::raw('COUNT(DISTINCT session_id) as unique_visitors')
            )
            ->with('place:id,title')
            ->whereBetween('checked_at', [
                $start,
                $end
            ])
            ->groupBy('place_id', 'place_code')
            ->orderByDesc('total_checkins')
            ->take(10)
            ->get();

        if ($summary->isEmpty()) {
            return;
        }

        $message =
            "📊 <b>QRUN CHECKPOINT SUMMARY</b>\n\n";

        $message .=
            "Period: {$hours} Hours\n";

        $message .=
            $start->format('d M Y H:i')
            . " - "
            . $end->format('d M Y H:i')
            . "\n\n";

        foreach ($summary as $index => $item) {

            $message .=
                ($index + 1) . ". <b>"
                . ($item->place->title ?? '-')
                . "</b>\n";

            $message .=
                "Code: {$item->place_code}\n";

            $message .=
                "Checkins: {$item->total_checkins}\n";

            $message .=
                "Unique Visitor: {$item->unique_visitors}\n\n";
        }

        TelegramService::send($message);

        $this->info('Summary sent');
    }
}