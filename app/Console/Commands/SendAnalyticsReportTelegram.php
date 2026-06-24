<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Place;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Storage;

class SendAnalyticsReportTelegram extends Command
{
    protected $signature = 'report:telegram
                            {--start=}
                            {--end=}';

    protected $description = 'Send analytics report PDF to Telegram';

    public function handle()
    {
        $startDate = $this->option('start');
        $endDate = $this->option('end');

        $places = Place::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate),
                    Carbon::parse($endDate)
                ]);
            })
            ->get();

        $users = User::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate),
                    Carbon::parse($endDate)
                ]);
            })
            ->get();

        $events = Event::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [
                    Carbon::parse($startDate),
                    Carbon::parse($endDate)
                ]);
            })
            ->get();

        $pdf = Pdf::loadView('Pages.Management.Master.report.pdf', [
            'places' => $places,
            'users' => $users,
            'events' => $events,
            'total_place' => $places->count(),
            'total_user' => $users->count(),
            'total_views' => $places->sum('views'),
            'total_events' => $events->count(),
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $filename = sprintf(
            'analytics-report-%s.pdf',
            now()->format('Ymd_His')
        );

        $path = storage_path('app/reports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, $pdf->output());

        TelegramService::sendDocument(
            $path,
            sprintf(
                "📊 QRUN Analytics Report\nPeriod: %s - %s",
                $startDate ?: '-',
                $endDate ?: '-'
            )
        );

        unlink($path);

        $this->info('Report sent to Telegram.');
    }

}