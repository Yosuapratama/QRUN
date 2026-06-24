<?php
namespace App\Helpers;

use App\Models\Event;
use App\Models\Place;
use App\Models\User;
use App\Models\UserHasPlaceLimit;
use Illuminate\Support\Facades\Auth;

class SidebarHelper
{
    public static function getAmountOfLimitUser(){
        $data = UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first()->placeLimit->total_limit ?? 1;

        return $data;
    }

    public static function getPendingUser(){
        return User::whereNotNull('email_verified_at')->whereNull('approved_at')->get()->count();
    }

    public static function getPendingApprovedUser(){
        return User::whereNull('approved_at')->whereNotNull('email_verified_at')->count();
    }

    public static function getPendingVerifiedUsers(){
        return User::whereNull('email_verified_at')->count();
    }

    public static function getActiveUser(){
        return User::whereNotNull('email_verified_at')->whereNotNull('approved_at')->get()->count();
    }

    public static function getPlaceCount(){
        return Place::count();
    }

    public static function getEventCount(){
        return Event::withTrashed()->count();
    }

    public static function getEventActiveCount(){
        return Event::count();
    }

    public static function getEndedEvent(){
        return Event::onlyTrashed()->count();
    }


}