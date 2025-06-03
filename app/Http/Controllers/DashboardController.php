<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Place;
use App\Models\User;
use App\Models\UserHasPlaceLimit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Comments;
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
        if (Auth::user()->hasRole('superadmin')) {
            $data = [
                'user_count' => User::count(),
                'user_pending' => User::whereNull('approved_at')->count(),
                'place_total' => Place::count(),
                'event_count' => Event::count(),
                'comments_count' => Comment::count(),
                'gallery_count' => Gallery::count(),
                'blog_count' => Blog::count(),
                'account_limit' =>  'Unlimited',
                'user_not_verified' => User::whereNull('email_verified_at')->count(),
                'data' =>  $data = [10, 20, 30, 40, 50]
            ];
        } else {

            $place = Place::select('id')->where('creator_id', Auth::user()->id)->get()->pluck('id');
            $event = $place->isNotEmpty() ? Event::whereIn('place_id', $place)->count() : 0;

            // Get All place created by user
            $placeData = Place::where('creator_id', Auth::user()->id)->get()->pluck('id');
            $comments = Comment::whereIn('place_id', $placeData)->count();

            $data = [
                'event_count' => $event,
                'place_total' => Place::where('creator_id', Auth::user()->id)->count(),
                'comments_count' => $comments,
                'account_limit' =>  UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first()->placeLimit->total_limit ?? 1
            ];
        }

        return view('Pages.Management.Master.Dashboard', compact('data'));
    }

    function termsOfService()
    {
        return view('Pages.TermsOfService');
    }

    function getChartData()
    {
        $placeData = Place::select('id', 'title', 'views', 'place_code')->orderBy('views', 'DESC')->limit(5)->get();
        $placeCodeArr = [];
        $arrViews = [];

        foreach ($placeData as $place) {
            $placeCodeArr[] = ["code" => $place->place_code, "title" => $place->title];
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

    function userGrowth()
    {
        // Ambil data user growth dari database
        $userGrowthData = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m-01") as month, count(*) as user_count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month'); // agar mudah diakses per bulan

        // Tentukan rentang bulan (dari bulan pertama user hingga bulan sekarang)
        $firstUser = User::orderBy('created_at')->first();
        $start = $firstUser ? \Carbon\Carbon::parse($firstUser->created_at)->startOfMonth() : now()->startOfMonth();
        $end = now()->startOfMonth();

        $months = [];
        $current = $start->copy();
        while ($current <= $end) {
            $monthKey = $current->format('Y-m-01');
            $months[] = [
                'month' => $monthKey,
                'user_count' => isset($userGrowthData[$monthKey]) ? $userGrowthData[$monthKey]->user_count : 0
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
