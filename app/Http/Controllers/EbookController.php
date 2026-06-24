<?php

namespace App\Http\Controllers;

use App\Exports\EbookReviewExport;
use App\Http\Controllers\Concerns\ReviewExportable;
use App\Models\Ebook;
use App\Models\EbookCategory;
use App\Models\EbookReviewQuestion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\LogActivities;
use DOMDocument;
use Exception;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class EbookController extends Controller
{
    use ReviewExportable;

    /*
    |--------------------------------------------------------------------------
    | Ebook Controller
    |--------------------------------------------------------------------------
    |
    | Manages the Ebook catalog (superadmin only). Mirrors BlogController:
    | 1. /ebook,            index   -> ebook.index
    | 2. /ebook/create,     create  -> ebook.create
    | 3. /ebook/store,      store   -> ebook.store
    | 4. /ebook/{id}/edit,  edit    -> ebook.edit
    | 5. /ebook/update,     update  -> ebook.update
    | 6. /ebook/{id}/delete destroy -> ebook.destroy
    */

    public function __construct(Request $request)
    {
        // Same guard pattern as BlogController: account approved + superadmin
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }
        if (!Auth::user()->hasRole('superadmin')) {
            return abort(403);
        }
    }

    // (1) Ebook list (DataTables)
    function index(Request $request)
    {
        $data = Ebook::select('id', 'slug', 'title', 'description', 'author', 'creator_id')
            ->with('creator_id')
            ->latest()
            ->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $editUrl = route('ebook.edit', $row->id);
                    $detailUrl = route('ebook.detail', $row->id);

                    return "
                        <div class='dropdown'>
                            <button
                                class='btn btn-primary btn-sm dropdown-toggle shadow-sm'
                                type='button'
                                data-toggle='dropdown'
                                aria-expanded='false'
                            >
                                <i class='fas fa-cog mr-1'></i>
                                Action
                            </button>

                            <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'>

                                <a
                                    href='{$detailUrl}'
                                    class='dropdown-item'
                                >
                                    <i class='fas fa-info-circle text-secondary mr-2'></i>
                                    Detail
                                </a>

                                <a
                                    href='{$editUrl}'
                                    class='dropdown-item'
                                >
                                    <i class='fas fa-edit text-secondary mr-2'></i>
                                    Edit
                                </a>

                                <div class='dropdown-divider'></div>

                                <button
                                    id='{$row->id}'
                                    class='delete dropdown-item text-danger'
                                    type='button'
                                >
                                    <i class='fas fa-trash-alt mr-2'></i>
                                    Delete
                                </button>

                            </div>
                        </div>
                    ";
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pages.Management.Master.ebook.index');
    }

    // (4) Edit form
    function edit($id)
    {
        $ebook = Ebook::with('reviewQuestions')->find($id);

        if (!$ebook) {
            return back()->withErrors('Ebook Not Found !');
        }

        return view('Pages.Management.Master.ebook.form', [
            'ebook' => $ebook,
            'categories' => EbookCategory::orderBy('name')->get(),
        ]);
    }

    // Admin detail: reviews collected for this ebook + export.
    function show($id)
    {
        $ebook = Ebook::withCount('reviews')->find($id);

        if (!$ebook) {
            return back()->withErrors('Ebook Not Found !');
        }

        $reviews = $ebook->reviews()->limit(50)->get();
        $avgRating = $ebook->reviews()->whereNotNull('rating')->avg('rating');

        return view('Pages.Management.Master.ebook.detail', [
            'ebook' => $ebook,
            'reviews' => $reviews,
            'avgRating' => $avgRating ? round($avgRating, 1) : null,
            'exportColumns' => $this->reviewColumns($ebook->reviewQuestions()->get()),
        ]);
    }

    // Preview (iframe) of the chosen export columns for this ebook's reviews.
    function reviewsExportPreview($id, Request $request)
    {
        $ebook = Ebook::find($id);
        if (!$ebook) {
            abort(404);
        }

        $cols = $this->resolveSelectedColumns($this->reviewColumns($ebook->reviewQuestions()->get()), $request);
        $reviews = $ebook->reviews()->limit(25)->get();
        [$headings, $rows] = $this->buildReviewExport($reviews, $cols);

        return view('Pages.Management.Master.ebook-place.reviews-preview', [
            'headings' => $headings,
            'rows' => $rows,
            'totalReviews' => $ebook->reviews()->count(),
        ]);
    }

    // Download this ebook's reviews as .xlsx with the chosen / ordered columns.
    function reviewsExport($id, Request $request)
    {
        $ebook = Ebook::find($id);
        if (!$ebook) {
            abort(404);
        }

        $cols = $this->resolveSelectedColumns($this->reviewColumns($ebook->reviewQuestions()->get()), $request);
        $reviews = $ebook->reviews()->get();
        [$headings, $rows] = $this->buildReviewExport($reviews, $cols);

        $filename = 'reviews-ebook-' . $ebook->slug . '-' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new EbookReviewExport($headings, $rows), $filename);
    }

    /**
     * Replace this ebook's review questions with the submitted set (full
     * replace; stored reviews keep their own copy of the question text).
     */
    private function syncReviewQuestions(Request $request, Ebook $ebook): void
    {
        if (!$request->has('rq_text')) {
            return;
        }

        $texts     = $request->input('rq_text', []);
        $types     = $request->input('rq_type', []);
        $requireds = $request->input('rq_required', []);
        $options   = $request->input('rq_options', []);
        $allowed   = ['rating', 'text', 'textarea', 'choice'];

        EbookReviewQuestion::where('ebook_id', $ebook->id)->delete();

        $order = 0;
        foreach ($texts as $i => $text) {
            $text = trim((string) $text);
            if ($text === '') {
                continue;
            }

            $type = in_array($types[$i] ?? 'text', $allowed, true) ? $types[$i] : 'text';

            $opts = null;
            if ($type === 'choice') {
                $opts = array_values(array_filter(array_map(
                    fn ($o) => trim($o),
                    explode(',', (string) ($options[$i] ?? ''))
                ), fn ($o) => $o !== ''));
                $opts = $opts ?: null;
            }

            EbookReviewQuestion::create([
                'ebook_id'    => $ebook->id,
                'question'    => $text,
                'type'        => $type,
                'options'     => $opts,
                'is_required' => (string) ($requireds[$i] ?? '1') === '1' ? 1 : 0,
                'sort_order'  => ++$order,
            ]);
        }
    }

    // (2) Create form
    function create()
    {
        return view('Pages.Management.Master.ebook.form', [
            'ebook' => null,
            'categories' => EbookCategory::orderBy('name')->get(),
        ]);
    }

    // (6) Delete
    function destroy($id)
    {
        $ebook = Ebook::find($id);

        if (!$ebook) {
            return back()->withErrors('Ebook Not Found !');
        }

        if (!Auth::user()->hasRole('superadmin')) {
            if ($ebook->creator_id !== Auth::user()->id) {
                return response()->json([
                    'errors' => 'You dont have access to this !'
                ]);
            }
        }

        $ebook->delete();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Deleted Ebook Data with id : " . $ebook->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_EBOOK
        ]);

        return response()->json([
            'success' => 'Delete Success !'
        ]);
    }

    // (5) Update
    function update(Request $request)
    {
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }

        $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'content' => 'required',
                'image_url' => 'required',
                'slug' => 'required|unique:ebooks,slug,' . $request->id ?? null
            ],
            [
                'title.required' => 'Title Fields is required',
                'description.required' => 'Description is required',
                'content.required' => 'Content is required',
            ]
        );

        if ($request->id) {
            if (Auth::user()->hasRole('superadmin')) {
                $Ebook = Ebook::where('id', $request->id)->first();
            } else {
                $Ebook = Ebook::where('id', $request->id)->where('creator_id', Auth::user()->id)->first();
                if (!$Ebook) {
                    return abort(404);
                }
            }
        } else {
            $Ebook = Ebook::where('creator_id', Auth::user()->id)->latest()->first();
        }

        $content = $this->processContentImages($request->content, $Ebook->id, false);

        $Ebook->title = $request->title;
        $Ebook->slug = Str::slug($request->slug);
        $Ebook->description = $request->description;
        $Ebook->author = $request->author;
        $Ebook->category = $this->resolveCategory($request);
        $Ebook->content = $content;
        $Ebook->is_published = $request->is_published == 'on' ? 1 : 0;
        $Ebook->image_url = $request->image_url;
        $Ebook->file_url = $request->file_url;
        $Ebook->fill($this->adOverrideAttributes($request));

        $Ebook->update();

        $this->syncReviewQuestions($request, $Ebook);

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Updated Ebook Data with id : " . $Ebook->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_EBOOK
        ]);

        return redirect()->route('ebook.index')->with('success', 'Ebook updated successfully!');
    }

    // (3) Store
    function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'image_url' => 'required',
            'slug' => 'required|unique:ebooks,slug,' . $request->id ?? null
        ], [
            'title.required' => 'Title Fields is required',
            'description.required' => 'Description is required',
            'content.required' => 'Content is required',
        ]);

        $user_id = Auth::user()->id;
        $Ebook_id = Ebook::latest()->first()?->id == null ? 1 : Ebook::latest()->first()->id + 1;

        $content = $this->processContentImages($request->content, $Ebook_id, true);

        $Ebook = Ebook::create([
            'slug' => Str::slug($request->slug),
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->author,
            'category' => $this->resolveCategory($request),
            'creator_id' => $user_id,
            'content' => $content,
            'views' => 0,
            'is_published' => $request->is_published == "on" ? 1 : 0,
            'image_url' => $request->image_url,
            'file_url' => $request->file_url
        ] + $this->adOverrideAttributes($request));

        $this->syncReviewQuestions($request, $Ebook);

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Created Ebook Data with id : " . $Ebook->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_CREATE_EBOOK
        ]);

        return redirect()->route('ebook.index')->with('success', 'Ebook created successfully!');
    }

    /**
     * Per-ebook override of the location read-gating policy. When the override
     * is off the columns are stored as null so the location settings win.
     */
    private function adOverrideAttributes(Request $request): array
    {
        $enabled = $request->ad_override_enabled == 'on' ? 1 : 0;

        if (!$enabled) {
            return [
                'ad_override_enabled' => 0,
                'lock_enabled'    => null,
                'read_limit'      => null,
                'unlock_method'   => null,
                'unlock_duration' => null,
                'unlock_timed_image'      => null,
                'unlock_timed_target_url' => null,
                'unlock_review_image'     => null,
            ];
        }

        $method = (string) $request->input('unlock_method', 'timed');
        if (!in_array($method, ['timed', 'review', 'both'], true)) {
            $method = 'timed';
        }

        $clean = fn ($v) => trim((string) $v) !== '' ? trim((string) $v) : null;

        return [
            'ad_override_enabled' => 1,
            'lock_enabled'    => $request->input('lock_enabled') == '1' ? 1 : 0,
            'read_limit'      => max(0, (int) $request->input('read_limit', 2)),
            'unlock_method'   => $method,
            'unlock_duration' => \App\Support\EbookGate::clampDuration((int) $request->input('unlock_duration', 15)),
            'unlock_timed_image'      => $clean($request->input('unlock_timed_image')),
            'unlock_timed_target_url' => $clean($request->input('unlock_timed_target_url')),
            'unlock_review_image'     => $clean($request->input('unlock_review_image')),
        ];
    }

    /**
     * Resolve the category name from the request. If a new category name was
     * typed it is added to the master list; otherwise the selected one is used.
     * Returns the category name (string) or null when none is provided.
     */
    private function resolveCategory(Request $request)
    {
        $new = trim($request->new_category ?? '');
        $name = $new !== '' ? $new : trim($request->category ?? '');

        if ($name === '') {
            return null;
        }

        // Keep the master list in sync (case-insensitive match to avoid dupes).
        $existing = EbookCategory::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();

        if ($existing) {
            return $existing->name;
        }

        EbookCategory::create(['name' => $name]);

        return $name;
    }

    /**
     * Extract inline base64 images from the editor content, store them on disk
     * and replace the src with a public URL. Mirrors BlogController behaviour.
     */
    private function processContentImages($content, $ebookId, $isCreate)
    {
        $dom = new DOMDocument();
        $dom->loadHtml($content, 9);

        $images = $dom->getElementsByTagName('img');

        if ($images) {
            foreach ($images as $key => $img) {
                $data = $img->getAttribute('src');

                if (strpos($data, 'data') !== false) {
                    list($type, $data) = array_pad(explode(';', $data), 2, null);
                    list(, $data) = array_pad(explode(',', $data), 2, null);
                    $dataConvert = base64_decode($data);

                    $str = $img->getAttribute('src');
                    $trim = Str::after($str, 'image/');
                    $trim2 = Str::before($trim, ';');

                    $image_name = time() . '-' . $key . Str::random(10) . '.' . $trim2;

                    if ($isCreate) {
                        $directory = public_path() . "/storage/UploadImage/EbookImages/{$ebookId}/";
                        $publicBase = "/storage/UploadImage/EbookImages/{$ebookId}/";
                    } else {
                        $directory = public_path() . "/UploadImage/EbookImages/{$ebookId}/";
                        $publicBase = "UploadImage/EbookImages/{$ebookId}/";
                    }

                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    $path = $directory . $image_name;

                    $saved = file_put_contents($path, $dataConvert);
                    if ($saved === false) {
                        throw new Exception('Failed to save the image.');
                    }

                    $publicUrl = asset($publicBase . $image_name);

                    $img->removeAttribute('src');
                    $img->setAttribute('src', $publicUrl);
                }
            }
        }

        return $dom->saveHTML();
    }
}
