<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use App\Models\Place;
use App\Models\User;
use App\Models\UserHasPlaceLimit;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Comments;

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

    // (1) This function to show detail of all data in qrun website
    function index(){
        // dd(UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first()->placeLimit->total_limit);
        if(Auth::user()->hasRole('superadmin')){
            $data = [
                'user_count' => User::count(),
                'user_pending' => User::whereNull('approved_at')->count(),
                'place_total' => Place::count(),
                'event_count' => Event::count(),
                'comments_count' => Comment::count(),
                'account_limit' =>  'Unlimited'
            ];
        }else{
            $place = Place::select('id')->where('creator_id', Auth::user()->id)->latest()->first();
            $event = $place ? Event::where('place_id', $place->id)->count() : 0;
           
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

    function termsOfService(){
        return view('Pages.TermsOfService');
    }
}
