<?php

namespace App\Http\Controllers;

use App\Exports\EbookReviewExport;
use App\Http\Controllers\Concerns\ReviewExportable;
use App\Models\EbookPlace;
use App\Models\EbookPlaceAd;
use App\Models\EbookPlaceCheckpoint;
use App\Models\EbookReview;
use App\Models\EbookReviewQuestion;
use App\Support\EbookGate;
use App\Models\LogActivities;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EbookPlaceController extends Controller
{
    use ReviewExportable;

    /*
    |--------------------------------------------------------------------------
    | Ebook Place Controller
    |--------------------------------------------------------------------------
    |
    | Manages ebook locations (hotel/cafe/room) that each carry a unique QR
    | code. Admin actions are superadmin-only; scan() is public.
    */

    private $applicationURLLocal;

    /** Optional contact / social fields stored on a location. */
    private const CONTACT_FIELDS = [
        'instagram', 'youtube', 'linkedin', 'email',
        'whatsapp', 'tiktok', 'website', 'reservation',
    ];

    public function __construct(Request $request)
    {
        $this->applicationURLLocal = $request->schemeAndHttpHost();

        // Guard only the admin actions; the public scan / unlock endpoints stay accessible.
        if (!$request->routeIs('ebook-place.scan', 'ebook-place.scan.data', 'ebook-place.unlock.start', 'ebook-place.unlock.complete')) {
            if (!Auth::check()) {
                return abort(403);
            }
            if (!Auth::user()->approved_at) {
                return back()->withErrors('Your Account Need Approval First !');
            }
            if (!Auth::user()->hasRole('superadmin')) {
                return abort(403);
            }
        }
    }

    // Admin: locations list (DataTables)
    public function index(Request $request)
    {
        $data = EbookPlace::withCount('ebooks')->latest()->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active
                        ? "<span class='badge badge-success'>Active</span>"
                        : "<span class='badge badge-secondary'>Inactive</span>";
                })
                ->addColumn('ebooks_count', function ($row) {
                    return $row->ebooks_count;
                })
                ->addColumn('action', function ($row) {
                    $detailUrl = route('ebook-place.detail', $row->id);
                    $editUrl = route('ebook-place.edit', $row->id);
                    $printUrl = route('ebook-place.print', $row->code);
                    $scanUrl = route('ebook-place.scan', $row->code);

                    return "
                        <div class='dropdown'>
                            <button class='btn btn-primary btn-sm dropdown-toggle shadow-sm' type='button'
                                data-toggle='dropdown' aria-expanded='false'>
                                <i class='fas fa-cog mr-1'></i> Action
                            </button>
                            <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'>
                                <a href='{$detailUrl}' class='dropdown-item'>
                                    <i class='fas fa-info-circle text-secondary mr-2'></i> Detail
                                </a>
                                <a href='{$scanUrl}' target='_blank' class='dropdown-item'>
                                    <i class='fas fa-eye text-secondary mr-2'></i> View Page
                                </a>
                                <a href='{$printUrl}' target='_blank' class='dropdown-item'>
                                    <i class='fas fa-qrcode text-secondary mr-2'></i> Print QR
                                </a>
                                <a href='{$editUrl}' class='dropdown-item'>
                                    <i class='fas fa-edit text-secondary mr-2'></i> Edit
                                </a>
                                <div class='dropdown-divider'></div>
                                <button id='{$row->id}' class='delete dropdown-item text-danger' type='button'>
                                    <i class='fas fa-trash-alt mr-2'></i> Delete
                                </button>
                            </div>
                        </div>
                    ";
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('Pages.Management.Master.ebook-place.index');
    }

    public function create()
    {
        return view('Pages.Management.Master.ebook-place.form', [
            'ebookPlace' => null,
        ]);
    }

    public function edit($id)
    {
        // Connected ebooks are loaded lazily via AJAX (a location can have
        // hundreds), so we only need the count here — not the full collection.
        $ebookPlace = EbookPlace::withCount('ebooks')->with(['ads', 'reviewQuestions'])->find($id);

        if (!$ebookPlace) {
            return back()->withErrors('Ebook Location Not Found !');
        }

        return view('Pages.Management.Master.ebook-place.form', [
            'ebookPlace' => $ebookPlace,
        ]);
    }

    public function show($id)
    {
        // Connected ebooks are loaded lazily via AJAX (a location can have
        // hundreds), so we only need the counts here — not the full collection.
        $ebookPlace = EbookPlace::withCount(['ebooks', 'reviews', 'checkpoints'])->find($id);

        if (!$ebookPlace) {
            return back()->withErrors('Ebook Location Not Found !');
        }

        // Latest reviews + average rating for the detail page.
        $reviews = $ebookPlace->reviews()->limit(50)->get();
        $avgRating = $ebookPlace->reviews()->whereNotNull('rating')->avg('rating');

        // Scan stats: recent visitors + device / platform breakdown.
        $scanCheckpoints = $ebookPlace->checkpoints()->limit(50)->get();
        $scanByDevice = $ebookPlace->checkpoints()
            ->reorder()
            ->selectRaw('device_type, COUNT(*) as total')
            ->groupBy('device_type')->pluck('total', 'device_type');
        $scanByPlatform = $ebookPlace->checkpoints()
            ->reorder()
            ->selectRaw('platform, COUNT(*) as total')
            ->groupBy('platform')->orderByDesc('total')->pluck('total', 'platform');

        return view('Pages.Management.Master.ebook-place.detail', [
            'ebookPlace' => $ebookPlace,
            'scanUrl' => route('ebook-place.scan', $ebookPlace->code),
            'reviews' => $reviews,
            'avgRating' => $avgRating ? round($avgRating, 1) : null,
            'exportColumns' => $this->reviewColumns($ebookPlace->reviewQuestions()->get()),
            'scanCheckpoints' => $scanCheckpoints,
            'scanByDevice' => $scanByDevice,
            'scanByPlatform' => $scanByPlatform,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Review answers export (preview + xlsx)
    |--------------------------------------------------------------------------
    */

    // Preview (iframe): renders an HTML table of the chosen columns (first rows only).
    public function reviewsExportPreview($id, Request $request)
    {
        $place = EbookPlace::find($id);
        if (!$place) {
            abort(404);
        }

        $cols = $this->resolveSelectedColumns($this->reviewColumns($place->reviewQuestions()->get()), $request);
        $reviews = $place->reviews()->limit(25)->get();
        [$headings, $rows] = $this->buildReviewExport($reviews, $cols);

        return view('Pages.Management.Master.ebook-place.reviews-preview', [
            'place' => $place,
            'headings' => $headings,
            'rows' => $rows,
            'totalReviews' => $place->reviews()->count(),
        ]);
    }

    // Download the reviews as an .xlsx with the chosen / ordered columns.
    public function reviewsExport($id, Request $request)
    {
        $place = EbookPlace::find($id);
        if (!$place) {
            abort(404);
        }

        $cols = $this->resolveSelectedColumns($this->reviewColumns($place->reviewQuestions()->get()), $request);
        $reviews = $place->reviews()->get();
        [$headings, $rows] = $this->buildReviewExport($reviews, $cols);

        $filename = 'reviews-' . $place->code . '-' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new EbookReviewExport($headings, $rows), $filename);
    }

    /** Connected ebooks per page on the admin detail / edit screens. */
    private const CONNECTED_PER_PAGE = 12;

    // Admin AJAX: paginated + searchable connected ebooks for a location.
    public function connectedEbooks($id, Request $request)
    {
        $ebookPlace = EbookPlace::find($id);

        if (!$ebookPlace) {
            return response()->json(['errors' => 'Ebook Location Not Found !'], 404);
        }

        $query = $ebookPlace->ebooks()
            ->select('ebooks.id', 'ebooks.title', 'ebooks.author', 'ebooks.category', 'ebooks.image_url', 'ebooks.is_published');

        if ($q = trim((string) $request->q)) {
            $query->where(function ($w) use ($q) {
                $w->where('ebooks.title', 'like', "%{$q}%")
                    ->orWhere('ebooks.author', 'like', "%{$q}%");
            });
        }

        $ebooks = $query->orderBy('ebooks.title')
            ->paginate(self::CONNECTED_PER_PAGE, ['*'], 'page', (int) $request->input('page', 1));

        $items = $ebooks->getCollection()->map(function ($eb) {
            return [
                'title' => $eb->title,
                'author' => $eb->author ?: 'Qrun Online',
                'category' => $eb->category,
                'image_url' => asset($eb->image_url),
                'is_published' => (bool) $eb->is_published,
                'edit_url' => route('ebook.edit', $eb->id),
            ];
        });

        return response()->json([
            'items' => $items,
            'total' => $ebooks->total(),
            'page' => $ebooks->currentPage(),
            'hasMore' => $ebooks->hasMorePages(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'new_ad_images.*' => 'image|mimes:png,jpg,jpeg,webp|max:4096',
        ], [
            'name.required' => 'Location name is required',
            'new_ad_images.*.image' => 'Each ad must be an image file.',
        ]);

        $logoUrl = null;
        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|mimes:png,jpg,jpeg,webp,svg|max:2048']);
            $logoUrl = $this->storeLogo($request->file('logo'));
        }

        $ebookPlace = EbookPlace::create(array_merge([
            'code' => 'TMP-' . Str::random(12), // temporary, replaced once the ID is known
            'name' => $request->name,
            'description' => $request->description,
            'logo_url' => $logoUrl,
            'is_active' => $request->is_active == 'on' ? 1 : 0,
            'ads_always_show' => $request->ads_always_show == 'on' ? 1 : 0,
            'creator_id' => Auth::user()->id,
        ], $this->lockAttributes($request), $request->only(self::CONTACT_FIELDS)));

        // Build the final code from the record ID and creation month.
        $ebookPlace->code = $this->buildLocationCode($ebookPlace);
        $ebookPlace->save();

        $this->syncAds($request, $ebookPlace);
        $this->syncReviewQuestions($request, $ebookPlace);

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Created Ebook Location with id : " . $ebookPlace->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            'type' => LogActivities::TYPE_CREATE_EBOOK_PLACE,
        ]);

        return redirect()->route('ebook-place.index')->with('success', 'Location created successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'new_ad_images.*' => 'image|mimes:png,jpg,jpeg,webp|max:4096',
        ], [
            'name.required' => 'Location name is required',
            'new_ad_images.*.image' => 'Each ad must be an image file.',
        ]);

        $ebookPlace = EbookPlace::find($request->id);

        if (!$ebookPlace) {
            return back()->withErrors('Ebook Location Not Found !');
        }

        $ebookPlace->name = $request->name;
        $ebookPlace->description = $request->description;
        $ebookPlace->is_active = $request->is_active == 'on' ? 1 : 0;
        $ebookPlace->ads_always_show = $request->ads_always_show == 'on' ? 1 : 0;
        $ebookPlace->fill($this->lockAttributes($request));
        $ebookPlace->fill($request->only(self::CONTACT_FIELDS));

        if ($request->boolean('remove_logo')) {
            $this->deleteLogo($ebookPlace->logo_url);
            $ebookPlace->logo_url = null;
        }
        if ($request->hasFile('logo')) {
            $request->validate(['logo' => 'image|mimes:png,jpg,jpeg,webp,svg|max:2048']);
            $this->deleteLogo($ebookPlace->logo_url);
            $ebookPlace->logo_url = $this->storeLogo($request->file('logo'));
        }

        $ebookPlace->update();

        $this->syncAds($request, $ebookPlace);
        $this->syncReviewQuestions($request, $ebookPlace);

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Updated Ebook Location with id : " . $ebookPlace->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            'type' => LogActivities::TYPE_UPDATE_EBOOK_PLACE,
        ]);

        return redirect()->route('ebook-place.index')->with('success', 'Location updated successfully!');
    }

    public function destroy($id)
    {
        $ebookPlace = EbookPlace::find($id);

        if (!$ebookPlace) {
            return response()->json(['errors' => 'Ebook Location Not Found !']);
        }

        $ebookPlace->delete();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Deleted Ebook Location with id : " . $ebookPlace->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            'type' => LogActivities::TYPE_DELETE_EBOOK_PLACE,
        ]);

        return response()->json(['success' => 'Delete Success !']);
    }

    // Admin: render printable QR for a location
    public function print($code)
    {
        $ebookPlace = EbookPlace::where('code', $code)->first();

        if (!$ebookPlace) {
            return back()->withErrors('Ebook Location Not Found !');
        }

        $printUrl = route('ebook-place.scan', $ebookPlace->code);

        return view('Pages.Management.Master.ebook-place.print', compact('ebookPlace', 'printUrl'));
    }

    /** Ebooks loaded per page on the public scan page. */
    private const SCAN_PER_PAGE = 15;

    private const SCAN_COLUMNS = [
        'ebooks.id', 'ebooks.slug', 'ebooks.title', 'ebooks.description',
        'ebooks.author', 'ebooks.category', 'ebooks.image_url',
    ];

    // Public: visitor scans the QR and sees the ebooks for this location
    public function scan($code)
    {
        $ebookPlace = EbookPlace::where('code', $code)->first();

        if (!$ebookPlace || !$ebookPlace->is_active) {
            abort(404);
        }

        // Record the scan (once per browser session per location).
        $this->recordScanCheckpoint($ebookPlace);

        // Only the first page is rendered server-side; the rest is loaded via AJAX.
        $ebooks = $ebookPlace->ebooks()
            ->where('is_published', 1)
            ->orderByDesc('ebooks.created_at')
            ->paginate(self::SCAN_PER_PAGE, self::SCAN_COLUMNS);

        // Distinct categories for the filter chips (cheap, separate query).
        $categories = $ebookPlace->ebooks()
            ->where('is_published', 1)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Only "promo" ads auto-play in the scan modal; timed/review ads are
        // reserved for the read-gating unlock flow on the detail page.
        $ads = $ebookPlace->ads()->where('type', 'promo')->where('is_active', 1)->get();

        return view('Pages.EbookPlaceScan', [
            'ebookPlace' => $ebookPlace,
            'ebooks' => $ebooks,
            'categories' => $categories,
            'ads' => $ads,
            'hasMore' => $ebooks->hasMorePages(),
            'total' => $ebooks->total(),
        ]);
    }

    // Public AJAX: paginated ebooks for a location (search + category filter)
    public function scanData($code, Request $request)
    {
        $ebookPlace = EbookPlace::where('code', $code)->first();

        if (!$ebookPlace || !$ebookPlace->is_active) {
            abort(404);
        }

        $query = $ebookPlace->ebooks()->where('is_published', 1);

        if ($q = trim((string) $request->q)) {
            $query->where(function ($w) use ($q) {
                $w->where('ebooks.title', 'like', "%{$q}%")
                    ->orWhere('ebooks.author', 'like', "%{$q}%");
            });
        }

        if ($category = trim((string) $request->category)) {
            $query->where('ebooks.category', $category);
        }

        $ebooks = $query->orderByDesc('ebooks.created_at')
            ->paginate(self::SCAN_PER_PAGE, self::SCAN_COLUMNS);

        $html = view('partials.ebook-scan-cards', [
            'ebooks' => $ebooks,
            'ebookPlace' => $ebookPlace,
        ])->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $ebooks->hasMorePages(),
            'total' => $ebooks->total(),
        ]);
    }

    /**
     * Record a scan checkpoint for the visitor — the ebook equivalent of
     * PlaceCheckpoint. Counted once per browser session per location so a
     * single visitor refreshing the page isn't double-counted.
     */
    private function recordScanCheckpoint(EbookPlace $place): void
    {
        $seen = (array) session('ebook_scan_seen', []);
        if (in_array($place->code, $seen, true)) {
            return;
        }
        session()->push('ebook_scan_seen', $place->code);

        $ua = (string) request()->userAgent();

        // Platform
        $platform = 'Unknown';
        if (preg_match('/windows/i', $ua)) {
            $platform = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $platform = 'MacOS';
        } elseif (preg_match('/iphone/i', $ua)) {
            $platform = 'iOS';
        } elseif (preg_match('/ipad/i', $ua)) {
            $platform = 'iPadOS';
        } elseif (preg_match('/android/i', $ua)) {
            $platform = 'Android';
        } elseif (preg_match('/linux/i', $ua)) {
            $platform = 'Linux';
        }

        // Device type
        $deviceType = 'desktop';
        if (preg_match('/mobile/i', $ua)) {
            $deviceType = 'mobile';
        }
        if (preg_match('/tablet|ipad/i', $ua)) {
            $deviceType = 'tablet';
        }

        // Browser
        $browserName = 'Unknown';
        $browserVersion = null;
        $browsers = [
            'Edge' => 'Edg', 'Opera' => 'OPR', 'Chrome' => 'Chrome',
            'Firefox' => 'Firefox', 'Safari' => 'Safari',
        ];
        foreach ($browsers as $name => $pattern) {
            if (preg_match("/{$pattern}\/([0-9\.]+)/i", $ua, $m)) {
                $browserName = $name;
                $browserVersion = $m[1];
                break;
            }
        }

        // Device name
        if (preg_match('/iphone/i', $ua)) {
            $deviceName = 'iPhone';
        } elseif (preg_match('/ipad/i', $ua)) {
            $deviceName = 'iPad';
        } elseif (preg_match('/android/i', $ua)) {
            $deviceName = 'Android Device';
        } else {
            $deviceName = 'Desktop';
        }

        EbookPlaceCheckpoint::create([
            'ebook_place_id'   => $place->id,
            'ebook_place_code' => $place->code,
            'user_id'          => Auth::id(),
            'session_id'       => session()->getId(),
            'ip_address'       => request()->ip(),
            'referrer'         => request()->header('referer'),
            'user_agent'       => $ua,
            'browser_name'     => $browserName,
            'browser_version'  => $browserVersion,
            'platform'         => $platform,
            'device_type'      => $deviceType,
            'device_name'      => $deviceName,
            'is_mobile'        => $deviceType === 'mobile',
            'checked_at'       => now(),
        ]);
    }

    /**
     * Build the location code used in the QR URL.
     * Format: Q-EB-R-{ID}-U-{MM}-N-{TIMESTAMP}  =>  e.g. QEBR100U06N1718800000
     * (MM = two-digit month the location was created; TIMESTAMP = Unix time.)
     */
    private function buildLocationCode(EbookPlace $place)
    {
        $createdAt = $place->created_at ?? now();
        $month     = $createdAt->format('m');
        $timestamp = $createdAt->timestamp;

        return 'QEBR' . $place->id . 'U' . $month . 'N' . $timestamp;
    }

    /**
     * Store an uploaded logo in public/ebook-places and return its relative path.
     */
    private function storeLogo($file)
    {
        $name = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('ebook-places'), $name);

        return 'ebook-places/' . $name;
    }

    /**
     * Remove a previously stored logo file (if any).
     */
    private function deleteLogo($path)
    {
        if ($path && file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
    }

    /** Allowed ad roles. */
    private const AD_TYPES = ['promo', 'timed', 'review'];

    /**
     * Build the read-gating (lock) attributes from the form, normalised and
     * clamped so the values stored are always sane.
     */
    private function lockAttributes(Request $request): array
    {
        $method = (string) $request->input('unlock_method', 'timed');
        if (!in_array($method, ['timed', 'review', 'both'], true)) {
            $method = 'timed';
        }

        return [
            'lock_enabled'    => $request->lock_enabled == 'on' ? 1 : 0,
            'read_limit'      => max(0, (int) $request->input('read_limit', 2)),
            'unlock_method'   => $method,
            'unlock_duration' => \App\Support\EbookGate::clampDuration((int) $request->input('unlock_duration', 15)),
        ];
    }

    /**
     * Persist the ads/promo slides for a location from the submitted form:
     *  - update existing ads (title, type, urls, duration),
     *  - delete ads marked for removal,
     *  - store newly uploaded images.
     */
    private function syncAds(Request $request, EbookPlace $place)
    {
        // 1) Update existing ads.
        $titles = $request->input('ad_title', []);
        if (is_array($titles)) {
            foreach ($titles as $adId => $title) {
                EbookPlaceAd::where('id', $adId)
                    ->where('ebook_place_id', $place->id)
                    ->update([
                        'title'            => $title ?: null,
                        'type'             => $this->normalizeAdType($request->input("ad_type.$adId")),
                        'target_url'       => $this->cleanUrl($request->input("ad_target_url.$adId")),
                        'review_url'       => $this->cleanUrl($request->input("ad_review_url.$adId")),
                        'duration_seconds' => $this->cleanDuration($request->input("ad_duration.$adId")),
                        'is_active'        => $request->input("ad_active.$adId") ? 1 : 0,
                    ]);
            }
        }

        // 2) Delete ads marked for removal.
        $deleteIds = $request->input('ad_delete', []);
        if (is_array($deleteIds) && count($deleteIds)) {
            $toDelete = EbookPlaceAd::where('ebook_place_id', $place->id)
                ->whereIn('id', $deleteIds)->get();
            foreach ($toDelete as $ad) {
                $this->deleteLogo($ad->image_url);
                $ad->delete();
            }
        }

        // 3) Store newly uploaded images.
        if ($request->hasFile('new_ad_images')) {
            $newTitles    = $request->input('new_ad_titles', []);
            $newTypes     = $request->input('new_ad_types', []);
            $newTargets   = $request->input('new_ad_target_urls', []);
            $newReviews   = $request->input('new_ad_review_urls', []);
            $newDurations = $request->input('new_ad_durations', []);
            $order = (int) EbookPlaceAd::where('ebook_place_id', $place->id)->max('sort_order');

            foreach ($request->file('new_ad_images') as $i => $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                EbookPlaceAd::create([
                    'ebook_place_id'   => $place->id,
                    'title'            => ($newTitles[$i] ?? null) ?: null,
                    'type'             => $this->normalizeAdType($newTypes[$i] ?? null),
                    'image_url'        => $this->storeAd($file),
                    'target_url'       => $this->cleanUrl($newTargets[$i] ?? null),
                    'review_url'       => $this->cleanUrl($newReviews[$i] ?? null),
                    'duration_seconds' => $this->cleanDuration($newDurations[$i] ?? null),
                    'is_active'        => 1,
                    'sort_order'       => ++$order,
                ]);
            }
        }
    }

    private function normalizeAdType($type): string
    {
        return in_array($type, self::AD_TYPES, true) ? $type : 'promo';
    }

    private function cleanUrl($url): ?string
    {
        $url = trim((string) $url);
        return $url !== '' ? $url : null;
    }

    private function cleanDuration($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }
        return \App\Support\EbookGate::clampDuration((int) $value);
    }

    /** Review question types the admin can pick. */
    private const REVIEW_QUESTION_TYPES = ['rating', 'text', 'textarea', 'choice'];

    /**
     * Replace the location's review questions with the submitted set. Questions
     * are low-volume config, so a full replace keeps the code simple; stored
     * reviews keep their own copy of the question text, so editing/removing a
     * question never corrupts past answers.
     */
    private function syncReviewQuestions(Request $request, EbookPlace $place)
    {
        // No `rq_text` key at all means the questions editor wasn't on the form;
        // leave the existing questions untouched in that case.
        if (!$request->has('rq_text')) {
            return;
        }

        $texts     = $request->input('rq_text', []);
        $types     = $request->input('rq_type', []);
        $requireds = $request->input('rq_required', []);
        $options   = $request->input('rq_options', []);

        EbookReviewQuestion::where('ebook_place_id', $place->id)->delete();

        $order = 0;
        foreach ($texts as $i => $text) {
            $text = trim((string) $text);
            if ($text === '') {
                continue;
            }

            $type = $types[$i] ?? 'text';
            if (!in_array($type, self::REVIEW_QUESTION_TYPES, true)) {
                $type = 'text';
            }

            $opts = null;
            if ($type === 'choice') {
                $opts = array_values(array_filter(array_map(
                    fn ($o) => trim($o),
                    explode(',', (string) ($options[$i] ?? ''))
                ), fn ($o) => $o !== ''));
                if (empty($opts)) {
                    $opts = null;
                }
            }

            EbookReviewQuestion::create([
                'ebook_place_id' => $place->id,
                'question'    => $text,
                'type'        => $type,
                'options'     => $opts,
                'is_required' => (string) ($requireds[$i] ?? '1') === '1' ? 1 : 0,
                'sort_order'  => ++$order,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Public: read-gating (unlock) endpoints
    |--------------------------------------------------------------------------
    | The counter lives in the server session, so these endpoints are the only
    | way to gain access to a locked ebook. A timed unlock is validated against
    | the server clock (see App\Support\EbookGate) and cannot be rushed.
    */

    // Begin an unlock challenge: returns a nonce + the seconds the visitor must wait.
    public function unlockStart($code, Request $request)
    {
        $request->validate([
            'slug'   => 'required|string',
            'method' => 'required|in:timed,review',
        ]);

        [$place, $ebook, $config] = $this->resolveGate($code, $request->slug);
        if (!$place) {
            return response()->json(['errors' => 'Not found'], 404);
        }

        if (!$config['lock_enabled'] || \App\Support\EbookGate::isOpened($code, $request->slug)) {
            return response()->json(['errors' => 'Tidak terkunci'], 422);
        }

        // The requested method must be offered by this location.
        $allowed = $config['unlock_method'] === 'both'
            ? ['timed', 'review']
            : [$config['unlock_method']];
        if (!in_array($request->method, $allowed, true)) {
            return response()->json(['errors' => 'Metode tidak diizinkan'], 422);
        }

        $challenge = \App\Support\EbookGate::startUnlock(
            $code,
            $request->slug,
            $request->method,
            $config['unlock_duration']
        );

        return response()->json($challenge);
    }

    // Complete an unlock challenge. Grants access only if the server clock agrees.
    public function unlockComplete($code, Request $request)
    {
        $request->validate([
            'slug'  => 'required|string',
            'nonce' => 'required|string',
        ]);

        $place = EbookPlace::where('code', $code)->first();
        if (!$place || !$place->is_active) {
            return response()->json(['errors' => 'Not found'], 404);
        }

        $granted = \App\Support\EbookGate::completeUnlock($code, $request->slug, $request->nonce);

        if (!$granted) {
            return response()->json(['errors' => 'Belum selesai'], 422);
        }

        return response()->json(['success' => true]);
    }

    // Submit the custom review answers, save them, and unlock if everything checks out.
    public function unlockReview($code, Request $request)
    {
        $request->validate([
            'slug'    => 'required|string',
            'nonce'   => 'required|string',
            'answers' => 'array',
        ]);

        [$place, $ebook, $config] = $this->resolveGate($code, $request->slug);
        if (!$place) {
            return response()->json(['errors' => 'Not found'], 404);
        }

        // Review must actually be an offered method for this ebook/location.
        $reviewAllowed = in_array($config['unlock_method'] ?? '', ['review', 'both'], true);
        if (!$config['lock_enabled'] || !$reviewAllowed || EbookGate::isOpened($code, $request->slug)) {
            return response()->json(['errors' => 'Review tidak tersedia'], 422);
        }

        // Per-ebook questions win when the ebook overrides with its own set.
        $questions = ($ebook->ad_override_enabled && $ebook->reviewQuestions()->exists())
            ? $ebook->reviewQuestions()->get()
            : $place->reviewQuestions()->get();
        $answers = (array) $request->input('answers', []);

        // Server-side validation of required questions.
        $stored = [];
        $rating = null;
        foreach ($questions as $q) {
            $value = $answers[$q->id] ?? null;
            if (is_string($value)) {
                $value = trim($value);
            }

            if ($q->is_required && ($value === null || $value === '' || $value === [])) {
                return response()->json([
                    'errors' => 'Mohon jawab semua pertanyaan wajib.',
                ], 422);
            }

            if ($q->type === 'rating' && $value !== null && $value !== '') {
                $rating = max(1, min(5, (int) $value));
                $value = $rating;
            }

            if ($q->type === 'choice' && is_array($q->options) && $value !== null && $value !== '') {
                if (!in_array($value, $q->options, true)) {
                    return response()->json(['errors' => 'Pilihan tidak valid.'], 422);
                }
            }

            $stored[] = [
                'id'       => $q->id,
                'question' => $q->question,
                'type'     => $q->type,
                'answer'   => $value,
            ];
        }

        // Fallback: no custom questions configured -> accept a generic star rating.
        if ($questions->isEmpty()) {
            $fallback = $answers[0] ?? null;
            if ($fallback !== null && $fallback !== '') {
                $rating = max(1, min(5, (int) $fallback));
                $stored[] = ['id' => 0, 'question' => 'Rating', 'type' => 'rating', 'answer' => $rating];
            }
        }

        // Validate the unlock token (nonce + slug + server-enforced min wait).
        $granted = EbookGate::completeUnlock($code, $request->slug, $request->nonce);
        if (!$granted) {
            return response()->json(['errors' => 'Sesi tidak valid, muat ulang halaman.'], 422);
        }

        EbookReview::create([
            'ebook_place_id' => $place->id,
            'ebook_id'    => $ebook->id,
            'ebook_slug'  => $request->slug,
            'rating'      => $rating,
            'answers'     => $stored,
            'ip_address'  => $request->ip(),
            'user_agent'  => substr((string) $request->header('User-Agent'), 0, 255),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Resolve the location, published ebook and effective gate config for a
     * scan code + ebook slug. Returns [place|null, ebook|null, config].
     */
    private function resolveGate($code, $slug): array
    {
        $place = EbookPlace::where('code', $code)->first();
        if (!$place || !$place->is_active) {
            return [null, null, []];
        }

        $ebook = $place->ebooks()
            ->where('ebooks.slug', $slug)
            ->where('is_published', 1)
            ->first();

        if (!$ebook) {
            return [null, null, []];
        }

        return [$place, $ebook, \App\Support\EbookGate::effectiveConfig($place, $ebook)];
    }

    /**
     * Store an uploaded ad image in public/ebook-places and return its path.
     */
    private function storeAd($file)
    {
        $name = 'ad_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('ebook-places'), $name);

        return 'ebook-places/' . $name;
    }
}
