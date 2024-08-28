<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Place;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->hasRole('superadmin')){
            $data = [
                'user_count' => User::count(),
                'user_pending' => User::where('is_deleted', 0)->where('is_approved', 0)->count(),
                'place_total' => Place::count(),
                'event_count' => Event::where('is_deleted', 0)->count()
            ];
        }else{
            $place = Place::select('id')->where('creator_id', Auth::user()->id)->first();
            $event = $place ? Event::where('place_id', $place->id)->count() : 0;
           
            $data = [
                'event_count' => $event
            ];
        }

        return view('Pages.Dashboard', compact('data'));
    }
}
