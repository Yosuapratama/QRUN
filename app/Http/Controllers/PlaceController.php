<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CustomAdsSettings;
use App\Models\CustomRunningTextSettings;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Place;
use App\Models\Image;
use App\Models\Event;
use App\Models\LogActivities;
use App\Models\PlaceCheckpoint;
use App\Models\UserHasPlaceLimit;
use DOMDocument;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\PlaceReportExport;
use Maatwebsite\Excel\Facades\Excel;

class PlaceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Detail Of Place Controller
    |--------------------------------------------------------------------------
    |
    | This Controllers Contains :
    | -> For Superadmin
    | 1. /place, Func Name : index, Route Name : place
    | 2. /edit/{place_code}, Func Name : editPlace, Route Name : edit.place
    | 3. /deleted-place, Func Name : indexDeletedPlace, Route Name : place.getDeleted
    | 4. /create, Func Name : indexCreatePlace, Route Name : place.create
    | 5. /{place_code}/delete, Func Name : deletePlace, Route Name : place.delete
    |   
    | -> For User Approved
    | 6. /my-place, Func Name : returnMyPlaceView, Route Name : place.myplace
    | 7. /my-place/update, Func Name : updatePlace, Route Name : place.update
    | 8. /store, Func Name : store, Route Name : place.store
    | 9. /get-detail-data/{code}, Func Name : getDetailPlaceData, Route Name : place.getDetailPlaceData
    |
    | -> For Public To See Detail OF Place
    | 10. /detail-place/{place_code}, Func Name : getDetailPlace, Route Name : place.detail
    |
    | 11. /print-barcode/{placeCode}, Func Name : print, Route Name : place.print
    */

    // Define Application URL, example : http://localhost or https://qrun.online 
    private $applicationURLLocal;

    // Set construct, save url tu private variabel in this controller
    public function __construct(Request $request)
    {
        $this->applicationURLLocal = $request->schemeAndHttpHost();
    }

    // (1) Place Index Menu, on sidenav this menu call ManagePlace
    function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Place::query()
                ->leftJoin('users', 'users.id', '=', 'place.creator_id')
                ->select([
                    'place.id',
                    'place.views',
                    'place.place_code',
                    'place.title',
                    'place.description',
                    'place.province_id',
                    'place.regency_id',
                    'place.district_id',
                    'place.creator_id',
                    'users.email as creator_email',
                    'place.created_at',
                    'place.updated_at'
                ]);

            if (!Auth::user()->hasRole('superadmin')) {
                $query->where('creator_id', Auth::user()->id);
            }

            if ($request->title) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->place_code) {
                $query->where('place_code', 'like', '%' . $request->place_code . '%');
            }

            if ($request->description) {
                $query->where('description', 'like', '%' . $request->description . '%');
            }

            if ($request->creator) {
                $query->where('users.email', 'like', '%' . $request->creator . '%');
            }

            if ($request->filled('updated_at_start') && $request->filled('updated_at_end')) {

                $query->whereBetween('place.updated_at', [
                    \Carbon\Carbon::parse($request->updated_at_start)->startOfDay(),
                    \Carbon\Carbon::parse($request->updated_at_end)->endOfDay(),
                ]);
            }

            if ($request->province) {
                $query->where('province_id', $request->province);
            }

            if ($request->regency) {
                $query->where('regency_id', $request->regency);
            }

            if ($request->district) {
                $query->where('district_id', $request->district);
            }

            if ($request->village) {
                $query->where('village_id', $request->village);
            }

            return DataTables::of($query)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->addColumn('creator', function ($row) {
                    return $row->creator_email ?? '-';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url = $this->applicationURLLocal . '/detail-place/' . $row->place_code;
                    $editUrl = $this->applicationURLLocal . '/management/master/place/edit/' . $row->place_code;
                    $detailUrl = $this->applicationURLLocal . '/management/master/place/detail/' . $row->place_code;
                    $printUrl = $this->applicationURLLocal . '/management/master/print-barcode/' . $row->place_code;

                    $btn = "
                    <div class='dropdown'>
                        <button 
                            class='btn btn-primary btn-sm dropdown-toggle' 
                            type='button' 
                            data-toggle='dropdown' 
                            aria-expanded='false'
                        >
                            <i class='fas fa-cog'></i> Action
                        </button>

                        <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'>

                            <a 
                                href='$detailUrl'
                                class=' dropdown-item'
                            >
                                <i class='fas fa-eye text-primary mr-2'></i>
                                Detail
                            </a>

                            <a 
                                target='_blank' 
                                href='$url' 
                                class='dropdown-item'
                            >
                                <i class='fas fa-external-link-alt text-warning mr-2'></i>
                                Visit
                            </a>

                            <a 
                                target='_blank' 
                                href='$editUrl' 
                                class='dropdown-item'
                            >
                                <i class='fas fa-edit text-secondary mr-2'></i>
                                Edit
                            </a>

                            <a 
                                target='_blank' 
                                href='$printUrl' 
                                class='dropdown-item'
                            >
                                <i class='fas fa-print text-success mr-2'></i>
                                Print
                            </a>

                            <div class='dropdown-divider'></div>

                            <button 
                                id='$row->place_code' 
                                class='delete dropdown-item text-danger'
                            >
                                <i class='fas fa-trash mr-2'></i>
                                Delete
                            </button>

                        </div>
                    </div>
                    ";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('Pages.Management.Master.place.index');
    }

    public function show($place_code)
    {
        $Place = Place::where('place_code', $place_code)->with('creator_id')->first();

        if (!$Place) {
            return abort(404);
        }

        return view('Pages.Management.Master.place.show', compact('Place'));
    }

    public function reportExcelPlace(Request $request)
    {
        $search = $request->search
            ? ' | Search: ' . $request->search
            : '';

        $filename =
            "Report Place QRUN - {$search}.xlsx";

        return Excel::download(
            new PlaceReportExport($request),
            $filename
        );
    }

    // (2) This Func For Superadmin to edit users place
    function editPlace($place_code)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            $Place = Place::where('place_code', $place_code)->where('creator_id', Auth::user()->id)->first();
            if (!$Place) {
                return abort(404);
            }
        } else {
            $Place = Place::where('place_code', $place_code)->first();
        }
        if (!$Place) {
            return back()->withErrors('Place Code Not Found !');
        }

        return view('Pages.Management.Master.place.form', compact('Place'));
    }

    // (3) This Func for admin to get all place deleted by admin or a users has blocked by admin
    public function indexDeletedPlace(Request $request)
    {
        // $query = Place::onlyTrashed()
        //     ->select([
        //         'id',
        //         'place_code',
        //         'title',
        //         'description',
        //         'creator_id',
        //         'views',
        //         'created_at',
        //         'updated_at',
        //         'deleted_at',
        //         'province_id',
        //         'regency_id',
        //         'district_id',
        //         'village_id'
        //     ])
        //     ->with(['creator_id:id,email']);

        $query = Place::onlyTrashed()
            ->leftJoin('users', 'users.id', '=', 'place.creator_id')
            ->select([
                'place.id',
                'place.views',
                'place.place_code',
                'place.title',
                'place.description',
                'place.province_id',
                'place.regency_id',
                'place.district_id',
                'place.creator_id',
                'users.email as creator_email',
                'place.created_at',
                'place.updated_at',
                'place.deleted_at'
            ]);

        // Restrict non-superadmin
        if (!Auth::user()->hasRole('superadmin')) {
            $query->where('creator_id', Auth::id());
        }

        // Filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('place_code')) {
            $query->where('place_code', 'like', '%' . $request->place_code . '%');
        }

        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        if ($request->filled('creator')) {
            $query->whereHas('creator_id', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->creator . '%');
            });
        }

        if ($request->filled('province')) {
            $query->where('province_id', $request->province);
        }

        if ($request->filled('regency')) {
            $query->where('regency_id', $request->regency);
        }

        if ($request->filled('district')) {
            $query->where('district_id', $request->district);
        }

        if ($request->filled('village')) {
            $query->where('village_id', $request->village);
        }

        // Deleted date range
        if ($request->filled('deleted_at_start') && $request->filled('deleted_at_end')) {
            $query->whereBetween('place.deleted_at', [
                $request->deleted_at_start . ' 00:00:00',
                $request->deleted_at_end . ' 23:59:59'
            ]);
        }

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                // ->addColumn('creator_email', function ($row) {
                //     return optional($row->creator_id)->email ?? '-';
                // })

                ->editColumn('deleted_at', function ($row) {
                    return $row->deleted_at
                        ? \Carbon\Carbon::parse($row->deleted_at)
                        ->format('d-M-Y H:i:s') . ' Wita'
                        : '-';
                })

                ->addColumn('action', function ($row) {
                    return '
                    <button
                        class="btn btn-success btn-sm restore"
                        data-id="' . $row->id . '">
                        <i class="fas fa-undo"></i> Restore
                    </button>
                ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pages.Management.Master.place.deleted');
    }

    public function restorePlace($placeId)
    {
        DB::beginTransaction();

        try {

            $place = Place::withTrashed()->findOrFail($placeId);

            $place->restore();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Place restored successfully.'
            ], 200);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to restore place.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // (4) To Show Pages For user to create new posts/place
    function indexCreatePlace()
    {
        if (!Auth::user()->hasRole('superadmin')) {
            if (Auth::user()->approved_at) {
                $checkTheLimitOfUserPlace = UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first();
                if ($checkTheLimitOfUserPlace) {
                    if (Place::where('creator_id', Auth::user()->id)->count() <= $checkTheLimitOfUserPlace->placeLimit->total_limit) {
                        return view('Pages.Management.Master.place.form');
                    } else {
                        return redirect()->route('dashboard')->withErrors('Your account place has entered the limit !');
                    }
                } else {
                    $Place = Place::where('creator_id', Auth::user()->id)->latest()->first();

                    if ($Place) {
                        $url = $this->applicationURLLocal . '/detail-place/' . $Place->place_code;
                        $printUrl = $this->applicationURLLocal . '/management/master/print-barcode/' . $Place->place_code;

                        return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
                    } else {
                        $Place = null;
                        $url = '#';
                        $printUrl = '#';
                        return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
                    }
                }
            } else {
                return back()->withErrors('Your Account Need Approval First !');
            }
        } else {
            return view('Pages.Management.Master.place.form');
        }
    }
    // (5) For admin to delete place user, after do this delete, the user can create a new place, like new account approved
    function deletePlace($place_code)
    {
        $GetPlace = Place::where('place_code', $place_code)->with('creator_id')->first();

        if (!Auth::user()->hasRole('superadmin')) {
            if ($GetPlace->creator_id !== Auth::user()->id) {
                return response()->json([
                    'errors' => 'You dont have access to this !'
                ]);
            }

            $GetPlace->delete();

            $commentData = Comment::where('place_id', $GetPlace->id)->get();

            foreach ($commentData as $key => $comment) {
                $commentData[$key]->delete();
            }
        } else {
            $GetPlace->delete();
            $commentData = Comment::where('place_id', $GetPlace->id)->get();

            foreach ($commentData as $key => $comment) {
                $commentData[$key]->delete();
            }
        }

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Deleted Place Data with Place Code : " . $place_code . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_PLACE
        ]);

        return response()->json([
            'success' => 'Delete Success !'
        ]);
    }

    // (6) Return View For User Approved
    function returnMyPlaceView(Request $request)
    {
        if (Auth::user()->approved_at) {
            $Place = Place::where('creator_id', Auth::user()->id)->latest()->first();

            if ($Place) {
                $url = $this->applicationURLLocal . '/detail-place/' . $Place->place_code;
                $printUrl = $this->applicationURLLocal . '/management/master/print-barcode/' . $Place->place_code;

                return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
            } else {
                $Place = null;
                $url = '#';
                $printUrl = '#';
                return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
            }
        } else {
            return back()->withErrors('Your Account Need Approval First !');
        }
    }

    public function sanitizeHtml($html)
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();

        $html = mb_convert_encoding(
            $html,
            'HTML-ENTITIES',
            'UTF-8'
        );

        $dom->loadHTML(
            '<div id="wrapper">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED |
                LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();

        // Tag yang diizinkan
        $allowedTags = [
            'p',
            'br',
            'b',
            'strong',
            'i',
            'em',
            'u',
            's',
            'span',
            'div',
            'ul',
            'ol',
            'li',
            'a',
            'img',
            'blockquote',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'iframe',
            'font',
            'hr',
            'table',
            'thead',
            'tbody',
            'tr',
            'td',
            'th'
        ];

        // Attribute yang diizinkan
        $allowedAttributes = [
            'href',
            'src',
            'style',
            'class',
            'target',
            'rel',
            'width',
            'height',
            'frameborder',
            'allow',
            'allowfullscreen',
            'align',
            'color',
            'id',
            'alt',
            'title',
            'data-filename',
            'loading',
            'referrerpolicy',
            'sandbox',
            'spellcheck',
            'contenteditable',
            'role',
            'aria-multiline'
        ];

        // Hanya domain iframe terpercaya
        $allowedIframeDomains = [
            // YouTube
            'qrun.online',
            '127.0.0.1',
            'www.qrun.online',
            'https://qrun.online',
            'http://qrun.online',
            'https://www.qrun.online',
            'http://www.qrun.online',
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
            'youtu.be',
            'youtube-nocookie.com',
            'www.youtube-nocookie.com',

            // Google Drive
            'drive.google.com',

            // Vimeo
            'vimeo.com',
            'player.vimeo.com',

            // Vine (legacy)
            'vine.co',

            // Instagram
            'instagram.com',
            'www.instagram.com',

            // DailyMotion
            'dailymotion.com',
            'www.dailymotion.com',
            'dai.ly',

            // Youku
            'youku.com',
            'player.youku.com',

            // PeerTube
            'peertube.tv',
        ];

        $xpath = new \DOMXPath($dom);

        foreach ($xpath->query('//*') as $node) {

            $tagName = strtolower($node->nodeName);

            // Hapus tag berbahaya
            if (!in_array($tagName, $allowedTags)) {
                $node->parentNode?->removeChild($node);
                continue;
            }

            // Remove event handler berbahaya
            if ($node->hasAttributes()) {

                $attributes = [];

                foreach ($node->attributes as $attr) {
                    $attributes[] = $attr->nodeName;
                }

                foreach ($attributes as $attrName) {

                    $attrLower = strtolower($attrName);

                    // Hapus onclick, onerror, dll
                    if (str_starts_with($attrLower, 'on')) {
                        $node->removeAttribute($attrName);
                        continue;
                    }

                    // Hapus attribute tidak diizinkan
                    if (!in_array($attrLower, $allowedAttributes)) {
                        $node->removeAttribute($attrName);
                        continue;
                    }

                    $value = $node->getAttribute($attrName);

                    // Anti javascript:
                    if (
                        in_array($attrLower, ['href', 'src']) &&
                        preg_match('/^\s*javascript:/i', $value)
                    ) {
                        $node->removeAttribute($attrName);
                    }
                }
            }

            // Khusus iframe
            if ($tagName === 'iframe') {

                $src = $node->getAttribute('src');

                if (!$src) {
                    $node->parentNode?->removeChild($node);
                    continue;
                }

                $host = parse_url($src, PHP_URL_HOST);

                if (
                    !$host ||
                    !in_array($host, $allowedIframeDomains)
                ) {
                    $node->parentNode?->removeChild($node);
                    continue;
                }

                // default keamanan iframe
                $node->setAttribute(
                    'allowfullscreen',
                    'true'
                );

                $node->setAttribute(
                    'loading',
                    'lazy'
                );
            }

            // Hyperlink aman
            if ($tagName === 'a') {

                $href = $node->getAttribute('href');

                if ($href) {
                    $node->setAttribute(
                        'target',
                        '_blank'
                    );

                    $node->setAttribute(
                        'rel',
                        'noopener noreferrer nofollow'
                    );
                }
            }
        }

        $wrapper = $dom->getElementById('wrapper');

        $cleanHtml = '';

        if ($wrapper) {
            foreach ($wrapper->childNodes as $child) {
                $cleanHtml .= $dom->saveHTML($child);
            }
        }

        return $cleanHtml;
    }


    // (7) Update Place Data With Place Code For user approved
    function updatePlace(Request $request)
    {
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }

        $Validate = $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'content' => 'required'
            ],
            [
                'title.required' => 'Title Fields is required',
                'description.required' => 'Description is required',
                'content.required' => 'Content is required',
            ]
        );

        if ($request->id) {
            if (Auth::user()->hasRole('superadmin')) {
                $Place = Place::where('id', $request->id)->first();
            } else {
                $Place = Place::where('id', $request->id)->where('creator_id', Auth::user()->id)->first();
                if (!$Place) {
                    return abort(404);
                }
            }
        } else {
            $Place = Place::where('creator_id', Auth::user()->id)->latest()->first();
        }

        $content = $this->sanitizeHtml(
            $request->content
        );

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $content = mb_convert_encoding(
            $request->content,
            'HTML-ENTITIES',
            'UTF-8'
        );

        $dom->loadHTML(
            $content,
            LIBXML_HTML_NOIMPLIED |
                LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');
        $imageData = [];

        $user_id = Auth::user()->id;
        // Setup Images
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

                    // Generate a unique image name
                    $image_name = time() . '-' . $key . Str::random(10) . '.' . $trim2;

                    // Define the directory and path for storing the image
                    $directory = public_path() . "/UploadImage/PlaceImage/{$Place->id}/";
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    $path = $directory . $image_name; // Full path to the file

                    // Store the file using file_put_contents
                    $menu = file_put_contents($path, $dataConvert);
                    if ($menu === false) {
                        throw new Exception('Failed to save the image.');
                    }

                    // Generate the public URL for the image
                    $publicUrl = asset("UploadImage/PlaceImage/{$Place->id}/" . $image_name);

                    // Remove the src attribute and set the new src
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $publicUrl);

                    // Store the public URL in the array
                    $imageData[] = $publicUrl;
                }
            }
        }


        $content = $dom->saveHTML();
        // $content = $this->sanitizeHtml($content);

        $Place->title = $request->title;
        $Place->description = $request->description;
        $Place->content = $content;
        $Place->is_comment = $request->AllowComment == 'on' ? 1 : 0;
        // $Place->phone_num = $request->phone_num;
        // $Place->province_id = $request->reg_province ? $request->reg_province : null;
        $Place->province_id = $request->reg_province ? $request->reg_province : null;
        $Place->regency_id = $request->reg_regency ? $request->reg_regency : null;
        $Place->district_id = $request->reg_district ? $request->reg_district : null;
        $Place->village_id = $request->reg_village ? $request->reg_village : null;

        $Place->update();


        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Updated Place Data with Place id : " . $Place->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_PLACE
        ]);


        foreach ($imageData as $img) {
            Image::create([
                'description' => '-',
                'place_id' => $Place->id,
                'src' => $img
            ]);
        }

        return back()->with('success', 'Data SuccesFully Saved !');
    }

    // (8) This function Is used to store data while user/admin create new place data
    public function store(Request $request)
    {
        // Check Authentication
        if (!Auth::user()->approved_at) {
            return back()->withErrors(
                'Your Account Need Approval First !'
            );
        }

        // Check limit
        if (!Auth::user()->hasRole('superadmin')) {

            $checkTheLimitOfUserPlace =
                UserHasPlaceLimit::where(
                    'user_id',
                    Auth::id()
                )
                ->with('placeLimit')
                ->first();

            if ($checkTheLimitOfUserPlace) {

                if (
                    Place::where(
                        'creator_id',
                        Auth::id()
                    )->count()
                    >=
                    $checkTheLimitOfUserPlace
                    ->placeLimit
                    ->total_limit
                ) {
                    return back()->withErrors(
                        'Your account place has entered the limit !'
                    );
                }
            } else {

                $place = Place::where(
                    'creator_id',
                    Auth::id()
                )->exists();

                if ($place) {
                    return back()->withErrors(
                        'You have created place !'
                    );
                }
            }
        }

        // Validation
        $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'content' => 'required',

                'reg_province' =>
                'nullable|exists:reg_provinces,id',

                'reg_regency' =>
                'nullable|exists:reg_regencies,id',

                'reg_district' =>
                'nullable|exists:reg_districts,id',

                'reg_village' =>
                'nullable|exists:reg_villages,id',
            ],
            [
                'title.required' =>
                'Title Fields is required',

                'description.required' =>
                'Description is required',

                'content.required' =>
                'Content is required',
            ]
        );

        $getPlaceData = Place::max('id') + 1;
        $convertedCode = sprintf(
            '%05d',
            $getPlaceData ?: 1
        );

        // SANITIZE HTML
        $content = $this->sanitizeHtml(
            $request->content
        );

        
        libxml_use_internal_errors(true);

        $dom = new DOMDocument();

        $dom->loadHTML(
            mb_convert_encoding(
                '<div>' . $content . '</div>',
                'HTML-ENTITIES',
                'UTF-8'
            ),
            LIBXML_HTML_NOIMPLIED |
                LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        $imageData = [];

        // temporary folder
        $tempFolder =
            'temp_' .
            Auth::id() .
            '_' .
            time();

        // PROCESS BASE64 IMAGE
        foreach ($images as $key => $img) {

            $src = $img->getAttribute('src');

            if (
                !$src ||
                !str_contains(
                    $src,
                    'data:image'
                )
            ) {
                continue;
            }

            try {

                [
                    $type,
                    $data
                ] = explode(';', $src);

                [, $data] = explode(
                    ',',
                    $data
                );

                $dataConvert =
                    base64_decode($data);

                $extension =
                    Str::before(
                        Str::after(
                            $type,
                            'image/'
                        ),
                        ';'
                    );

                if (!$extension) {
                    $extension = 'png';
                }

                $imageName =
                    time()
                    . '-'
                    . $key
                    . '-'
                    . Str::random(10)
                    . '.'
                    . $extension;

                $directory =
                    public_path(
                        "storage/UploadImage/PlaceImage/{$tempFolder}/"
                    );

                if (
                    !file_exists(
                        $directory
                    )
                ) {
                    mkdir(
                        $directory,
                        0755,
                        true
                    );
                }

                $path =
                    $directory .
                    $imageName;

                file_put_contents(
                    $path,
                    $dataConvert
                );

                $publicUrl = asset(
                    "storage/UploadImage/PlaceImage/{$tempFolder}/{$imageName}"
                );

                $img->setAttribute(
                    'src',
                    $publicUrl
                );

                $imageData[] = [
                    'temp_url' =>
                    $publicUrl,
                    'file_name' =>
                    $imageName
                ];
            } catch (\Exception $e) {
                continue;
            }
        }

        $content = $dom->saveHTML();

        // CREATE PLACE
        $place = Place::create([
            'place_code' =>
            time()
                . $convertedCode,

            'title' =>
            $request->title,

            'description' =>
            $request->description,

            'creator_id' =>
            Auth::id(),

            'content' =>
            $content,

            'views' => 0,

            'is_comment' =>
            $request->AllowComment
                == 'on'
                ? 1
                : 0,

            'province_id' =>
            $request->reg_province,

            'regency_id' =>
            $request->reg_regency,

            'district_id' =>
            $request->reg_district,

            'village_id' =>
            $request->reg_village
        ]);

        // MOVE IMAGE TO FINAL FOLDER
        foreach ($imageData as $img) {

            $oldPath = public_path(
                'storage/UploadImage/PlaceImage/'
                    . $tempFolder
                    . '/'
                    . $img['file_name']
            );

            $newDirectory =
                public_path(
                    "storage/UploadImage/PlaceImage/{$place->id}/"
                );

            if (
                !file_exists(
                    $newDirectory
                )
            ) {
                mkdir(
                    $newDirectory,
                    0755,
                    true
                );
            }

            $newPath =
                $newDirectory .
                $img['file_name'];

            if (
                file_exists(
                    $oldPath
                )
            ) {
                rename(
                    $oldPath,
                    $newPath
                );
            }

            $newUrl = asset(
                "storage/UploadImage/PlaceImage/{$place->id}/"
                    . $img['file_name']
            );

            // update content image src
            $content = str_replace(
                $img['temp_url'],
                $newUrl,
                $content
            );

            Image::create([
                'description' => '-',
                'place_id' =>
                $place->id,
                'src' =>
                $newUrl
            ]);
        }

        // UPDATE FINAL CONTENT
        $place->update([
            'content' => $content
        ]);

        LogActivities::create([
            'ip_address' =>
            request()->ip(),

            'user_agent' =>
            request()->header(
                'User-Agent'
            ),

            'user_id' =>
            Auth::id(),

            'activities' =>
            "User Created Place Data with Place id : "
                . $place->id
                . " at "
                . now()->format(
                    'Y-m-d H:i:s'
                ),

            'type' =>
            LogActivities::TYPE_CREATE_PLACE
        ]);

        return back()->with(
            'success',
            'Data Successfully Created !'
        );
    }
    // (9) This function is to get JsonFileData From Place selected
    function getDetailPlaceData($place_code)
    {
        $Place = Place::with('creator_id')->where('place_code', $place_code)->first();

        if (!$Place) {
            return response()->json([
                'message' => 'Place Not Found !'
            ], 404);
        }

        $Event = Event::select('id')->where('place_id', $Place->id)->get();

        return response()->json([
            'data' => $Place,
            'total_event' => $Event->count() ? $Event->count() : 0,
            'event' => $Event ? $Event : null
        ]);
    }

    // (10) This function is used to get detail place for public user to see the detail of the place
    function getDetailPlace($place_code)
    {
        $place = Place::with('province', 'regency', 'district')->where('place_code', $place_code)->first();
        if (!$place) {
            return redirect()->route('homes')->withErrors('Place Not Found !');
        }

        if ($place->deleted_at) {
            return redirect()->route('homes')->withErrors('This Place has been deleted !');
        }

        if (!session()->has('views')) {
            session(['views' => []]);
        }

        // If the post hasn't been viewed yet, add it to the session
        if (!in_array($place_code, session('views'))) {
            session()->push('views', $place_code);
            $place->increment('views');
            $userAgent = request()->userAgent();

            $browserName = 'Unknown';
            $browserVersion = null;
            $platform = 'Unknown';
            $deviceType = 'desktop';
            $deviceName = null;

            /*
            |--------------------------------------------------------------------------
            | PLATFORM
            |--------------------------------------------------------------------------
            */

            if (preg_match('/windows/i', $userAgent)) {
                $platform = 'Windows';
            } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
                $platform = 'MacOS';
            } elseif (preg_match('/iphone/i', $userAgent)) {
                $platform = 'iOS';
            } elseif (preg_match('/ipad/i', $userAgent)) {
                $platform = 'iPadOS';
            } elseif (preg_match('/android/i', $userAgent)) {
                $platform = 'Android';
            } elseif (preg_match('/linux/i', $userAgent)) {
                $platform = 'Linux';
            }

            /*
            |--------------------------------------------------------------------------
            | DEVICE TYPE
            |--------------------------------------------------------------------------
            */

            if (preg_match('/mobile/i', $userAgent)) {
                $deviceType = 'mobile';
            }

            if (preg_match('/tablet|ipad/i', $userAgent)) {
                $deviceType = 'tablet';
            }

            /*
            |--------------------------------------------------------------------------
            | BROWSER
            |--------------------------------------------------------------------------
            */

            $browsers = [
                'Edge' => 'Edg',
                'Opera' => 'OPR',
                'Chrome' => 'Chrome',
                'Mozilla' => 'Mozilla',
                'Safari' => 'Safari',
                'Firefox' => 'Firefox',
            ];

            foreach ($browsers as $name => $pattern) {

                if (preg_match("/{$pattern}\/([0-9\.]+)/i", $userAgent, $matches)) {

                    $browserName = $name;
                    $browserVersion = $matches[1];

                    break;
                }
            }
            /*
            |--------------------------------------------------------------------------
            | DEVICE NAME
            |--------------------------------------------------------------------------
            */

            if (preg_match('/iphone/i', $userAgent)) {
                $deviceName = 'iPhone';
            } elseif (preg_match('/ipad/i', $userAgent)) {
                $deviceName = 'iPad';
            } elseif (preg_match('/android/i', $userAgent)) {
                $deviceName = 'Android Device';
            } else {
                $deviceName = 'Desktop';
            }

            PlaceCheckpoint::create([
                'place_id' => $place->id,
                'place_code' => $place->place_code,

                'user_id' => Auth::id(),

                'session_id' => session()->getId(),
                'ip_address' => request()->ip(),
                'referrer' => request()->header('referer'),

                'user_agent' => $userAgent,

                'browser_name' => $browserName,
                'browser_version' => $browserVersion,

                'platform' => $platform,
                'device_type' => $deviceType,
                'device_name' => $deviceName,

                'is_mobile' => $deviceType === 'mobile',

                'checked_at' => now()
            ]);
        }


        $today = Carbon::now();

        $event = Event::where('place_id', $place->id)
            ->where('is_active', true)
            ->where(function ($query) use ($today) {
                $query
                    // Event yang sedang berlangsung
                    ->where(function ($q) use ($today) {
                        $q->whereDate('date', '<=', $today)
                            ->whereDate('end_date', '>=', $today);
                    })
                    // Event upcoming
                    ->orWhereDate('date', '>=', $today);
            })
            ->get();


        $customSettingRunningText = CustomRunningTextSettings::first();

        $customSettingAds = CustomAdsSettings::with('images')
            ->where('is_active', true)
            ->first();

        $ads = $place->advertises?->where('is_active', 1)->first();

        $modalAds = null;
        $modalAdsImages = collect();

        if ($customSettingAds) {

            // pakai setting global
            $modalAds = (object)[
                'title' => $customSettingAds->title,
                'time' => $customSettingAds->time,
                'is_active' => $customSettingAds->is_active,
                'is_block' => $customSettingAds->is_blocking,
            ];

            // priority custom images
            $modalAdsImages = $customSettingAds->images
                ->map(fn($img) => [
                    'image_url' => $img->image_url,
                    'source' => 'custom'
                ]);

            // merge advertise
            if (
                $customSettingAds->merge_with_advertise_users &&
                $ads &&
                $ads->images?->count()
            ) {
                $advertiseImages = $ads->images->map(fn($img) => [
                    'image_url' => $img->image_url,
                    'source' => 'advertise'
                ]);

                $modalAdsImages = $modalAdsImages->concat($advertiseImages);
            }
        } elseif ($ads) {

            // fallback advertise
            $modalAds = (object)[
                'title' => $ads->title,
                'time' => $ads->time,
                'is_active' => $ads->is_active,
                'is_block' => $ads->is_block,
            ];

            $modalAdsImages = $ads->images->map(fn($img) => [
                'image_url' => $img->image_url,
                'source' => 'advertise'
            ]);
        }

        return view(
            'Pages.detail-place.index',
            compact(
                'place',
                'event',
                'customSettingRunningText',
                'customSettingAds',
                'ads',
                'modalAds',
                'modalAdsImages'
            )
        );
    }


    // (11) This function is used to print qrcode by admin
    function print($placeCode)
    {
        $place = Place::where('place_code', $placeCode)->first();
        $printUrl = $this->applicationURLLocal . '/detail-place/' . $place->place_code;

        if (!$place) {
            return back()->withErrors('Place Code Not Found !');
        }
        return view('Pages.Management.Master.print-barcode.index', compact('place', 'printUrl'));
    }

    function fetchAll()
    {
        if (Auth::user()->hasRole('superadmin')) {
            $placeData = Place::select('id', 'place_code', 'title')->get();
        } else {
            $placeData = Place::where('creator_id', Auth::user()->id)->select('id', 'place_code', 'title')->get();
        }

        return response()->json([
            'data' => $placeData
        ]);
    }


    public function getPlaceChartData()
    {
        $provinces = DB::table('reg_provinces')->pluck('name', 'id');
        $regencies = DB::table('reg_regencies')->pluck('name', 'id');
        $districts = DB::table('reg_districts')->pluck('name', 'id');
        $villages = DB::table('reg_villages')->pluck('name', 'id');

        $charts = [];

        // Province
        $provinceData = Place::selectRaw('COALESCE(province_id, 0) as id, COUNT(*) as total')
            ->groupBy('province_id')->get()
            ->map(function ($item) use ($provinces) {
                return [
                    'label' => $item->id == 0 ? 'Unknown' : ($provinces[$item->id] ?? 'Unknown'),
                    'value' => $item->total
                ];
            });

        // Regency
        $regencyData = Place::selectRaw('COALESCE(regency_id, 0) as id, COUNT(*) as total')
            ->groupBy('regency_id')->get()
            ->map(function ($item) use ($regencies) {
                return [
                    'label' => $item->id == 0 ? 'Unknown' : ($regencies[$item->id] ?? 'Unknown'),
                    'value' => $item->total
                ];
            });

        // District
        $districtData = Place::selectRaw('COALESCE(district_id, 0) as id, COUNT(*) as total')
            ->groupBy('district_id')->get()
            ->map(function ($item) use ($districts) {
                return [
                    'label' => $item->id == 0 ? 'Unknown' : ($districts[$item->id] ?? 'Unknown'),
                    'value' => $item->total
                ];
            });

        // Village
        $villageData = Place::selectRaw('COALESCE(village_id, 0) as id, COUNT(*) as total')
            ->groupBy('village_id')->get()
            ->map(function ($item) use ($villages) {
                return [
                    'label' => $item->id == 0 ? 'Unknown' : ($villages[$item->id] ?? 'Unknown'),
                    'value' => $item->total
                ];
            });

        return response()->json([
            'province' => $provinceData,
            'regency' => $regencyData,
            'district' => $districtData,
            'village' => $villageData,
        ]);
    }

    /**
     * AJAX Search Methods for Select2 Cascading Location Filters
     */

    // Search Provinces
    public function searchProvinces(Request $request)
    {
        $search = $request->get('q', '');

        $query = DB::table('reg_provinces');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $results = $query->limit(20)->get();

        return response()->json([
            'results' => $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            })
        ]);
    }

    // Search Regencies
    public function searchRegencies(Request $request)
    {
        $province_id = $request->get('province_id');
        $search = $request->get('q', '');

        $query = DB::table('reg_regencies');

        if ($province_id) {
            $query->where('province_id', $province_id);
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $results = $query->limit(20)->get();

        return response()->json([
            'results' => $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            })
        ]);
    }

    // Search Districts
    public function searchDistricts(Request $request)
    {
        $regency_id = $request->get('regency_id');
        $search = $request->get('q', '');

        $query = DB::table('reg_districts');

        if ($regency_id) {
            $query->where('regency_id', $regency_id);
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $results = $query->limit(20)->get();

        return response()->json([
            'results' => $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            })
        ]);
    }

    // Search Villages
    public function searchVillages(Request $request)
    {
        $district_id = $request->get('district_id');
        $search = $request->get('q', '');

        $query = DB::table('reg_villages');

        if ($district_id) {
            $query->where('district_id', $district_id);
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $results = $query->limit(20)->get();

        return response()->json([
            'results' => $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            })
        ]);
    }
}
