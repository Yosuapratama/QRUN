<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendUserRegistrationSummary extends Command
{
    protected $signature = 'user:summary {hours=6}';

    protected $description = 'Send user registration summary';

    public function handle()
    {
        $hours = (int) $this->argument('hours');

        $start = now()->subHours($hours);
        $end = now();

        $users = User::query()
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at')
            ->get([
                'name',
                'email',
                'created_at',
                'email_verified_at'
            ]);

        $totalUsers = $users->count();

        if ($totalUsers === 0) {
            $this->info('No new users');
            return;
        }

        $emailDomains = User::query()
            ->whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw("SUBSTRING_INDEX(email, '@', -1) as domain"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('domain')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $verifiedCount = $users
            ->whereNotNull('email_verified_at')
            ->count();

        $message = "👤 <b>QRUN USER REGISTRATION SUMMARY</b>\n";
        $message .= "━━━━━━━━━━━━━━\n\n";

        $message .= "🕒 <b>Period</b>\n";
        $message .= "{$start->format('d M Y H:i')} - {$end->format('d M Y H:i')}\n";
        $message .= "Last {$hours} Hours\n\n";

        $message .= "📊 <b>Overview</b>\n";
        $message .= "• New Users: <b>{$totalUsers}</b>\n";
        $message .= "• Verified Emails: <b>{$verifiedCount}</b>\n";
        $message .= "• Unverified Emails: <b>" . ($totalUsers - $verifiedCount) . "</b>\n\n";

        if ($emailDomains->count()) {
            $message .= "📧 <b>Top Email Domains</b>\n";

            foreach ($emailDomains as $domain) {
                $message .= "• {$domain->domain}: {$domain->total}\n";
            }

            $message .= "\n";
        }

        $message .= "📝 <b>New Registrations</b>\n";

        foreach ($users as $index => $user) {
            $verified = $user->email_verified_at
                ? '✅'
                : '⏳';

            $message .= "\n" . ($index + 1) . ". {$verified} <b>{$user->name}</b>\n";
            $message .= "└ {$user->email}\n";
            $message .= "└ {$user->created_at->format('d M Y H:i')}\n";
        }

        TelegramService::send($message);

        $this->info('User summary sent');
    }
}