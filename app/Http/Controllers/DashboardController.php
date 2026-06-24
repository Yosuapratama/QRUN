<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Regency;
use App\Models\Province;
use App\Models\District;
use App\Models\Village;
use App\Models\Place;
use App\Models\PlaceCheckpoint;
use App\Models\User;
use App\Models\UserHasPlaceLimit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Comments;
use Yajra\DataTables\Facades\DataTables;

use stdClass;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Detail Of Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This Controllers Contains :
    | -> For User/Admin to see detail of users, approved, place, event total
    |  1. /dashboard, Func Name : index, Route Name : dashboard
    |
    */

    public function sendRecapToday()
    {
        Artisan::call('checkpoint:summary 24');

        return response()->json([
            'message' => 'Recap sent successfully'
        ]);
    }

    public function getRunningScanTimeNow(Request $request)
    {
        $query = PlaceCheckpoint::query()
            ->select([
                'id',
                'place_id',
                'place_code',
                'user_id',
                'checked_at',
                'created_at',
                'browser_name',
                'platform',
                'device_type'
            ])
            ->with([
                'user:id,name,email',
                'place:id,place_code,title'
            ]);

        if (!Auth::user()->hasRole('superadmin')) {
            $placeIds = Place::where('creator_id', Auth::id())
                ->pluck('id');

            $query->whereIn('place_id', $placeIds);
        }
        /*
    |--------------------------------------------------------------------------
    | DATE FILTER
    |--------------------------------------------------------------------------
    */

        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = Carbon::parse($request->start_date)
                ->startOfDay();

            $endDate = Carbon::parse($request->end_date)
                ->endOfDay();

            $query->whereBetween(
                'created_at',
                [$startDate, $endDate]
            );
        }

        /*
    |--------------------------------------------------------------------------
    | DEFAULT ORDER
    |--------------------------------------------------------------------------
    */

        $query->latest('created_at');

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();
        $isSuperAdmin = $authUser->hasRole('superadmin');

        $datatable = DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('user_name', fn($row) => $row->user?->name ?? 'Guest')
            ->addColumn('place_name', fn($row) => $row->place?->title ?? $row->place_code)
            ->editColumn('checked_at', fn($row) => Carbon::parse($row->checked_at)->format('d M Y H:i:s'))
            ->editColumn('created_at', fn($row) => Carbon::parse($row->created_at)->format('d M Y H:i:s'))
            ->blacklist(['user_name', 'place_name']);

        if (!$isSuperAdmin) {
            $datatable->removeColumn('user_name');
            $datatable->rawColumns(['place_name']);
        } else {
            $datatable->rawColumns(['user_name', 'place_name']);
        }

        return $datatable->make(true);
    }

    function sync()
    {
        $data = Place::all();
        $arrData = [];

        foreach ($data as $dt) {
            $datass = new stdClass();

            $datass->place_code = $dt->place_code;
            $datass->title = $dt->title;
            $datass->description = $dt->description;
            $datass->content = $dt->content;
            $datass->views = 1;
            $datass->is_comment = 0;
            $datass->created_at = $dt->created_at;
            $datass->updated_at = $dt->updated_at;
            $datass->deleted_at = $dt->is_deleted ? Carbon::now() : null;

            $arrData[] = $datass;
        }

        $sqlQueries = [];

        foreach ($arrData as $data) {
            $sqlQueries[] = sprintf(
                "INSERT INTO place (place_code, title, description, content, views, is_comment, created_at, updated_at, deleted_at) VALUES ('%s', '%s', '%s', '%s', %d, %d, '%s', '%s', %s);",
                addslashes($data->place_code),
                addslashes($data->title),
                addslashes($data->description),
                addslashes($data->content),
                $data->views,
                $data->is_comment,
                $data->created_at,
                $data->updated_at,
                $data->deleted_at ? "'" . $data->deleted_at . "'" : "NULL"
            );
        }

        foreach ($sqlQueries as $query) {
            echo $query . "\n";
        }
    }

    // (1) This function to show detail of all data in qrun website
    function index()
    {
        // dd(UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first()->placeLimit->total_limit);
        // if (Auth::user()->hasRole('superadmin')) {
        //     $data = [
        //         'user_count' => User::count(),
        //         'user_pending' => User::whereNull('approved_at')->count(),
        //         'place_total' => Place::count(),
        //         'event_count' => Event::count(),
        //         'comments_count' => Comment::count(),
        //         'gallery_count' => Gallery::count(),
        //         'blog_count' => Blog::count(),
        //         'account_limit' =>  'Unlimited',
        //         'user_not_verified' => User::whereNull('email_verified_at')->count(),
        //         'data' =>  $data = [10, 20, 30, 40, 50]
        //     ];
        // } else {

        //     $place = Place::select('id')->where('creator_id', Auth::user()->id)->get()->pluck('id');
        //     $event = $place->isNotEmpty() ? Event::whereIn('place_id', $place)->count() : 0;

        //     // Get All place created by user
        //     $placeData = Place::where('creator_id', Auth::user()->id)->get()->pluck('id');
        //     $comments = Comment::whereIn('place_id', $placeData)->count();

        //     $data = [
        //         'event_count' => $event,
        //         'place_total' => Place::where('creator_id', Auth::user()->id)->count(),
        //         'comments_count' => $comments,
        //         'account_limit' =>  UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first()->placeLimit->total_limit ?? 1
        //     ];
        // }

        return view('Pages.Management.Master.Dashboard');
    }

    private function getCheckinAnalytics($startDate, $endDate, $placeIds = null)
    {
        $query = PlaceCheckpoint::query()
            ->whereBetween('checked_at', [$startDate, $endDate])
            ->whereNotNull('checked_at');

        if ($placeIds) {
            $query->whereIn('place_id', $placeIds);
        }

        $checkpoints = $query->get();

        if (!$checkpoints->count()) {

            return [
                'avg_checkin_time' => null,
                'fastest_checkin_time' => null,
                'slowest_checkin_time' => null,
                'total_checkins' => 0,
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | CONVERT TIME TO SECONDS
    |--------------------------------------------------------------------------
    */

        $times = $checkpoints->map(function ($item) {

            $time = Carbon::parse($item->checked_at);

            return (
                ($time->hour * 3600) +
                ($time->minute * 60) +
                $time->second
            );
        });

        /*
    |--------------------------------------------------------------------------
    | AVG / MIN / MAX
    |--------------------------------------------------------------------------
    */

        $avgSeconds = round($times->avg());

        $minSeconds = $times->min();

        $maxSeconds = $times->max();

        /*
    |--------------------------------------------------------------------------
    | FORMAT
    |--------------------------------------------------------------------------
    */

        return [

            'avg_checkin_time' => gmdate(
                'H:i:s',
                $avgSeconds
            ),

            'fastest_checkin_time' => gmdate(
                'H:i:s',
                $minSeconds
            ),

            'slowest_checkin_time' => gmdate(
                'H:i:s',
                $maxSeconds
            ),

            'total_checkins' => $checkpoints->count(),
        ];
    }

    public function getDashboardStats(Request $request)
    {
        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfMonth();



        if (Auth::user()->hasRole('superadmin')) {

            $checkinAnalytics = $this->getCheckinAnalytics(
                $startDate,
                $endDate
            );

            return response()->json([
                'user_count' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
                'checkin_analytics' => $checkinAnalytics,

                'user_pending' => User::whereNull('approved_at')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),

                'user_not_verified' => User::whereNull('email_verified_at')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),

                'place_total' => Place::whereBetween('created_at', [$startDate, $endDate])->count(),

                'event_count' => Event::whereBetween('created_at', [$startDate, $endDate])->count(),

                'comments_count' => Comment::whereBetween('created_at', [$startDate, $endDate])->count(),

                'gallery_count' => Gallery::whereBetween('created_at', [$startDate, $endDate])->count(),

                'blog_count' => Blog::whereBetween('created_at', [$startDate, $endDate])->count(),

                'account_limit' => 'Unlimited'
            ]);
        }


        $placeIds = Place::where('creator_id', Auth::id())
            ->pluck('id');

        $checkinAnalytics = $this->getCheckinAnalytics(
            $startDate,
            $endDate,
            $placeIds
        );

        return response()->json([
            'event_count' => Event::whereIn('place_id', $placeIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'place_total' => Place::where('creator_id', Auth::id())
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'comments_count' => Comment::whereIn('place_id', $placeIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),

            'account_limit' =>
            UserHasPlaceLimit::where('user_id', Auth::id())
                ->with('placeLimit')
                ->first()
                ?->placeLimit
                ?->total_limit ?? 1
        ]);
    }

    // public function getMapData(Request $request)
    // {
    //     $level = $request->level ?? 'province';
    //     $parentId = $request->parent_id;

    //     $request['start_date'] = '2023-01-01';
    //     $request['end_date'] = '2027-12-31';

    //     $startDate = $request->start_date
    //         ? Carbon::parse($request->start_date)->startOfDay()
    //         : now()->startOfMonth();

    //     $endDate = $request->end_date
    //         ? Carbon::parse($request->end_date)->endOfDay()
    //         : now()->endOfMonth();

    //     switch ($level) {

    //         case 'province':

    //             $data = Province::query()
    //                 ->withCount([
    //                     'places as total_places' => function ($q) use ($startDate, $endDate) {
    //                         $q->whereBetween('created_at', [$startDate, $endDate]);
    //                     }
    //                 ])
    //                 ->get()
    //                 ->filter(function ($item) {
    //                     return $item->total_places > 0;
    //                 })
    //                 ->map(function ($province) use ($startDate, $endDate) {

    //                     $breakdown = Regency::query()
    //                         ->where('province_id', $province->id)
    //                         ->with([
    //                             'districts.villages'
    //                         ])
    //                         ->get()
    //                         ->map(function ($regency) use ($startDate, $endDate) {

    //                             $districts = $regency->districts->map(function ($district) use ($startDate, $endDate) {

    //                                 $villages = $district->villages->map(function ($village) use ($startDate, $endDate) {

    //                                     $total = Place::query()
    //                                         ->where('village_id', $village->id)
    //                                         ->whereBetween('created_at', [$startDate, $endDate])
    //                                         ->count();

    //                                     return [
    //                                         'name' => $village->name,
    //                                         'total' => $total
    //                                     ];
    //                                 })->filter(function ($v) {
    //                                     return $v['total'] > 0;
    //                                 })->values();

    //                                 return [
    //                                     'district_name' => $district->name,
    //                                     'total_places' => $villages->sum('total'),
    //                                     'villages' => $villages
    //                                 ];
    //                             })->filter(function ($d) {
    //                                 return $d['total_places'] > 0;
    //                             })->values();

    //                             return [
    //                                 'regency_name' => $regency->name,
    //                                 'districts' => $districts
    //                             ];
    //                         })->filter(function ($r) {
    //                             return count($r['districts']) > 0;
    //                         })->values();

    //                     return [
    //                         'id' => $province->id,
    //                         'name' => $province->name,
    //                         'latitude' => $province->latitude,
    //                         'longitude' => $province->longitude,
    //                         'polygon_path' => $province->polygon_path,
    //                         'total_places' => $province->total_places,
    //                         'breakdown' => $breakdown
    //                     ];
    //                 });

    //             break;

    //         case 'regency':

    //             $data = Regency::query()
    //                 ->where('province_id', $parentId)
    //                 ->withCount([
    //                     'places as total_places' => function ($q) use ($startDate, $endDate) {
    //                         $q->whereBetween('created_at', [$startDate, $endDate]);
    //                     }
    //                 ])
    //                 ->get()
    //                 ->filter(function ($item) {
    //                     return $item->total_places > 0;
    //                 })
    //                 ->map(function ($regency) use ($startDate, $endDate) {

    //                     $breakdown = District::query()
    //                         ->where('regency_id', $regency->id)
    //                         ->with('villages')
    //                         ->get()
    //                         ->map(function ($district) use ($startDate, $endDate) {

    //                             $villages = $district->villages->map(function ($village) use ($startDate, $endDate) {

    //                                 $total = Place::query()
    //                                     ->where('village_id', $village->id)
    //                                     ->whereBetween('created_at', [$startDate, $endDate])
    //                                     ->count();

    //                                 return [
    //                                     'name' => $village->name,
    //                                     'total' => $total
    //                                 ];
    //                             })->filter(function ($v) {
    //                                 return $v['total'] > 0;
    //                             })->values();

    //                             return [
    //                                 'district_name' => $district->name,
    //                                 'total_places' => $villages->sum('total'),
    //                                 'villages' => $villages
    //                             ];
    //                         })->filter(function ($d) {
    //                             return $d['total_places'] > 0;
    //                         })->values();

    //                     return [
    //                         'id' => $regency->id,
    //                         'name' => $regency->name,
    //                         'latitude' => $regency->latitude,
    //                         'longitude' => $regency->longitude,
    //                         'polygon_path' => $regency->polygon_path,
    //                         'total_places' => $regency->total_places,
    //                         'breakdown' => $breakdown
    //                     ];
    //                 });

    //             break;

    //         default:

    //             $data = collect([]);
    //             break;
    //     }

    //     return response()->json(
    //         $data->values()
    //     );
    // }

    public function getMapData(Request $request)
    {
        $level = $request->level ?? 'province';
        $parentId = $request->parent_id;

        // $request['start_date'] = '2023-01-01';
        // $request['end_date'] = '2027-12-31';


        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfMonth();

        /*
    |--------------------------------------------------------------------------
    | PRELOAD PLACE COUNTS (SUPER IMPORTANT)
    |--------------------------------------------------------------------------
    */

        $placeCounts = Place::query()
            ->selectRaw('village_id, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('village_id')
            ->pluck('total', 'village_id');

        if (!Auth::user()->hasRole('superadmin')) {
            $placeIds = Place::where('creator_id', Auth::id())
                ->pluck('id');

            $placeCounts = Place::query()
                ->selectRaw('village_id, COUNT(*) as total')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('id', $placeIds)
                ->groupBy('village_id')
                ->pluck('total', 'village_id');
        }

        switch ($level) {

                /*
        |--------------------------------------------------------------------------
        | PROVINCE
        |--------------------------------------------------------------------------
        */

            case 'province':

                $data = Province::query()
                    ->with([
                        'regencies.districts.villages'
                    ])
                    ->get()
                    ->map(function ($province) use ($placeCounts) {

                        $provinceTotal = 0;

                        $breakdown = $province->regencies
                            ->map(function ($regency) use ($placeCounts, &$provinceTotal) {

                                $districts = $regency->districts
                                    ->map(function ($district) use ($placeCounts, &$provinceTotal) {

                                        $districtTotal = 0;

                                        $villages = $district->villages
                                            ->map(function ($village) use (
                                                $placeCounts,
                                                &$districtTotal,
                                                &$provinceTotal
                                            ) {

                                                $total = (int) ($placeCounts[$village->id] ?? 0);

                                                $districtTotal += $total;
                                                $provinceTotal += $total;

                                                return [
                                                    'name' => $village->name,
                                                    'total' => $total
                                                ];
                                            })
                                            ->filter(fn($v) => $v['total'] > 0)
                                            ->values();

                                        return [
                                            'district_name' => $district->name,
                                            'total_places' => $districtTotal,
                                            'villages' => $villages
                                        ];
                                    })
                                    ->filter(fn($d) => $d['total_places'] > 0)
                                    ->values();

                                return [
                                    'regency_name' => $regency->name,
                                    'districts' => $districts
                                ];
                            })
                            ->filter(fn($r) => count($r['districts']) > 0)
                            ->values();

                        return [
                            'id' => $province->id,
                            'name' => $province->name,
                            'latitude' => $province->latitude,
                            'longitude' => $province->longitude,
                            'polygon_path' => $province->polygon_path,
                            'total_places' => $provinceTotal,
                            'breakdown' => $breakdown
                        ];
                    })
                    ->filter(fn($p) => $p['total_places'] > 0)
                    ->values();

                break;

                /*
        |--------------------------------------------------------------------------
        | REGENCY
        |--------------------------------------------------------------------------
        */

            case 'regency':

                $data = Regency::query()
                    ->where('province_id', $parentId)
                    ->with([
                        'districts.villages'
                    ])
                    ->get()
                    ->map(function ($regency) use ($placeCounts) {

                        $regencyTotal = 0;

                        $breakdown = $regency->districts
                            ->map(function ($district) use ($placeCounts, &$regencyTotal) {

                                $districtTotal = 0;

                                $villages = $district->villages
                                    ->map(function ($village) use (
                                        $placeCounts,
                                        &$districtTotal,
                                        &$regencyTotal
                                    ) {

                                        $total = (int) ($placeCounts[$village->id] ?? 0);

                                        $districtTotal += $total;
                                        $regencyTotal += $total;

                                        return [
                                            'name' => $village->name,
                                            'total' => $total
                                        ];
                                    })
                                    ->filter(fn($v) => $v['total'] > 0)
                                    ->values();

                                return [
                                    'district_name' => $district->name,
                                    'total_places' => $districtTotal,
                                    'villages' => $villages
                                ];
                            })
                            ->filter(fn($d) => $d['total_places'] > 0)
                            ->values();

                        return [
                            'id' => $regency->id,
                            'name' => $regency->name,
                            'latitude' => $regency->latitude,
                            'longitude' => $regency->longitude,
                            'polygon_path' => $regency->polygon_path,
                            'total_places' => $regencyTotal,
                            'breakdown' => $breakdown
                        ];
                    })
                    ->filter(fn($r) => $r['total_places'] > 0)
                    ->values();

                break;

            default:

                $data = collect([]);
                break;
        }

        return response()->json(
            $data->values()
        );
    }

    function termsOfService()
    {
        return view('Pages.TermsOfService');
    }

    public function getChartData(Request $request)
    {
        $startDate = $request->start_date
            ? \Carbon\Carbon::parse($request->start_date)->startOfDay()
            : null;

        $endDate = $request->end_date
            ? \Carbon\Carbon::parse($request->end_date)->endOfDay()
            : null;

        $query = Place::query();

        $query->when($startDate, function ($q) use ($startDate) {
            $q->whereDate('created_at', '>=', $startDate);
        });

        $query->when($endDate, function ($q) use ($endDate) {
            $q->whereDate('created_at', '<=', $endDate);
        });


        if (!Auth::user()->hasRole('superadmin')) {
            $placeData = $query
                ->where('creator_id', Auth::id())
                ->select('id', 'title', 'views', 'place_code')
                ->orderByDesc('views')
                ->limit(5)
                ->get();
        } else {
            $placeData = $query
                ->select('id', 'title', 'views', 'place_code')
                ->orderByDesc('views')
                ->limit(5)
                ->get();
        }

        $placeCodeArr = [];
        $arrViews = [];

        foreach ($placeData as $place) {

            $placeCodeArr[] = [
                "code" => $place->place_code,
                "title" => $place->title
            ];

            $arrViews[] = $place->views;
        }

        return response()->json([
            'data' => [
                'place_code' => [
                    $placeCodeArr
                ],
                'no' => [
                    $arrViews
                ]
            ]
        ]);
    }
    function privacyPolicy()
    {
        return view('Pages.PrivacyPolicy');
    }

    public function userGrowth(Request $request)
    {
        $startDate = $request->start_date
            ? \Carbon\Carbon::parse($request->start_date)->startOfDay()
            : null;

        $endDate = $request->end_date
            ? \Carbon\Carbon::parse($request->end_date)->endOfDay()
            : null;

        $query = User::query();

        $query->when($startDate, function ($q) use ($startDate) {
            $q->whereDate('created_at', '>=', $startDate);
        });

        $query->when($endDate, function ($q) use ($endDate) {
            $q->whereDate('created_at', '<=', $endDate);
        });

        $userGrowthData = $query
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-01") as month, COUNT(*) as user_count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        /*
    |--------------------------------------------------------------------------
    | RANGE MONTH
    |--------------------------------------------------------------------------
    */

        $start = $startDate
            ? $startDate->copy()->startOfMonth()
            : (
                User::orderBy('created_at')->first()
                ? \Carbon\Carbon::parse(
                    User::orderBy('created_at')->first()->created_at
                )->startOfMonth()
                : now()->startOfMonth()
            );

        $end = $endDate
            ? $endDate->copy()->startOfMonth()
            : now()->startOfMonth();

        $months = [];

        $current = $start->copy();

        while ($current <= $end) {

            $monthKey = $current->format('Y-m-01');

            $months[] = [
                'month' => $monthKey,
                'user_count' => $userGrowthData[$monthKey]->user_count ?? 0
            ];

            $current->addMonth();
        }

        return response()->json($months);
    }

    public function setLocale($locale)
    {
        if (in_array($locale, ['en', 'id'])) {
            Session::put('locale', $locale);
        }

        // Redirect the user back to the previous page
        return redirect()->back();
    }

    public function getLocation(Request $request)
    {
        $provincesResult = DB::table('reg_provinces')
            ->get();
        if ($request->has('province_id') && $request->province_id !== null && $request->province_id !== "") {
            $regencyResult = DB::table('reg_regencies')
                ->when($request->province_id !== null, function ($query) use ($request) {
                    return $query->where('province_id', $request->province_id);
                })
                ->get();
        }

        if ($request->has('regency_id') && $request->regency_id !== null && $request->regency_id !== "" && $request->has('province_id') && $request->province_id !== null && $request->province_id !== "") {
            $districtResult = DB::table('reg_districts')
                ->when($request->regency_id !== null, function ($query) use ($request) {
                    return $query->where('regency_id', $request->regency_id);
                })
                ->get();
        }
        if ($request->has('district_id') && $request->district_id !== null && $request->district_id !== "" && $request->has('regency_id') && $request->regency_id !== null && $request->regency_id !== ""  && $request->has('province_id') && $request->province_id !== null && $request->province_id !== "") {
            $villagesResult = DB::table('reg_villages')
                ->when($request->district_id !== null, function ($query) use ($request) {
                    return $query->where('district_id', $request->district_id);
                })
                ->get();
        }

        return response()->json([
            "code" => 200,
            "success" => true,
            "province" => $provincesResult,
            "regency" => $regencyResult ?? [],
            "districts" => $districtResult ?? [],
            "villages" => $villagesResult ?? []
        ]);
    }
}
