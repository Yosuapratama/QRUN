<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index(){
        if(Auth::user()->hasRole('superadmin')){
            $data = [
                'user_count' => User::count(),
                'user_pending' => User::where('is_deleted', 0)->where('is_approved', 0)->count(),
                'place_total' => Place::count(),
                'event_count' => Event::where('is_deleted', 0)->count()
            ];
        }else{
            $place = Place::where('creator_id', Auth::user()->id)->first();
            if($place){
                $event = Event::where('place_id', $place->id)->count();
            }else{
                $event = 0;
            }
            $data = [
                'event_count' => $event
            ];
        }

        return view('Pages.Dashboard', compact('data'));
    }
}
