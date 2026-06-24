<?php

namespace App\Support;

use App\Models\Ebook;
use App\Models\EbookPlace;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Server-side read-gating for ebook locations.
 *
 * The whole point of this class is that the "how many ebooks have you read"
 * counter lives in the Laravel server session (signed cookie -> server store),
 * never in the browser. A visitor cannot edit localStorage / devtools to grant
 * themselves more reads, and a timed unlock is validated against the server
 * clock so a countdown cannot be fast-forwarded on the client.
 *
 * Session shape:
 *   ebook_gate => [
 *     <code> => [
 *       'opened' => ['slug-a', 'slug-b', ...],   // ebooks already granted
 *       'token'  => [                            // pending unlock challenge
 *         'nonce'      => '...',
 *         'slug'       => 'slug-c',
 *         'method'     => 'timed'|'review',
 *         'duration'   => 15,                    // seconds required
 *         'started_at' => 1718800000,            // server unix time
 *       ],
 *     ],
 *   ]
 */
class EbookGate
{
    private const SESSION_KEY = 'ebook_gate';

    /** Minimum server-enforced wait for a "review" unlock (anti-instant-click). */
    public const REVIEW_MIN_SECONDS = 4;

    /** Hard bounds so a misconfigured place can't lock the gate forever / never. */
    private const MAX_DURATION = 600;
    private const MIN_DURATION = 3;

    /**
     * Merge the per-ebook override (when enabled) over the location policy.
     * Returns a normalised config array.
     */
    public static function effectiveConfig(EbookPlace $place, Ebook $ebook): array
    {
        $lockEnabled  = (bool) $place->lock_enabled;
        $readLimit    = (int) $place->read_limit;
        $unlockMethod = (string) ($place->unlock_method ?: 'timed');
        $duration     = (int) $place->unlock_duration;

        if ($ebook->ad_override_enabled) {
            if ($ebook->lock_enabled !== null)   $lockEnabled  = (bool) $ebook->lock_enabled;
            if ($ebook->read_limit !== null)     $readLimit    = (int) $ebook->read_limit;
            if ($ebook->unlock_method !== null)  $unlockMethod = (string) $ebook->unlock_method;
            if ($ebook->unlock_duration !== null) $duration    = (int) $ebook->unlock_duration;
        }

        if (!in_array($unlockMethod, ['timed', 'review', 'both'], true)) {
            $unlockMethod = 'timed';
        }

        return [
            'lock_enabled'  => $lockEnabled,
            'read_limit'    => max(0, $readLimit),
            'unlock_method' => $unlockMethod,
            'unlock_duration' => self::clampDuration($duration ?: 15),
        ];
    }

    public static function clampDuration(int $seconds): int
    {
        return max(self::MIN_DURATION, min(self::MAX_DURATION, $seconds));
    }

    /** Whole gate state for one location code. */
    private static function state(string $code): array
    {
        $all = Session::get(self::SESSION_KEY, []);
        return $all[$code] ?? ['opened' => [], 'token' => null];
    }

    private static function save(string $code, array $state): void
    {
        $all = Session::get(self::SESSION_KEY, []);
        $all[$code] = $state;
        Session::put(self::SESSION_KEY, $all);
    }

    /** Has this exact ebook already been opened/granted at this location? */
    public static function isOpened(string $code, string $slug): bool
    {
        return in_array($slug, self::state($code)['opened'] ?? [], true);
    }

    /** Number of distinct ebooks already opened at this location. */
    public static function openedCount(string $code): int
    {
        return count(self::state($code)['opened'] ?? []);
    }

    /**
     * Consume one of the free reads if the limit hasn't been reached yet.
     * Returns true when access is granted (and the slug recorded).
     */
    public static function tryConsumeFreeRead(string $code, string $slug, int $readLimit): bool
    {
        $state = self::state($code);
        $opened = $state['opened'] ?? [];

        if (count($opened) >= $readLimit) {
            return false;
        }

        $opened[] = $slug;
        $state['opened'] = array_values(array_unique($opened));
        self::save($code, $state);

        return true;
    }

    /** Permanently grant access to one ebook at this location. */
    public static function grantAccess(string $code, string $slug): void
    {
        $state = self::state($code);
        $opened = $state['opened'] ?? [];
        $opened[] = $slug;
        $state['opened'] = array_values(array_unique($opened));
        $state['token'] = null;
        self::save($code, $state);
    }

    /**
     * Begin an unlock challenge for a locked ebook. Stores a server-side token
     * with the start time; the matching complete() call must arrive only after
     * `duration` real seconds have elapsed.
     */
    public static function startUnlock(string $code, string $slug, string $method, int $duration): array
    {
        $method = in_array($method, ['timed', 'review'], true) ? $method : 'timed';

        $required = $method === 'review'
            ? max(self::REVIEW_MIN_SECONDS, 0)
            : self::clampDuration($duration);

        $token = [
            'nonce'      => Str::random(40),
            'slug'       => $slug,
            'method'     => $method,
            'duration'   => $required,
            'started_at' => time(),
        ];

        $state = self::state($code);
        $state['token'] = $token;
        self::save($code, $state);

        return ['nonce' => $token['nonce'], 'duration' => $required];
    }

    /**
     * Validate an unlock challenge. Grants access only when the nonce + slug
     * match the pending token AND enough real time has passed on the server.
     */
    public static function completeUnlock(string $code, string $slug, string $nonce): bool
    {
        $state = self::state($code);
        $token = $state['token'] ?? null;

        if (!$token) {
            return false;
        }

        if (!hash_equals((string) $token['nonce'], $nonce)) {
            return false;
        }

        if ($token['slug'] !== $slug) {
            return false;
        }

        $elapsed = time() - (int) $token['started_at'];
        if ($elapsed < (int) $token['duration']) {
            return false;
        }

        self::grantAccess($code, $slug);

        return true;
    }
}
